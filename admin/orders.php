<?php include('partition/header.php');
$order_query = "SELECT o.id AS order_id, u.first_name AS customer_name, o.total_price, o.status, o.created_at
                FROM orders o
                JOIN users u ON o.user_id = u.id
                ORDER BY o.created_at DESC";

$order_result = mysqli_query($conn, $order_query);
?>

<div class="wrapper d-flex flex-column min-vh-100">
    <main class="flex-grow-1">
        <div class="container mt-4">
            <h3>Orders</h3>
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Customer</th>
                        <th>Product(s)</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $i = 1;
                    while($order = mysqli_fetch_assoc($order_result)) {
                        // print_r($order);
                        $order_id = $order['order_id'];
                        $products_query = "SELECT p.name 
                                           FROM order_items oi 
                                           JOIN products p ON oi.product_id = p.id 
                                           WHERE oi.order_id = $order_id";
                        $products_result = mysqli_query($conn, $products_query);

                        $product_names = [];
                        while($product = mysqli_fetch_assoc($products_result)) {
                            $product_names[] = htmlspecialchars($product['name']??'');
                        }

                        // Status badge
                        $statusClass = 'bg-secondary';
                        if ($order['status'] == 'Completed') $statusClass = 'bg-success';
                        elseif ($order['status'] == 'Pending') $statusClass = 'bg-warning';
                        elseif ($order['status'] == 'Cancelled') $statusClass = 'bg-danger';
                    ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td><?= htmlspecialchars($order['customer_name']??'') ?></td>
                        <td><?= implode(', ', $product_names) ?></td>
                        <td><?= number_format($order['total_price'], 2) ?></td>
                        <td><span class="badge <?= $statusClass ?>"><?= htmlspecialchars($order['status']??'') ?></span></td>
                        <td><?= date('Y-m-d', strtotime($order['created_at'])) ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </main>
</div>
<?php include('partition/footer.php'); ?>