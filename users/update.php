<?php

try {
    require "../dbConnect.php";

    $id = $_POST['id'];
    $name = $_POST['name'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Sử dụng câu lệnh SQL UPDATE chính xác
    $stmt = $conn->prepare('UPDATE USERS SET NAME = :name, PASSWORD = :password, ROLE = :role WHERE ID = :id');

    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':role', $role);

    $stmt->execute();

    echo "Update data successful";
} catch (PDOException $pe) {
    die("Could not update data to the database $dbname: " . $pe->getMessage());
}
