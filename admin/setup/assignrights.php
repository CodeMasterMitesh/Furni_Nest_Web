<?php
include('../partition/header.php');

// Regular page load continues below
// Fetch all users
$users = [];
$userQuery = "SELECT id, username, first_name FROM users WHERE role like '%employee%' ORDER BY first_name";
$userResult = mysqli_query($conn, $userQuery);
while ($row = mysqli_fetch_assoc($userResult)) {
    $users[] = $row;
}

// Fetch all software, modules, and sub-modules with hierarchy
$softwareData = [];
$softwareQuery = "SELECT s.id as software_id, s.name as software_name, s.icon,
                 m.id as module_id, m.name as module_name, m.icon as module_icon,
                 sm.id as submodule_id, sm.name as submodule_name, sm.icon as submodule_icon
                 FROM software s
                 LEFT JOIN modules m ON s.id = m.sid AND m.parent_id IS NULL
                 LEFT JOIN modules sm ON m.id = sm.parent_id
                 ORDER BY s.sort, m.sort, sm.sort";
$softwareResult = mysqli_query($conn, $softwareQuery);

while ($row = mysqli_fetch_assoc($softwareResult)) {
    $softwareId = $row['software_id'];
    $moduleId = $row['module_id'];
    $submoduleId = $row['submodule_id'];
    
    // Initialize software if not exists
    if (!isset($softwareData[$softwareId])) {
        $softwareData[$softwareId] = [
            'name' => $row['software_name'] ?? '',
            'icon' => $row['icon'] ?? 'bi-grid',
            'modules' => []
        ];
    }
    
    // Add module if it exists and not already added
    if ($moduleId && !isset($softwareData[$softwareId]['modules'][$moduleId])) {
        $softwareData[$softwareId]['modules'][$moduleId] = [
            'name' => $row['module_name'] ?? '',
            'icon' => $row['module_icon'] ?? 'bi-circle',
            'submodules' => []
        ];
    }
    
    // Add submodule if it exists
    if ($submoduleId) {
        $softwareData[$softwareId]['modules'][$moduleId]['submodules'][$submoduleId] = [
            'name' => $row['submodule_name'] ?? '',
            'icon' => $row['submodule_icon'] ?? 'bi-circle-fill'
        ];
    }
}

// Fetch existing rights if user is selected
$existingRights = [];
$userId = isset($_POST['user_id']) ? (int)$_POST['user_id'] : null;
if ($userId) {
    $rightsQuery = "SELECT module_id, can_view, can_add, can_edit, can_delete 
                    FROM user_rights 
                    WHERE user_id = ?";
    $stmt = mysqli_prepare($conn, $rightsQuery);
    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);
    $rightsResult = mysqli_stmt_get_result($stmt);
    
    while ($row = mysqli_fetch_assoc($rightsResult)) {
        $existingRights[$row['module_id']] = [
            'view' => $row['can_view'],
            'add' => $row['can_add'],
            'edit' => $row['can_edit'],
            'delete' => $row['can_delete']
        ];
    }
}
?>

<style>
    .rights-container {
        background: white;
        border-radius: 10px;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        padding: 1.5rem;
    }
    
    .accordion-button {
        font-weight: 600;
        padding: 1rem 1.5rem;
    }
    
    .accordion-button:not(.collapsed) {
        background-color: rgba(78, 115, 223, 0.05);
        color: #4e73df;
    }
    
    .accordion-button::after {
        background-size: 1.25rem;
    }
    
    .module-item {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #f0f0f0;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
    }
    
    .module-name {
        flex: 1;
        font-weight: 500;
        min-width: 200px;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .rights-checkboxes {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }
    
    .checkbox-group {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        min-width: 80px;
    }
    
    .submodule-item {
        padding: 0.75rem 1.5rem 0.75rem 3rem;
        border-bottom: 1px solid #f8f8f8;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        background-color: #fafafa;
    }
    
    .form-select {
        max-width: 300px;
    }
    
    .user-select-form {
        margin-bottom: 2rem;
        padding: 1.5rem;
        background: #f8f9fa;
        border-radius: 8px;
    }
    
    @media (max-width: 768px) {
        .module-item, .submodule-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }
        
        .module-name {
            min-width: 100%;
        }
        
        .rights-checkboxes {
            width: 100%;
        }
    }
    
    /* Loading overlay */
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
        display: none;
    }
    
    .loading-spinner {
        border: 5px solid #f3f3f3;
        border-top: 5px solid #3498db;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>

<div class="content">
    <div class="wrapper d-flex flex-column min-vh-100">
        <main class="flex-grow-1">
            <div class="container-fluid mt-4">
                <h2 class="mb-4">Assign User Rights</h2>
                
                <div class="user-select-form">
                    <form method="POST" action="assignrights.php" class="row g-3 align-items-center">
                        <div class="col-md-6">
                            <label for="userSelect" class="form-label">Select User</label>
                            <select class="form-select" id="userSelect" name="user_id" onchange="this.form.submit()">
                                <option value="">-- Select User --</option>
                                <?php foreach ($users as $user): ?>
                                    <option value="<?= htmlspecialchars($user['id']) ?>" 
                                        <?= $userId === $user['id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($user['first_name'] ?? $user['username']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <?php if ($userId): ?>
                        <div class="col-md-6 d-flex align-items-end">
                            <button type="button" class="btn btn-outline-secondary" onclick="window.location.href='assignrights.php'">
                                <i class="bi bi-x-circle me-1"></i> Clear Selection
                            </button>
                        </div>
                        <?php endif; ?>
                    </form>
                </div>
                
                <?php if ($userId): ?>
                <form id="rightsForm" method="POST" action="userrights.php">
                    <input type="hidden" name="user_id" value="<?= htmlspecialchars($userId) ?>">
                    
                    <div class="rights-container">
                        <div class="accordion" id="softwareAccordion">
                            <?php foreach ($softwareData as $softwareId => $software): ?>
                                <?php if (!empty($software['modules'])): ?>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading<?= $softwareId ?>">
                                        <button class="accordion-button collapsed" type="button" 
                                                data-bs-toggle="collapse" data-bs-target="#collapse<?= $softwareId ?>" 
                                                aria-expanded="false" aria-controls="collapse<?= $softwareId ?>">
                                            <i class="bi <?= htmlspecialchars($software['icon']) ?> me-2"></i>
                                            <?= htmlspecialchars($software['name']) ?>
                                        </button>
                                    </h2>
                                    <div id="collapse<?= $softwareId ?>" class="accordion-collapse collapse" 
                                         aria-labelledby="heading<?= $softwareId ?>" data-bs-parent="#softwareAccordion">
                                        <div class="accordion-body p-0">
                                            <?php foreach ($software['modules'] as $moduleId => $module): ?>
                                                <!-- Main Module -->
                                                <div class="module-item">
                                                    <div class="module-name">
                                                        <i class="bi <?= htmlspecialchars($module['icon']) ?>"></i>
                                                        <?= htmlspecialchars($module['name']) ?>
                                                    </div>
                                                    <div class="rights-checkboxes">
                                                        <div class="checkbox-group">
                                                            <input type="checkbox" id="view_<?= $moduleId ?>" 
                                                                   name="rights[<?= $moduleId ?>][view]" 
                                                                   <?= isset($existingRights[$moduleId]['view']) && $existingRights[$moduleId]['view'] ? 'checked' : '' ?>>
                                                            <label for="view_<?= $moduleId ?>">View</label>
                                                        </div>
                                                        <div class="checkbox-group">
                                                            <input type="checkbox" id="add_<?= $moduleId ?>" 
                                                                   name="rights[<?= $moduleId ?>][add]" 
                                                                   <?= isset($existingRights[$moduleId]['add']) && $existingRights[$moduleId]['add'] ? 'checked' : '' ?>>
                                                            <label for="add_<?= $moduleId ?>">Add</label>
                                                        </div>
                                                        <div class="checkbox-group">
                                                            <input type="checkbox" id="edit_<?= $moduleId ?>" 
                                                                   name="rights[<?= $moduleId ?>][edit]" 
                                                                   <?= isset($existingRights[$moduleId]['edit']) && $existingRights[$moduleId]['edit'] ? 'checked' : '' ?>>
                                                            <label for="edit_<?= $moduleId ?>">Edit</label>
                                                        </div>
                                                        <div class="checkbox-group">
                                                            <input type="checkbox" id="delete_<?= $moduleId ?>" 
                                                                   name="rights[<?= $moduleId ?>][delete]" 
                                                                   <?= isset($existingRights[$moduleId]['delete']) && $existingRights[$moduleId]['delete'] ? 'checked' : '' ?>>
                                                            <label for="delete_<?= $moduleId ?>">Delete</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <!-- Submodules -->
                                                <?php foreach ($module['submodules'] as $submoduleId => $submodule): ?>
                                                    <div class="submodule-item">
                                                        <div class="module-name">
                                                            <i class="bi <?= htmlspecialchars($submodule['icon']) ?> ms-3"></i>
                                                            <?= htmlspecialchars($submodule['name']) ?>
                                                        </div>
                                                        <div class="rights-checkboxes">
                                                            <div class="checkbox-group">
                                                                <input type="checkbox" id="view_<?= $submoduleId ?>" 
                                                                       name="rights[<?= $submoduleId ?>][view]" 
                                                                       <?= isset($existingRights[$submoduleId]['view']) && $existingRights[$submoduleId]['view'] ? 'checked' : 'checked' ?>>
                                                                <label for="view_<?= $submoduleId ?>">View</label>
                                                            </div>
                                                            <div class="checkbox-group">
                                                                <input type="checkbox" id="add_<?= $submoduleId ?>" 
                                                                       name="rights[<?= $submoduleId ?>][add]" 
                                                                       <?= isset($existingRights[$submoduleId]['add']) && $existingRights[$submoduleId]['add'] ? 'checked' : '' ?>>
                                                                <label for="add_<?= $submoduleId ?>">Add</label>
                                                            </div>
                                                            <div class="checkbox-group">
                                                                <input type="checkbox" id="edit_<?= $submoduleId ?>" 
                                                                       name="rights[<?= $submoduleId ?>][edit]" 
                                                                       <?= isset($existingRights[$submoduleId]['edit']) && $existingRights[$submoduleId]['edit'] ? 'checked' : '' ?>>
                                                                <label for="edit_<?= $submoduleId ?>">Edit</label>
                                                            </div>
                                                            <div class="checkbox-group">
                                                                <input type="checkbox" id="delete_<?= $submoduleId ?>" 
                                                                       name="rights[<?= $submoduleId ?>][delete]" 
                                                                       <?= isset($existingRights[$submoduleId]['delete']) && $existingRights[$submoduleId]['delete'] ? 'checked' : '' ?>>
                                                                <label for="delete_<?= $submoduleId ?>">Delete</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                        
                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn-primary px-4 py-2">
                                <i class="bi bi-save me-2"></i> Save Rights
                            </button>
                        </div>
                    </div>
                </form>
                <?php elseif (isset($_POST['user_id'])): ?>
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle me-2"></i> User not found.
                    </div>
                <?php else: ?>
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i> Please select a user to assign rights.
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>
</div>

<!-- Loading overlay -->
<div class="loading-overlay">
    <div class="loading-spinner"></div>
</div>

<?php include('../partition/footer.php'); ?>
<script>
$(document).ready(function() {
    // Handle form submission with AJAX
    $('#rightsForm').on('submit', function(e) {
        e.preventDefault();
        
        // Show loading overlay
        $('.loading-overlay').show();
        
        // Get form data
        var formData = $(this).serialize();
        
        // Send AJAX request
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                // Hide loading overlay
                $('.loading-overlay').hide();
                
                if (response.success) {
                    // Show success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.message,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        // Clear the selection after user clicks OK
                        if (result.isConfirmed) {
                            window.location.href = 'assignrights.php';
                        }
                    });
                } else {
                    // Show error message
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: response.message,
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'OK'
                    });
                }
            },
            error: function(xhr, status, error) {
                // Hide loading overlay
                $('.loading-overlay').hide();
                
                // Show error message
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'An error occurred while saving rights. Please try again.',
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'OK'
                });
                
                console.error(error);
            }
        });
    });
    
    // Auto-expand accordion if user has rights in that section
    <?php if ($userId): ?>
        $(document).ready(function() {
            $('.accordion-item').each(function() {
                var accordionId = $(this).find('.accordion-collapse').attr('id');
                var hasCheckedItems = $(this).find('input[type="checkbox"]:checked').length > 0;
                
                if (hasCheckedItems) {
                    $('#' + accordionId).addClass('show');
                    $(this).find('.accordion-button').removeClass('collapsed');
                }
            });
        });
    <?php endif; ?>
});
</script>