<?php
$cookieName = 'visiting_count';
$expire = time() + 3600;

$count = isset($_COOKIE[$cookieName]) ? (int)$_COOKIE[$cookieName] + 1 : 1;

setcookie($cookieName, $count, [
    'expires' => $expire,
    'path' => '/',
    'secure' => isset($_SERVER['HTTPS']),
    'httponly' => true,
    'samesite' => 'Lax'
]);

echo $count === 1 ? "Lần đầu tiên truy cập<br>" : "Số lần truy cập: $count<br>";
?>
