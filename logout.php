<?php
session_start();

// إزالة جميع بيانات السيشن
$_SESSION = array();

// حذف كعكة (كوكي) السيشن من المتصفح – مهم جدًا
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// تدمير السيشن بالكامل
session_destroy();

// إعادة التوجيه لصفحة تسجيل الدخول
header("Location: login.php");
exit;
?>
