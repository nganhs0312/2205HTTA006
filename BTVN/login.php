<?php
	session_start(); 
	$message = '';
	
	if($_SERVER['REQUEST_METHOD'] === "POST")
	{	
		$username = "admin";
		$password = "password";
		
		//Check tính hợp lệ bằng cách viết code để so sánh thông tin lấy được với csdl
		// Nếu hợp lệ -> redirect sang trang index
		if (isset ($_POST['username']) && $_POST['username'] === $username && isset ($_POST['password']) && $_POST['password'] === $password)
		{		
			$_SESSION['logged'] = $username;
			header("location: index.php");
			exit;
		}
		else
		{
			//header("location: login.php");
			$message = "Sai tên truy cập hoặc mật khẩu";		
		}
			
	}
?>

<!DOCTYPE html>
<html lang="en">

	<head>
	
		<style> </style>	
	</head>
	<body>
		<?php 	if ($message) : ?>		
			<p style="color: red"><?=$message; ?></p>
		<?php 	endif; ?>		
		<h4> Login form </h2>
		<form method = "POST" action = "login.php">
			<label for="username"> Username </label>
			<input type="text" name="username" id = "username" required /> <br>
			<label for="password">Password </label>
			<input type="password" name="password" id = "password" required /> <br>
			<button type="submit" name = "login"> Login </button>
		</form>
	
	<script >
	</body>
</html>