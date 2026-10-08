<?php
session_start();

// Kiểm tra Session hoặc Cookie auth_token
if (!isset($_SESSION['username']) && !isset($_COOKIE['auth_token'])) {
    header('Location: index.php');
    exit();
}

// Nếu truy cập bằng Cookie (chưa có Session), phục hồi lại Session
if (!isset($_SESSION['username']) && isset($_COOKIE['auth_token'])) {
    $_SESSION['username'] = 'admin'; // Giả định khôi phục Session từ token
}

$fullName = "Quản trị viên AI"; // Giả định lấy thông tin Full Name từ class AI_User

// Mảng danh sách các Mô hình AI (giả định từ bài trước)
$aiModels = [
    ['id' => 1, 'name' => 'GPT-4o', 'type' => 'Language Model', 'version' => '2024'],
    ['id' => 2, 'name' => 'Claude 3.5 Sonnet', 'type' => 'Language Model', 'version' => '2024'],
    ['id' => 3, 'name' => 'Gemini 1.5 Pro', 'type' => 'Multimodal Model', 'version' => '2024'],
    ['id' => 4, 'name' => 'Stable Diffusion XL', 'type' => 'Image Generation', 'version' => '1.0']
];
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Trang Quản trị AI</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
<div class="admin-card">
        <!-- Header -->
        <div class="header">
            <div class="welcome-text">
                <span class="badge">Admin</span>
                <h2>Chào mừng: Quản trị viên AI</h2>
            </div>
            <a href="logout.php" class="btn-logout">Đăng xuất</a>
        </div>

        <!-- Section Title -->
        <div class="section-title">
            <h3>Danh sách các Mô hình AI</h3>
            <span class="count">4 mô hình</span>
        </div>

        <!-- Table -->
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                <th>STT</th>
                <th>Tên mô hình</th>
                <th>Loại</th>
                <th>Phiên bản</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($aiModels as $index => $model) : ?>
                <tr>
                    <td><?php echo $index + 1; ?></td>
                    <td><?php echo htmlspecialchars($model['name']); ?></td>
                    <td><?php echo htmlspecialchars($model['type']); ?></td>
                    <td><?php echo htmlspecialchars($model['version']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>