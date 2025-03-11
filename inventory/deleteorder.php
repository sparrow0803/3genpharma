<?php
// Check if product ID is set and not empty
if(isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    // Include connection file
    include_once("connection/connection.php");
    $pdo = connection();
    
    // Sanitize the product ID
    
    // Prepare SQL statement to delete the item
    $sql = "DELETE FROM ordertb WHERE product_Id = :product_id";
    $stmt = $pdo->prepare($sql);
    
    // Bind the product ID parameter
    $stmt->bindParam(':product_id', $product_id);
    
    // Execute the statement
    if($stmt->execute()) {
        // Redirect back to the inventory page after successful deletion
        header("Location: order.php");
        exit();
    } else {
        // If deletion fails, display an error message
        echo "Error deleting item.";
    }
} else {
    // If product ID is not set or empty, redirect back to the inventory page
    header("Location: inventory.php");
    exit();
}
?>
