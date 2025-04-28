<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
include_once(__DIR__ . '/../../config/conn.php');

$result = mysqli_query($conn, "SELECT * FROM products");
$rows = [];
while($row = mysqli_fetch_assoc($result)) {
  $rows[] = $row;
}
echo json_encode($rows);
