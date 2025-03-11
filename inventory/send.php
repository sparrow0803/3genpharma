<?php
include_once("connection/connection.php");
$pdo = connection();


$stmt = $pdo->query("SELECT * FROM ordertb");
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Loop through each item and insert into the destination database
foreach ($items as $item) {
    $stmt = $pdo->prepare("INSERT INTO ordered_items (category, product_name, description, quantity) VALUES (:category, :product_name, :description, :quantity)");
    $stmt->execute([
        ':category' => $item['category'],
        ':product_name' => $item['product_name'],
        ':description' => $item['description'],
        ':quantity' => $item['quantity']
    ]);
}

// Redirect back to the page after data transfer
header("Location: deleteall.php");
exit();
?>