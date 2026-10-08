<?php
session_start();

// 1. Hủy toàn bộ Session
$_SESSION = array();

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

session_destroy();

//2. Xóa Cookie auth_token bằng cách đặt thời gian hết hạn trong quá khứ
if (isset($_COOKIE['auth_token'])) {
    setcookie('auth_token', '', time() - 3600, '/');
}

// Chuyển hướng về trang đăng nhập
header('Location: login.php');
exit();
?>