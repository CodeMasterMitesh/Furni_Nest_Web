<?php
include 'config/conn.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

$cart_sql = "SELECT cart.*, products.price FROM cart JOIN products ON cart.product_id = products.id WHERE cart.user_id = '$user_id'";
$cart_result = mysqli_query($conn, $cart_sql);

if (mysqli_num_rows($cart_result) == 0) {
    echo "Cart is empty!";
    exit();
}
// Fetch billing address
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$address_line1 = $_POST['address_line1'];
$address_line2 = $_POST['address_line2'];
$city = $_POST['city'];
$state = $_POST['state'];
$country = $_POST['country'];
$postal_code = $_POST['postal_code'];
$phone = $_POST['phone'];
$email = $_POST['email'];

$full_address1 = $first_name . " " . $last_name . ", " . $address_line1;
$full_address2 = $address_line2;

$order_number = 'ORD' . strtoupper(uniqid());

$total_price = 0;
$cart_items = [];

while ($row = mysqli_fetch_assoc($cart_result)) {
    $cart_items[] = $row;
    $total_price += $row['price'] * $row['quantity'];
}

// Insert into orders table
$order_sql = "INSERT INTO orders (user_id, order_number, total_price, status, payment_status, created_at)
              VALUES ('$user_id', '$order_number', '$total_price', 'Pending', 'Pending', NOW())";

if (mysqli_query($conn, $order_sql)) {
    $order_id = mysqli_insert_id($conn);

    foreach ($cart_items as $item) {
        $product_id = $item['product_id'];
        $quantity = $item['quantity'];
        $price = $item['price'];
        $total = $price * $quantity;

        $item_sql = "INSERT INTO order_items (order_id, product_id, quantity, price, total)
                     VALUES ('$order_id', '$product_id', '$quantity', '$price', '$total')";
        mysqli_query($conn, $item_sql);
    }

    $address_sql = "INSERT INTO addresses (user_id, type, address_line1, address_line2, city, state, country, postal_code, created_at)
                    VALUES ('$user_id', 'billing', '$full_address1', '$full_address2', '$city', '$state', '$country', '$postal_code', NOW())";
    mysqli_query($conn, $address_sql);

    $clear_cart_sql = "DELETE FROM cart WHERE user_id = '$user_id'";
    mysqli_query($conn, $clear_cart_sql);

    // Sweet Success Page Starts Here
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Order Successful</title>
        <style>
            body {
                background: #f7f7f7;
                font-family: 'Poppins', sans-serif;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                margin: 0;
            }
            .success-container {
                background: #fff;
                padding: 40px;
                text-align: center;
                border-radius: 20px;
                box-shadow: 0 0 20px rgba(0,0,0,0.1);
                animation: pop 0.5s ease forwards;
            }
            @keyframes pop {
                0% { transform: scale(0.5); opacity: 0; }
                100% { transform: scale(1); opacity: 1; }
            }
            .checkmark {
                width: 100px;
                height: 100px;
                margin: 0 auto 20px;
                border-radius: 50%;
                background: #4BB543;
                display: flex;
                justify-content: center;
                align-items: center;
            }
            .checkmark::after {
                content: "✓";
                font-size: 50px;
                color: white;
            }
            h1 {
                color: #333;
                margin-bottom: 10px;
            }
            p {
                color: #666;
                margin-bottom: 30px;
            }
            .btn {
                display: inline-block;
                background: #4BB543;
                color: #fff;
                padding: 12px 30px;
                border-radius: 30px;
                text-decoration: none;
                transition: 0.3s;
            }
            .btn:hover {
                background: #3da536;
            }
        </style>
    </head>
    <body>
        <div class="success-container">
            <div class="checkmark"></div>
            <h1>Thank You!</h1>
            <p>Your order <strong>#<?php echo $order_number; ?></strong> has been placed successfully.</p>
            <a href="index.php" class="btn">Continue Shopping</a>
        </div>
    </body>
    </html>
    <?php
} else {
    echo "Failed to place order. Please try again.";
}
?>

