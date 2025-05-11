<?php
include_once '../../config/conn.php';

// Set JSON header
header('Content-Type: application/json');

// CSRF token validation
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    echo json_encode(['status' => 'error', 'message' => 'CSRF token validation failed!']);
    exit;
}

// Get the table name and record ID
$table = $_POST['table'] ?? '';
$id = $_POST['id'] ?? '';
unset($_POST['table'], $_POST['id']); // Remove from POST data

if (empty($table) || empty($id)) {
    echo json_encode(['status' => 'error', 'message' => 'Table name or record ID not specified.']);
    exit;
}

// Initialize arrays for update
$set = [];
$values = [];
$types = '';

// Prepare data for prepared statement
foreach ($_POST as $key => $val) {
    if ($key !== 'csrf_token') {
        $set[] = "`" . mysqli_real_escape_string($conn, $key) . "` = ?";
        $values[] = $val;
        $types .= 's'; // Assume string type for all parameters
    }
}

// Handle file uploads
$imageFolder = '../../uploads/';
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
                $set[] = "`" . mysqli_real_escape_string($conn, $key) . "` = ?";
                $values[] = $filename;
                $types .= 's';
            }
        }
    }
}

// Build and execute prepared statement
try {
    if (empty($set)) {
        throw new Exception('No fields to update');
    }

    $sql = "UPDATE `" . mysqli_real_escape_string($conn, $table) . "` SET " . implode(', ', $set) . " WHERE id = ?";
    $values[] = $id;
    $types .= 's'; // Add type for ID parameter
    
    $stmt = mysqli_prepare($conn, $sql);
    
    if (!$stmt) {
        throw new Exception('Prepare failed: ' . mysqli_error($conn));
    }
    
    // Bind parameters dynamically
    mysqli_stmt_bind_param($stmt, $types, ...$values);
    $result = mysqli_stmt_execute($stmt);
    
    if ($result) {
        // Regenerate CSRF token after successful update
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        echo json_encode([
            'status' => 'success',
            'message' => 'Data updated successfully!',
            'affected_rows' => mysqli_stmt_affected_rows($stmt)
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