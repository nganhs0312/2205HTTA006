<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <link href="css/my.css" rel="stylesheet">
    <title>Car OOP</title>
</head>
<body>

<?php

class Car
{
    private string $name;
    private float $price;

    public function __construct(string $name, float $price)
    {
        $this->name  = $name;
        $this->price = $price;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function display(): void
    {
        echo "<h2>
                Car name: {$this->name}<br>
                Price: {$this->price} $
              </h2>";
    }

    public function renderRow(): string
    {
        return "
            <tr>
                <td>{$this->name}</td>
                <td>{$this->price}</td>
            </tr>
        ";
    }
}

// =======================
// Khởi tạo object
// =======================

$car = new Car("Toyota", 15000);
$car->display();

// =======================
// Mảng object
// =======================

$cars = [
    new Car("Toyota", 20000),
    new Car("Volvo", 15000),
    new Car("Mitsubishi", 30000),
];

?>

<table border="1" cellpadding="10" cellspacing="0">
    <tr>
        <th>Name</th>
        <th>Price ($)</th>
    </tr>

    <?php
        foreach ($cars as $car) {
            echo $car->renderRow();
        }
    ?>
</table>

<div class="box">
    <span>test div</span>
</div>

</body>
</html>
