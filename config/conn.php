<?php
session_start();
error_reporting( E_ALL );
ini_set('display_errors', '1');
$host     = "localhost";         // or your host IP
$db_user  = "root";              // your DB username
$db_pass  = "";                  // your DB password
$db_name  = "furni_nest_db";     // your selected DB

try {
    // Create connection
    $conn = mysqli_connect($host, $db_user, $db_pass, $db_name);
    // Set charset (optional but recommended)
    mysqli_set_charset($conn, "utf8mb4");
} catch (mysqli_sql_exception $e) {
    include 'connection_error.php';
    exit;
}

/**
 * Function to close the DB connection.
 */
function closeConnection($conn) {
    if ($conn) {
        mysqli_close($conn);
        // echo "Connection closed successfully."; // Optional for debug
    }
}

function convertToWebP($source, $destination, $quality = 80)
{
    $info = getimagesize($source);
    if ($info === false) return false;

    switch ($info['mime']) {
        case 'image/jpeg':
            $image = imagecreatefromjpeg($source);
            break;
        case 'image/png':
            $image = imagecreatefrompng($source);
            break;
        case 'image/gif':
            $image = imagecreatefromgif($source);
            break;
        default:
            return false;
    }

    imagepalettetotruecolor($image);
    imagealphablending($image, true);
    imagesavealpha($image, true);
    return imagewebp($image, $destination, $quality);
}

// function createDropdown($column_name, $table, $id_field, $name_field, $condition = '')
// {
//     global $conn;
//     $where = !empty($condition) ? "WHERE $condition" : "";
//     $query = "SELECT $id_field, $name_field FROM $table $where";

//     $result = mysqli_query($conn, $query);

//     $output = '<select class="form-control" name="' . $column_name . '" required>';
//     $output .= '<option value="">-- Select --</option>';

//     if ($result && mysqli_num_rows($result) > 0) {
//         while ($row = mysqli_fetch_assoc($result)) {
//             $output .= '<option value="' . $row[$id_field] . '">' . $row[$name_field] . '</option>';
//         }
//     }

//     $output .= '</select>';

//     return $output;
// }

function createDropdown($table, $valueField, $displayField, $selectedValue = '') {
    global $conn;
    $query = "SELECT * FROM $table";
    $result = mysqli_query($conn, $query);
    // $dropdown = "<select name='$selectName' class='form-control rounded-3 py-2'>";
    // $dropdown.="<option>None</option>";
    while ($row = mysqli_fetch_assoc($result)) {
        $selected = ($row[$valueField] == $selectedValue) ? "selected" : "";
        $dropdown .= "<option value='" . $row[$valueField] . "' $selected>" . $row[$displayField] . "</option>";
    }
    // $dropdown .= "</select>";
    return $dropdown;
}

function getRows($table, $condition = '',$orderby = '') {
    global $conn;
    $query = "SELECT * FROM $table";
    if ($condition != '') {
        $query .= " WHERE $condition";
    }
    if ($orderby != '') {
        $query .= " $orderby";
    }
    $result = mysqli_query($conn, $query);
    $data = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row; // Append each row to the $data array
    }

    return $data; // Returns array of all rows
}

function getsingleRow($table, $condition = '') {
    global $conn;
    $query = "SELECT * FROM $table";
    if($condition != ''){
        $query .= " WHERE $condition";
    }
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row;
}

// $password = password_hash("admin123", PASSWORD_DEFAULT);
// mysqli_query($conn, "INSERT INTO users (first_name, last_name,display_name,email,username,password,phone,role) VALUES ('admin','admin','admin','admin@example.com','admin','$password','1234567890','admin')");

// Get products with filters
function getProducts($filters = []) {
    global $conn;
    
    $sql = "SELECT p.*, c.name as category_name
            FROM products p 
            LEFT JOIN categories c ON p.category_id = c.id
            WHERE 1";
    
    $params = [];
    $types = '';
    
    if (!empty($filters['search'])) {
        $sql .= " AND (p.name LIKE ? OR p.description LIKE ?)";
        $params[] = "%{$filters['search']}%";
        $params[] = "%{$filters['search']}%";
        $types .= 'ss';
    }
    
    if (!empty($filters['category'])) {
        $sql .= " AND p.category_id = ?";
        $params[] = $filters['category'];
        $types .= 'i';
    }
    
    if (!empty($filters['vendor'])) {
        $sql .= " AND p.vendor_id = ?";
        $params[] = $filters['vendor'];
        $types .= 'i';
    }
    
    // Add pagination
    $page = isset($filters['page']) ? max(1, (int)$filters['page']) : 1;
    $limit = 10;
    $offset = ($page - 1) * $limit;
    $sql .= " LIMIT ? OFFSET ?";
    $params[] = $limit;
    $params[] = $offset;
    $types .= 'ii';
    
    $stmt = $conn->prepare($sql);
    // echo $stmt;
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    
    $stmt->execute();
    $result = $stmt->get_result();
    
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Count all products
function countProducts() {
    global $conn;
    $result = $conn->query("SELECT COUNT(*) FROM products");
    return $result->fetch_row()[0];
}

// Count published products
function countPublishedProducts() {
    global $conn;
    $result = $conn->query("SELECT COUNT(*) FROM products WHERE status = 'published'");
    return $result->fetch_row()[0];
}

// Count draft products
function countDraftProducts() {
    global $conn;
    $result = $conn->query("SELECT COUNT(*) FROM products WHERE status = 'draft'");
    return $result->fetch_row()[0];
}

// Count discounted products
function countDiscountedProducts() {
    global $conn;
    $result = $conn->query("SELECT COUNT(*) FROM products WHERE discount > 0");
    return $result->fetch_row()[0];
}

// Get all categories
function getCategories() {
    global $conn;
    $result = $conn->query("SELECT * FROM categories ORDER BY name");
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Get all vendors
// function getVendors() {
//     global $conn;
//     $result = $conn->query("SELECT * FROM vendors ORDER BY name");
//     return $result->fetch_all(MYSQLI_ASSOC);
// }

// Format price
function formatPrice($price) {
    return '$' . number_format($price, 2);
}

// Close connection at the end of script execution
register_shutdown_function(function() {
    global $conn;
    // $mysqli->close();
});

function getOrderStats($conn) {
    $stats = [
        'today_orders' => 0,
        'month_orders' => 0,
        'year_orders' => 0,
        'today_amount' => 0,
        'month_amount' => 0,
        'year_amount' => 0
    ];

    $today = date('Y-m-d');
    $month = date('m');
    $year = date('Y');

    // Today's Orders and Amount
    $query_today = "
        SELECT 
            COUNT(DISTINCT o.id) AS total_orders, 
            SUM(oi.price * oi.quantity) AS total_price
        FROM orders o
        LEFT JOIN order_items oi ON o.id = oi.order_id
        WHERE DATE(o.created_at) = '$today'
    ";
    $result_today = mysqli_query($conn, $query_today);
    if ($row = mysqli_fetch_assoc($result_today)) {
        $stats['today_orders'] = $row['total_orders'];
        $stats['today_amount'] = $row['total_price'] ?? 0;
    }

    // This Month's Orders and Amount
    $query_month = "
        SELECT 
            COUNT(DISTINCT o.id) AS total_orders, 
            SUM(oi.price * oi.quantity) AS total_price
        FROM orders o
        LEFT JOIN order_items oi ON o.id = oi.order_id
        WHERE YEAR(o.created_at) = '$year' AND MONTH(o.created_at) = '$month'
    ";
    $result_month = mysqli_query($conn, $query_month);
    if ($row = mysqli_fetch_assoc($result_month)) {
        $stats['month_orders'] = $row['total_orders'];
        $stats['month_amount'] = $row['total_price'] ?? 0;
    }

    // This Year's Orders and Amount
    $query_year = "
        SELECT 
            COUNT(DISTINCT o.id) AS total_orders, 
            SUM(oi.price * oi.quantity) AS total_price
        FROM orders o
        LEFT JOIN order_items oi ON o.id = oi.order_id
        WHERE YEAR(o.created_at) = '$year'
    ";
    $result_year = mysqli_query($conn, $query_year);
    if ($row = mysqli_fetch_assoc($result_year)) {
        $stats['year_orders'] = $row['total_orders'];
        $stats['year_amount'] = $row['total_price'] ?? 0;
    }

    return $stats;
}
function isSuperAdmin() {
    return ($_SESSION['udata']['role'] ?? '') === 'superadmin';
}

function hasPermission($moduleId, $action) {
    // Super admin has all permissions
    if (isSuperAdmin()) {
        return true;
    }
    
    // For view permission, check if module exists in rights at all
    if ($action === 'view') {
        return isset($_SESSION['user_rights'][$moduleId]);
    }
    
    // For other permissions, check the specific flag
    if (isset($_SESSION['user_rights'][$moduleId][$action])) {
        return (bool)$_SESSION['user_rights'][$moduleId][$action];
    }
    
    return false;
}
// And add this helper function:
function hasAnyPermission($moduleId) {
    if (isSuperAdmin()) return true;
    return isset($_SESSION['user_rights'][$moduleId]);
}
?>
