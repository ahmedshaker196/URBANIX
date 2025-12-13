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
 <nav class="navbar navbar-expand-lg position-fixed top-0 end-0 start-0 border border-bottom-1 border-top-0 border-start-0 border-end-0 border-secondary">
  <div class="container-fluid">

    <h5 class="me-4 mt-2 logo" style="font-weight: 700;color: var(--black);text-shadow: 1px 1px 17px var(--orange);
">URBANIX</h5>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
       <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link me-2" aria-current="page" href="home.html">HOME</a></li>
        <li class="nav-item"><a class="nav-link me-2" href="products.php">PRODUCTS</a></li>
        <li class="nav-item"><a class="nav-link me-2" href="about.php">ABOUT</a></li>
        <li class="nav-item"><a class="nav-link" href="contact.php">CONTACT US</a></li>
      </ul>

      <div class="d-flex me-2 align-items-center">
    <a href="cart.php">
        <i class="fa-solid fa-cart-shopping nav-icon me-3" style="cursor:pointer;"></i>
    </a>

    <form action="index.php">
        <button class="btn nav-btn fw-bold px-3" type="submit">logout</button>
    </form>
</div>

    </div>
  </div>
</nav>

<!-- Sidebar -->
<div class="menu">
    <ul>
        <li class="profile">
            <div class="img-box"><img src="img/user-200x300.webp" alt="profile"></div>
            <h2>Jorg</h2>
        </li>

        <li><a  href="admin.php"><i class="fa-solid fa-house"></i><p>dashboard</p></a></li>
        <li><a href="client.php"><i class="fa-solid fa-users"></i><p>clients</p></a></li>
        <li><a href="addproduct_admin.php"><i class="fa-solid fa-table"></i><p>products</p></a></li>
        <li><a class="active" href="fetch_cart.php"><i class="fa-regular fa-chart-bar"></i><p>carts</p></a></li>
        <li><a href="posts.php"><i class="fa-solid fa-pen"></i><p>posts</p></a></li>

        <li class="log-out">
            <a href="logout.php"><i class="fa-solid fa-arrow-right-from-bracket"></i><p>Log out</p></a>
        </li>
    </ul>
</div>

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
