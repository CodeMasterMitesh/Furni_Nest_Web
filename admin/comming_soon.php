<?php 
include('../partition/header.php');
?>
<div class="wrapper d-flex flex-column min-vh-100">
<main class="flex-grow-1">
<div class="container-fluid mt-5">
  <style>
    .coming-soon-container {
      background: white;
      padding: 60px;
      border-radius: 20px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }
    .logo {
      font-size: 2rem;
      font-weight: bold;
      color: #0d6efd;
    }
  </style>
  <div class="coming-soon-container">
    <div class="logo mb-4"></div>
    <h1 class="display-5 mb-3">Coming Soon</h1>
    <p class="lead mb-4">We are working hard to bring something amazing for you. Stay tuned!</p>
    <div class="spinner-border text-primary" role="status">
      <span class="visually-hidden">Loading...</span>
    </div>
  </div>
</div>
</div>
<?php include('../partition/footer.php'); ?>
