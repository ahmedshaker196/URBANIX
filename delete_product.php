<?php
require_once 'config/db.php';

if(!isset($_GET['id'])) die("Product ID not provided");
$product_id = $_GET['id'];

$sql="DELETE FROM products WHERE id=$product_id";
mysqli_query($conn,$sql);

header("Location: admin.php"); 
exit;
?>