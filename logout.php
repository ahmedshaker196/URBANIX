<?php
session_start();

$_SESSION = array();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

session_destroy();

// إعادة التوجيه لصفحة تسجيل الدخول
header("Location: index.php");
exit;
?>
