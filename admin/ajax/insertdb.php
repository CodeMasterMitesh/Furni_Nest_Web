<?php
include_once '../../config/conn.php';
// Set JSON header
header('Content-Type: application/json');
error_log(print_r($_POST, true));
// CSRF token validation
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    echo json_encode(['status' => 'error', 'message' => 'CSRF token validation failed!']);
    exit;
}

// Get the table name
$table = $_POST['table'] ?? '';
unset($_POST['table']); // Remove table from POST data

if (empty($table)) {
    echo json_encode(['status' => 'error', 'message' => 'Table name not specified.']);
    exit;
}

// Initialize arrays for columns and values
$columns = [];
$placeholders = [];
$values = [];
$types = '';

// Prepare data for prepared statement
foreach ($_POST as $key => $val) {
    if ($key !== 'csrf_token') {
        $columns[] = "`" . mysqli_real_escape_string($conn, $key) . "`";
        $placeholders[] = "?";
        $values[] = $val;
        $types .= 's'; // Assume string type for all parameters
    }
}

// Handle file uploads
$imageFolder = '../../uploads/'; // Changed to more standard location
if (!empty($_FILES)) {
    // Create uploads directory if it doesn't exist
    if (!file_exists($imageFolder)) {
        mkdir($imageFolder, 0755, true);
    }
    
    if (!is_writable($imageFolder)) {
        echo json_encode(['status' => 'error', 'message' => 'Upload directory is not writable.']);
        exit;
    }

    foreach ($_FILES as $key => $file) {
        if ($file['error'] === UPLOAD_ERR_OK) {
            // Generate safe filename
            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $filename = uniqid() . '.' . $extension;
            $destination = $imageFolder . $filename;

            if (move_uploaded_file($file['tmp_name'], $destination)) {
                $columns[] = "`" . mysqli_real_escape_string($conn, $key) . "`";
                $placeholders[] = "?";
                $values[] = $filename;
                $types .= 's';
            }
        }
    }
}

// Build and execute prepared statement
try {
    $sql = "INSERT INTO `" . mysqli_real_escape_string($conn, $table) . "` (" . implode(',', $columns) . ") VALUES (" . implode(',', $placeholders) . ")";
    $stmt = mysqli_prepare($conn, $sql);
    
    if (!$stmt) {
        throw new Exception('Prepare failed: ' . mysqli_error($conn));
    }
    
    // Bind parameters dynamically
    mysqli_stmt_bind_param($stmt, $types, ...$values);
    $result = mysqli_stmt_execute($stmt);
    
    if ($result) {
        // Regenerate CSRF token after successful insert
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        echo json_encode([
            'status' => 'success',
            'message' => 'Data saved successfully!',
            'insert_id' => mysqli_insert_id($conn)
        ]);
    } else {
        throw new Exception('Execute failed: ' . mysqli_error($conn));
    }
    
    mysqli_stmt_close($stmt);
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}

mysqli_close($conn);
?>