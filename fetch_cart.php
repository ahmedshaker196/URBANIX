<?php
require_once 'config/db.php';

$result = $conn->query("
    SELECT 
        p.name, 
        p.price, 
        c.qty AS quantity
    FROM cart_items c
    JOIN products p ON c.product_id = p.id
    ORDER BY c.id ASC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Cart - URBANIX</title>
<link rel="stylesheet" href="css/all.min.css">
<link rel="stylesheet" href="css/admin.css">
<link rel="stylesheet" href="css/bootstrap.css">
</head>
<body style="padding-top: 50px;">

<!-- (Navbar + Sidebar نفس القديم بدون أي تعديل) -->

<div class="content">
    <div class="title-info">
        <p>Cart</p>
        <i class="fa-solid fa-cart-shopping"></i>
    </div>

    <table>
        <thead>
            <tr>
                <th style="color:#555">Product</th>
                <th style="color:#555">Price</th>
                <th style="color:#555">Quantity</th>
                <th style="color:#555">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['name'] ?></td>
                <td>$<?= number_format($row['price'], 2) ?></td>
                <td><?= $row['quantity'] ?></td>
                <td>$<?= number_format($row['price'] * $row['quantity'], 2) ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script src="js/popper.min.js"></script>
<script src="js/jquery-3.7.1.js"></script>
<script src="js/bootstrap.js"></script>
</body>
</html>
