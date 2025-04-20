<?php 
include('partition/header.php'); 
?>
<link rel="stylesheet" href="/admin/assets/css/dashboard.css">
<div class="content">
<div class="wrapper d-flex flex-column min-vh-100">
  <main class="flex-grow-1">
    <div class="container mt-4">

      <!-- First Row -->
      <div class="row g-4 mb-4">
        <div class="col-md-3">
          <div class="dashboard-card bg-gradient-primary">
            <h6>Total Orders</h6>
            <div class="value">150</div>
            <i class="bi bi-cart-check card-icon"></i>
          </div>
        </div>
        <div class="col-md-3">
          <div class="dashboard-card bg-gradient-success">
            <h6>Today's Orders</h6>
            <div class="value">15</div>
            <i class="bi bi-calendar-day card-icon"></i>
          </div>
        </div>
        <div class="col-md-3">
          <div class="dashboard-card bg-gradient-warning">
            <h6>This Month's Orders</h6>
            <div class="value">75</div>
            <i class="bi bi-calendar3 card-icon"></i>
          </div>
        </div>
        <div class="col-md-3">
          <div class="dashboard-card bg-gradient-danger">
            <h6>This Year's Orders</h6>
            <div class="value">320</div>
            <i class="bi bi-calendar-range card-icon"></i>
          </div>
        </div>
      </div>

      <!-- Second Row -->
      <div class="row g-4 mb-4">
        <div class="col-md-3">
          <div class="dashboard-card bg-gradient-secondary">
            <h6>Total Customers</h6>
            <div class="value">120</div>
            <i class="bi bi-people card-icon"></i>
          </div>
        </div>
        <div class="col-md-3">
          <div class="dashboard-card bg-gradient-dark">
            <h6>This Month's Sales</h6>
            <div class="value">₹75,000</div>
            <i class="bi bi-graph-up-arrow card-icon"></i>
          </div>
        </div>
        <div class="col-md-3">
          <div class="dashboard-card bg-gradient-info">
            <h6>Today's Sales</h6>
            <div class="value">₹5,500</div>
            <i class="bi bi-currency-rupee card-icon"></i>
          </div>
        </div>
        <div class="col-md-3">
          <div class="dashboard-card bg-gradient-success">
            <h6>Total Products</h6>
            <div class="value">300</div>
            <i class="bi bi-box-seam card-icon"></i>
          </div>
        </div>
      </div>

      <!-- Chart -->
      <div class="row mb-5">
        <div class="col-12">
          <canvas id="salesChart" height="100"></canvas>
        </div>
      </div>

    </div>
  </main>
</div>
</div>

<script>
  const ctx = document.getElementById('salesChart');
  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
      datasets: [{
        label: 'Sales',
        data: [120, 150, 180, 90, 200],
        backgroundColor: 'rgba(54, 162, 235, 0.6)'
      }]
    }
  });
</script>

<?php include('partition/footer.php'); ?>