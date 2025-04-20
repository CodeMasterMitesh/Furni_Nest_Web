<?php
include '../config/conn.php';

if (isset($_POST['login'])) {
  print_r($_POST);
  // exit;
  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $password = $_POST['password'];

  $sql = "SELECT * FROM users WHERE username = '$username'";
  $res = mysqli_query($conn, $sql);
  // print_r($res);
  // // echo $sql;
  if (mysqli_num_rows($res) == 1) {
    $row = mysqli_fetch_assoc($res);
    if (password_verify($password, $row['password'])) {
        // print_r($row['password']);
        // exit;
      $_SESSION['admin_logged_in'] = true;
      $_SESSION['admin_username'] = $row['username'];
      $_SESSION['udata'] = $row;
      header("Location: dashboard.php");
      exit;
    } else {
      $_SESSION['login_error'] = "Invalid password.";
      header("Location: /admin/login.php");
      exit;
    }
  } else {
    $_SESSION['login_error'] = "Invalid username.";
    header("Location: /admin/login.php");
    exit;
  }
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
  <!-- Custom CSS -->
  <style>
    body {
      background: linear-gradient(135deg, #74ebd5 0%, #9face6 100%);
      font-family: 'Segoe UI', sans-serif;
    }

    .login-card {
      background: #fff;
      border-radius: 1rem;
      padding: 2rem;
      box-shadow: 0 0 30px rgba(0, 0, 0, 0.1);
    }

    .login-title {
      font-weight: 700;
      font-size: 1.5rem;
      color: #333;
    }

    .form-label {
      font-weight: 600;
    }

    .login-btn {
      font-weight: 600;
      background-color: #3f51b5;
      border: none;
    }

    .login-btn:hover {
      background-color: #303f9f;
    }

    .brand-logo {
      font-size: 2rem;
      font-weight: 700;
      color: #3f51b5;
    }
  </style>
</head>
<body>
  <div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="col-md-5">
      <div class="text-center mb-4">
        <div class="brand-logo">🪑 FurniNest</div>
      </div>

      <div class="login-card">
        <h4 class="login-title text-center mb-4">Admin Login</h4>

        <?php if (isset($_SESSION['login_error'])): ?>
          <div class="alert alert-danger">
            <?= $_SESSION['login_error']; unset($_SESSION['login_error']); ?>
          </div>
        <?php endif; ?>

        <form method="POST" action="<?= $_SERVER['PHP_SELF']; ?>">
          <div class="mb-3">
            <label class="form-label">Username / Email</label>
            <input type="text" name="username" class="form-control" placeholder="Enter username" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" placeholder="Enter password" required>
          </div>

          <button type="submit" name="login" class="btn btn-primary w-100 login-btn">Login</button>
        </form>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>