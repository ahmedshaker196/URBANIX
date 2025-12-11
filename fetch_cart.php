<?php
require_once 'config/db.php';


$result = $conn->query("
    SELECT p.name, p.price, c.quantity
    FROM cart_items c
    JOIN products p ON c.product_id = p.product_id
    ORDER BY c.item_id ASC
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
<style>

</style>
</head>
<body style="padding-top: 50px;">

<nav class="navbar navbar-expand-lg position-fixed top-0 end-0 start-0 border border-bottom-1 border-secondary">
  <div class="container-fluid">
    <h5 class="me-4 mt-2 logo">URBANIX</h5>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
       <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link me-2" href="home.html">HOME</a></li>
        <li class="nav-item"><a class="nav-link me-2" href="products.html">PRODUCTS</a></li>
        <li class="nav-item"><a class="nav-link me-2" href="about.html">ABOUT</a></li>
        <li class="nav-item"><a class="nav-link me-2" href="fetch_cart.php">CART</a></li>
        <li class="nav-item"><a class="nav-link" href="contact.php">CONTACT US</a></li>
      </ul>
      <form class="d-flex me-2" action="index.php">
        <a class="mt-1" href="admin.php">
            <i class="fa-regular fa-user align-self-center nav-icon me-4"></i>
        </a>
        <i class="fa-solid fa-cart-shopping align-self-center nav-icon me-3"></i>
        <button class="btn nav-btn fw-bold px-3" type="submit">logout</button>
      </form>
    </div>
  </div>
</nav>

 <div class="menu">
        <ul>
            <li class="profile">
                <div class="img-box">
                    <img src="img/user-200x300.webp" alt="profile">
                </div>
                <h2>Jorg </h2>
            </li>
            <li>
                <a   href="admin.php">
               <i class="fa-solid fa-house"></i>
                    <p>dashboard</p>
                </a>
            </li>
              <li>
                <a href="client.php">
                <i class="fa-solid fa-users"></i>
                    <p>clients</p>
                </a>
            </li>
              <li>
                <a href="addproduct_admin.php">
                <i class="fa-solid fa-table"></i>
                    <p>products</p>
                </a>
            </li>
              <li>
                <a class ="active" href="fetch_cart.php">
                 <i class="fa-jelly fa-regular fa-chart-bar"></i>
                    <p>carts</p>
                </a>
            </li>

              <li>
                <a href="posts.php">
                <i class="fa-solid fa-pen"></i>
                    <p>posts</p>
                </a>
            </li>
         
              <li class="log-out">
                <a href="logout.php">
                 <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    <p>Log out</p>
                </a>
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