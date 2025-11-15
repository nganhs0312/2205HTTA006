<?php 
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Xóa công việc
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM tasks WHERE id = ? AND user_id = ?");
    $stmt->execute([$id, $user_id]);
    header("Location: dashboard.php");
    exit();
}

// Xử lý lọc và sắp xếp
$order_by = "due_date"; // mặc định sắp xếp theo hạn
$order_dir = "ASC"; // ASC: hạn sớm lên trên, DESC: hạn xa lên trên
$status_filter = ""; 

if (isset($_GET['sort'])) {
    if ($_GET['sort'] === 'title') $order_by = "title";
    if ($_GET['sort'] === 'due_date') $order_by = "due_date";
}

if (isset($_GET['dir']) && in_array(strtoupper($_GET['dir']), ['ASC','DESC'])) {
    $order_dir = strtoupper($_GET['dir']);
}

if (isset($_GET['status']) && in_array($_GET['status'], ['pending','in_progress','completed'])) {
    $status_filter = $_GET['status'];
}

// Lấy danh sách công việc
$sql = "SELECT * FROM tasks WHERE user_id = ?";
$params = [$user_id];

if ($status_filter) {
    $sql .= " AND status = ?";
    $params[] = $status_filter;
}

$sql .= " ORDER BY $order_by $order_dir";
$stmt = $conn->prepare($sql);
$stmt->execute($params);
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Danh sách công việc</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<style>
    body {
        background: #e9f7ef;
        font-family: Arial, sans-serif;
        padding-top: 40px;
        padding-bottom: 40px;
        display: flex;
        justify-content: center;
    }
    .dashboard-container {
        width: 100%;
        max-width: 950px;
        background: #fff;
        padding: 30px;
        border-radius: 16px;
        box-shadow: 0 6px 18px rgba(0,0,0,0.1);
    }
    table {
        border-radius: 12px;
        overflow: hidden;
    }
    th, td {
        vertical-align: middle !important;
        text-align: center;
    }
    .btn-sm {
        padding: 0.4rem 0.7rem;
        font-size: 0.9rem;
    }
    h3 {
        text-align: center;
        margin-bottom: 20px;
        color: #2c662d;
    }
    .top-buttons {
        text-align: center;
        margin-bottom: 20px;
    }
    .top-buttons a {
        margin: 0 5px;
    }
    .filter-sort {
        margin-bottom: 20px;
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 10px;
    }
</style>
</head>
<body>

<div class="dashboard-container">
    <h3>Xin chào, <?= $_SESSION['username'] ?> 👋</h3>

    <div class="top-buttons">
        <a href="logout.php" class="btn btn-danger btn-sm">Đăng xuất</a>
        <a href="add_task.php" class="btn btn-primary btn-sm">+ Thêm công việc</a>
    </div>

    <!-- Form lọc và sắp xếp -->
    <form method="GET" class="filter-sort">
        <div>
            <label>Sắp xếp theo:</label>
            <select name="sort" class="form-select form-select-sm d-inline-block" style="width:auto;">
                <option value="due_date" <?= $order_by=='due_date'?'selected':'' ?>>Hạn</option>
                <option value="title" <?= $order_by=='title'?'selected':'' ?>>Tiêu đề</option>
            </select>
            <select name="dir" class="form-select form-select-sm d-inline-block" style="width:auto;">
                <?php if ($order_by == 'title'): ?>
                    <option value="ASC" <?= $order_dir=='ASC'?'selected':'' ?>>A → Z</option>
                    <option value="DESC" <?= $order_dir=='DESC'?'selected':'' ?>>Z → A</option>
                <?php else: ?>
                    <option value="ASC" <?= $order_dir=='ASC'?'selected':'' ?>>Gần hết hạn → trên</option>
                    <option value="DESC" <?= $order_dir=='DESC'?'selected':'' ?>>Còn hạn dài → trên</option>
                <?php endif; ?>
            </select>
        </div>
        <div>
            <label>Lọc trạng thái:</label>
            <select name="status" class="form-select form-select-sm d-inline-block" style="width:auto;">
                <option value="" <?= !$status_filter?'selected':'' ?>>Tất cả</option>
                <option value="pending" <?= $status_filter=='pending'?'selected':'' ?>>Đang chờ</option>
                <option value="in_progress" <?= $status_filter=='in_progress'?'selected':'' ?>>Đang làm</option>
                <option value="completed" <?= $status_filter=='completed'?'selected':'' ?>>Hoàn thành</option>
            </select>
        </div>
        <div>
            <button type="submit" class="btn btn-info btn-sm">Áp dụng</button>
        </div>
    </form>

    <table class="table table-bordered table-striped">
        <thead class="table-success">
        <tr>
            <th>Tiêu đề</th>
            <th>Mô tả</th>
            <th>Hạn</th>
            <th>Trạng thái</th>
            <th>Hành động</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($tasks as $task): ?>
            <tr>
                <td><?= htmlspecialchars($task['title']) ?></td>
                <td><?= htmlspecialchars($task['description']) ?></td>
                <td><?= $task['due_date'] ?></td>
                <td><?= $task['status'] ?></td>
                <td>
                    <a href="edit_task.php?id=<?= $task['id'] ?>" class="btn btn-warning btn-sm">Sửa</a>
                    <a href="?delete=<?= $task['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Xóa công việc này?')">Xóa</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>
