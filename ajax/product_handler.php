<?php
header('Content-Type: application/json');
include '../config/conn.php';

// Get parameters from AJAX request
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$per_page = 9;
$offset = ($page - 1) * $per_page;

// Sorting
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'default';
$order_by = '';
switch($sort) {
    case 'popularity':
        $order_by = 'ORDER BY views DESC';
        break;
    case 'rating':
        $order_by = 'ORDER BY average_rating DESC';
        break;
    case 'latest':
        $order_by = 'ORDER BY created_at DESC';
        break;
    case 'price_low':
        $order_by = 'ORDER BY price ASC';
        break;
    case 'price_high':
        $order_by = 'ORDER BY price DESC';
        break;
    default:
        $order_by = 'ORDER BY id ASC';
}

// Filters
$filters = [];
if(isset($_GET['category']) && !empty($_GET['category'])) {
    $filters[] = "category_id = " . (int)$_GET['category'];
}
if(isset($_GET['price_range']) && !empty($_GET['price_range'])) {
    $range = explode('-', $_GET['price_range']);
    $filters[] = "price BETWEEN " . (float)$range[0] . " AND " . (float)$range[1];
}
// Add more filters for color, size etc.

$where = !empty($filters) ? 'WHERE ' . implode(' AND ', $filters) : '';

// Get products
$sql = "SELECT p.*, c.name as category_name 
        FROM products p 
        LEFT JOIN categories c ON p.category_id = c.id
        $where 
        $order_by 
        LIMIT $offset, $per_page";

$result = $conn->query($sql);
$products = [];
while($row = $result->fetch_assoc()) {
    $products[] = $row;
}

// Get total count for pagination
$count_sql = "SELECT COUNT(*) as total FROM products $where";
$count_result = $conn->query($count_sql);
$total = $count_result->fetch_assoc()['total'];
$total_pages = ceil($total / $per_page);

// Get categories for filter
$categories_sql = "SELECT * FROM categories";
$categories_result = $conn->query($categories_sql);
$categories = [];
while($row = $categories_result->fetch_assoc()) {
    $categories[] = $row;
}

echo json_encode([
    'products' => $products,
    'pagination' => [
        'total' => $total,
        'current_page' => $page,
        'per_page' => $per_page,
        'total_pages' => $total_pages
    ],
    'categories' => $categories
]);

$conn->close();
?>