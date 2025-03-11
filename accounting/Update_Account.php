<?php
session_start(); // Start the session

//Updates the Balance Sheet

if (isset($_POST['insert'])) {

    try {
        // Establish database connection
        $pdoConnect = new PDO("mysql:host=localhost;dbname=finance_dept","root","");
        $pdoConnect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Extract data from the form
        $acc = $_POST['Acc'];
        $sub = $_POST['Sub'];
        $amount = $_POST['Amount'];
        $payment = $_POST['Payment'];
    // Prepare and execute the query to update the account
        $flow = $_POST['Flow']; // Added to get the flow value

        if ($sub == 'Cash' && $flow == 'Decrease' && $payment == 'On Credit'){
            header("Location: reports.php?error=1");
            exit();
        } else {

//---------------------------------Logics------------------------------------------//
        
//-------------------------Cash - Increase - On Cash----------------------------------------//
        if($sub == 'Cash' && $flow == 'Increase' && $payment == 'On Cash') {
            $sub2 = 'Equity Capital';
            $flow2 = $flow;
            $desc = 'Capital Investment';
            $information = 'Capital Investment';
            $debit = $amount;
            $crebit = '0';
            $type = 'Financing';
        } 
//-------------------------Cash - Increase - On Credit----------------------------------------//        
        elseif ($sub == 'Cash' && $flow == 'Increase' && $payment == 'On Credit') {
            $sub2 = 'Loans Payable';
            $flow2 = $flow;
            $desc = 'Capital On Loan';
            $information = 'Capital On Loan';
            $debit = '0';
            $crebit = $amount;
            $type = 'Withdrawals';
        } 
//-------------------------Cash - Decrease - On Cash----------------------------------------//
        elseif ($sub == 'Cash' && $flow == 'Decrease' && $payment == 'On Cash') {
            $sub2 = 'Equity Capital';
            $flow2 = 'Decrease';
            $desc = 'Capital Withdrawal';
            $information = 'Capital Withdrawal';
            $debit = '0';
            $crebit = $amount;
            $type = 'Withdrawals';
        } 
//-------------------------Inventory - Increase - On Cash----------------------------------------//
        elseif ($sub == 'Inventory' && $flow == 'Increase' && $payment == 'On Cash') {
            $sub2 = 'Cash';
            $flow2 = 'Decrease';
            $desc = 'Inventory Purchased';
            $information = 'Inventory Purchased';
            $debit = $amount;
            $crebit = '0';
            $type = 'Purchases';
        } 
//-------------------------Inventory - Increase - On Credit----------------------------------------//        
        elseif ($sub == 'Inventory' && $flow == 'Increase' && $payment == 'On Credit') {
            $sub2 = 'Accounts Payable';
            $flow2 = 'Increase';
            $desc = 'Inventory Purchased on Account';
            $information = 'Inventory Purchased on Account';
            $debit = $amount;
            $crebit = '0';
            $type = 'Purchases On Account';
        }
//-------------------------Inventory - Decrease - On Cash----------------------------------------//        
        elseif ($sub == 'Inventory' && $flow == 'Decrease' && $payment == 'On Cash') {
            $sub2 = 'Cash';
            $flow2 = 'Increase';
            $desc = 'Inventory Sold';
            $information = 'Inventory Sold';
            $debit = '0';
            $crebit = $amount;
            $type = 'Cost of Goods Sold';
        }
//-------------------------Inventory - Decrease - On Credit----------------------------------------//        
        elseif ($sub == 'Inventory' && $flow == 'Decrease' && $payment == 'On Credit') {
            $sub2 = 'Accounts Receivable';
            $flow2 = 'Increase';
            $desc = 'Inventory Sold on Account';
            $information = 'Inventory Sold on Account';
            $debit = '0';
            $crebit = $amount;
            $type = 'Cost of Goods Sold on Account';
        }
//-------------------------Accounts Receivable - Decrease - On Cash----------------------------------------//        
        elseif ($sub == 'Accounts Receivable' && $flow == 'Decrease' && $payment == 'On Cash') {
            $flow = 'Increase';
            $sub2 = 'Cash';
            $flow2 = 'Increase';
            $desc = 'Cash Receivable Paid';
            $information = 'Payments Received';
            $debit = $amount;
            $crebit = '0';
            $type = 'Sales on Account';
            $payment == 'On Cash';
        }
//-------------------------Investments - Increase - On Credit----------------------------------------//        
        elseif ($sub == 'Investments' && $flow == 'Increase' && $payment == 'On Cash') {
            $sub2 = 'Cash';
            $flow2 = 'Decrease';
            $desc = 'Investments';
            $information = 'Investments';
            $debit = $amount;
            $crebit = '0';
            $type = 'Investments';
        }
//-------------------------Investments - Decrease - On Credit----------------------------------------//        
        elseif ($sub == 'Investments' && $flow == 'Decrease' && $payment == 'On Cash') {
            $sub2 = 'Cash';
            $flow2 = 'Increase';
            $desc = 'Investments Income';
            $information = 'Investments Income';
            $debit = $amount;
            $crebit = '0';
            $type = 'Investments Income';
        }
//-------------------------Lands - Increase - On Cash----------------------------------------//        
        elseif ($sub == 'Land' && $flow == 'Increase' && $payment == 'On Cash') {
            $sub2 = 'Cash';
            $flow2 = 'Decrease';
            $desc = 'Land Purchase';
            $information = 'Land Purchase';
            $debit = '0';
            $crebit = $amount;
            $type = 'Purchases';
        }
//-------------------------Lands - Increase - On Credit----------------------------------------//        
        elseif ($sub == 'Land' && $flow == 'Increase' && $payment == 'On Credit') {
            $sub2 = 'Loans Payable';
            $flow2 = 'Increase';
            $desc = 'Land Purchase on Account';
            $information = 'Land Purchase on Account';
            $debit = '0';
            $crebit = $amount;
            $type = 'Purchases';
        }
//-------------------------Lands - Decrease - On Cash----------------------------------------//        
        elseif ($sub == 'Land' && $flow == 'Decrease' && $payment == 'On Cash') {
            $sub2 = 'Cash';
            $flow2 = 'Increase';
            $desc = 'Land Sale';
            $information = 'Land Sale';
            $debit = $amount;
            $crebit = '0';
            $type = 'Sale of Assets';
        }
//-------------------------Lands - Decrease - On Credit----------------------------------------//        
        elseif ($sub == 'Land' && $flow == 'Decrease' && $payment == 'On Credit') {
            $sub2 = 'Accounts Receivable';
            $flow2 = 'Increase';
            $desc = 'Land Sale on Account';
            $information = 'Land Sale on Account';
            $debit = $amount;
            $crebit = '0';
            $type = 'Sale of Assets';
        }
//-------------------------Buildings - Increase - On Cash----------------------------------------//        
        elseif ($sub == 'Buildings' && $flow == 'Increase' && $payment == 'On Cash') {
            $sub2 = 'Cash';
            $flow2 = 'Decrease';
            $desc = 'Buildings Purchase';
            $information = 'Buildings Purchase';
            $debit = '0';
            $crebit = $amount;
            $type = 'Purchases';
        }
//-------------------------Buildings - Increase - On Credit----------------------------------------//        
        elseif ($sub == 'Buildings' && $flow == 'Increase' && $payment == 'On Credit') {
            $sub2 = 'Loans Payable';
            $flow2 = 'Increase';
            $desc = 'Buildings Purchase on Account';
            $information = 'Buildings Purchase on Account';
            $debit = '0';
            $crebit = $amount;
            $type = 'Purchases';
        }
//-------------------------Buildings - Decrease - On Cash----------------------------------------//        
        elseif ($sub == 'Buildings' && $flow == 'Decrease' && $payment == 'On Cash') {
            $sub2 = 'Cash';
            $flow2 = 'Increase';
            $desc = 'Buildings Sale';
            $information = 'Buildings Sale';
            $debit = $amount;
            $crebit = '0';
            $type = 'Sale of Assets';
        }
//-------------------------Buildings - Decrease - On Credit----------------------------------------//        
        elseif ($sub == 'Buildings' && $flow == 'Decrease' && $payment == 'On Credit') {
            $sub2 = 'Accounts Receivable';
            $flow2 = 'Increase';
            $desc = 'Buildings Sale on Account';
            $information = 'Buildings Sale on Account';
            $debit = $amount;
            $crebit = '0';
            $type = 'Sale of Assets';
        }
//-------------------------Equipments - Increase - On Cash----------------------------------------//        
        elseif ($sub == 'Equipments' && $flow == 'Increase' && $payment == 'On Cash') {
            $sub2 = 'Cash';
            $flow2 = 'Decrease';
            $desc = 'Equipments Purchase';
            $information = 'Equipments Purchase';
            $debit = '0';
            $crebit = $amount;
            $type = 'Purchases';
        }
//-------------------------Equipments - Increase - On Credit----------------------------------------//        
        elseif ($sub == 'Equipments' && $flow == 'Increase' && $payment == 'On Credit') {
            $sub2 = 'Loans Payable';
            $flow2 = 'Increase';
            $desc = 'Equipments Purchase on Account';
            $information = 'Equipments Purchase on Account';
            $debit = '0';
            $crebit = $amount;
            $type = 'Purchases';
        }
//-------------------------Equipments - Decrease - On Cash----------------------------------------//        
        elseif ($sub == 'Equipments' && $flow == 'Decrease' && $payment == 'On Cash') {
            $sub2 = 'Cash';
            $flow2 = 'Increase';
            $desc = 'Equipments Sale';
            $information = 'Equipments Sale';
            $debit = $amount;
            $crebit = '0';
            $type = 'Sale of Assets';
        }
//-------------------------Equipments - Decrease - On Credit----------------------------------------//        
        elseif ($sub == 'Equipments' && $flow == 'Decrease' && $payment == 'On Credit') {
            $sub2 = 'Accounts Receivable';
            $flow2 = 'Increase';
            $desc = 'Equipments Sale on Account';
            $information = 'Equipments Sale on Account';
            $debit = $amount;
            $crebit = '0';
            $type = 'Sale of Assets';
        }
//-------------------------Accounts Payable - Decrease - On Cash----------------------------------------//        
        elseif ($sub == 'Accounts Payable' && $flow == 'Decrease' && $payment == 'On Cash') {
            $sub2 = 'Cash';
            $flow2 = 'Decrease';
            $desc = 'Payable Paid';
            $information = 'Payable Paid';
            $debit = '0';
            $crebit = $amount;
            $type = 'Payment of Accounts Payable';
        }
//-------------------------Tax - Decrease - On Cash----------------------------------------//        
        elseif ($sub == 'Tax' && $flow == 'Decrease' && $payment == 'On Cash') {
            $sub2 = 'Cash';
            $flow2 = 'Decrease';
            $desc = 'Tax Paid';
            $information = 'Tax Paid';
            $debit = '0';
            $crebit = $amount;
            $type = 'Payment of Tax';
        }
//-------------------------Notes Payable - Decrease - On Cash----------------------------------------//        
        elseif ($sub == 'Notes Payable' && $flow == 'Decrease' && $payment == 'On Cash') {
            $sub2 = 'Cash';
            $flow2 = 'Decrease';
            $desc = 'Notes Payable Paid';
            $information = 'Notes Payable Paid';
            $debit = '0';
            $crebit = $amount;
            $type = 'Payment of Notes Payable';
        }
//-------------------------Accrued Expenses - Decrease - On Cash----------------------------------------//        
        elseif ($sub == 'Expenditure Liabilities' && $flow == 'Decrease' && $payment == 'On Cash') {
            $flow = 'Increase';
            $sub2 = 'Cash';
            $flow2 = 'Increase';
            $desc = 'Expenditure Adjustment';
            $information = 'Expenditure Adjustment';
            $debit = '0';
            $crebit = $amount;
            $type = 'Expenditure Adjustment';
        }
//-------------------------Bonds Payable - Increase - On Cash----------------------------------------//        
        elseif ($sub == 'Bonds Payable' && $flow == 'Increase' && $payment == 'On Cash') {
            $sub2 = 'Cash';
            $flow2 = 'Increase';
            $desc = 'Bond Financing';
            $information = 'Bond Financing';
            $debit = $amount;
            $crebit = '0';
            $type = 'Bond Issuance';
        }
//-------------------------Bonds Payable - Decrease - On Cash----------------------------------------//        
        elseif ($sub == 'Bonds Payable' && $flow == 'Decrease' && $payment == 'On Cash') {
            $sub2 = 'Cash';
            $flow2 = 'Decrease';
            $desc = 'Bonds Redemption';
            $information = 'Bonds Redemption';
            $debit = '0';
            $crebit = $amount;
            $type = 'Bonds Repayment';
        }
//-------------------------Loans Payable - Increase - On Cash----------------------------------------//        
        elseif ($sub == 'Loans Payable' && $flow == 'Increase' && $payment == 'On Cash') {
            $sub2 = 'Cash';
            $flow2 = 'Increase';
            $desc = 'Loan Financing';
            $information = 'Loan Financing';
            $debit = $amount;
            $crebit = '0';
            $type = 'Loan Acquisition';
        }
//-------------------------Loans Payable - Decrease - On Cash----------------------------------------//        
        elseif ($sub == 'Loans Payable' && $flow == 'Decrease' && $payment == 'On Cash') {
            $sub2 = 'Cash';
            $flow2 = 'Decrease';
            $desc = 'Loan Repayment';
            $information = 'Loan Repayment';
            $debit = '0';
            $crebit = $amount;
            $type = 'Loan Amortization';
        }
//-------------------------Pension - Increase - On Cash----------------------------------------//        
        elseif ($sub == 'Pension' && $flow == 'Increase' && $payment == 'On Cash') {
            $sub2 = 'Cash';
            $flow2 = 'Increase';
            $desc = 'Pension Financing';
            $information = 'Pension Financing';
            $debit = $amount;
            $crebit = '0';
            $type = 'Pension Fund Inflow';
        }
//-------------------------Pension - Decrease - On Cash----------------------------------------//        
        elseif ($sub == 'Pension' && $flow == 'Decrease' && $payment == 'On Cash') {
            $sub2 = 'Cash';
            $flow2 = 'Decrease';
            $desc = 'Pension Obligation Settlement';
            $information = 'Pension Obligation Settlement';
            $debit = '0';
            $crebit = $amount;
            $type = 'Pension Asset Reduction';
        }
//-------------------------Equity Capital - Increase - On Cash----------------------------------------//        
        elseif ($sub == 'Equity Capital' && $flow == 'Increase' && $payment == 'On Cash') {
            $sub2 = 'Cash';
            $flow2 = 'Increase';
            $desc = 'Capital Investment';
            $information = 'Capital Investment';
            $debit = $amount;
            $crebit = '0';
            $type = 'Drawing account';
        }
//-------------------------Equity Capital - Decrease - On Cash----------------------------------------//        
        elseif ($sub == 'Equity Capital' && $flow == 'Decrease' && $payment == 'On Cash') {
            $sub2 = 'Cash';
            $flow2 = 'Decrease';
            $desc = 'Capital Withdrawal';
            $information = 'Capital Withdrawal';
            $debit = '0';
            $crebit = $amount;
            $type = 'Drawing account';
        }
//-------------------------Retained Earnings - Decrease - On Cash----------------------------------------//        
        elseif ($sub == 'Retained Earnings' && $flow == 'Increasae' && $payment == 'On Cash') {
            $sub2 = 'Cash';
            $flow2 = 'Increase';
            $desc = 'Retained Earnings';
            $information = 'Retained Earnings';
            $debit = '0';
            $crebit = $amount;
            $type = 'Net Income';
        }
//-------------------------Retained Earnings - Decrease - On Cash----------------------------------------//
        elseif ($sub == 'Retained Earnings' && $flow == 'Decrease' && $payment == 'On Cash') {
            $sub2 = 'Cash';
            $flow2 = 'Increase';
            $desc = 'Retained Earnings';
            $information = 'Retained Earnings';
            $debit = '0';
            $crebit = $amount;
            $type = 'Net Loss';
        }

//---------------------------------Balance Sheet------------------------------------------//
        date_default_timezone_set('Asia/Manila');        
        $current_year = date("Y");

        // Prepare and execute the query to update the account
        if ($flow == 'Increase') {
            $updateQuery1 = "UPDATE balance_sheet SET Amount = Amount + :amount WHERE sub_account = :sub AND year = :year";
        } elseif ($flow == 'Decrease') {
            $updateQuery1 = "UPDATE balance_sheet SET Amount = Amount - :amount WHERE sub_account = :sub AND year = :year";
        }

        $stmt = $pdoConnect->prepare($updateQuery1);
        $stmt->bindParam(':amount', $amount);
        $stmt->bindParam(':sub', $sub);
        $stmt->bindParam(':year', $current_year);
        $stmt->execute();

        // Prepare and execute the query to update the account
        if ($flow2 == 'Increase') {
            $updateQuery2 = "UPDATE balance_sheet SET Amount = Amount + :amount WHERE sub_account = :sub AND year = :year";
        } elseif ($flow2 == 'Decrease') {
            $updateQuery2 = "UPDATE balance_sheet SET Amount = Amount - :amount WHERE sub_account = :sub AND year = :year";
        }

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
    
    if ($sub == 'Inventory' || $sub == 'Accounts Receivable' || $sub == 'Investments' || $sub == 'Land'  || $sub == 'Buildings'  || $sub == 'Equipments' ) {
        $balance = $lastBalance;
    } else {
        // Prepare and execute the query to update the account
        if ($flow == 'Increase'){
            $balance = $amount + $lastBalance;
        } elseif ($flow == 'Decrease') {
            $balance = $lastBalance - $amount;
        }
    }

        
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
}
        // Set a session variable to indicate successful update
        $_SESSION['update_success'] = true;

        // Redirect to the same page to prevent form resubmission
        header("location: reports.php");
        exit();
    } catch (PDOException $e) {
        // Handle database errors
        echo "Error: " . $e->getMessage();
        exit(); // Exit after handling the error
    }
}

