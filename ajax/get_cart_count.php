<?php
include '../config/conn.php';

$count = 0;

if (isset($_SESSION['customer_logged_in']) && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $res = mysqli_query($conn, "SELECT SUM(quantity) as total FROM cart WHERE user_id='$user_id'");
    $data = mysqli_fetch_assoc($res);
    $count = $data['total'] ?? 0;
} elseif (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $count += $item['quantity'];
    }
}

echo json_encode(['count' => $count]);
exit;
