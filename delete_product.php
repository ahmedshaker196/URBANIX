<?php
require_once 'config/db.php';


if(!isset($_GET['id'])) die("Product ID not provided");
$product_id = $_GET['id'];


$conn->query("DELETE FROM product_images WHERE product_id=$product_id");


$conn->query("DELETE FROM products WHERE product_id=$product_id");

header("Location: admin.php"); 
exit;
?>