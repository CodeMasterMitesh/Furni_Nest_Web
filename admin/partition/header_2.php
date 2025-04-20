<?php include_once(__DIR__ . '/../../config/conn.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>FurniNest Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
  body {
    font-family: 'Poppins', sans-serif;
    background-color: #f3f4f6;
    margin: 0;
  }

  .navbar {
    background: linear-gradient(to right, #ffffffcc, #f0f0f0cc);
    backdrop-filter: blur(15px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
    border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    transition: all 0.3s ease-in-out;
    position: sticky;
    top: 0;
    z-index: 1030;
  }

  .navbar-brand {
    font-weight: 700;
    font-size: 1.5rem;
    display: flex;
    align-items: center;
    color: #333 !important;
  }

  .navbar-brand img {
    height: 32px;
    margin-right: 10px;
  }

  .navbar-nav .nav-link {
    font-weight: 500;
    color: #333 !important;
    transition: 0.3s ease;
  }

  .navbar-nav .nav-link:hover,
  .navbar-nav .nav-link.active {
    color: #6c5ce7 !important;
    text-shadow: 0 0 5px rgba(108, 92, 231, 0.2);
    transform: scale(1.05);
  }

  .dropdown-menu {
    border-radius: 12px;
    animation: fadeIn 0.3s ease-in-out;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
  }

  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(-5px); }
    to { opacity: 1; transform: translateY(0); }
  }

  .navbar-toggler {
    border: none;
  }

  .navbar-toggler:focus {
    outline: none;
    box-shadow: none;
  }

  .sidebar {
    height: 100vh;
    width: 220px;
    position: fixed;
    top: 0;
    left: 0;
    background: #ffffff;
    box-shadow: 2px 0 12px rgba(0, 0, 0, 0.05);
    padding: 1rem;
    z-index: 1020;
  }

  .sidebar a {
    display: block;
    padding: 10px 15px;
    margin: 5px 0;
    color: #333;
    text-decoration: none;
    border-radius: 8px;
    transition: 0.3s;
  }

  .sidebar a:hover,
  .sidebar a.active {
    background-color: #6c5ce7;
    color: white;
    box-shadow: 0 0 10px rgba(108, 92, 231, 0.3);
  }

  .content {
    margin-left: 230px;
    padding: 2rem;
  }
</style>
</head>
<body>
<!-- !-- Navbar -->
<div class="sidebar">
  <a href="dashboard.php" class="active"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a>
  <a href="orders.php"><i class="bi bi-cart-check me-2"></i> Orders</a>
  <a href="category.php"><i class="bi bi-tag me-2"></i> Category</a>
  <a href="product.php"><i class="bi bi-box-seam me-2"></i> Products</a>
  <a href="colors.php"><i class="bi bi-palette2 me-2"></i> Colors</a>
</div>
<nav class="navbar navbar-expand-lg">
  <div class="container-fluid">
    <a class="navbar-brand" href="dashboard.php">
      FurniNest
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarMenu">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-person-circle fs-5"></i><span class="ms-2">User</span>
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
            <li><a class="dropdown-item" href="profile.php"><i class="bi bi-person me-2"></i>Profile</a></li>
            <li><a class="dropdown-item" href="settings.php"><i class="bi bi-gear me-2"></i>Settings</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item text-danger" href="logout.php"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>