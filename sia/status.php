<?php
include_once("connections/connection.php");
$pdo = connection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id'])) {
        $id = $_POST['id'];

        // Fetch the current status
        $stmt = $pdo->prepare("SELECT status FROM medicine WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $currentStatus = $stmt->fetchColumn();

        // Increment and update the status ONLY if not already 'Stored' or beyond
        if ($currentStatus < 4) {  
            $newStatus = $currentStatus + 1;
            $updateStmt = $pdo->prepare("UPDATE medicine SET status = :status WHERE id = :id");
            $updateStmt->bindParam(':id', $id);
            $updateStmt->bindParam(':status', $newStatus);
            
            try {
                $updateStmt->execute();
            } catch (PDOException $e) {
                // Handle the error 
                echo "Error: " . $e->getMessage();
            }
        } 

        // Redirect regardless of whether status was updated
        header("Location: logistics.php"); 
        exit();
    } else {
        echo "Item ID not provided.";
    }
} else {
    // Handle other request methods (e.g., GET)
}
?>
