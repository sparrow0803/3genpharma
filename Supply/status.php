<?php

include_once("connections/connection.php");
$pdo = connection();

if(isset($_POST['item_id'])) {
    $id = htmlspecialchars($_POST['item_id']); // Sanitize the input
    // Fetch the current status value from the database
    $stmt = $pdo->prepare("SELECT status FROM sia_order WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $currentStatus = $stmt->fetchColumn();

    echo "Current Status: " . $currentStatus . "<br>"; // Debugging

    // Increment the status value by 1
    $newStatus = $currentStatus + 1;

    echo "New Status: " . $newStatus . "<br>"; // Debugging

    // Update the database with the new incremented value
    $stmt = $pdo->prepare("UPDATE sia_order SET status = :status WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':status', $newStatus);

    try {
        $stmt->execute();
        $rowCount = $stmt->rowCount();
        if ($rowCount > 0) {
            echo "Status updated successfully";
            header("Location: /3GENPHARMA/Supply/index.php");
            exit; // Ensure that no more output is sent after the header redirect
        } else {
            echo "No rows updated"; // Indicates that no rows matched the given ID
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Item ID not provided.";
}
?>
