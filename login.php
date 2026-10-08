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

    $user = AI_User::authenticate($username, $password);

    if ($user) {
        // 1. Lưu username vào $_SESSION
        $_SESSION['username'] = $username;

        // 2. Nếu chọn Ghi nhớ đăng nhập: lưu auth_token vào Cookie trong 7 ngày
        if ($remember) {
            $token = bin2hex(random_bytes(16));
            // Lưu token vào Cookie (7 ngày = 7 * 24 * 3600 giây)
            setcookie('auth_token', $token, time() + (7 * 86400), "/", "", false, true);
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
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(135deg, #cfd9df 0%, #e2ebf0 100%);
            position: relative;
            overflow: hidden;
        }

        /* Các khối hình cầu trang trí nền */
        .shape {
            position: absolute;
            border-radius: 50%;
            background: linear-gradient(135deg, #ffffff, #a1c4fd);
        }

        .shape-1 {
            width: 250px;
            height: 250px;
            top: 10%;
            left: 20%;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }

        .shape-2 {
            width: 300px;
            height: 300px;
            bottom: 10%;
            right: 20%;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }

        /* Thẻ Form với hiệu ứng Glassmorphism */
        .login-card {
            position: relative;
            z-index: 10;
            width: 380px;
            padding: 40px;
            background: rgba(255, 255, 255, 0.45);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.6);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
            text-align: center;
        }

        .login-card h2 {
            font-size: 24px;
            color: #333;
            letter-spacing: 2px;
            margin-bottom: 30px;
            text-transform: uppercase;
        }

        .input-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .input-group input {
            width: 100%;
            padding: 12px 20px;
            border-radius: 30px;
            border: 1px solid rgba(255, 255, 255, 0.8);
            background: rgba(255, 255, 255, 0.7);
            outline: none;
            font-size: 14px;
            color: #333;
            transition: all 0.3s ease;
        }

        .input-group input:focus {
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        }

        .actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 12px;
            color: #555;
            margin-bottom: 25px;
        }

        .actions label {
            display: flex;
            align-items: center;
            gap: 5px;
            cursor: pointer;
        }

        .actions a {
            color: #555;
            text-decoration: none;
            transition: color 0.2s;
        }

        .actions a:hover {
            color: #000;
        }

        .btn-submit {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 30px;
            background: rgba(255, 255, 255, 0.85);
            color: #333;
            font-weight: bold;
            letter-spacing: 1px;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .btn-submit:hover {
            background: #ffffff;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
            transform: translateY(-1px);
        }
    </style>
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