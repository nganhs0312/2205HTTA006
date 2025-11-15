<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    try {
        $stmt->execute([$username, $email, $password]);
        $_SESSION['success'] = "Đăng ký thành công, vui lòng đăng nhập!";
        header("Location: login.php");
        exit();
    } catch (PDOException $e) {
        $error = "Tên đăng nhập hoặc email đã tồn tại!";
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Đăng ký tài khoản</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<style>
    body {
        background: linear-gradient(135deg, #d4fc79, #96e6a1);
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        font-family: Arial, sans-serif;
    }
    .register-box {
        background: white;
        padding: 40px;
        border-radius: 16px;
        box-shadow: 0px 8px 20px rgba(0,0,0,0.15);
        width: 100%;
        max-width: 500px;
    }
    h2 {
        text-align: center;
        margin-bottom: 25px;
        font-weight: bold;
        color: #2c662d;
    }
    .form-control {
        padding: 12px;
        font-size: 1.1rem;
        border-radius: 10px;
    }
    .form-control:focus {
        border-color: #80c904;
        box-shadow: 0 0 6px rgba(128, 201, 4, 0.5);
    }
    .btn-primary {
        background-color: #28a745;
        border: none;
        padding: 12px;
        font-size: 1.1rem;
        border-radius: 10px;
    }
    .btn-primary:hover {
        background-color: #218838;
    }
</style>
</head>
<body>

<div class="register-box">
    <h2>Đăng ký</h2>
    <form method="POST">
        <input type="text" name="username" class="form-control mb-4" placeholder="Tên đăng nhập" required>
        <input type="email" name="email" class="form-control mb-4" placeholder="Email">
        <input type="password" name="password" class="form-control mb-4" placeholder="Mật khẩu" required>
        <button type="submit" class="btn btn-primary w-100">Đăng ký</button>
        <div class="mt-3 text-center">
            <a href="login.php" class="btn btn-link">Đã có tài khoản? Đăng nhập</a>
        </div>
    </form>
    <?php if (!empty($error)) echo "<div class='alert alert-danger mt-4 text-center'>$error</div>"; ?>
</div>

</body>
</html>
