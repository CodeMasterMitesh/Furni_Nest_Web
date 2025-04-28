<?php
// session_start();
error_reporting( E_ALL );
ini_set('display_errors', '1');
include_once(__DIR__ . '/../../config/conn.php');

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if (!$email || !$password) {
    echo "Email and password required.";
    exit;
}

$stmt = $conn->prepare("SELECT password FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    echo "User not found.";
    exit;
}

$stmt->bind_result($hashedPassword);
$stmt->fetch();

if (password_verify($password, $hashedPassword)) {
    echo "<script>
            alert('Login Successfull');
            window.location.href = 'dashboard.html';
        </script>";
} else {
    echo "Incorrect password.";
}
?>
