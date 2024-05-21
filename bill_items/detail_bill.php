<?php
require "../dbConnect.php";

class Bill
{
    public $bill_item_id;
    public $quantity;
    public $total_price;
    public $product_id;
    public $bill_id;
    public $product_name;

    public function __construct($bill_item_id, $quantity, $total_price, $product_id, $bill_id, $product_name)
    {
        $this->bill_item_id = $bill_item_id;
        $this->quantity = $quantity;
        $this->total_price = $total_price;
        $this->product_id = $product_id;
        $this->bill_id = $bill_id;
        $this->product_name = $product_name;
    }
}

try {
    $bill_id_post = $_POST['bill_id_post'];

    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $stmt = $conn->prepare('SELECT bill_items.id AS bill_item_id, bill_items.quantity, bill_items.total_price, bill_items.product_id, bill_items.bill_id, bill_items.product_name
    FROM bill_items, bills WHERE bill_items.bill_id = bills.id AND bill_items.bill_id = :bill_id_post;');

    $stmt->bindParam(':bill_id_post', $bill_id_post);

    $stmt->execute();
    $bills = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $bill_item_id = $row['bill_item_id'];
        $quantity = $row['quantity'];
        $total_price = $row['total_price'];
        $product_id = $row['product_id'];
        $bill_id = $row['bill_id'];
        $product_name = $row['product_name'];
        array_push($bills, new Bill($bill_item_id, $quantity, $total_price, $product_id, $bill_id, $product_name));
    }

    echo json_encode($bills);
} catch (PDOException $pe) {
    die("Could not connect to the database $dbname: " . $pe->getMessage());
}
