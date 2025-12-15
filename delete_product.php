<?php
require_once 'config/db.php';

if (!isset($_GET['id'])) {
    die("Product ID not provided");
}

$product_id = (int) $_GET['id'];

$stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();

$stmt->close();

header("Location: admin.php");
exit;
?>
