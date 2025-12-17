<?php 
//session có giá trị từ lúc bắt đầu đến khi đóng trình duyệt
//Để start session dùng: session_start();
//Để đặt giá trị cho sesstion: $_SESSION['TEN BIẾN'] = 'VALUE'

session_start();
?>

<!DOCTYPE html>
<html lang='vi'>
	<head>
		<title>Test GET Session </title>
	</head>
	<body>
		<?php
			if (isset($_SESSION['subject']))
				echo "subject: " . $_SESSION['subject'] . "<br>";
			if (isset($_SESSION['grade']))
				echo "Grade: " . $_SESSION['grade'] . "<br>";
		?>
		
	</body>
</html>
