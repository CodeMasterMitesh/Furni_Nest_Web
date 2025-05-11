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

  <!-- datatable css  -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="/admin/assets/css/header.css">
  <style>
/* Position sub-menu correctly */
.dropdown-submenu {
  position: relative;
}

.dropdown-submenu .dropdown-menu {
  top: 0;
  left: 100%;
  margin-top: -1px;
}
</style>

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
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
            <i class="bi bi-person-badge"></i> HR
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="/admin/hr/hrdashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
            <li><a class="dropdown-item" href="/admin/hr/employee.php"><i class="bi bi-person-lines-fill"></i> Employee</a></li>
            <li><a class="dropdown-item" href="/admin/hr/event.php"><i class="bi bi-calendar-event"></i> Event</a></li>
            <li><a class="dropdown-item" href="/admin/hr/attendance.php"><i class="bi bi-clipboard-check"></i> Attendance</a></li>
            <li><a class="dropdown-item" href="/admin/hr/leaves.php"><i class="bi bi-calendar-x"></i> Leaves</a></li>
            <li><a class="dropdown-item" href="/admin/hr/salary.php"><i class="bi bi-currency-rupee"></i> Salary</a></li>
            <li><a class="dropdown-item" href="/admin/hr/task.php"><i class="bi bi-list-check"></i> Task</a></li>
            <li><a class="dropdown-item" href="/admin/hr/assets.php"><i class="bi bi-hdd-stack"></i> Assets</a></li>
            <li><a class="dropdown-item" href="/admin/hr/request.php"><i class="bi bi-inbox"></i> Request</a></li>

          </ul>
        </li>

        <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
          <i class="bi bi-cash-stack"></i> Accounts
        </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="/admin/accounts/receipt.php"><i class="bi bi-receipt"></i> Receipt</a></li>
            <li><a class="dropdown-item" href="/admin/accounts/multireceipt.php"><i class="bi bi-files"></i>Multi Receipt</a></li>
            <li><a class="dropdown-item" href="/admin/accounts/payment.php"><i class="bi bi-cash-stack"></i>Payment</a></li>
            <li><a class="dropdown-item" href="/admin/accounts/multipayment.php"><i class="bi bi-wallet2"></i>Multi Payment</a></li>
            <li><a class="dropdown-item" href="/admin/accounts/voucher.php"><i class="bi bi-ticket-perforated"></i> Voucher</a></li>
            <li><a class="dropdown-item" href="/admin/accounts/stockjournal.php"><i class="bi bi-journal-text"></i> Stock Journal</a></li>
          </ul>
        </li>

        <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
          <i class="bi bi-people"></i> CRM
        </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="/admin/crm/crmdashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
            <li><a class="dropdown-item" href="/admin/crm/leads.php"><i class="bi bi-person-plus"></i> Lead</a></li>
            <li><a class="dropdown-item" href="/admin/crm/inquiry.php"><i class="bi bi-question-circle"></i> Inquiry</a></li>
            <li><a class="dropdown-item" href="/admin/crm/quotation.php"><i class="bi bi-receipt"></i> Quotation</a></li>
            <li><a class="dropdown-item" href="/admin/crm/task.php"><i class="bi bi-list-task"></i> Task</a></li>
            <li><a class="dropdown-item" href="/admin/crm/expense.php"><i class="bi bi-cash-coin"></i> Expense</a></li>
            <li><a class="dropdown-item" href="/admin/crm/target.php"><i class="bi bi-bullseye"></i> Target</a></li>
          </ul>
        </li>

        <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
          <i class="bi bi-box-seam"></i> Inventory
        </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="/admin/inventory/materialrequest.php"><i class="bi bi-journal-plus"></i> Material Request</a></li>
            <li><a class="dropdown-item" href="/admin/inventory/materialindent.php"><i class="bi bi-file-text"></i> Material Indent</a></li>
            <li><a class="dropdown-item" href="/admin/inventory/purchaseorder.php"><i class="bi bi-cart-check"></i> Purchase Order</a></li>
            <li><a class="dropdown-item" href="/admin/inventory/grn.php"><i class="bi bi-box-arrow-in-down"></i> GRN</a></li>
            <li><a class="dropdown-item" href="/admin/inventory/qc.php"><i class="bi bi-shield-check"></i> QC</a></li>
            <li><a class="dropdown-item" href="/admin/inventory/stocktransfer.php"><i class="bi bi-arrow-left-right"></i> Stock Transfer</a></li>
          </ul>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
            <i class="bi bi-grid-3x3-gap"></i> Masters
          </a>
          <ul class="dropdown-menu">
            <!-- Sub-dropdown: HR -->
            <li class="dropdown-submenu">
              <a class="dropdown-item dropdown-toggle"><i class="bi bi-person-badge"></i> Inventory</a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="/admin/masters/inventory/category.php"><i class="bi bi-tag"></i> Category</a></li>
                <li><a class="dropdown-item" href="/admin/masters/inventory/product.php"><i class="bi bi-box-seam"></i> Products</a></li>
                <li><a class="dropdown-item" href="/admin/masters/inventory/colors.php"><i class="bi bi-palette2"></i> Colors</a></li>
              </ul>
            </li>
            
            <!-- Sub-dropdown: HR -->
            <li class="dropdown-submenu">
              <a class="dropdown-item dropdown-toggle"><i class="bi bi-person-badge"></i> HR</a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="/admin/masters/hr/department.php"><i class="bi bi-building"></i> Department</a></li>
                <li><a class="dropdown-item" href="/admin/masters/hr/designation.php"><i class="bi bi-person-workspace"></i> Designation</a></li>
              </ul>
            </li>
          </ul>
        </li>

        <!-- reports  -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
            <i class="bi bi-bar-chart-line"></i> Reports
          </a>
          <ul class="dropdown-menu">
            <!-- Sub-dropdown: HR -->
            <li class="dropdown-submenu">
              <a class="dropdown-item dropdown-toggle"><i class="bi bi-person-badge"></i> HR</a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="/admin/reports/hr/attandancereport.php"><i class="bi bi-clock-history"></i> Attandance Report</a></li>
              </ul>
            </li>
            
            <!-- Sub-dropdown: Accounts -->
            <li class="dropdown-submenu">
              <a class="dropdown-item dropdown-toggle"><i class="bi bi-cash-stack"></i> Accounts</a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="/admin/reports/accounts/department.php"><i class="bi bi-file-earmark-text"></i> Receipt Report</a></li>
              </ul>
            </li>
          </ul>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
            <i class="bi bi-globe"></i> Website
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="website/orders.php"><i class="bi bi-journal-plus"></i> Orders</a></li>
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
            <li><a class="dropdown-item" href="setup/setup.php"><i class="bi bi-gear me-2"></i>Setup</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item text-danger" href="/admin/logout.php"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
          </ul>
        </li>

      </ul>
    </div>
  </div>
</nav>