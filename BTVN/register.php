<?php
$pdo = new PDO("mysql:host=localhost;dbname=test;charset=utf8", "root", "");

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare(
        "INSERT INTO users (username, password) VALUES (?, ?)"
    );
    $stmt->execute([$username, $password]);

    echo "Đăng ký thành công";
}
?>

<form method="post">
    <input name="username" placeholder="Username" required>
    <input name="password" type="password" required>
    <button name="register">Đăng ký</button>
</form>
