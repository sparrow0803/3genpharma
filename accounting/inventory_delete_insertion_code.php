<?php
        $pdoConnect = new PDO("mysql:host=localhost;dbname=finance_dept","root","");
        $pdoConnect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $current_year = date("Y");

        $itemPrice  = '???'; //Populate this variable
        $itemQuantity = '???'; //Populate this variable

        $sub = 'Inventory';
        $amount = $itemPrice * $itemQuantity;
        $sub2 = 'Cash';
        $desc = 'Inventory Sold';
        $information = 'Inventory Sold';
        $debit = '0';
        $crebit = $amount;
        $type = 'Cost of Goods Sold';
        $flow = 'Decrease';         

//---------------------------------Balance Sheet------------------------------------------//

        // Prepare and execute the query to update the account
        $updateQuery1 = "UPDATE balance_sheet SET Amount = Amount - :amount WHERE sub_account = :sub AND year = :year";
        $stmt = $pdoConnect->prepare($updateQuery1);
        $stmt->bindParam(':amount', $amount);
        $stmt->bindParam(':sub', $sub);
        $stmt->bindParam(':year', $current_year);
        $stmt->execute();

        // Prepare and execute the query to update the account
        $updateQuery2 = "UPDATE balance_sheet SET Amount = Amount + :amount WHERE sub_account = :sub AND year = :year";
        $stmt = $pdoConnect->prepare($updateQuery2);
        $stmt->bindParam(':amount', $amount);
        $stmt->bindParam(':sub', $sub2);
        $stmt->bindParam(':year', $current_year);
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
    
        $balance = $lastBalance;

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
        $insert1->bindParam(':credit', $crebit);
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