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







$session_id = session_id();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    
    if (isset($_POST['product_id'])) {
        $product_id = (int) $_POST['product_id'];
        $qty = isset($_POST['qty']) ? (int) $_POST['qty'] : 1;
        if ($qty < 1) $qty = 1;

        
        $sql = "SELECT id, price FROM products WHERE id = ?";
        $stmt = mysqli_prepare($mysqli, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $product_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $found_id, $price);
        $exists = mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        if ($exists) {
            
            $sql = "SELECT id FROM carts WHERE session_id = ? LIMIT 1";
            $stmt = mysqli_prepare($mysqli, $sql);
            mysqli_stmt_bind_param($stmt, 's', $session_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $cart_id);
            $found_cart = mysqli_stmt_fetch($stmt);
            mysqli_stmt_close($stmt);

            if (!$found_cart) {
                $sql = "INSERT INTO carts (session_id) VALUES (?)";
                $stmt = mysqli_prepare($mysqli, $sql);
                mysqli_stmt_bind_param($stmt, 's', $session_id);
                mysqli_stmt_execute($stmt);
                $cart_id = mysqli_insert_id($mysqli);
                mysqli_stmt_close($stmt);
            }

            
            $sql = "SELECT id, qty FROM cart_items WHERE cart_id = ? AND product_id = ? LIMIT 1";
            $stmt = mysqli_prepare($mysqli, $sql);
            mysqli_stmt_bind_param($stmt, 'ii', $cart_id, $product_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $item_id, $existing_qty);
            $found_item = mysqli_stmt_fetch($stmt);
            mysqli_stmt_close($stmt);

            if ($found_item) {
                $new_qty = $existing_qty + $qty;
                $sql = "UPDATE cart_items SET qty = ? WHERE id = ?";
                $stmt = mysqli_prepare($mysqli, $sql);
                mysqli_stmt_bind_param($stmt, 'ii', $new_qty, $item_id);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
            } else {
                $price_at_added = (float) $price;
                $sql = "INSERT INTO cart_items (cart_id, product_id, qty, price_at_added) VALUES (?, ?, ?, ?)";
                $stmt = mysqli_prepare($mysqli, $sql);
                mysqli_stmt_bind_param($stmt, 'iiid', $cart_id, $product_id, $qty, $price_at_added);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
            }
        }
    }

    
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        if ($action === 'update_qty' && isset($_POST['item_id'], $_POST['qty'])) {
            $item_id = (int) $_POST['item_id'];
            $qty = (int) $_POST['qty'];
            if ($qty < 1) $qty = 1;

            $sql = "UPDATE cart_items ci
                    JOIN carts c ON ci.cart_id = c.id
                    SET ci.qty = ?
                    WHERE ci.id = ? AND c.session_id = ?
                    LIMIT 1";
            $stmt = mysqli_prepare($mysqli, $sql);
            mysqli_stmt_bind_param($stmt, 'iis', $qty, $item_id, $session_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }

        if ($action === 'remove_item' && isset($_POST['item_id'])) {
            $item_id = (int) $_POST['item_id'];
            
            
            $sql = "DELETE FROM cart_items 
                    WHERE id = ? 
                    AND cart_id = (SELECT id FROM carts WHERE session_id = ? LIMIT 1)";
            
            $stmt = mysqli_prepare($mysqli, $sql);
            mysqli_stmt_bind_param($stmt, 'is', $item_id, $session_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
    }

    
    header('Location: cart.php');
    exit;
}


$cart_id = null;
$sql = "SELECT id FROM carts WHERE session_id = ? LIMIT 1";
$stmt = mysqli_prepare($mysqli, $sql);
mysqli_stmt_bind_param($stmt, 's', $session_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $cart_id);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

$items = [];
$total_subtotal = 0.0;

if ($cart_id) {
    $sql = "SELECT ci.id AS ci_id, p.id AS product_id, p.name, ci.qty, ci.price_at_added, (ci.qty * ci.price_at_added) AS subtotal, p.image
            FROM cart_items ci
            JOIN products p ON p.id = ci.product_id
            WHERE ci.cart_id = ?";
    $stmt = mysqli_prepare($mysqli, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $cart_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $ci_id, $product_id, $pname, $qty, $price_at_added, $subtotal, $pimage);
    while (mysqli_stmt_fetch($stmt)) {
        $items[] = [
            'ci_id' => $ci_id,
            'product_id' => $product_id,
            'name' => $pname,
            'qty' => $qty,
            'price' => (float)$price_at_added,
            'subtotal' => (float)$subtotal,
            'image' => $pimage
        ];
        $total_subtotal += (float)$subtotal;
    }
    mysqli_stmt_close($stmt);
}

$discount = 0.00;
$total = $total_subtotal - $discount;

function e($s) { return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>URBANIX - Cart</title>
  <link rel="stylesheet" href="fontawesome-free-6.7.2-web/css/all.min.css">
  <link rel="stylesheet" href="CSS/bootstrap.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background:#f8f9fa; }
    .cart-container { padding: 100px 15px 40px; }
    .cart-item { background: #fff; border-radius:12px; padding:16px; margin-bottom:12px; }
    .cart-sidebar { background:#fff; border-radius:12px; padding:16px; position:sticky; top:100px; }
    .product-thumb { width:84px; height:84px; object-fit:cover; border-radius:8px; }
    .qty-input { width:80px; }
    .muted { color:#6c757d; }
    
    /* Header Styles */
    .navbar { background:#fff; box-shadow:0 2px 10px rgba(0,0,0,0.1); }
    .nav-link { color:#333 !important; font-weight:500; }
    .nav-link:hover { color:#000 !important; }
    .logo { font-weight:bold; font-size:24px; color:#000; }
    .nav-btn { background:#000; color:#fff; border-radius:20px; }
    .nav-btn:hover { background:#333; color:#fff; }
    .nav-icon { font-size:20px; color:#333; }
    
    /* Footer Styles */
    .footer-icon-box { 
        width:40px; height:40px; 
        background:#f8f9fa; 
        color:#333; 
        transition:all 0.3s; 
    }
    .footer-icon-box:hover { 
        background:#000; 
        color:#fff; 
        transform:translateY(-3px); 
    }
  </style>
</head>
<body>

<!-- Start of Navbar -->
<nav class="navbar navbar-expand-lg position-fixed top-0 end-0 start-0 border border-bottom-1 border-top-0 border-start-0 border-end-0 border-secondary" style="z-index:1000;">
  <div class="container-fluid">
    <h5 class="me-4 mt-2 logo">URBANIX</h5>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link me-2" aria-current="page" href="home.html">HOME</a>
        </li>
        <li class="nav-item">
          <a class="nav-link me-2" href="products.php">PRODUCTS</a>
        </li>
        <li class="nav-item">
          <a class="nav-link me-2" href="about.php">ABOUT</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="contact.php">CONTACT US</a>
        </li>
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
<!-- End of Navbar -->

<div class="container cart-container">
  <div class="row">
    <div class="col-lg-8">
      <h3 class="mb-4"><i class="fa-solid fa-cart-shopping"></i> Your Shopping Cart</h3>

      <?php if (empty($items)): ?>
        <div class="alert alert-info">
          Your cart is empty. <a href="products.php" class="fw-semibold">Go to products</a>
        </div>
      <?php else: ?>
        <?php foreach ($items as $it): ?>
          <div class="cart-item d-flex">
            <div class="me-3">
              <?php if (!empty($it['image'])): ?>
                <img src="<?= e($it['image']) ?>" alt="<?= e($it['name']) ?>" class="product-thumb">
              <?php else: ?>
                <div class="product-thumb bg-light d-flex align-items-center justify-content-center muted">No image</div>
              <?php endif; ?>
            </div>
            <div class="flex-grow-1">
              <h5 class="mb-1"><?= e($it['name']) ?></h5>
              <div class="muted mb-2">Price (at add): <?= number_format($it['price'], 2) ?> EGP</div>

              <div class="d-flex align-items-center gap-3">
                <form method="post" class="d-flex align-items-center gap-2">
                  <input type="hidden" name="action" value="update_qty">
                  <input type="hidden" name="item_id" value="<?= (int)$it['ci_id'] ?>">
                  <input type="number" name="qty" value="<?= (int)$it['qty'] ?>" min="1" class="form-control qty-input">
                  <button type="submit" class="btn btn-sm btn-primary">Update</button>
                </form>

                <form method="post" onsubmit="return confirm('Are you sure you want to remove this item?');">
                  <input type="hidden" name="action" value="remove_item">
                  <input type="hidden" name="item_id" value="<?= (int)$it['ci_id'] ?>">
                  <button type="submit" class="btn btn-sm btn-outline-danger">Remove</button>
                </form>

                <div class="ms-auto text-end">
                  <div class="muted">Subtotal</div>
                  <div class="fw-bold"><?= number_format($it['subtotal'], 2) ?> EGP</div>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>

    <div class="col-lg-4">
      <div class="cart-sidebar">
        <h5 class="mb-3">Order Summary</h5>

        <div class="d-flex justify-content-between mb-2">
          <div class="muted">Subtotal</div>
          <div><?= number_format($total_subtotal, 2) ?> EGP</div>
        </div>

        <div class="d-flex justify-content-between mb-2">
          <div class="muted">Discount</div>
          <div><?= number_format($discount, 2) ?> EGP</div>
        </div>

        <hr>

        <div class="d-flex justify-content-between mb-3">
          <div class="fw-bold fs-5">Total</div>
          <div class="fw-bold fs-5"><?= number_format($total, 2) ?> EGP</div>
        </div>

        <div class="d-grid gap-2">
          <a href="products.php" class="btn btn-outline-secondary">Continue Shopping</a>
          <?php if (!empty($items)): ?>
            <a href="#" class="btn btn-primary">Checkout</a>
          <?php else: ?>
            <button class="btn btn-primary" disabled>Checkout</button>
          <?php endif; ?>
        </div>

      </div>
    </div>
  </div>
</div>

<!-- Footer -->
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
<!-- End of Footer -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>