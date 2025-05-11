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

    // Using prepared statement
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($res) == 1) {
        $row = mysqli_fetch_assoc($res);
        if (password_verify($password, $row['password'])) {
            session_regenerate_id(true);
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = $row['username'];
            $_SESSION['udata'] = $row;
            
            // Update last login
            $update_sql = "UPDATE users SET last_login = NOW() WHERE id = ?";
            $update_stmt = mysqli_prepare($conn, $update_sql);
            mysqli_stmt_bind_param($update_stmt, "i", $row['id']);
            mysqli_stmt_execute($update_stmt);
            
            header("Location: dashboard.php");
            exit;
        } else {
            sleep(1); // Anti-brute force
            $_SESSION['login_error'] = "Invalid credentials.";
        }
    } else {
        sleep(1); // Anti-brute force
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
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root {
      --primary: #4f46e5;
      --primary-dark: #4338ca;
      --gray-100: #f3f4f6;
      --gray-700: #374151;
      --gray-900: #111827;
    }
    
    body {
      background-color: var(--gray-100);
      font-family: 'Inter', sans-serif;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .login-container {
      width: 100%;
      max-width: 420px;
      padding: 0 15px;
    }

    .login-card {
      background: white;
      border-radius: 12px;
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
      padding: 2.5rem;
      border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .brand-logo {
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 2rem;
      color: var(--gray-900);
      font-size: 1.75rem;
      font-weight: 700;
    }

    .brand-logo i {
      color: var(--primary);
      margin-right: 0.75rem;
      font-size: 2rem;
    }

    .login-title {
      font-size: 1.5rem;
      font-weight: 600;
      color: var(--gray-900);
      margin-bottom: 1.5rem;
      text-align: center;
    }

    .form-label {
      font-weight: 500;
      color: var(--gray-700);
      margin-bottom: 0.5rem;
    }

    .form-control {
      border-radius: 8px;
      padding: 0.75rem 1rem;
      border: 1px solid #d1d5db;
      transition: border-color 0.2s;
    }

    .form-control:focus {
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
    }

    .input-group-text {
      background-color: white;
      border-right: none;
    }

    .login-btn {
      background-color: var(--primary);
      border: none;
      padding: 0.75rem;
      font-weight: 500;
      width: 100%;
      border-radius: 8px;
      margin-top: 1rem;
    }

    .login-btn:hover {
      background-color: var(--primary-dark);
    }

    .password-toggle {
      position: absolute;
      right: 12px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
      color: var(--gray-700);
    }

    .alert {
      border-radius: 8px;
    }

    .divider {
      display: flex;
      align-items: center;
      margin: 1.5rem 0;
      color: var(--gray-700);
    }

    .divider::before,
    .divider::after {
      content: "";
      flex: 1;
      border-bottom: 1px solid #e5e7eb;
    }

    .divider::before {
      margin-right: 1rem;
    }

    .divider::after {
      margin-left: 1rem;
    }
  </style>
</head>
<body>
  <div class="login-container">
    <div class="login-card">
      <div class="brand-logo">
        <i class="fas fa-couch"></i>
        <span>FurniNest</span>
      </div>

      <h4 class="login-title">Admin Portal</h4>

      <?php if (isset($_SESSION['login_error'])): ?>
        <div class="alert alert-danger mb-4">
          <i class="fas fa-exclamation-circle me-2"></i>
          <?= $_SESSION['login_error']; unset($_SESSION['login_error']); ?>
        </div>
      <?php endif; ?>

      <form method="POST" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
        
        <div class="mb-3">
          <label class="form-label">Username</label>
          <div class="input-group">
            <span class="input-group-text"><i class="fas fa-user"></i></span>
            <input type="text" name="username" class="form-control" placeholder="Enter username" required autofocus>
          </div>
        </div>

        <div class="mb-3 position-relative">
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
          <a href="#" class="text-decoration-none text-primary">Forgot password?</a>
        </div>

        <button type="submit" name="login" class="btn btn-primary login-btn">
          <i class="fas fa-sign-in-alt me-2"></i> Login
        </button>
      </form>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
  </script>
</body>
</html>