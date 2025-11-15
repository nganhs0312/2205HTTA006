<?php
session_start();
require 'db.php';

if (isset($_SESSION['success'])) {
    $success = $_SESSION['success'];
    unset($_SESSION['success']); // chỉ hiển thị 1 lần
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Sai tên đăng nhập hoặc mật khẩu!";
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Đăng nhập</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<style>
    body {
        background: linear-gradient(135deg, #d4fc79, #96e6a1); /* Xanh lá nhạt */
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        font-family: Arial, sans-serif;
    }
    .login-box {
        background: white;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0px 8px 15px rgba(0,0,0,0.1);
        width: 100%;
        max-width: 400px;
    }
    h2 {
        text-align: center;
        margin-bottom: 20px;
        font-weight: 600;
        color: #3c763d;
    }
    .form-control:focus {
        border-color: #80c904;
        box-shadow: 0 0 5px rgba(128, 201, 4, 0.5);
    }
    .btn-primary {
        background-color: #28a745;
        border: none;
    }
    .btn-primary:hover {
        background-color: #218838;
    }
</style>
</head>
<body>

<div class="login-box">
    <h2>Đăng nhập</h2>

    <!-- Thông báo thành công -->
    <?php if (!empty($success)): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="username" class="form-control mb-3" placeholder="Tên đăng nhập" required>
        <input type="password" name="password" class="form-control mb-3" placeholder="Mật khẩu" required>
        <button type="submit" class="btn btn-primary w-100">Đăng nhập</button>
        <div class="mt-3 text-center">
            <a href="register.php" class="btn btn-link">Đăng ký</a>
        </div>
    </form>

    <?php if (!empty($error)) echo "<div class='alert alert-danger mt-3'>$error</div>"; ?>
</div>

</body>
</html>
