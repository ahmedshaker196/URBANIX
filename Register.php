<?php

$servername = "localhost";
$usernameDB = "root";
$passwordDB = "";
$dbname = "urbanix";

$conn = new mysqli($servername, $usernameDB, $passwordDB, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";


if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name     = trim($_POST["name"]);
    $username = trim($_POST["username"]);
    $email    = trim($_POST["email"]);
    $password = $_POST["password"];
    $cpassword = $_POST["cpassword"];

    if ($password !== $cpassword) {
        $message = "<div class='alert alert-danger'>Passwords do not match!</div>";
    } else {

        $check_sql = "SELECT * FROM users WHERE email=? OR username=?";
        $stmt = $conn->prepare($check_sql);
        $stmt->bind_param("ss", $email, $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $message = "<div class='alert alert-danger'>Email or Username already exists!</div>";
        } else {

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $insert_sql = "INSERT INTO users (name, username, email, password, role, created_at)
                           VALUES (?, ?, ?, ?, 'user', NOW())";

            $stmt = $conn->prepare($insert_sql);
            $stmt->bind_param("ssss", $name, $username, $email, $hashedPassword);

            if ($stmt->execute()) {
                $message = "<div class='alert alert-success'>Account created successfully!</div>";
            } else {
                $message = "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>URBANIX</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="CSS/regss.css">
  
</head>

<body>

<div class="container d-flex justify-content-center align-items-center py-5">
    <div class="register-box col-lg-5 col-md-12 col-sm-12 p-4 shadow">

        <h3 class="text-center mb-4">Register Your Account</h3>

        <!-- PHP Message -->
        <?php echo $message; ?>

        <form method="POST" action="">

            <div class="mb-3">
                <label class="form-label text-white">Name</label>
                <input type="text" name="name" class="form-control py-2 rounded-5" required placeholder="Enter your full name...">
            </div>

            <div class="mb-3">
                <label class="form-label text-white">Username</label>
                <input type="text" name="username" class="form-control py-2 rounded-5" required placeholder="Enter a username...">
            </div>

            <div class="mb-3">
                <label class="form-label text-white">Email Address</label>
                <input type="email" name="email" class="form-control py-2 rounded-5" required placeholder="Enter your email address...">
            </div>

            <div class="mb-3">
                <label class="form-label text-white">Password</label>
                <input type="password" name="password" class="form-control py-2 rounded-5" required placeholder="Enter your password...">
            </div>

            <div class="mb-3">
                <label class="form-label text-white">Confirm Password</label>
                <input type="password" name="cpassword" class="form-control py-2 rounded-5" required placeholder="Enter your password again...">
            </div>

            <button type="submit" class="btn btn-custom w-100 mt-3  py-2 rounded-5">
                Sign Up
            </button>

            <div class="text-center mt-3 text-white">
                <span>Already have an account? </span>
                <a href="index.php" class="link-orange text-decoration-none">Sign in</a>
            </div>

        </form>

    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>

</body>
</html>
