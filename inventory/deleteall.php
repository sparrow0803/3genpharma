<?php
include_once("connection/connection.php");
$pdo = connection();

try {
    // SQL query to delete all data from the table
    $sql = "DELETE FROM ordertb";
    
    // Prepare and execute the SQL query
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    
    // Return a success message
    echo "All data deleted successfully!";
} catch (PDOException $e) {
    // Handle any errors that occur during the deletion process
    echo "Error: " . $e->getMessage();
}

header("Location: inventory.php");
exit();
?>