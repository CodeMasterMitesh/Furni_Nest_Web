<?php
// Include database connection
include('../../../config/conn.php'); // Adjust path as needed

// Set headers for JSON response
header('Content-Type: application/json');

// Initialize response array
$response = ['success' => false, 'message' => ''];

// Check if request is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $response['message'] = 'Invalid request method';
    echo json_encode($response);
    exit;
}

// Check if user is logged in (if authentication is required)
if (!isset($_SESSION['admin_logged_in'])) {
    $response['message'] = 'Unauthorized access';
    echo json_encode($response);
    exit;
}

// Get the category ID from POST data
$categoryId = isset($_POST['id']) ? intval($_POST['id']) : 0;

// Validate category ID
if ($categoryId <= 0) {
    $response['message'] = 'Invalid category ID';
    echo json_encode($response);
    exit;
}

try {
    // Begin transaction (if you need atomic operations)
    mysqli_begin_transaction($conn);
    
    // Option 1: Soft delete (if you have an 'is_deleted' column)
    // $sql = "UPDATE categories SET is_deleted = 1 WHERE id = ?";
    
    // Option 2: Hard delete (permanent removal)
    $sql = "DELETE FROM categories WHERE id = ?";
    
    // Prepare statement
    $stmt = mysqli_prepare($conn, $sql);
    
    if (!$stmt) {
        throw new Exception("Database error: " . mysqli_error($conn));
    }
    
    // Bind parameters
    mysqli_stmt_bind_param($stmt, "i", $categoryId);
    
    // Execute statement
    $result = mysqli_stmt_execute($stmt);
    
    if (!$result) {
        throw new Exception("Delete failed: " . mysqli_error($conn));
    }
    
    // Check if any row was actually deleted
    $affectedRows = mysqli_stmt_affected_rows($stmt);
    
    if ($affectedRows === 0) {
        $response['message'] = 'Category not found or already deleted';
    } else {
        $response['success'] = true;
        $response['message'] = 'Category deleted successfully';
    }
    
    // Commit transaction
    mysqli_commit($conn);
    
    // Close statement
    mysqli_stmt_close($stmt);
    
} catch (Exception $e) {
    // Rollback transaction on error
    mysqli_rollback($conn);
    
    $response['message'] = 'Error: ' . $e->getMessage();
    
    // Log the error (you might want to implement proper error logging)
    error_log('Delete category error: ' . $e->getMessage());
}

// Close database connection
mysqli_close($conn);

// Return JSON response
echo json_encode($response);
?>