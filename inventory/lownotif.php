<?php
include_once("connection/connection.php");
$pdo = connection();

try {

    // Fetch low stock products
    $stmt = $pdo->prepare("SELECT * FROM inventory WHERE quantity < 50");
    $stmt->execute();
    $lowStockProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return data as JSON
    header('Content-Type: application/json');
    echo json_encode(['lowStock' => $lowStockProducts]);

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>

