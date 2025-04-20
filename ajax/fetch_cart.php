<?php
include '../config/conn.php';

$cart_items = [];
$subtotal = 0;

// Logged-in user
if (isset($_SESSION['customer_logged_in']) && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $result = mysqli_query($conn, "
        SELECT c.*, p.name, p.image, p.price 
        FROM cart c 
        JOIN products p ON p.id = c.product_id 
        WHERE c.user_id = '$user_id'
    ");
    while ($row = mysqli_fetch_assoc($result)) {
        $row['total'] = $row['price'] * $row['quantity'];
        $subtotal += $row['total'];
        $cart_items[] = $row;
    }
} 
// Guest user
else if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $product_id = $item['product_id'];
        $qty = $item['quantity'];

        $res = mysqli_query($conn, "SELECT id, name, price, image FROM products WHERE id = '$product_id'");
        if ($product = mysqli_fetch_assoc($res)) {
            $product['quantity'] = $qty;
            $product['total'] = $product['price'] * $qty;
            $subtotal += $product['total'];
            $cart_items[] = $product;
        }
    }
}

// Generate HTML
$html = '';
foreach ($cart_items as $item) {
    $html .= '
    <li class="minicart-product">
        <a class="product-item_remove" href="javascript:void(0)" data-id="'.$item['id'].'"><i class="icon-cross2"></i></a>
        <a class="product-item_img"><img class="img-fluid" src="'.$item['image'].'" alt="'.$item['name'].'"></a>
        <div class="product-item_content">
            <a class="product-item_title" href="index.php?p=product-details&id='.$item['id'].'">'.$item['name'].'</a>
            <label>Qty : <span>'.$item['quantity'].'</span></label>
            <label class="product-item_quantity">Price: <span> ₹'.number_format($item['total'], 2).'</span></label>
        </div>
    </li>';
}

echo json_encode([
    'html' => $html,
    'subtotal' => number_format($subtotal, 2),
    'count' => count($cart_items)
]);
exit;
