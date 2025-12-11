<?php
require_once 'config/db.php';


if(!isset($_GET['id'])) die("Product ID not provided");
$product_id = $_GET['id'];

$categories = $conn->query("SELECT category_id, category_name FROM categories");
$product_res = $conn->query("SELECT * FROM products WHERE product_id = $product_id");
if($product_res->num_rows == 0) die("Product not found");
$product = $product_res->fetch_assoc();


if(isset($_POST['update_product'])){
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $category_id = $_POST['category_id'];
    $is_new = isset($_POST['is_new']) ? 1 : 0;

   
    if(isset($_FILES['image']) && $_FILES['image']['tmp_name']){
        $targetDir = "uploads/";
        
        $targetFile = $targetDir . basename($_FILES["image"]["name"]);
        if(move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)){
            $conn->query("UPDATE product_images SET image_url='$targetFile' WHERE product_id=$product_id");
        }
    }

    $sql = "UPDATE products SET 
            name='$name', description='$description', price='$price', stock='$stock', 
            category_id='$category_id', is_new='$is_new' WHERE product_id=$product_id";
    if($conn->query($sql)){
        echo "<p style='color:green;'>Product updated successfully!</p>";
        $product = $conn->query("SELECT * FROM products WHERE product_id = $product_id")->fetch_assoc();
    } else {
        echo "Error: " . $conn->error;
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
.content {  padding:20px; }
.content-box { background:white; padding: 25px; border-radius: 10px; box-shadow: 0 0 10px #00000020; margin-top: 40px;  }
.title-info { display:flex; align-items:center; gap:10px; margin-bottom:20px; }
.title-info p { font-size:24px; font-weight:bold; margin:0; }
.form-group { margin-bottom: 15px; }
.form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
.form-group input, .form-group select, .form-group textarea { width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ccc; }
.btn-save { background: #ff8c33;; color: white; padding: 10px 20px; border-radius: 10px; border: none; cursor: pointer; margin-top: 10px; width: 100%; font-size:16px; }
.btn-save:hover { background: #cac9c9; }
h2 { text-align:center; color:#333; margin-bottom:20px; }
</style>
</head>
<body>
<div class="content w-50 mx-auto">
    <div class="title-info w-100">
        <p>Edit Product</p>
        <i class="fa-solid fa-pen-to-square"></i>
    </div>

    <div class="content-box">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Product Name</label>
                <input type="text" id="name" name="name" value="<?= $product['name'] ?>" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" required><?= $product['description'] ?></textarea>
            </div>

            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" id="price" name="price" value="<?= $product['price'] ?>" required>
            </div>

            <div class="form-group">
                <label for="stock">Stock</label>
                <input type="number" id="stock" name="stock" value="<?= $product['stock'] ?>" required>
            </div>

            <div class="form-group">
                <label for="category_id">Category</label>
                <select id="category_id" name="category_id" required>
                    <?php while($cat = $categories->fetch_assoc()): ?>
                        <option value="<?= $cat['category_id'] ?>" <?= $cat['category_id']==$product['category_id']?'selected':'' ?>>
                            <?= $cat['category_name'] ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="is_new">New Product?</label>
                <input type="checkbox" id="is_new" name="is_new" value="1" <?= $product['is_new']?'checked':'' ?>>
            </div>

            <div class="form-group">
                <label for="image">Product Image</label>
                <input type="file" id="image" name="image">
            </div>

            <button type="submit" name="update_product" class="btn-save">Update Product</button>
        </form>
    </div>
</div>
</body>
</html>