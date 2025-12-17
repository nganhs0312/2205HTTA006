<?php
$x = 10;
$y = "10";

echo "x = 10, y = '10'<br><br>";

var_dump($x == $y);   // true
echo "<br>";
var_dump($x === $y);  // false
echo "<br>";
var_dump($x != $y);   // false
echo "<br>";
var_dump($x > 5);     // true
