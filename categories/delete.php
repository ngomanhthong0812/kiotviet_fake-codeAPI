<?php

try {
    require "../dbConnect.php";

    $id = $_POST['id'];

    // Kiểm tra xem có bất kỳ đơn hàng nào đang liên kết với sản phẩm này không
    $stmt_check = $conn->prepare('SELECT COUNT(*) FROM products WHERE categories_id = :id');
    $stmt_check->bindParam(':id', $id);
    $stmt_check->execute();
    $count = $stmt_check->fetchColumn();

    if ($count > 0) {
        // Nếu có liên kết, gửi thông báo lỗi tới client
        http_response_code(400);
    } else {
        $stmt = $conn->prepare('DELETE FROM CATEGORIES WHERE ID = :id');

        $stmt->bindParam(':id', $id);

        $stmt->execute();

        echo "Delete data successful";
    }
} catch (PDOException $pe) {
    die("Could not delete data from the database $dbname: " . $pe->getMessage());
}
