<?php
require "../dbConnect.php";

try {
    $shop_id_account = $_POST['shop_id'];

    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $stmt = $conn->prepare('SELECT PRODUCTS.id, PRODUCTS.name AS product_name, 
    PRODUCTS.price, PRODUCTS.quantity, PRODUCTS.categories_id, CATEGORIES.name AS categories_name,
    PRODUCTS.product_code FROM PRODUCTS INNER JOIN CATEGORIES ON PRODUCTS.categories_id = CATEGORIES.id
    WHERE CATEGORIES.shop_id = :shop_id_account;');

    $stmt->bindParam(':shop_id_account', $shop_id_account);
    $stmt->execute();
    $mang = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $id = $row['id'];
        $product_name = $row['product_name'];
        $price = $row['price'];
        $quantity = $row['quantity'];
        $categories_id = $row['categories_id'];
        $categories_name = $row['categories_name'];
        $product_code = $row['product_code'];
        array_push($mang, new Products($id, $product_name, $price, $quantity, $categories_id, $categories_name, $product_code));
    }

    echo json_encode($mang);
} catch (PDOException $pe) {
    die("Could not connect to the database $dbname :" . $pe->getMessage());
}

class Products
{
    public $id;
    public $product_name;
    public $price;
    public $quantity;
    public $categories_id;
    public $categories_name;
    public $product_code;

    public function __construct($id, $product_name, $price, $quantity, $categories_id, $categories_name, $product_code)
    {
        $this->id = $id;
        $this->product_name = $product_name;
        $this->price = $price;
        $this->quantity = $quantity;
        $this->categories_id = $categories_id;
        $this->categories_name = $categories_name;
        $this->product_code = $product_code;
    }
}
