<?php
include "config/conn.php";

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE username='$username' OR email='$username'";
$res = mysqli_query($conn, $sql);

if (mysqli_num_rows($res) > 0) {
    $user = mysqli_fetch_assoc($res);
    // print_r($user);
    // exit;
    if (password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['customer_data'] = $user;
        $_SESSION['customer_logged_in'] = true;
        // ✅ SYNC CART if session cart exists
        if (!empty($_SESSION['cart'])) {
            $user_id = $user['id'];

            foreach ($_SESSION['cart'] as $item) {
                $product_id = $item['product_id'];
                $quantity = $item['quantity'];

                // Check if already in DB
                $check = mysqli_query($conn, "SELECT * FROM cart WHERE user_id = '$user_id' AND product_id = '$product_id'");
                if (mysqli_num_rows($check) > 0) {
                    // Update quantity
                    mysqli_query($conn, "UPDATE cart SET quantity = quantity + $quantity WHERE user_id = '$user_id' AND product_id = '$product_id'");
                } else {
                    // Insert new
                    mysqli_query($conn, "INSERT INTO cart (user_id, product_id, quantity) VALUES ('$user_id', '$product_id', '$quantity')");
                }
            }

            // Clear session cart
            unset($_SESSION['cart']);
        }
        echo json_encode(['status' => 'success', 'message' => 'Login successful']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid password']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'User not found']);
}
?>
