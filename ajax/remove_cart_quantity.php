<?php
include '../config/conn.php';

$product_id = intval($_POST['product_id']);
$quantity = intval($_POST['quantity'] ?? 1);

// print_r($_POST);

if ($quantity <= 0) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid quantity']);
    exit;
}

if (isset($_SESSION['customer_logged_in']) && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    $check = mysqli_query($conn, "SELECT * FROM cart WHERE user_id='$user_id' AND product_id='$product_id'");
    if (mysqli_num_rows($check) > 0) {
        mysqli_query($conn, "UPDATE cart SET quantity = quantity - $quantity WHERE user_id='$user_id' AND product_id='$product_id'");
    } else {
        mysqli_query($conn, "INSERT INTO cart (user_id, product_id, quantity) VALUES ('$user_id', '$product_id', '$quantity')");
    }

    $count_res = mysqli_query($conn, "SELECT SUM(quantity) as total FROM cart WHERE user_id='$user_id'");
    $row = mysqli_fetch_assoc($count_res);
    $cart_count = $row['total'] ?? 0;

} else {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]['quantity'] += $quantity;
    } else {
        $_SESSION['cart'][$product_id] = [
            'product_id' => $product_id,
            'quantity' => $quantity
        ];
    }

    $cart_count = 0;
    foreach ($_SESSION['cart'] as $item) {
        $cart_count += $item['quantity'];
    }
}

echo json_encode([
    'status' => 'success',
    'cart_count' => $cart_count
]);
exit;
