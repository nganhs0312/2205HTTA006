<?php 
//session có giá trị từ lúc bắt đầu đến khi đóng trình duyệt
//Để start session dùng: session_start();
//Để đặt giá trị cho sesstion: $_SESSION['TEN BIẾN'] = 'VALUE'

session_start();
?>

<!DOCTYPE html>
<html lang='vi'>
	<head>
		<title>Test Session </title>
	</head>
	<body>
		<?php
			$_SESSION['subject'] = 'Ngôn ngữ lập trình PHP';
			$_SESSION['grade'] = 10;
			echo "Session variable are set. <br>";
		?>
		
	</body>
</html>