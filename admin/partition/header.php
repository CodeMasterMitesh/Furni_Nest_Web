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
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
<!-- Navbar -->
<nav class="navbar navbar-expand-lg sticky-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="dashboard.php">FurniNest</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarMenu">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center">
        <!-- Dashboard (always visible) -->
        <li class="nav-item">
          <a class="nav-link active" href="/admin/dashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
        </li>

        <?php
        // Fetch main navigation items from software table
        $mainNavQuery = "SELECT * FROM software ORDER BY sort";
        $mainNavResult = mysqli_query($conn, $mainNavQuery);
        
        while ($mainNav = mysqli_fetch_assoc($mainNavResult)) {
            // Check if user has any permissions in this software section
            $hasPermissionInSection = false;
            $modulesQuery = "SELECT * FROM modules WHERE sid = {$mainNav['id']} AND parent_id IS NULL ORDER BY sort";
            $modulesResult = mysqli_query($conn, $modulesQuery);
            
            // First pass to check if any modules are accessible
            $accessibleModules = [];
            while ($module = mysqli_fetch_assoc($modulesResult)) {
                if (isSuperAdmin() || isset($_SESSION['user_rights'][$module['id']])) {
                    $hasPermissionInSection = true;
                    $accessibleModules[] = $module;
                }
            }
            
            // Reset pointer for second pass
            mysqli_data_seek($modulesResult, 0);
            
            if ($hasPermissionInSection) {
                // Main nav item with dropdown
                echo '<li class="nav-item dropdown">';
                echo '<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">';
                echo '<i class="bi ' . htmlspecialchars($mainNav['icon']) . '"></i> ' . htmlspecialchars($mainNav['name']);
                echo '</a>';
                echo '<ul class="dropdown-menu">';
                
                // Second pass to build the menu
                foreach ($accessibleModules as $module) {
                    // Check if this module has sub-modules
                    $subModulesQuery = "SELECT * FROM modules WHERE parent_id = {$module['id']} ORDER BY sort";
                    $subModulesResult = mysqli_query($conn, $subModulesQuery);
                    
                    $accessibleSubModules = [];
                    while ($subModule = mysqli_fetch_assoc($subModulesResult)) {
                        if (isSuperAdmin() || isset($_SESSION['user_rights'][$subModule['id']])) {
                            $accessibleSubModules[] = $subModule;
                        }
                    }
                    
                    if (!empty($accessibleSubModules)) {
                        // Module with sub-dropdown
                        echo '<li class="dropdown-submenu">';
                        echo '<a class="dropdown-item dropdown-toggle"><i class="bi ' . htmlspecialchars($module['icon']) . '"></i> ' . htmlspecialchars($module['name']) . '</a>';
                        echo '<ul class="dropdown-menu">';
                        
                        foreach ($accessibleSubModules as $subModule) {
                            echo '<li><a class="dropdown-item" href="' . htmlspecialchars($subModule['url']) . '">';
                            echo '<i class="bi ' . htmlspecialchars($subModule['icon']) . '"></i> ' . htmlspecialchars($subModule['name']);
                            echo '</a></li>';
                        }
                        
                        echo '</ul></li>';
                    } else {
                        // Regular module item (only show if user has view permission)
                        if (isSuperAdmin() || isset($_SESSION['user_rights'][$module['id']])) {
                            echo '<li><a class="dropdown-item" href="' . htmlspecialchars($module['url']) . '">';
                            echo '<i class="bi ' . htmlspecialchars($module['icon']) . '"></i> ' . htmlspecialchars($module['name']);
                            echo '</a></li>';
                        }
                    }
                }
                
                echo '</ul></li>';
            }
        }
        ?>

        <!-- Profile (always visible) -->
        <li class="nav-item dropdown ms-3">
          <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-person-circle fs-5"></i>
            <span class="ms-2"><?php echo htmlspecialchars($_SESSION['udata']['display_name'] ?? 'User'); ?></span>
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
            <li><a class="dropdown-item" href="admin/profile.php"><i class="bi bi-person me-2"></i>Profile</a></li>
            <?php if (isSuperAdmin() || isset($_SESSION['user_rights']['settings'])): ?>
              <li><a class="dropdown-item" href="settings.php"><i class="bi bi-gear me-2"></i>Settings</a></li>
            <?php endif; ?>
            <?php if (isSuperAdmin()): ?>
              <li><a class="dropdown-item" href="/admin/setup/setup.php"><i class="bi bi-gear me-2"></i>Setup</a></li>
            <?php endif; ?>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item text-danger" href="/admin/logout.php"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Add this CSS for dropdown-submenu -->
<style>
  .dropdown-submenu {
    position: relative;
  }
  
  .dropdown-submenu .dropdown-menu {
    top: 0;
    left: 100%;
    margin-top: -1px;
    margin-left: .1rem;
  }
  
  .dropdown-submenu:hover .dropdown-menu {
    display: block;
  }
  
  @media (min-width: 992px) {
    .dropdown-menu {
      margin-top: 0;
    }
  }
</style>

<!-- Add this JavaScript for better dropdown interaction -->
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Enable Bootstrap dropdowns
  var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'));
  var dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
    return new bootstrap.Dropdown(dropdownToggleEl);
  });
  
  // Handle submenu hover on desktop
  if (window.innerWidth >= 992) {
    document.querySelectorAll('.dropdown-submenu').forEach(function(element) {
      element.addEventListener('mouseenter', function() {
        this.querySelector('.dropdown-menu').classList.add('show');
      });
      element.addEventListener('mouseleave', function() {
        this.querySelector('.dropdown-menu').classList.remove('show');
      });
    });
  }
});
</script>