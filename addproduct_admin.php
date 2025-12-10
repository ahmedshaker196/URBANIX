<?php
require_once 'config/db.php';

$categories = $conn->query("SELECT category_id, category_name FROM categories");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Add Product - Admin</title>
<link rel="stylesheet" href="css/bootstrap.css">
<link rel="stylesheet" href="css/admin.css">
<link rel="stylesheet" href="css/all.min.css">
<style>
.content-box { background: white; padding: 25px; border-radius: 10px; box-shadow: 0 0 10px #00000020; margin-top: 40px;  }
.form-group { margin-bottom: 15px; }
.form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
.form-group input, .form-group select, .form-group textarea { width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ccc; }
.btn-save { background: #2e7d32; color: white; padding: 10px 20px; border-radius: 6px; border: none; cursor: pointer; margin-top: 10px; }
.btn-save:hover { background: #27632a; }
</style>
</head>
<body>
<div class="content w-50 mx-auto" >
    <div class="title-info w-100 mx-auto ">
        <p >Add Product</p>
        <i class="fa-solid fa-plus"></i>
    </div>

    <div class="content-box">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Product Name</label>
                <input type="text" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" required></textarea>
            </div>

            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" id="price" name="price" required>
            </div>

            <div class="form-group">
                <label for="stock">Stock</label>
                <input type="number" id="stock" name="stock" required>
            </div>

            <div class="form-group">
                <label for="category_id">Category</label>
                <select id="category_id" name="category_id" required>
                    <?php while($cat = $categories->fetch_assoc()): ?>
                        <option value="<?= $cat['category_id'] ?>"><?= $cat['category_name'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="is_new">New Product?</label>
                <input type="checkbox" id="is_new" name="is_new" value="1">
            </div>

            <div class="form-group">
                <label for="image">Product Image</label>
                <input type="file" id="image" name="image" accept="image/*" required>
            </div>

            <button type="submit" name="save_product" class="btn-save">Save Product</button>
        </form>
    </div>
</div>

<?php
if(isset($_POST['save_product'])){
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $category_id = $_POST['category_id'];
    $is_new = isset($_POST['is_new']) ? 1 : 0;
    $created_at = date('Y-m-d H:i:s');

 // Upload image
    $targetDir = "uploads/";
    if(!is_dir($targetDir)) mkdir($targetDir, 0777, true);
    $targetFile = $targetDir . basename($_FILES["image"]["name"]);

    if(move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)){
        $sql = "INSERT INTO products (name, description, price, stock, category_id, is_new, created_at)
                VALUES ('$name', '$description', '$price', '$stock', '$category_id', '$is_new', '$created_at')";
        if($conn->query($sql)){
            $product_id = $conn->insert_id;
            $conn->query("INSERT INTO product_images (product_id, image_url) VALUES ('$product_id', '$targetFile')");
            echo "<p style='color:green;'>Product added successfully!</p>";
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Error uploading image.";
    }
}
$conn->close();
?>
</body>
</html>