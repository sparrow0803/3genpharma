<?php
session_start(); // Start the session



        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            // Establish database connection
            $pdoConnect = new PDO("mysql:host=localhost;dbname=finance_dept","root","");
            $pdoConnect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $pdoLedgerQuery = "SELECT * FROM financial_request WHERE id = :id";
            $pdoResult = $pdoConnect->prepare($pdoLedgerQuery);
            $pdoResult->bindParam(':id', $id);
            $pdoResult->execute();

           // Fetch data for a specific 'id'
           $row = $pdoResult->fetch(PDO::FETCH_ASSOC);
           if ($row) {
               $desc = $row['description'];
               $amount = $row['amount'];
           } else {
               // Handle if no data found for the given 'id'
               echo "No data found for the given ID.";
               exit;
           }
       
           // Construct the UPDATE query
$pdoLedgerQuery = "UPDATE financial_request SET status = 'Approved' WHERE id = :id";

// Prepare the query
$pdoResult = $pdoConnect->prepare($pdoLedgerQuery);

// Bind parameters
$pdoResult->bindParam(':id', $id);

// Execute the query
$pdoResult->execute();

        
        
        

        // Extract data from the form
        $exp_amount = -$amount;
        $acc = 'Current Liabilities';
        $sub = 'Expenditure Liabilities';
        $sub2 = 'Cash';
        $type ='Expenditure';
        $information = $desc;
        $flow = 'Decrease';
        $debit = '0';
        $credit = $amount;
        
    // Prepare and execute the query to update the account // Added to get the flow value

//---------------------------------Balance Sheet------------------------------------------//

        // Prepare and execute the query to update the account
        $updateQuery1 = "UPDATE balance_sheet SET Amount = Amount + :amount WHERE sub_account = :sub";
        $stmt = $pdoConnect->prepare($updateQuery1);
        $stmt->bindParam(':amount', $exp_amount);
        $stmt->bindParam(':sub', $sub);
        $stmt->execute();

        // Prepare and execute the query to update the account

        $updateQuery2 = "UPDATE balance_sheet SET Amount = Amount - :amount WHERE sub_account = :sub";
        $stmt = $pdoConnect->prepare($updateQuery2);
        $stmt->bindParam(':amount', $amount);
        $stmt->bindParam(':sub', $sub2);
        $stmt->execute();
        
//---------------------------------------------------------------------------//

   
        $selectQuery = "SELECT balance FROM general_ledger ORDER BY CONCAT(date, ' ', time) DESC LIMIT 1";
        $stmt = $pdoConnect->prepare($selectQuery);
        $stmt->execute();
        $latestBalance = $stmt->fetchColumn();

     
        if ($latestBalance !== false) {
            // Successfully fetched the latest balance
            $lastBalance = $latestBalance;
        } else {
            // No balance found, set default value
            $lastBalance = '0';
        }

        $balance = $lastBalance - $amount;

        date_default_timezone_set('Asia/Manila');
        $date = date('Y-m-d');
        $time = date('H:i:s');

//---------------------------------General Ledger------------------------------------------//

        $insertQuery1 = "INSERT INTO general_ledger (`date`, `time`, `account`, `description`, `debit`, `credit`, `balance`) VALUES (:date, :time, :account, :description, :debit, :credit, :balance)";
        $insert1 = $pdoConnect->prepare($insertQuery1);
        $insert1->bindParam(':date', $date, PDO::PARAM_STR);
        $insert1->bindParam(':time', $time, PDO::PARAM_STR);
        $insert1->bindParam(':account', $sub);
        $insert1->bindParam(':description', $desc);
        $insert1->bindParam(':debit', $debit);
        $insert1->bindParam(':credit', $credit);
        $insert1->bindParam(':balance', $balance);
        $insert1->execute();

//---------------------------------Audit Trail------------------------------------------//

        $insertQuery2 = "INSERT INTO audit_trail (`date`, `time`, `transaction_type`, `account`, `description`, `amount`, `flow`) VALUES (:date, :time, :transaction_type, :account, :description, :amount, :flow)";
        $insert2 = $pdoConnect->prepare($insertQuery2);
        $insert2->bindParam(':date', $date, PDO::PARAM_STR);
        $insert2->bindParam(':time', $time, PDO::PARAM_STR);
        $insert2->bindParam(':transaction_type', $type);
        $insert2->bindParam(':account', $sub);
        $insert2->bindParam(':description', $information);
        $insert2->bindParam(':amount', $amount);
        $insert2->bindParam(':flow', $flow);
        $insert2->execute();

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
