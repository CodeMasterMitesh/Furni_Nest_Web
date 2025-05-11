<?php
include_once '../../config/conn.php';

// Set JSON header
header('Content-Type: application/json');
$response = ['success' => false, 'message' => ''];
// CSRF token validation
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    echo json_encode(['status' => 'error', 'message' => 'CSRF token validation failed!']);
    exit;
}

// Get the table name and record ID
$table = $_POST['table'] ?? '';
$id = $_POST['id'] ?? '';

if (empty($table) || empty($id)) {
    $response['status'] = 'error';
    $response['message'] = 'Table name or record ID not specified.';
    exit;
}

try {
    // First check if record exists
    $check_sql = "SELECT COUNT(*) as count FROM `" . mysqli_real_escape_string($conn, $table) . "` WHERE id = ?";
    $check_stmt = mysqli_prepare($conn, $check_sql);
    mysqli_stmt_bind_param($check_stmt, "s", $id);
    mysqli_stmt_execute($check_stmt);
    $check_result = mysqli_stmt_get_result($check_stmt);
    $row = mysqli_fetch_assoc($check_result);
    
    if ($row['count'] == 0) {
        throw new Exception('Record not found');
    }
    // Prepare delete statement
    $sql = "DELETE FROM `" . mysqli_real_escape_string($conn, $table) . "` WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    
    if (!$stmt) {
        throw new Exception('Prepare failed: ' . mysqli_error($conn));
    }
    
    // Bind parameters
    mysqli_stmt_bind_param($stmt, "s", $id);
    $result = mysqli_stmt_execute($stmt);
    
    if ($result) {
        // Regenerate CSRF token after successful deletion
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        $response['success'] = true;
        $response['message'] = 'Data deleted successfully';
    } else {
        throw new Exception('Delete failed: ' . mysqli_error($conn));
    }
    
    mysqli_stmt_close($stmt);
} catch (Exception $e) {
    $response['success'] = false;
    $response['status'] = 'error';
    $response['message'] = 'Database error: ' . $e->getMessage();
}

mysqli_close($conn);
echo json_encode($response);
?>