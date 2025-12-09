<?php

$servername = "localhost";
$usernameDB = "root";
$passwordDB = "";
$dbname = "urbanix";

$conn = new mysqli($servername, $usernameDB, $passwordDB, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = ""; // مكان لرسائل النجاح / الخطأ

// ===========================
// 2) Handle Form Submit
// ===========================
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name     = trim($_POST["name"]);
    $username = trim($_POST["username"]);
    $email    = trim($_POST["email"]);
    $password = $_POST["password"];
    $cpassword = $_POST["cpassword"];

    // Validate Confirm Password
    if ($password !== $cpassword) {
        $message = "<div class='alert alert-danger'>Passwords do not match!</div>";
    } else {

        // Check Email or Username Exists
        $check_sql = "SELECT * FROM users WHERE email=? OR username=?";
        $stmt = $conn->prepare($check_sql);
        $stmt->bind_param("ss", $email, $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $message = "<div class='alert alert-danger'>Email or Username already exists!</div>";
        } else {

            // Hash Password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insert User
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

    <style>
        :root {
            --accent-orange: #ff9f00;
            --whiteColor: #ffffff;
            --black-bg: #1a1a1a;
        }
        body { background-color: #f5f5f5; }
        .register-box {
            background-color: var(--black-bg);
            border: 1px solid var(--whiteColor);
            border-radius: 40px;
        }
        .register-box h3 { color: var(--accent-orange); }
        .form-label { color: white; }
        .form-control {
            border-radius: 40px;
            height: 45px;
        }
        .btn-custom {
            background-color: var(--accent-orange);
            border-radius: 40px;
            height: 45px;
            font-weight: bold;
            color: black;
        }
        .btn-custom:hover { opacity: 0.9; }
        .link-orange { color: var(--accent-orange); }
    </style>
</head>

<body>

<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="register-box col-md-5 col-11 p-4 shadow">

        <h3 class="text-center mb-4">Register Your Account</h3>

        <!-- PHP Message -->
        <?php echo $message; ?>

        <form method="POST" action="">

            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" required placeholder="Enter your full name...">
            </div>

            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" required placeholder="Enter a username...">
            </div>

            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control" required placeholder="Enter your email address...">
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required placeholder="Enter your password...">
            </div>

            <div class="mb-3">
                <label class="form-label">Confirm Password</label>
                <input type="password" name="cpassword" class="form-control" required placeholder="Enter your password again...">
            </div>

            <button type="submit" class="btn btn-custom w-100 mt-3">
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
