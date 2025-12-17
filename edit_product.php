<?php
require_once 'config/db.php';

/* =========================
   GET PRODUCT ID
========================= */
if (!isset($_GET['id'])) die("Product ID not provided");
$product_id =  $_GET['id'];

/* =========================
   Fetch Product
========================= */
$sql="SELECT * FROM products WHERE id = $product_id";
$product_res = mysqli_query($conn, $sql);

if (mysqli_num_rows($product_res) == 0) {
    die("Product not found");
}

$product = mysqli_fetch_assoc($product_res);


/* =========================
   UPDATE PRODUCT
========================= */
if (isset($_POST['update_product'])) {

    $name        = $_POST['name'];
    $description = $_POST['description'];
    $price       = $_POST['price'];
    $stock       = $_POST['stock'];
    $is_new      = isset($_POST['is_new']) ? 1 : 0;

    /* Image Upload */
    if (isset($_FILES['image']) && $_FILES['image']['tmp_name']) {

    $myimage  = $_FILES['image'];
    $filename = $myimage['name'];        
    $tempname = $myimage['tmp_name'];    
    $size     = $myimage['size'];        
    $folder = "uploads/" . $filename;

     if (move_uploaded_file($tempname, $folder)) {
        $sql="UPDATE products SET image='$folder' WHERE id=$product_id";
        mysqli_query($conn,$sql);
    } else {
        echo "Error uploading image.";
    }
    }


    /* Update Product */
    $sql = "
        UPDATE products SET 
            name='$name',
            description='$description',
            price='$price',
            stock='$stock',
            is_new='$is_new'
        WHERE id=$product_id
    ";

    if (mysqli_query($conn,$sql)) {
        echo "<p style='color:green; text-align:center;'>Product updated successfully!</p>";
        $product_res = mysqli_query($conn,"SELECT * FROM products WHERE id = $product_id");
         $product = mysqli_fetch_assoc($product_res);
    } else {

        echo "<p style='color:red;'>Error: " . mysqli_error($conn) . "</p>";

    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit Product - Admin</title>

<link rel="stylesheet" href="css/bootstrap.css">
<link rel="stylesheet" href="css/admin.css">
<link rel="stylesheet" href="css/all.min.css">

<style>
.content { padding:20px; }
.content-box {
    background:white;
    padding:25px;
    border-radius:10px;
    box-shadow:0 0 10px #00000020;
    margin-top:40px;
}
.title-info { display:flex; align-items:center; gap:10px; margin-bottom:20px; }
.title-info p { font-size:24px; font-weight:bold; margin:0; }

.form-group { margin-bottom:15px; }
.form-group label { display:block; margin-bottom:5px; font-weight:bold; }
.form-group input,
.form-group textarea {
    width:100%;
    padding:10px;
    border-radius:5px;
    border:1px solid #ccc;
}

/* Update Button */
.btn-save {
    background:#ff8c33;
    color:#fff;
    padding:10px 20px;
    border-radius:10px;
    border:none;
    cursor:pointer;
    margin-top:10px;
    width:100%;
    font-size:16px;
}
.btn-save:hover { background:#cac9c9; }

/* Back Button */
.btn-back {
    background:#000;
    color:#fff;
    padding:10px 20px;
    border-radius:10px;
    border:none;
    cursor:pointer;
    margin-top:10px;
    width:100%;
    font-size:16px;
    text-align:center;
    display:block;
    text-decoration:none;
}
.btn-back:hover {
    background:#333;
    color:#fff;
}
</style>
</head>

<body>

<div class="content w-50 mx-auto">

    <div class="title-info">
        <p>Edit Product</p>
        <i class="fa-solid fa-pen-to-square"></i>
    </div>

    <div class="content-box">
        <form action="" method="post" enctype="multipart/form-data">

            <div class="form-group">
                <label>Product Name</label>
                <input type="text" name="name" value="<?= $product['name'] ?>" required>
            </div>

            <div class="form-group">
                <label>Description</label>
                <textarea name="description" required><?= $product['description'] ?></textarea>
            </div>

            <div class="form-group">
                <label>Price</label>
                <input type="number" name="price" value="<?= $product['price'] ?>" required>
            </div>

            <div class="form-group">
                <label>Stock</label>
                <input type="number" name="stock" value="<?= $product['stock'] ?>" required>
            </div>

            <div class="form-group">
                <label>
                    <input type="checkbox" name="is_new" value="1" <?= $product['is_new'] ? 'checked' : '' ?>>
                    New Product?
                </label>
            </div>

            <div class="form-group">
                <label>Product Image</label>
                <input type="file" name="image">
            </div>

            <!-- Buttons -->
            <button type="submit" name="update_product" class="btn-save">
                Update Product
            </button>

            <a href="admin.php" class="btn-back">
                Back
            </a>

        </form>
    </div>
</div>

</body>
</html>
