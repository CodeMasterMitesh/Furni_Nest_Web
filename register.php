<?php
include "config/conn.php";
// print_r($_POST);
// exit;
$username = $_POST['username'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$check = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' OR email='$email'");
if (mysqli_num_rows($check) > 0) {
    echo json_encode(['status' => 'error', 'message' => 'Username or email already exists']);
    exit;
}

$sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
if (mysqli_query($conn, $sql)) {
    // Get the newly registered user ID
    $user_id = mysqli_insert_id($conn);

    // Store login session
    $_SESSION['customer_logged_in'] = true;
    $_SESSION['customer_data'] = [
        'id' => $user_id,
        'username' => $username,
        'email' => $email
    ];

    // ✅ Migrate guest cart into user_cart table
    if (!empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
        $product_id = $item['product_id'];
        $quantity = $item['quantity'];

        // Check if product already in user_cart
        $check = mysqli_query($conn, "SELECT * FROM cart WHERE user_id = '$user_id' AND product_id = '$product_id'");
        if (mysqli_num_rows($check) > 0) {
            mysqli_query($conn, "UPDATE user_cart SET quantity = quantity + $quantity WHERE user_id = '$user_id' AND product_id = '$product_id'");
        } else {
            mysqli_query($conn, "INSERT INTO cart (user_id, product_id, quantity) VALUES ('$user_id', '$product_id', '$quantity')");
        }
        }

        // Clear guest session cart
        unset($_SESSION['cart']);
    }
    echo json_encode(['status' => 'success', 'message' => 'Registration successful']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Something went wrong']);
}
?>