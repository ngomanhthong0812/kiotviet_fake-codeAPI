<?php

try {
    require "../dbConnect.php";

    $id = $_POST['id'];
    $newUserId = $_POST['newUserId'];

    // Bắt đầu giao dịch
    $conn->beginTransaction();

    // Cập nhật bảng BILLS để thay đổi user_id thành $newUserId nếu khớp với $id
    $stmtUpdateBills = $conn->prepare('UPDATE bills SET user_id = :newUserId WHERE user_id = :id');
    $stmtUpdateBills->bindParam(':newUserId', $newUserId);
    $stmtUpdateBills->bindParam(':id', $id);
    $stmtUpdateBills->execute();

    // Cập nhật bảng ORDERS để thay đổi user_id thành $newUserId nếu khớp với $id
    $stmtUpdateOrders = $conn->prepare('UPDATE orders SET user_id = :newUserId WHERE user_id = :id');
    $stmtUpdateOrders->bindParam(':newUserId', $newUserId);
    $stmtUpdateOrders->bindParam(':id', $id);
    $stmtUpdateOrders->execute();

    // Xóa người dùng khỏi bảng USERS
    $stmtDeleteUser = $conn->prepare('DELETE FROM users WHERE id = :id');
    $stmtDeleteUser->bindParam(':id', $id);
    $stmtDeleteUser->execute();

    // Cam kết giao dịch
    $conn->commit();

    echo "Delete data successful";
} catch (PDOException $pe) {
    // Rollback giao dịch nếu có lỗi
    $conn->rollBack();
    die("Could not delete data from the database $dbname: " . $pe->getMessage());
}
