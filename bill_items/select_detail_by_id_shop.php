<?php
require "../dbConnect.php";

try {
    $shop_id_account = $_POST['shop_id'];

    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $stmt = $conn->prepare('SELECT SUM(`bill_items`.`quantity`) as quantity, SUM(`bill_items`.`total_price`) as total_price, `products`.`name`, DATE(`bills`.`dateTime_end`) as `date`
    FROM `bill_items` 
    JOIN `products` ON `bill_items`.`product_id` = `products`.`id`
    JOIN `bills` ON `bill_items`.`bill_id` = `bills`.`id`
    JOIN `users` ON `bills`.`user_id` = `users`.`id`
    WHERE `users`.`shop_id` = :shop_id_account
    GROUP BY `name`,`date`
    ORDER BY `date` ASC;');

    $stmt->bindParam(':shop_id_account', $shop_id_account);

    $stmt->execute();
    $billArray = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $quantity = $row['quantity'];
        $total_price = $row['total_price'];
        $name = $row['name'];
        $dateTime_end = $row['date'];
        array_push($billArray, new Bill_ITEMS($quantity, $total_price, $name, $dateTime_end));
    }

    echo json_encode($billArray);
} catch (PDOException $pe) {
    die("Could not connect to the database $dbname :" . $pe->getMessage());
}

class Bill_ITEMS
{
    public $quantity;
    public $total_price;
    public $name;
    public $dateTime_end;

    public function __construct($quantity, $total_price, $name, $dateTime_end)
    {
        $this->quantity = $quantity;
        $this->total_price = $total_price;
        $this->name = $name;
        $this->dateTime_end = $dateTime_end;
    }
}
