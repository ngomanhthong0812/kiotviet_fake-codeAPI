<?php

function generateUniqueCode($conn) {
    $code = '';
    $isUnique = false;

    while (!$isUnique) {
        $code = 'SP0' . str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);

        $stmt = $conn->prepare('SELECT COUNT(*) FROM PRODUCTS WHERE product_code = :product_code');
        $stmt->bindParam(':product_code', $code);
        $stmt->execute();
        $count = $stmt->fetchColumn();

        if ($count == 0) {
            $isUnique = true;
        }
    }

    return $code;
}

try {
    require "../dbConnect.php";

    $name = $_POST['name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $categories_id = $_POST['categories_id'];

    // Generate unique product code
    $product_code = generateUniqueCode($conn);

    $stmt = $conn->prepare('INSERT INTO PRODUCTS (product_code, name, price, quantity, categories_id) VALUES (:product_code, :name, :price, :quantity, :categories_id)');

    $stmt->bindParam(':product_code', $product_code);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':quantity', $quantity);
    $stmt->bindParam(':categories_id', $categories_id);

    $stmt->execute();

    echo "Insert data successful. Product Code: " . $product_code;
} catch (PDOException $pe) {
    die("Could not insert data into the database: " . $pe->getMessage());
}
?>
