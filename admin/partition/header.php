<?php 
include_once(__DIR__ . '/../../config/conn.php'); 
if (!isset($_SESSION['admin_logged_in'])) {
  header("Location: /admin/login.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>FurniNest Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/admin/assets/css/header.css">
</head>
<body>
<!-- !-- Navbar -->
<nav class="navbar navbar-expand-lg sticky-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="dashboard.php">FurniNest</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarMenu">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center">

        <li class="nav-item">
          <a class="nav-link active" href="/admin/dashboard.php"><i class="bi bi-speedometer2"></i>Dashboard</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="orders.php"><i class="bi bi-cart-check"></i>Orders</a>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
            <i class="bi bi-grid-3x3-gap"></i>Masters
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="/admin/masters/category/category.php"><i class="bi bi-tag"></i> Category</a></li>
            <li><a class="dropdown-item" href="/admin/masters/product/product.php"><i class="bi bi-box-seam"></i> Products</a></li>
            <li><a class="dropdown-item" href="/admin/masters/colors/colors.php"><i class="bi bi-palette2"></i> Colors</a></li>
          </ul>
        </li>

        <!-- Profile -->
        <li class="nav-item dropdown ms-3">
          <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-person-circle fs-5"></i>
            <span class="ms-2"><?php echo $_SESSION['udata']['display_name']; ?></span>
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
            <li><a class="dropdown-item" href="profile.php"><i class="bi bi-person me-2"></i>Profile</a></li>
            <li><a class="dropdown-item" href="settings.php"><i class="bi bi-gear me-2"></i>Settings</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item text-danger" href="/admin/logout.php"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
          </ul>
        </li>

      </ul>
    </div>
  </div>
</nav>