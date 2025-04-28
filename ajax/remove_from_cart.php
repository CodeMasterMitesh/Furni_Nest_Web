<?php
include '../config/conn.php';

$product_id = $_POST['product_id'] ?? null;
// echo $product_id;
// exit;

if (!$product_id) {
    echo json_encode(['status' => 'error', 'message' => 'No product ID provided']);
    exit;
}

if (isset($_SESSION['customer_logged_in']) && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
   
   $sql = "DELETE FROM cart WHERE user_id='$user_id' AND id='$product_id'";
   $query = mysqli_query($conn, $sql);
//    echo $sql;
//    exit;
} else {
    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
    }
}

echo json_encode(['status' => 'success']);
exit;
