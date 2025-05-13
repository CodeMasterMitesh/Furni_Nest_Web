<?php 
include('partition/header.php');
// echo "<pre>";
// print_r($_SESSION['user_rights']);
// echo "</pre>";
// exit;
$orderStats = getOrderStats($conn);
?>
<link rel="stylesheet" href="/admin/assets/css/dashboard.css">

<div class="content">
    <div class="wrapper d-flex flex-column min-vh-100">
        <main class="flex-grow-1">
            <div class="container-fluid dashboard-container">
                <h2 class="section-title">Dashboard Overview</h2>
                
                <!-- First Row -->
                <div class="row g-4 mb-4">
                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                        <div class="dashboard-card card-success">
                            <h6>Today's Orders</h6>
                            <div class="value"><?= $orderStats['today_orders'] ?></div>
                            <i class="bi bi-calendar-day card-icon"></i>
                        </div>
                    </div>
                    
                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                        <div class="dashboard-card card-warning">
                            <h6>This Month's Orders</h6>
                            <div class="value"><?= $orderStats['month_orders'] ?></div>
                            <i class="bi bi-calendar3 card-icon"></i>
                        </div>
                    </div>
                    
                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                        <div class="dashboard-card card-danger">
                            <h6>This Year's Orders</h6>
                            <div class="value"><?= $orderStats['year_orders'] ?></div>
                            <i class="bi bi-calendar-range card-icon"></i>
                        </div>
                    </div>
                    
                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                        <div class="dashboard-card card-secondary">
                            <h6>Total Customers</h6>
                            <div class="value">120</div>
                            <i class="bi bi-people card-icon"></i>
                        </div>
                    </div>
                </div>
                
                <!-- Second Row -->
                <div class="row g-4 mb-4">
                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                        <div class="dashboard-card card-dark">
                            <h6>This Month's Sales</h6>
                            <div class="value"><?= $orderStats['month_amount'] ?></div>
                            <i class="bi bi-graph-up-arrow card-icon"></i>
                        </div>
                    </div>
                    
                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                        <div class="dashboard-card card-info">
                            <h6>Today's Sales</h6>
                            <div class="value"><?= $orderStats['today_amount'] ?></div>
                            <i class="bi bi-currency-rupee card-icon"></i>
                        </div>
                    </div>
                    
                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                        <div class="dashboard-card card-primary">
                            <h6>Yearly Sales</h6>
                            <div class="value"><?= $orderStats['year_amount'] ?></div>
                            <i class="bi bi-cart-check card-icon"></i>
                        </div>
                    </div>
                    
                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                        <div class="dashboard-card card-success">
                            <h6>Total Products</h6>
                            <div class="value">300</div>
                            <i class="bi bi-box-seam card-icon"></i>
                        </div>
                    </div>
                </div>
                
                <!-- Chart Section -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="chart-container">
                            <canvas id="salesChart" height="100"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('salesChart');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Monthly Sales (₹)',
                data: [12000, 15000, 18000, 9000, 20000, 17000, 21000, 19000, 23000, 25000, 30000, 35000],
                backgroundColor: 'rgba(78, 115, 223, 0.7)',
                borderColor: 'rgba(78, 115, 223, 1)',
                borderWidth: 1,
                borderRadius: 8,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        font: {
                            family: 'Inter',
                            size: 13,
                            weight: 'bold'
                        },
                        padding: 20,
                        color: '#2d3748'
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(45, 55, 72, 0.95)',
                    titleFont: {
                        size: 14,
                        weight: 'bold',
                        family: 'Inter'
                    },
                    bodyFont: {
                        size: 13,
                        family: 'Inter'
                    },
                    padding: 12,
                    cornerRadius: 8,
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            return '₹' + context.raw.toLocaleString();
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)',
                        drawBorder: false
                    },
                    ticks: {
                        font: {
                            family: 'Inter'
                        },
                        callback: function(value) {
                            return '₹' + value.toLocaleString();
                        }
                    }
                },
                x: {
                    grid: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        font: {
                            family: 'Inter'
                        }
                    }
                }
            }
        }
    });
</script>

<?php include('partition/footer.php'); ?>