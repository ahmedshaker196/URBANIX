<?php
session_start();

// ---------- Database Connection ----------
$servername = "localhost";
$usernameDB = "root";
$passwordDB = "";
$dbname = "urbanix";

$conn = new mysqli($servername, $usernameDB, $passwordDB, $dbname);

if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

$message = "";

// ---------- Handle Login ----------
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE email = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {

        $user = $result->fetch_assoc();

        if (password_verify($password, $user["password"])) {

            $_SESSION["user_id"]  = $user["user_id"];
            $_SESSION["username"] = $user["username"];
            $_SESSION["role"]     = $user["role"];

            if ($user["role"] === "admin") {
                header("Location: admin.php");
                exit;
            } else {
                header("Location: home.html");
                exit;
            }

        } else {
            $message = "<div class='alert alert-danger mt-2 text-center'>Incorrect password!</div>";
        }

    } else {
        $message = "<div class='alert alert-danger mt-2 text-center'>No account found with this email.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="fontawesome-free-6.7.2-web/css/all.min.css">
    <link rel="stylesheet" href="CSS/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Days+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Chakra+Petch&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="CSS/style.css">
</head>

<body>

<main>

    <!-- Show error messages -->
    <?php echo $message; ?>

    <form method="POST" action="index.php" class="col-lg-5">

        <h1 class="fw-bolder">Login</h1>
        <br>

        <label for="email"></label>
        <input type="email" id="email" name="email" required placeholder="Enter Your Email">
        <br><br>

        <label for="pass"></label>
        <input type="password" id="pass" name="password" required placeholder="Enter Your Password">
        <br><br>

        <div class="row">
            <div class="col-lg-6 check-box">
                <div>
                    <input class="form-check-input" type="checkbox" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Remember Me</label>
                </div>
            </div>

            <div class="col-lg-6 forget-pass">
                <a href="#">Forget Password ?</a>
            </div>
        </div>
        <br>

        <button type="submit" class="login-btn">Login</button>

        <br><br>

        <p>Don't Have An Account ? <a href="register.php">Register</a></p>

    </form>

</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
