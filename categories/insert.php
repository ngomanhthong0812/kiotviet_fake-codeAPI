<?php
try {
    require "../dbConnect.php";

    // Bắt đầu một giao dịch
    $conn->beginTransaction();

    // Lấy giá trị ID lớn nhất hiện tại
    $stmt = $conn->query('SELECT MAX(id) AS max_id FROM CATEGORIES');
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $max_id = $row['max_id'];

    // Tăng giá trị này lên một để tạo ID mới
    $new_id = $max_id + 1;

    $name = $_POST['name'];
    $shop_id = $_POST['shop_id'];

    // Chèn dữ liệu vào bảng CATEGORIES với ID mới
    $stmt = $conn->prepare('INSERT INTO CATEGORIES (id, name, shop_id) VALUES (:id, :name, :shop_id)');

    // Bind các tham số vào câu lệnh SQL
    $stmt->bindParam(':id', $new_id);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':shop_id', $shop_id);

    // Thực thi câu lệnh
    $stmt->execute();

    // Commit giao dịch
    $conn->commit();

    echo "Insert data successful";
} catch (PDOException $pe) {
    // Rollback giao dịch nếu có lỗi
    $conn->rollBack();
    die("Could not insert data to the database: " . $pe->getMessage());
}
