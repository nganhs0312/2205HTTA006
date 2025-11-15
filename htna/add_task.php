<?php
session_start();
require 'db.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $desc = $_POST['description'];
    $due = $_POST['due_date'];
    $uid = $_SESSION['user_id'];

    $stmt = $conn->prepare("INSERT INTO tasks (user_id, title, description, due_date) VALUES (?, ?, ?, ?)");
    $stmt->execute([$uid, $title, $desc, $due]);
    header("Location: dashboard.php");
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Thêm công việc</title>
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
    .task-box {
        background: white;
        padding: 40px;
        border-radius: 16px;
        box-shadow: 0px 6px 18px rgba(0,0,0,0.1);
        width: 100%;
        max-width: 500px;
    }
    h3 {
        text-align: center;
        margin-bottom: 25px;
        color: #2c662d;
        font-weight: bold;
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
    .btn-success {
        padding: 12px;
        font-size: 1.1rem;
        border-radius: 10px;
        width: 48%;
    }
    .btn-secondary {
        padding: 12px;
        font-size: 1.1rem;
        border-radius: 10px;
        width: 48%;
        margin-left: 4%;
    }
    .btn-group {
        display: flex;
        justify-content: space-between;
        margin-top: 15px;
    }
</style>
</head>
<body>

<div class="task-box">
    <h3>Thêm công việc mới</h3>
    <form method="POST">
        <input name="title" class="form-control mb-3" placeholder="Tiêu đề" required>
        <textarea name="description" class="form-control mb-3" placeholder="Mô tả"></textarea>
        <input type="date" name="due_date" class="form-control mb-3">
        <div class="btn-group">
            <button class="btn btn-success" type="submit">Lưu</button>
            <a href="dashboard.php" class="btn btn-secondary">Quay lại</a>
        </div>
    </form>
</div>

</body>
</html>
