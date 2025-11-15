<?php
session_start();
require 'db.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];
$uid = $_SESSION['user_id'];

// Lấy dữ liệu
$stmt = $conn->prepare("SELECT * FROM tasks WHERE id=? AND user_id=?");
$stmt->execute([$id, $uid]);
$task = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$task) {
    die("Không tìm thấy công việc!");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $desc = $_POST['description'];
    $due = $_POST['due_date'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE tasks SET title=?, description=?, due_date=?, status=? WHERE id=? AND user_id=?");
    $stmt->execute([$title, $desc, $due, $status, $id, $uid]);
    header("Location: dashboard.php");
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Sửa công việc</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<style>
    body {
        background: linear-gradient(135deg, #a1c4fd, #c2e9fb); /* Xanh dương nhạt */
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
        color: #0d3b66;
        font-weight: bold;
    }
    .form-control {
        padding: 12px;
        font-size: 1.1rem;
        border-radius: 10px;
    }
    .form-control:focus {
        border-color: #1e90ff;
        box-shadow: 0 0 6px rgba(30,144,255,0.5);
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
    <h3>Sửa công việc</h3>
    <form method="POST">
        <input name="title" value="<?= htmlspecialchars($task['title']) ?>" class="form-control mb-3" placeholder="Tiêu đề">
        <textarea name="description" class="form-control mb-3" placeholder="Mô tả"><?= htmlspecialchars($task['description']) ?></textarea>
        <input type="date" name="due_date" value="<?= $task['due_date'] ?>" class="form-control mb-3">
        <select name="status" class="form-control mb-3">
            <option value="pending" <?= $task['status']=='pending'?'selected':'' ?>>Đang chờ</option>
            <option value="in_progress" <?= $task['status']=='in_progress'?'selected':'' ?>>Đang làm</option>
            <option value="completed" <?= $task['status']=='completed'?'selected':'' ?>>Hoàn thành</option>
        </select>
        <div class="btn-group">
            <button class="btn btn-success" type="submit">Cập nhật</button>
            <a href="dashboard.php" class="btn btn-secondary">Quay lại</a>
        </div>
    </form>
</div>

</body>
</html>
