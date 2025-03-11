<?php
session_start(); // Start the session



        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            // Establish database connection
            $pdoConnect = new PDO("mysql:host=localhost;dbname=finance_dept","root","");
            $pdoConnect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       
           // Construct the UPDATE query
$pdoLedgerQuery = "UPDATE financial_request SET status = 'Declined' WHERE id = :id";

// Prepare the query
$pdoResult = $pdoConnect->prepare($pdoLedgerQuery);

// Bind parameters
$pdoResult->bindParam(':id', $id);

// Execute the query
$pdoResult->execute();

//---------------------------------Session End------------------------------------------//


// Set a session variable to indicate successful update
        $_SESSION['update_success'] = true;

        // Redirect to the same page to prevent form resubmission
        header("location: reports.php");
        exit();

} else {
    // Handle if 'id' parameter is not set
    echo "ID parameter is missing.";
    exit;
}
