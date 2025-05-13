<?php
include('../partition/header.php');

// Fetch all users
$users = [];
$userQuery = "SELECT id, username, first_name FROM users ORDER BY first_name";
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

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
    $userId = (int)$_POST['user_id'];
    $rights = $_POST['rights'] ?? [];
    
    // Begin transaction
    mysqli_begin_transaction($conn);
    
    try {
        // Delete existing rights for this user
        $deleteQuery = "DELETE FROM user_rights WHERE user_id = ?";
        $stmt = mysqli_prepare($conn, $deleteQuery);
        mysqli_stmt_bind_param($stmt, "i", $userId);
        mysqli_stmt_execute($stmt);
        
        // Insert new rights
        foreach ($rights as $moduleId => $perms) {
            $moduleId = (int)$moduleId;
            $add = isset($perms['add']) ? 1 : 0;
            $edit = isset($perms['edit']) ? 1 : 0;
            $delete = isset($perms['delete']) ? 1 : 0;
            
            $insertQuery = "INSERT INTO user_rights (user_id, module_id, can_add, can_edit, can_delete) 
                            VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $insertQuery);
            mysqli_stmt_bind_param($stmt, "iiiii", $userId, $moduleId, $add, $edit, $delete);
            mysqli_stmt_execute($stmt);
        }
        
        mysqli_commit($conn);
        $_SESSION['success_message'] = "Rights updated successfully!";
        header("Location: assignrights.php?user_id=" . $userId);
        exit;
    } catch (Exception $e) {
        mysqli_rollback($conn);
        $_SESSION['error_message'] = "Error updating rights: " . $e->getMessage();
    }
}

// Fetch existing rights if user is selected
$existingRights = [];
$userId = isset($_GET['user_id']) ? (int)$_GET['user_id'] : null;
if ($userId) {
    $rightsQuery = "SELECT module_id, can_add, can_edit, can_delete 
                    FROM user_rights 
                    WHERE user_id = ?";
    $stmt = mysqli_prepare($conn, $rightsQuery);
    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);
    $rightsResult = mysqli_stmt_get_result($stmt);
    
    while ($row = mysqli_fetch_assoc($rightsResult)) {
        $existingRights[$row['module_id']] = [
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
        gap: 1.5rem;
        flex-wrap: wrap;
    }
    
    .checkbox-group {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        min-width: 100px;
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
</style>

<div class="content">
    <div class="wrapper d-flex flex-column min-vh-100">
        <main class="flex-grow-1">
            <div class="container-fluid mt-4">
                <h2 class="mb-4">Assign User Rights</h2>
                
                <?php if (isset($_SESSION['success_message'])): ?>
                    <div class="alert alert-success alert-dismissible fade show">
                        <?= htmlspecialchars($_SESSION['success_message']) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php unset($_SESSION['success_message']); ?>
                <?php endif; ?>
                
                <?php if (isset($_SESSION['error_message'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show">
                        <?= htmlspecialchars($_SESSION['error_message']) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php unset($_SESSION['error_message']); ?>
                <?php endif; ?>
                
                <div class="user-select-form">
                    <form method="GET" action="assignrights.php" class="row g-3 align-items-center">
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
                <form method="POST" action="assignrights.php">
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
                <?php elseif (isset($_GET['user_id'])): ?>
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

<?php include('../partition/footer.php'); ?>