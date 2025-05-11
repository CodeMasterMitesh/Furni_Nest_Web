<?php
session_start();
include '../config/conn.php';

// CSRF token generation
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if (isset($_POST['login'])) {
    // Validate CSRF token
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $_SESSION['login_error'] = "Security token mismatch. Please try again.";
        header("Location: login.php");
        exit;
    }

    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    // Using prepared statement for better security
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($res) == 1) {
        $row = mysqli_fetch_assoc($res);
        if (password_verify($password, $row['password'])) {
            // Regenerate session ID to prevent fixation
            session_regenerate_id(true);
            
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = $row['username'];
            $_SESSION['udata'] = $row;
            
            // Set last login time
            $update_sql = "UPDATE users SET last_login = NOW() WHERE id = ?";
            $update_stmt = mysqli_prepare($conn, $update_sql);
            mysqli_stmt_bind_param($update_stmt, "i", $row['id']);
            mysqli_stmt_execute($update_stmt);
            
            header("Location: dashboard.php");
            exit;
        } else {
            // Delay to prevent brute force
            sleep(1);
            $_SESSION['login_error'] = "Invalid credentials.";
        }
    } else {
        // Delay to prevent brute force
        sleep(1);
        $_SESSION['login_error'] = "Invalid credentials.";
    }
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Login - FurniNest</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <!-- Animate.css -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
  <!-- Custom CSS -->
  <style>
    :root {
      --primary-color: #6c5ce7;
      --secondary-color: #a29bfe;
      --dark-color: #2d3436;
      --light-color: #f5f6fa;
    }
    
    body {
      background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
      font-family: 'Poppins', sans-serif;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      overflow-x: hidden;
    }

    .login-container {
      perspective: 1000px;
    }

    .login-card {
      background: rgba(255, 255, 255, 0.95);
      border-radius: 20px;
      padding: 2.5rem;
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
      transform-style: preserve-3d;
      transition: all 0.5s ease;
      width: 100%;
      max-width: 450px;
      position: relative;
      overflow: hidden;
    }

    .login-card:before {
      content: '';
      position: absolute;
      top: -50%;
      left: -50%;
      width: 200%;
      height: 200%;
      background: linear-gradient(45deg, transparent, rgba(255,255,255,0.1), transparent);
      transform: rotate(45deg);
      animation: shine 3s infinite;
    }

    @keyframes shine {
      0% { left: -50%; }
      100% { left: 150%; }
    }

    .brand-logo {
      font-size: 2.5rem;
      font-weight: 700;
      color: var(--primary-color);
      margin-bottom: 1rem;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .brand-logo i {
      margin-right: 10px;
    }

    .login-title {
      font-weight: 700;
      font-size: 1.8rem;
      color: var(--dark-color);
      margin-bottom: 1.5rem;
      text-align: center;
    }

    .form-control {
      border-radius: 10px;
      padding: 12px 15px;
      border: 2px solid #e0e0e0;
      transition: all 0.3s;
    }

    .form-control:focus {
      border-color: var(--primary-color);
      box-shadow: 0 0 0 0.25rem rgba(108, 92, 231, 0.25);
    }

    .input-group-text {
      background: transparent;
      border-right: none;
    }

    .form-floating>label {
      padding: 0.8rem 0.75rem;
    }

    .login-btn {
      font-weight: 600;
      background-color: var(--primary-color);
      border: none;
      padding: 12px;
      border-radius: 10px;
      letter-spacing: 1px;
      text-transform: uppercase;
      transition: all 0.3s;
      width: 100%;
    }

    .login-btn:hover {
      background-color: #5649c0;
      transform: translateY(-2px);
    }

    .login-btn:active {
      transform: translateY(0);
    }

    .forgot-pass {
      color: var(--primary-color);
      text-decoration: none;
      font-size: 0.9rem;
      transition: all 0.3s;
    }

    .forgot-pass:hover {
      text-decoration: underline;
    }

    .particle {
      position: absolute;
      background: rgba(255, 255, 255, 0.5);
      border-radius: 50%;
      pointer-events: none;
    }

    /* .floating {
      animation: floating 3s ease-in-out infinite;
    }

    @keyframes floating {
      0% { transform: translateY(0px); }
      50% { transform: translateY(-15px); }
      100% { transform: translateY(0px); }
    } */

    .alert {
      border-radius: 10px;
    }

    .password-toggle {
      position: absolute;
      right: 10px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
      color: var(--dark-color);
      opacity: 0.7;
    }
  </style>
</head>
<body>
  <!-- Animated Background Particles -->
  <div id="particles-js"></div>

  <div class="container login-container animate__animated animate__fadeIn">
    <div class="row justify-content-center">
      <div class="col-md-8 col-lg-6">
        <div class="login-card floating">
          <div class="text-center mb-4">
            <div class="brand-logo animate__animated animate__bounceIn">
              <i class="fas fa-couch"></i> FurniNest
            </div>
          </div>

          <h4 class="login-title animate__animated animate__fadeInDown">Admin Portal</h4>

          <?php if (isset($_SESSION['login_error'])): ?>
            <div class="alert alert-danger animate__animated animate__shakeX">
              <i class="fas fa-exclamation-circle me-2"></i>
              <?= $_SESSION['login_error']; unset($_SESSION['login_error']); ?>
            </div>
          <?php endif; ?>

          <form method="POST" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="animate__animated animate__fadeIn animate__delay-1s">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
            
            <div class="mb-4 position-relative">
              <label class="form-label">Username</label>
              <div class="input-group">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
                <input type="text" name="username" class="form-control" placeholder="Enter username" required autofocus>
              </div>
            </div>

            <div class="mb-4 position-relative">
              <label class="form-label">Password</label>
              <div class="input-group">
                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                <input type="password" name="password" id="password" class="form-control" placeholder="Enter password" required>
                <span class="password-toggle" id="togglePassword">
                  <i class="fas fa-eye"></i>
                </span>
              </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="rememberMe">
                <label class="form-check-label" for="rememberMe">Remember me</label>
              </div>
              <a href="#" class="forgot-pass">Forgot password?</a>
            </div>

            <button type="submit" name="login" class="btn login-btn">
              <i class="fas fa-sign-in-alt me-2"></i> Login
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Particles.js -->
  <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
  <!-- Custom JS -->
  <script>
    // Password toggle
    document.getElementById('togglePassword').addEventListener('click', function() {
      const password = document.getElementById('password');
      const icon = this.querySelector('i');
      if (password.type === 'password') {
        password.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
      } else {
        password.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
      }
    });

    // Particles.js initialization
    particlesJS("particles-js", {
      "particles": {
        "number": {
          "value": 80,
          "density": {
            "enable": true,
            "value_area": 800
          }
        },
        "color": {
          "value": "#ffffff"
        },
        "shape": {
          "type": "circle",
          "stroke": {
            "width": 0,
            "color": "#000000"
          }
        },
        "opacity": {
          "value": 0.5,
          "random": true,
          "anim": {
            "enable": true,
            "speed": 1,
            "opacity_min": 0.1,
            "sync": false
          }
        },
        "size": {
          "value": 3,
          "random": true,
          "anim": {
            "enable": true,
            "speed": 2,
            "size_min": 0.1,
            "sync": false
          }
        },
        "line_linked": {
          "enable": true,
          "distance": 150,
          "color": "#ffffff",
          "opacity": 0.4,
          "width": 1
        },
        "move": {
          "enable": true,
          "speed": 1,
          "direction": "none",
          "random": true,
          "straight": false,
          "out_mode": "out",
          "bounce": false,
          "attract": {
            "enable": true,
            "rotateX": 600,
            "rotateY": 1200
          }
        }
      },
      "interactivity": {
        "detect_on": "canvas",
        "events": {
          "onhover": {
            "enable": true,
            "mode": "grab"
          },
          "onclick": {
            "enable": true,
            "mode": "push"
          },
          "resize": true
        },
        "modes": {
          "grab": {
            "distance": 140,
            "line_linked": {
              "opacity": 1
            }
          },
          "push": {
            "particles_nb": 4
          }
        }
      },
      "retina_detect": true
    });

    // Add floating animation to card on hover
    const card = document.querySelector('.login-card');
    card.addEventListener('mouseenter', () => {
      card.classList.add('animate__animated', 'animate__pulse');
    });
    card.addEventListener('mouseleave', () => {
      card.classList.remove('animate__animated', 'animate__pulse');
    });
  </script>
</body>
</html>