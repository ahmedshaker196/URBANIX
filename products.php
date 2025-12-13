<?php

session_start();
//require 'db.php';



$DB_HOST = 'localhost';
$DB_USER = 'root';      
$DB_PASS = '';          
$DB_NAME = 'URBANIX';

$mysqli = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if (!$mysqli) {
    die('Database connect error: ' . mysqli_connect_error());
}
mysqli_set_charset($mysqli, "utf8mb4");





$sql = "SELECT  id, name, price, image, description FROM products ORDER BY id";
$result = mysqli_query($mysqli, $sql);

if (!$result) {
    die("Error fetching products: " . mysqli_error($mysqli));
}

$products = [];
while ($row = mysqli_fetch_assoc($result)) {
    $products[] = $row;
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>URBANIX - Products</title>
  <link rel="stylesheet" href="fontawesome-free-6.7.2-web/css/all.min.css">
  <link rel="stylesheet" href="CSS/bootstrap.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="CSS/products.css">
  <style>
    .product-card img { max-width:100%; height:160px; object-fit:cover; border-radius:8px; }
    .add-to-cart-btn { cursor:pointer; border:none; background:#111; color:#fff; }
    .pro-img { min-height:160px; display:flex; align-items:center; justify-content:center; }
    
  </style>
</head>
<body>


<nav class="navbar navbar-expand-lg position-fixed top-0 end-0 start-0 border border-bottom-1 border-top-0 border-start-0 border-end-0 border-secondary">
  <div class="container-fluid">
    <h5 class="me-4 mt-2 logo">URBANIX</h5>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
       <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link me-2" href="home.html">HOME</a></li>
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

<div style="height:80px;"></div>



<section class="hero-sec p-5 mt-4 d-flex align-items-lg-center">
  <div class="herosec-txt w-50 ms-5 mt-0 mb-5">
    <p class="mb-0">Live Loud <br><span> Dress URBANIX</span>.</p>
  </div>
</section>


<section class="sec-products py-4">
  <div class="container">
    <p class="fw-medium titleee fs-2 ms-3"> OUR PRODUCTS</p>
    <div class="row g-3">
      <?php if (empty($products)): ?>
        <div class="col-12 text-center">
          <p>No products available at the moment.</p>
        </div>
      <?php else: ?>
        <?php foreach ($products as $p): ?>
          <div class="col-lg-2 col-md-6 col-sm-12 p-3">
            <div class="product-card p-3 text-center rounded-4 border border-2 h-100 d-flex flex-column">
              <div class="pro-img mb-3">
                <?php if (!empty($p['image'])): ?>
                  <img src="<?= htmlspecialchars($p['image']) ?>" alt="<?= htmlspecialchars($p['name']) ?>">
                <?php else: ?>
                  <div class="bg-light w-100" style="height:160px; display:flex; align-items:center; justify-content:center;">
                    <span class="text-muted">No image</span>
                  </div>
                <?php endif; ?>
              </div>

              <div class="mb-2 text-start">
                <p class="mb-1"><?= htmlspecialchars($p['name']) ?></p>
                <?php if (!empty($p['description'])): ?>
                  <small class="text-muted"><?= htmlspecialchars($p['description']) ?></small>
                <?php endif; ?>
              </div>

              <div class="mt-auto w-100">
                <p class="fw-bold mb-2"><?= number_format((float)$p['price'], 2) ?> EGP</p>

                
                <form method="post" action="cart.php" class="d-grid">
                  <input type="hidden" name="product_id" value="<?= (int)$p['id'] ?>">
                  <input type="hidden" name="qty" value="1">
                  <button type="submit" class="add-to-cart-btn w-100 p-2 rounded-4">Add to Cart</button>
                </form>

              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>
</section>


<footer class="pb-2 mt-5 pt-5 border border-top-1 border-secondary">
  <div class="container-fluid px-5">
    <div class="d-flex justify-content-between align-items-start flex-wrap">
      <div class="mb-4">
        <div class="d-flex align-items-center gap-2">
          <h4 class="f-logo fw-bold m-0">URBANIX</h4>
        </div>
        <p class="mt-3 text-muted w-75">
          Redefining urban fashion with pieces that fit your lifestyle
        </p>
      </div>
      
      <div class="d-flex gap-3">
        <div class="footer-icon-box d-flex justify-content-center align-items-center rounded-3"><i class="fa-brands fa-tiktok"></i></div>
        <div class="footer-icon-box d-flex justify-content-center align-items-center rounded-3"><i class="fa-brands fa-twitter"></i></div>
        <div class="footer-icon-box d-flex justify-content-center align-items-center rounded-3"><i class="fa-brands fa-facebook"></i></div>
        <div class="footer-icon-box d-flex justify-content-center align-items-center rounded-3"><i class="fa-brands fa-instagram"></i></div>
      </div>
    </div>

    <hr class="my-4 border-light">

    <div class="text-center text-muted">
      © 2025 URBANIX. All rights reserved. <br>
      Made with <i class="fa-solid fa-heart" style="color:#d9591d;"></i> for amazing SHOPPING 
    </div>
  </div>
</footer>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>