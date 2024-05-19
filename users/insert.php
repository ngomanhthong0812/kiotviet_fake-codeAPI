<?php

try {
    require "../dbConnect.php";

    // Các biến đăng ký cố định
    $shop_name = $_POST['name_shop'];
    $user_name = $_POST['name_user'];
    $password = $_POST['password'];
    $role = "admin";

    // Thêm cửa hàng mới với ID của người dùng
    $stmtShop = $conn->prepare("INSERT INTO shops (name) VALUES (:name)");
    $stmtShop->bindParam(':name', $shop_name);
    $stmtShop->execute();

    // Lấy ID của shop vừa thêm vào cơ sở dữ liệu
    $shop_id = $conn->lastInsertId();

    // Thêm người dùng mới
    $stmtUser = $conn->prepare("INSERT INTO users (name, password, role,shop_id) VALUES (:name, :password, :role,:shop_id)");
    $stmtUser->bindParam(':name', $user_name);
    $stmtUser->bindParam(':password', $password);
    $stmtUser->bindParam(':role', $role);
    $stmtUser->bindParam(':shop_id', $shop_id);
    $stmtUser->execute();

    // Lấy ID của người dùng vừa thêm vào cơ sở dữ liệu
    $user_id = $conn->lastInsertId();


    // Tạo 1 bàn cho người dùng mới
    $table_name = "Mang về ";
    $stmtTable = $conn->prepare("INSERT INTO tables (table_name, status, user_id, table_price,shop_id) VALUES (:table_name, 0, :user_id, 0,:shop_id)");
    $stmtTable->bindParam(':table_name', $table_name);
    $stmtTable->bindParam(':user_id', $user_id);
    $stmtTable->bindParam(':shop_id', $shop_id);
    $stmtTable->execute();


    echo "Insert data successful";
} catch (PDOException $pe) {
    die("Could not insert data to the database: " . $pe->getMessage());
}
