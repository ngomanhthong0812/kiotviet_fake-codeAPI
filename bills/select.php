<?php
require "../dbConnect.php";

try {
    $shop_id_account = $_POST['shop_id'];

    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $stmt = $conn->prepare('SELECT BILLS.* FROM BILLS JOIN USERS ON BILLS.user_id = USERS.id WHERE USERS.shop_id = :shop_id_account;');

    $stmt->bindParam(':shop_id_account', $shop_id_account);
    $stmt->execute();
    $billArray = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $dateTime = $row['dateTime'];
        $dateTimeEnd = $row['dateTime_end'];
        $code = $row['code'];
        $tableId = $row['table_id'];
        $userId = $row['user_id'];
        $total_price = $row['total_price'];
        array_push($billArray, new Bill($dateTime, $dateTimeEnd, $code, $tableId, $userId, $total_price));
    }

    echo json_encode($billArray);
} catch (PDOException $pe) {
    die("Could not connect to the database $dbname :" . $pe->getMessage());
}

class Bill
{
    public $dateTime;
    public $dateTimeEnd;
    public $code;
    public $tableId;
    public $userId;
    public $total_price;

    public function __construct($dateTime, $dateTimeEnd, $code, $tableId, $userId, $total_price)
    {
        $this->dateTime = $dateTime;
        $this->dateTimeEnd = $dateTimeEnd;
        $this->code = $code;
        $this->tableId = $tableId;
        $this->userId = $userId;
        $this->total_price = $total_price;
    }
}
