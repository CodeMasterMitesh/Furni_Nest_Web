<?php
include('../config/conn.php'); 

$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if (!$name || !$email || !$password) {
    echo "All fields are required.";
    exit;
}

$passwordHash = password_hash($password, PASSWORD_BCRYPT);

$stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $name, $email, $passwordHash);

if ($stmt->execute()) {
    echo "Registered successfully!";
} else {
    echo "Error: " . $conn->error;
}
?>
