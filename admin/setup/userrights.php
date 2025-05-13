<?php
include '../../config/conn.php';
// First, check if this is an AJAX request
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

if ($isAjax && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
    // Handle AJAX request
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
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'message' => 'Rights updated successfully!']);
        exit;
    } catch (Exception $e) {
        mysqli_rollback($conn);
        header('Content-Type: application/json');
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Error updating rights: ' . $e->getMessage()]);
        exit;
    }
}

?>