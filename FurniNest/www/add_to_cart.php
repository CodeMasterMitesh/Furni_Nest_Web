<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
include_once(__DIR__ . '/../../config/conn.php');

// $email = $_POST['email'];
$product_id = $_POST['product_id'];

mysqli_query($conn, "INSERT INTO cart (product_id) VALUES ('$product_id')");
echo json_encode(["message" => "Added to cart"]);
