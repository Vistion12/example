p<?php


class Transport {
    public string $brand;
    public int $speed;
    public int $year;


    public function __construct(string $brand, int $speed, int $year) {
        $this->brand = $brand;
        $this->speed = $speed;
        $this->year = $year;
    }


    public function displayInfo(): void {
        echo "Марка: {$this->brand}, Скорость: {$this->speed} км/ч, Год выпуска: {$this->year}\n";
    }
}


class Car extends Transport {
    public int $doors;


    public function __construct(string $brand, int $speed, int $year, int $doors) {
        parent::__construct($brand, $speed, $year);
        $this->doors = $doors;
    }


    public function displayCarInfo(): void {
        $this->displayInfo();
        echo "Количество дверей: {$this->doors}\n";
    }
}


class Motorcycle extends Transport {
    public string $type;


    public function __construct(string $brand, int $speed, int $year, string $type) {
        parent::__construct($brand, $speed, $year);
        $this->type = $type;
    }

    public function displayMotorcycleInfo(): void {
        $this->displayInfo();
        echo "Тип мотоцикла: {$this->type}\n";
    }
}

$car = new Car("Toyota", 180, 2020, 4);
$motorcycle = new Motorcycle("Harley-Davidson", 120, 2019, "Спортивный");


$car->displayCarInfo();
$motorcycle->displayMotorcycleInfo();

echo "\n";

class Product {
    public $name;
    public $price;

    public function __construct($name, $price) {
        $this->name = $name;
        $this->price = $price;
    }
}

class Cart {
    private $products = [];

    public function addProduct(Product $product) {
        $this->products[] = $product;
    }

    public function getTotalPrice() {
        $total = 0;
        foreach ($this->products as $product) {
            $total += $product->price;
        }
        return $total;
    }

    public function getProducts() {
        return $this->products;
    }
}

// Создаем несколько товаров
$product1 = new Product("Ноут", 1000);
$product2 = new Product("Телефон", 500);
$product3 = new Product("Наушники", 100);


$cart = new Cart();

$cart->addProduct($product1);
$cart->addProduct($product2);
$cart->addProduct($product3);

echo "продукты в корзине: \n";
foreach ($cart->getProducts() as $product) {
    echo "Название: " . $product->name . ", Цена: " . $product->price . " биткоинов\n";
}

echo "Сумма: " . $cart->getTotalPrice() . " биткоинов\n";