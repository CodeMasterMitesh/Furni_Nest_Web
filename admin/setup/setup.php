<?php 
include('../partition/header.php'); 
?>
<link rel="stylesheet" href="/admin/assets/css/dashboard.css">
<style>
    .dashboard-card {
    height: 150px; /* or any height you want */
    display: flex;
    /* flex-direction: column; */
    justify-content: center;
    align-items:center;
    line-height:150px;
    padding: 1rem;
    border-radius: 12px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .card-icon {
    font-size: 2rem;
    align-self: flex-start;
    }
    .dashboard-card .card-icon{
        left:50px;
        top:0px;
    }
    .dashboard-card a{
        text-decoration:none;
    }

</style>
<div class="content">
<div class="wrapper d-flex flex-column min-vh-100">
  <main class="flex-grow-1">
    <div class="container-fluid mt-4">

      <!-- First Row -->
      <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="dashboard-card bg-gradient-primary">
                <i class="bi bi-building card-icon"></i>
                <h6><a class="text-white" href="company/company.php">Company</a></h6>
            </div>
        </div>
        <div class="col-md-3">
            <div class="dashboard-card bg-gradient-success">
                <i class="bi bi-diagram-3 card-icon"></i>
                <h6><a class="text-white" href="branch/branch.php">Branch</a></h6>
            </div>
        </div>
        <div class="col-md-3">
            <div class="dashboard-card bg-gradient-warning">
                <i class="bi bi-geo-alt card-icon"></i>
                <h6><a class="text-white" href="location/location.php">Location</a></h6>
            </div>
        </div>
        </div>

        </div>
    </main>
    </div>
</div>


<?php include('../partition/footer.php'); ?>