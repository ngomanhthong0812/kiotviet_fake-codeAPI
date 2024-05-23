<?php
try {
    require "../dbConnect.php";

    $name = $_POST['name'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $shop_id = $_POST['shop_id'];

    $stmt = $conn->prepare('INSERT INTO USERS (name, password, role, shop_id) VALUES (:name, :password, :role, :shop_id)');

    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':role', $role);
    $stmt->bindParam(':shop_id', $shop_id);

    $stmt->execute();

    echo "Insert data successful. Product Code: " . $product_code;
} catch (PDOException $pe) {
    die("Could not insert data into the database: " . $pe->getMessage());
}
?>
