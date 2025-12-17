<!DOCTYPE html>
<html lang="vi">
<head>	
	<meta charset="UTF-8">
	<link href="css/my.css" rel="stylesheet">	
</head>
<body>

<?php
// Lập trình hướng đối tượng

class Car {
	// Access Modifier
	private $name;       // Chỉ dùng trong class
	protected $price;   // Dùng trong class & class kế thừa
	public $branch;     // Dùng mọi nơi
	
	// Setter / Getter
	public function setName($name){
		$this->name = $name;
	}

	public function getName(){
		return $this->name;
	}

	public function setPrice($price){
		$this->price = $price;
	}

	public function getPrice(){
		return $this->price;
	}
}

// =======================
// Sử dụng class
// =======================

$car = new Car();

// Gán giá trị (đúng)
$car->setName("Honda City");
$car->setPrice(15000);
$car->branch = "Honda";

// Hiển thị (đúng)
echo "Name: " . $car->getName() . "<br>";
echo "Price: " . $car->getPrice() . "<br>";
echo "Branch: " . $car->branch . "<br>";

?>

</body>
</html>
