<?php
include_once("connections/connection.php");
$pdo = connection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve item ID and status from the form
    $item_id = $_POST['item_id'];
    $status = $_POST['status'];

    try {
        // Update the status of the medicine
        $stmt = $pdo->prepare("UPDATE genpharma.medicine SET status = :status WHERE id = :item_id");
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        $stmt->bindParam(':item_id', $item_id, PDO::PARAM_INT);
        $stmt->execute();

        // Redirect back to the page where the update was made
        header("Location: logistics.php");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    // If the request method is not POST, redirect to the homepage
    header("Location: index.php");
    exit();
}
?>
