<?php
// Include database connection
include_once("connection/connection.php");
$pdo = connection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input data
    $itemCategory = htmlspecialchars($_POST['itemCategory']);
    $itemName = htmlspecialchars($_POST['itemName']);
    $itemDescription = htmlspecialchars($_POST['itemDescription']);
    $itemQuantity = intval($_POST['itemQuantity']);

    // Check if the item already exists in the database
    $stmt = $pdo->prepare("SELECT * FROM ordertb WHERE category=:itemCategory AND description=:itemDescription AND product_name = :itemName");
    $stmt->bindParam(':itemCategory', $itemCategory);
    $stmt->bindParam(':itemName', $itemName);
    $stmt->bindParam(':itemDescription', $itemDescription);
    $stmt->execute();

    // If item exists, update its quantity; otherwise, insert a new item
    if ($stmt->rowCount() > 0) {
        $sql_update = "UPDATE ordertb SET quantity = quantity + :itemQuantity WHERE product_name = :itemName";
        $stmt = $pdo->prepare($sql_update);
        $stmt->bindParam(':itemQuantity', $itemQuantity);
        $stmt->bindParam(':itemName', $itemName);
        $stmt->execute();
    } else {
        $sql_insert = "INSERT INTO ordertb (category, product_name, description, quantity) VALUES (:itemCategory, :itemName, :itemDescription, :itemQuantity)";
        $stmt = $pdo->prepare($sql_insert);
        $stmt->bindParam(':itemCategory', $itemCategory);
        $stmt->bindParam(':itemName', $itemName);
        $stmt->bindParam(':itemDescription', $itemDescription);
        $stmt->bindParam(':itemQuantity', $itemQuantity);
        $stmt->execute();
    }
}

// Redirect back to the page after adding item
header("Location: order.php");
exit();
?>
