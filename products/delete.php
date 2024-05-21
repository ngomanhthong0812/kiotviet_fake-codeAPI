<?php
try {
    require "../dbConnect.php";

    $id = $_POST['id'];

    // Kiểm tra xem có bất kỳ đơn hàng nào đang liên kết với sản phẩm này không
    $stmt_check = $conn->prepare('SELECT COUNT(*) FROM order_items WHERE product_id = :id');
    $stmt_check->bindParam(':id', $id);
    $stmt_check->execute();
    $count = $stmt_check->fetchColumn();

    if ($count > 0) {
        // Nếu có liên kết, gửi thông báo lỗi tới client
        http_response_code(400);
        echo "Cannot delete data due to existing orders associated with this product.";
    } else {
        // Nếu không có liên kết, thực hiện xoá dữ liệu
        $stmt = $conn->prepare('DELETE FROM PRODUCTS WHERE ID = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        echo "Delete data successful";
    }
} catch (PDOException $pe) {
    // Xử lý lỗi kết nối CSDL
    http_response_code(500);
    die("Could not delete data from the database: " . $pe->getMessage());
}
?>
