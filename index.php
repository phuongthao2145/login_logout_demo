<?php
session_start();
require_once 'AI_User.php';

// Nếu đã đăng nhập hoặc có Cookie ghi nhớ, tự động vào trang admin
if (isset($_SESSION['username']) || isset($_COOKIE['auth_token'])) {
    header('Location: admin.php');
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $remember = isset($_POST['remember']);

    $user = AI_User::authenticate($username, password_hash($password, PASSWORD_DEFAULT));

    if ($user) {
        // 1. Lưu username vào $_SESSION
        $_SESSION['username'] = $username;

        // 2. Nếu chọn Ghi nhớ đăng nhập: lưu auth_token vào Cookie trong 7 ngày
        if ($remember) {
            $token = bin2hex(random_bytes(16));
            // Lưu token vào Cookie (7 ngày = 7 * 24 * 3600 giây)
            setcookie('auth_token', $token, [
                'expires'  => $expire_time,
                'path'     => '/',
                'domain'   => '',       // Tự động nhận domain hiện tại
                'secure'   => true,     // Chỉ gửi qua HTTPS
                'httponly' => true,     // Bật cờ HttpOnly (chống XSS)
                'samesite' => 'Lax'     // Chống CSRF
            ]);
        }
        header('Location: admin.php');
        exit();
    } else {
        $error = 'Tên đăng nhập hoặc mật khẩu không đúng!';
    }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập</title>
    <link rel="stylesheet" href="main.css">
</head>

<body>

    <!-- Hình cầu làm nền -->
    <div class="shape shape-1"></div>
    <div class="shape shape-2"></div>

    <!-- Form Đăng Nhập -->
    <div class="login-card">
        <h2>LOGIN</h2>
        <?php if ($error) : ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>
        <form action="#" method="POST">
            <div class="input-group">
                <input type="text" name="username" required>
            </div>

            <div class="input-group">
                <input type="password" name="password" required>
            </div>

            <div class="actions">
                <label>
                    <input type="checkbox" name="remember" id="remember"> Remember me
                </label>
                <a href="#">Forgot password?</a>
            </div>

            <button type="submit" class="btn-submit">SIGN IN</button>
        </form>
    </div>

</body>

</html>