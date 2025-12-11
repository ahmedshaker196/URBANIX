<?php
require_once 'config/db.php';

// ============================
// 1) Count Users
// ============================
$user_result = $conn->query("SELECT COUNT(*) AS total_users FROM users");
$user_count = $user_result->fetch_assoc()['total_users'];

// ============================
// 2) Count Contact Messages
// ============================
$post_result = $conn->query("SELECT COUNT(*) AS total_posts FROM contact_messages");
$post_count = $post_result->fetch_assoc()['total_posts'];

// ============================
// 3) Count Products
// ============================
$product_result_count = $conn->query("SELECT COUNT(*) AS total_products FROM products");
$product_count = $product_result_count->fetch_assoc()['total_products'];

// ============================
// 4) Total Revenue
// ============================
$revenue_result = $conn->query("
    SELECT SUM(total_price * (1 - discount / 100)) AS total_revenue 
    FROM orders
");
$revenue = $revenue_result->fetch_assoc()['total_revenue'] ?? 0;

// ============================
// 5) Fetch Products List
// ============================
$result = $conn->query("
    SELECT id, name, price, stock, image, created_at
    FROM products
    ORDER BY id ASC
");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>URBANIX</title>
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="css/bootstrap.css">

    <style>
        .btn-edit i {color:#ff8c33; padding:2px 6px; border-radius:3px; text-decoration:none; margin-right:20px; }
        .btn-del i { color:#ff8c33; padding:2px 6px; border-radius:3px; text-decoration:none; }
        .btn-del i:hover{color:white;}
        .btn-edit i:hover{color:white;}
        .btn-edit i {color:#ff8c33; padding:2px 6px; border-radius:3px; text-decoration:none; margin-right:20px; }
        .btn-del i { color:#ff8c33; padding:2px 6px; border-radius:3px; text-decoration:none; }
        .btn-del i:hover{color:white;}
        .btn-edit i:hover{color:white;}
    </style>
</head>
<body style="padding-top: 50px;">

<nav class="navbar navbar-expand-lg position-fixed top-0 end-0 start-0 border border-bottom-1 border-top-0 border-start-0 border-end-0 border-secondary">
  <div class="container-fluid">

    <h5 class="me-4 mt-2 logo">URBANIX</h5>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
       <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link me-2" aria-current="page" href="home.html">HOME</a></li>
        <li class="nav-item"><a class="nav-link me-2" href="products.html">PRODUCTS</a></li>
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

        <li><a class="active" href="admin.php"><i class="fa-solid fa-house"></i><p>dashboard</p></a></li>
        <li><a href="client.php"><i class="fa-solid fa-users"></i><p>clients</p></a></li>
        <li><a href="addproduct_admin.php"><i class="fa-solid fa-table"></i><p>products</p></a></li>
        <li><a href="fetch_cart.php"><i class="fa-regular fa-chart-bar"></i><p>carts</p></a></li>
        <li><a href="posts.php"><i class="fa-solid fa-pen"></i><p>posts</p></a></li>

        <li class="log-out">
            <a href="logout.php"><i class="fa-solid fa-arrow-right-from-bracket"></i><p>Log out</p></a>
        </li>
    </ul>
</div>

<!-- Content -->
<div class="content">
    <div class="title-info">
        <p>dashboard</p>
        <i class="fa-solid fa-house"></i>
    </div>

    <div class="data-info">
        <div class="box"><i class="fa-solid fa-users"></i><div class="data"><p>user</p><span><?= $user_count ?></span></div></div>
        <div class="box"><i class="fa-solid fa-pen"></i><div class="data"><p>posts</p><span><?= $post_count ?></span></div></div>
        <div class="box"><i class="fa-solid fa-table"></i><div class="data"><p>products</p><span><?= $product_count ?></span></div></div>
        <div class="box"><i class="fa-solid fa-dollar-sign"></i><div class="data"><p>revenue</p><span>$<?= number_format($revenue, 2) ?></span></div></div>
    </div>

    <div class="title-info">
        <p>product</p>
        <i class="fa-solid fa-table"></i>
    </div>

    <table>
        <thead>
            <tr>
                <th>product</th>
                <th>price</th>
                <th>count</th>
                <th>actions</th>
            </tr>
        </thead>

        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['name'] ?></td>
                <td><span class="price">$<?= number_format($row['price'], 2) ?></span></td>
                <td><span class="count"><?= $row['stock'] ?></span></td>

                <td>
                    <!-- FIXED ONLY THIS PART -->
                    <a href="edit_product.php?id=<?= $row['id'] ?>" class="btn-edit">
                        <i class="fa-regular fa-pen-to-square"></i>
                    </a>

                    <a href="delete_product.php?id=<?= $row['id'] ?>" class="btn-del">
                        <i class="fa-solid fa-delete-left"></i>
                    </a>
                </td>

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
