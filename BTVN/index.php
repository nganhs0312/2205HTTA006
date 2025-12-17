<?php
	require_once('validatelogin.php');

// supper global variable
/*
 $GLOBALS
 $_SERVER
 $_POST
 $_GET
 $_EVN
 $_COOKIE
 $_SESSION
 ......
 */
 
 
echo "<h2> Xin chào " .  htmlspecialchars($_SESSION['logged']) . "</h2>";
echo "Server " . $_SERVER['PHP_SELF'] . "<br>";
echo "Servername " . $_SERVER['SERVER_NAME'] . "<br>";
echo "ServerHOST " . $_SERVER['HTTP_HOST'] . "<br>";
echo "Server Script " . $_SERVER['SCRIPT_NAME'] . "<br>";


echo htmlspecialchars('<h2>This text is in h2 heading format & a <= b </h2>');
	
?>