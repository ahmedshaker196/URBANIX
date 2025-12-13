<?php
session_start();

/* =========================
   Database Connection
========================= */
$servername = "localhost";
$usernameDB = "root";
$passwordDB = "";
$dbname = "urbanix";

$conn = new mysqli($servername, $usernameDB, $passwordDB, $dbname);
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

$message = "";

/* =========================
   Handle Login
========================= */
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email    = trim($_POST["email"]);
    $password = $_POST["password"];

    $stmt = $conn->prepare(
        "SELECT user_id, username, password, role
         FROM users
         WHERE email = ?
         LIMIT 1"
    );
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {

        $user = $result->fetch_assoc();

        if (password_verify($password, $user["password"])) {

            $_SESSION["user_id"]  = $user["user_id"];
            $_SESSION["username"] = $user["username"];
            $_SESSION["role"]     = $user["role"];

            /* ---- CART ---- */
            $user_id = $user["user_id"];

            $cartStmt = $conn->prepare(
                "SELECT id FROM carts WHERE user_id = ? LIMIT 1"
            );
            $cartStmt->bind_param("i", $user_id);
            $cartStmt->execute();
            $cartResult = $cartStmt->get_result();

            if ($cartResult->num_rows === 0) {
                $createCart = $conn->prepare(
                    "INSERT INTO carts (user_id) VALUES (?)"
                );
                $createCart->bind_param("i", $user_id);
                $createCart->execute();
                $cart_id = $createCart->insert_id;
            } else {
                $cart = $cartResult->fetch_assoc();
                $cart_id = $cart["id"];
            }

            $_SESSION["cart_id"] = $cart_id;

            if ($user["role"] === "admin") {
                header("Location: admin.php");
            } else {
                header("Location: home.html");
            }
            exit;

        } else {
            $message = "<div class='alert alert-danger text-center mt-2'>
                            Incorrect password!
                        </div>";
        }

    } else {
        $message = "<div class='alert alert-danger text-center mt-2'>
                        No account found with this email.
                    </div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>URBANIX | Login</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css">

    <style>
        :root {
            --accent-orange: #ff9f00;
            --whiteColor: #ffffff;
            --black-bg: #1a1a1a;
        }

        body {
            min-height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;

            background:
                radial-gradient(circle at 20% 20%, rgba(255, 140, 51, 0.35), transparent 40%),
                radial-gradient(circle at 80% 80%, rgba(255, 179, 71, 0.25), transparent 45%),
                linear-gradient(135deg, #0b0e13 0%, #141824 60%, #1a1f2b 100%);

            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .login-box {
            background-color: var(--black-bg);
            border: 1px solid var(--whiteColor);
            border-radius: 40px;
        }

        .login-box h3 {
            color: var(--accent-orange);
        }

        .form-label {
            color: white;
        }

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

        .btn-custom:hover {
            opacity: 0.9;
        }

        .link-orange {
            color: var(--accent-orange);
        }
    </style>
</head>

<body>

<!-- خدعة منع Autofill -->
<input type="text" style="display:none">
<input type="password" style="display:none">

<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="login-box col-md-5 col-11 p-4 shadow">

        <h3 class="text-center mb-4">Login</h3>

        <?php echo $message; ?>

        <form method="POST" action="index.php" autocomplete="off">

            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <input
                    type="email"
                    name="email"
                    class="form-control"
                    placeholder="Enter your email..."
                    required
                    autocomplete="off"
                >
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input
                    type="password"
                    name="password"
                    class="form-control"
                    placeholder="Enter your password..."
                    required
                    autocomplete="new-password"
                >
            </div>

            <button type="submit" class="btn btn-custom w-100 mt-3">
                Login
            </button>

            <div class="text-center mt-3 text-white">
                <span>Don't have an account? </span>
                <a href="register.php" class="link-orange text-decoration-none">Register</a>
            </div>

        </form>

    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
