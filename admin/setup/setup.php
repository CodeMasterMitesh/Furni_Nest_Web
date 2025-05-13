<?php 
include('../partition/header.php'); 
?>
<!-- Custom CSS -->
<link rel="stylesheet" href="/admin/assets/css/setup.css">

<div class="content">
    <div class="wrapper d-flex flex-column min-vh-100">
        <main class="flex-grow-1">
            <div class="container-fluid setup-dashboard">
                <h2 class="section-title animate__animated animate__fadeIn">System Setup</h2>
                
                <div class="row g-4 mb-4">
                    <!-- Company Card -->
                    <div class="col-xl-3 col-md-6 animate__animated animate__fadeIn animate__delay-1s">
                        <div class="dashboard-card bg-gradient-primary position-relative">
                            <i class="bi bi-building card-icon"></i>
                            <h6 class="card-title">Company Setup</h6>
                            <a class="card-link" href="company/company.php"></a>
                        </div>
                    </div>
                    
                    <!-- Branch Card -->
                    <div class="col-xl-3 col-md-6 animate__animated animate__fadeIn animate__delay-2s">
                        <div class="dashboard-card bg-gradient-success position-relative">
                            <i class="bi bi-diagram-3 card-icon"></i>
                            <h6 class="card-title">Branch Management</h6>
                            <a class="card-link" href="branch/branch.php"></a>
                        </div>
                    </div>
                    
                    <!-- Location Card -->
                    <div class="col-xl-3 col-md-6 animate__animated animate__fadeIn animate__delay-3s">
                        <div class="dashboard-card bg-gradient-info position-relative">
                            <i class="bi bi-geo-alt card-icon"></i>
                            <h6 class="card-title">Location Setup</h6>
                            <a class="card-link" href="location/location.php"></a>
                        </div>
                    </div>
                    
                    <!-- Software Card -->
                    <div class="col-xl-3 col-md-6 animate__animated animate__fadeIn animate__delay-4s">
                        <div class="dashboard-card bg-gradient-warning position-relative">
                            <i class="bi bi-cpu card-icon"></i>
                            <h6 class="card-title">Software Configuration</h6>
                            <a class="card-link" href="software/software.php"></a>
                        </div>
                    </div>
                </div>
                
                <div class="row g-4">
                    <!-- Modules Card -->
                    <div class="col-xl-3 col-md-6 animate__animated animate__fadeIn animate__delay-5s">
                        <div class="dashboard-card bg-gradient-danger position-relative">
                            <i class="bi bi-grid-3x3-gap card-icon"></i>
                            <h6 class="card-title">Modules Setup</h6>
                            <a class="card-link" href="modules/modules.php"></a>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 animate__animated animate__fadeIn animate__delay-5s">
                        <div class="dashboard-card bg-gradient-secondary position-relative">
                            <i class="bi bi-grid-3x3-gap card-icon"></i>
                            <h6 class="card-title">Assign Rights</h6>
                            <a class="card-link" href="assignrights.php"></a>
                        </div>
                    </div>
                    
                    <!-- Add more cards here as needed -->
                    <!--
                    <div class="col-xl-3 col-md-6">
                        <div class="dashboard-card bg-gradient-secondary position-relative">
                            <i class="bi bi-gear card-icon"></i>
                            <h6 class="card-title">System Settings</h6>
                            <a class="card-link" href="settings/system.php"></a>
                        </div>
                    </div>
                    -->
                </div>
            </div>
        </main>
    </div>
</div>

<?php include('../partition/footer.php'); ?>