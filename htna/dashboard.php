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
$order_by = "due_date";
$order_dir = "ASC";
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
        background: linear-gradient(135deg, #a8edea, #fed6e3);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 25px;
        font-family: 'Segoe UI', sans-serif;
    }
    .dashboard-container {
        width: 100%;
        max-width: 1100px;
        background: rgba(255, 255, 255, 0.95);
        padding: 30px;
        border-radius: 16px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }
    table {
        border-spacing: 0;
        width: 100%;
        border-radius: 15px;
        overflow: hidden;
        background-color: #fff;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    th {
        background: #3993DD;
        color: #fff;
        font-size: 16px;
    }
    th, td {
        padding: 14px;
        text-align: center;
    }
    tr:nth-child(even) {
        background-color: #e9f7fe;
    }
    tr:hover {
        background-color: #d4eefc;
        transition: 0.2s;
    }
    .badge-status {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
    }
    .pending { background: #fff3cd; color: #856404; }
    .in_progress { background: #d1ecf1; color: #0c5460; }
    .completed { background: #d4edda; color: #155724; }
</style>
</head>
<body>

<div class="dashboard-container">
    <h2 class="text-center mb-4 text-primary">Xin chào, <?= $_SESSION['username'] ?> 👋</h2>

    <div class="d-flex justify-content-between mb-3">
        <a href="logout.php" class="btn btn-outline-danger">Đăng xuất</a>
        <a href="add_task.php" class="btn btn-primary">+ Thêm công việc</a>
    </div>

    <form method="GET" class="d-flex mb-4 gap-3">
        <select name="sort" class="form-select">
            <option value="due_date" <?= $order_by == 'due_date' ? 'selected' : '' ?>>Sắp xếp theo hạn</option>
            <option value="title" <?= $order_by == 'title' ? 'selected' : '' ?>>Sắp xếp theo tiêu đề</option>
        </select>
        <select name="dir" class="form-select">
            <option value="ASC" <?= $order_dir == 'ASC' ? 'selected' : '' ?>>Tăng dần</option>
            <option value="DESC" <?= $order_dir == 'DESC' ? 'selected' : '' ?>>Giảm dần</option>
        </select>
        <select name="status" class="form-select">
            <option value="" <?= $status_filter == '' ? 'selected' : '' ?>>Tất cả trạng thái</option>
            <option value="pending" <?= $status_filter == 'pending' ? 'selected' : '' ?>>Đang chờ</option>
            <option value="in_progress" <?= $status_filter == 'in_progress' ? 'selected' : '' ?>>Đang làm</option>
            <option value="completed" <?= $status_filter == 'completed' ? 'selected' : '' ?>>Hoàn thành</option>
        </select>
        <button class="btn btn-info">Lọc</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>Tiêu đề</th>
                <th>Mô tả</th>
                <th>Hạn</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($tasks) == 0): ?>
                <tr>
                    <td colspan="5" class="text-center text-muted">Chưa có công việc nào.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($tasks as $task): ?>
                    <tr>
                        <td><?= htmlspecialchars($task['title']) ?></td>
                        <td><?= htmlspecialchars($task['description']) ?></td>
                        <td><?= $task['due_date'] ?></td>
                        <td><span class="badge-status <?= $task['status'] ?>"><?= $task['status'] == 'pending' ? 'Đang chờ' : ($task['status'] == 'in_progress' ? 'Đang làm' : 'Hoàn thành') ?></span></td>
                        <td>
                            <a href="edit_task.php?id=<?= $task['id'] ?>" class="btn btn-sm btn-outline-primary">Sửa</a>
                            <a href="?delete=<?= $task['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Xóa công việc này?')">Xóa</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>
