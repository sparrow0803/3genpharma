To fully use the module, import the finance_dept.sql only.








<?php
// Fetch_ledger_data.php

// Assuming you have established the database connection somewhere in your code
    $pdoConnect = new PDO("mysql:host=localhost;dbname=finance_dept","root","");
    $pdoConnect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Check if the date parameter is set
if(isset($_GET['date'])) {
    // Get the selected date from the URL
    $selectedDate = $_GET['date'];
    [$day, $month, $year] = explode('-', $selectedDate);


    // Prepare SQL query to fetch ledger data for the selected date
    $pdoLedgerQuery = "SELECT * FROM general_ledger WHERE `year` :year, `month` :month, `day` = :day";
    $pdoResult = $pdoConnect->prepare($pdoLedgerQuery);
    $pdoResult->bindParam(':year', $year);
    $pdoResult->bindParam(':month', $month);
    $pdoResult->bindParam(':day', $day);
    $pdoExec = $pdoResult->execute();

    // Fetch the data and encode it as JSON
    $ledgerData = $pdoResult->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($ledgerData);
} else {
    // If date parameter is not set, return an error message or handle it as per your requirement
    echo json_encode(array("error" => "Date parameter not provided"));
}
?>




<?php
                $pdoLedgerQuery = "SELECT * FROM general_ledger";
                $pdoResult = $pdoConnect->prepare($pdoLedgerQuery);
                $pdoExec = $pdoResult->execute();
                while ($row = $pdoResult->fetch(PDO::FETCH_ASSOC)){
                    extract($row);
                    echo "<tr>";
                    echo "<td>$year-$month-$day</td>";
                    echo "<td>$time</td>";
                    echo "<td>$account</td>";
                    echo "<td>$description</td>";
                    echo "<td>$debit</td>";
                    echo "<td>$credit</td>";
                    echo "<td>$balance</td>";
                    echo "</tr>";
                }
                ?>


if ($date != ''){
    [$year, $month, $day] = explode('-', $date);
} else{
    echo "<script>showErrorPopup('Invalid Date');</script>";
}





<div class="datepicker-container">
                <input type="date" id="datepicker" class="datepicker-input">
                <i class="bx bx-calendar datepicker-icon"></i>
                <button onclick="fetchData()">Fetch Data</button>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Account</th>
                        <th>Description</th>
                        <th>Debit</th>
                        <th>Credit</th>
                        <th>Balance</th>
                    </tr>
                </thead>
                <tbody id="ledgerData">
                    <!-- Add your ledger entries here -->
                
                    
                </tbody>
            </table>
        
            </div>
        
        </div>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        var currentDate = new Date().toISOString().split('T')[0];
        document.getElementById("datepicker").value = currentDate;
        fetchData(currentDate);
    });

    document.getElementById("datepicker").addEventListener("change", function() {
        var selectedDate = this.value;
        fetchData(selectedDate);
    });

    function fetchData(date) {
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "fetch_ledger_data.php?date=" + date, true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var data = JSON.parse(xhr.responseText);
                displayData(data);
            }
        };
        xhr.send();
    }

    function displayData(data) {
        var tableBody = document.getElementById("ledgerData");
        tableBody.innerHTML = "";

        data.forEach(function(item) {
            var row = document.createElement("tr");
            var dateCell = document.createElement("td");
            var timeCell = document.createElement("td");
            var accountCell = document.createElement("td");
            var descriptionCell = document.createElement("td");
            var debitCell = document.createElement("td");
            var creditCell = document.createElement("td");
            var balanceCell = document.createElement("td");

            // Adjust the date format to YYYY-MM-DD
            var dateParts = item.date.split("-");
            var formattedDate = dateParts[0] + "-" + dateParts[1] + "-" + dateParts[2];

            dateCell.textContent = formattedDate;
            timeCell.textContent = item.time;
            accountCell.textContent = item.account;
            descriptionCell.textContent = item.description;
            debitCell.textContent = item.debit;
            creditCell.textContent = item.credit;
            balanceCell.textContent = item.balance;

            row.appendChild(dateCell);
            row.appendChild(timeCell);
            row.appendChild(accountCell);
            row.appendChild(descriptionCell);
            row.appendChild(debitCell);
            row.appendChild(creditCell);
            row.appendChild(balanceCell);

            tableBody.appendChild(row);
        });
    }
</script>


<?php
require_once 'reports_asset/connection/dbcon.php';
session_start();

unset($_SESSION['reload']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> FINANCIAL REPORTS </title>
    <link rel="stylesheet" href="/styles/reports.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel="stylesheet">

    <!-- BOOTSTRAP STYLES
    <link href="reports_asset/css/bootstrap.css" rel="stylesheet" />-->
     <!-- FONTAWESOME STYLES-->
    <link href="reports_asset/css/font-awesome.css" rel="stylesheet" />
        <!-- CUSTOM STYLES-->
    <link href="reports_asset/css/custom.css" rel="stylesheet" />
     <!-- GOOGLE FONTS-->
   <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>

<body>
<nav class="sidebar close">
<header>
    <div class="image-text">
    <span class="image">
    <img src="/img/logo.png" alt="logo">
    </span>
    </div>
    <i class='bx bx-menu toggle'></i>
</header>

<div class="menu-bar">
    <div class="menu">
        <ul class="menu-links">
            <li class="nav-link"> 
                <a href="dashboard.html">
                <i class='bx bx-home-alt icon' ></i>
                <span class="text nav-text"> Dashboard </span>
                </a>
            </li>
            <li class="nav-link"> 
                <a href="employee.html">
                <i class='bx bx-group icon' ></i>
                <span class="text nav-text"> Employees </span>
                </a>
            </li>
            <li class="nav-link"> 
                <a href="customer.html">
                <i class='bx bx-user-pin icon' ></i>
                <span class="text nav-text"> Customers </span>
                </a> 
            </li>
            <li class="nav-link"> 
                <a href="sales.html">
                <i class='bx bx-money-withdraw icon' ></i>
                <span class="text nav-text"> Sales </span>
                </a> 
            </li>
            <li class="nav-link"> 
                <a href="reports.html">
                <i class='bx bxs-book icon' ></i>
                <span class="text nav-text"> Reports </span>
                </a> 
            </li>
            <li class="nav-link"> 
                <a href="inventory.html">
                <i class='bx bx-package icon' ></i>
                <span class="text nav-text"> Inventory </span>
                </a> 
            </li>
    
            <div class="sidenav-menu">
            <li class="nav-link"> 
                <i class='bx bxs-factory icon'> </i>
                <span class="text nav-text"> Manufacturers </span>
                <div class="sidenav-btn">
                <i class="bx bx-chevron-down"></i>
                </div>
            </li>
                <ul class="sidenavoptions">
                    <li class="sidenavoption">
                        <span class="snavoption-text">Logistics & Manufacturing </span>
                    </li>
                    <li class="sidenavoption">
                        <span class="snavoption-text">Warehouse Management</span>
                    </li>
                    <li class="sidenavoption">
                        <span class="snavoption-text">Supply Chain</span>
                    </li>
                </ul>
                
            </div>
            <li class="nav-link"> 
                <a href="purchase.html">
                <i class='bx bx-purchase-tag icon' ></i>
                <span class="text nav-text"> Purchases </span>
                </a>
            </li>
            
            <div class="bottom-content">
                <hr style="height:1px;opacity:40%;border-width:0;background-color:#FFD041;">
                <li class="nav-link"> 
                    <a href="settings.html">
                    <i class='bx bx-cog icon' ></i>
                    <span class="text nav-text"> Settings </span>
                    </a>
                </li>
                <li class="nav-link"> 
                    <a href="logout.php">
                    <i class='bx bx-log-out icon' ></i>
                    <span class="text nav-text"> Logout </span>
                    </a>
                </li>
            </div>
        </ul>
    </div>    
    </div>
</nav>

<section class="home">
    <div class="userheader"> 
        <h1> <i class='bx bxs-book icon'>&nbsp</i> FINANCIAL REPORTS </h1> 
        <h2><i class='bx bxs-user usericon'>&nbsp</i> Super Admin </h2>  
    </div>

<!----- INPUT CODE HERE :) ----->

<ul class="nav nav-tabs">
    <li class="active"><a href="#home" data-toggle="tab">General Ledger</a>
    </li>
    <li class=""><a href="#profile" data-toggle="tab">Audit Trail</a>
    </li>
    <li class=""><a href="#messages" data-toggle="tab">Balance Sheet</a>
    </li>
    <li class=""><a href="#settings" data-toggle="tab">Add New Account</a>
    </li>
</ul>

<div class="tab-content">
    <div class="tab-pane fade active in" id="home">
        <div class="card--container2"> 

            <div class="date">
                <div class="select-menu">
                    <div class="select-btn">
                        <span class="sBtn-text" style="font-size: 16px; color: #FFD041;">Select your option</span>
                        <i class="bx bx-chevron-down" style="color: #FFD041;"></i>
                    </div>
                    <ul class="options">
                        <li class="option">
                            <span class="option-text">This year</span>
                        </li>
                        <li class="option">
                            <span class="option-text">This month</span>
                        </li>
                        <li class="option">
                            <span class="option-text">This week</span>
                        </li>
                        <li class="option">
                            <span class="option-text">Overall</span>
                        </li>
                    </ul>
                </div>
            </div>
        
            <div class="todaysreport">
            <div class="title-card3"><h1>General Ledger</h1></div>
                
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Account</th>
                        <th>Description</th>
                        <th>Debit</th>
                        <th>Credit</th>
                        <th>Balance</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Add your ledger entries here -->
                    <tr>
                        <td>2024-03-07</td>
                        <td>1001</td>
                        <td>Opening Balance</td>
                        <td></td>
                        <td></td>
                        <td>1000.00</td>
                    </tr>
                    <tr>
                        <td>2024-03-08</td>
                        <td>2002</td>
                        <td>Sales</td>
                        <td></td>
                        <td>500.00</td>
                        <td>1500.00</td>
                    </tr>
                    <tr>
                        <td>2024-03-10</td>
                        <td>3003</td>
                        <td>Expenses</td>
                        <td>200.00</td>
                        <td></td>
                        <td>1300.00</td>
                    </tr>
                    <!-- Add more entries as needed -->
                </tbody>
            </table>
        
            </div>
        
        </div>
    </div>

    <div class="tab-pane fade" id="profile">
        <div class="card--container2"> 
            <div class="date">
                March 
                &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                <i class='bx bx-chevron-down icon'></i>
            </div>
        
            <div class="todaysreport">
            <div class="title-card3"><h1>Audit Trail</h1></div>
                
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Transaction Type</th>
                        <th>Account</th>
                        <th>Description</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>2024-03-07 09:45:00</td>
                        <td>Journal Entry</td>
                        <td>Accounts Receivable</td>
                        <td>Sale of goods</td>
                        <td>$5,000.00</td>                
                    </tr>
                    <tr>
                        <td>2024-03-07 11:30:45</td>
                        <td>Adjustment</td>
                        <td>Bad Debt Expense</td>
                        <td>Write-off of uncollectible receivable</td>
                        <td>($500.00)</td>                
                    </tr>
                    <!-- Add more rows as needed -->
                </tbody>
            </table>
        
            </div>
        
        </div>
    </div>

    <div class="tab-pane fade" id="messages">
        <div class="card--container2"> 
            <div class="date">
                2023 
                &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                <i class='bx bx-chevron-down icon'></i>
            </div>
        
            <div class="todaysreport">
            <div class="title-card3"><h1>Balance Sheet</h1></div>
            
            <h1 style="text-align: center;">ASSETS</h1>
            <br >
            <h3>Current Assets</h3>
        
<?php

?>

            <table>
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $asset = "Asset";
                $pdoQuery = "SELECT * FROM balance_sheet WHERE accounts = :account";
                $pdoResult = $pdoConnect->prepare($pdoQuery);
                $pdoExec = $pdoResult->execute(array(":account" => $asset));
                while ($row = $pdoResult->fetch(PDO::FETCH_ASSOC)){
                    extract($row);
                    echo "<tr>";
                    echo "<td>$description</td>";
                    echo "<td>$amount</td>";
                    echo "</tr>";
                }
                ?>
                </tbody>
                <tfoot>
                    <tr>
                        <?php 
                    //    $sql = "SELECT SUM(amount) AS total FROM balance_sheet";

                    //    $result = $pdoConnect->query($sql);
                        
                    //    if ($result->num_rows > 0) {

                    //        $row = $result->fetch_assoc();
                    //       $sum = $row["total"];
                    //    } else {
                    //        echo "0";
                    //    }

$sql = "SELECT amount FROM balance_sheet";
try {
    // Prepare and execute the query
    $stmt = $pdoConnect->prepare($sql);
    $stmt->execute();

    // Initialize sum variable
    $sum = 0;

    // Fetch each row and add its number to the sum
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $sum += $row['amount'];
    }

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

// Close the connection
$pdo = null;
                        
                        ?>
                        <th>Subtotal</th>
                        <th><?php echo $sum ?></th>
                    </tr>
                </tfoot>
            </table>
        
            <br >
            <h3>Long-term Assets</h3>
        
            <table>
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Land</td>
                        <td>250,000</td>              
                    </tr>
                    <tr>
                        <td>Buildings</td>
                        <td>150,000</td>             
                    </tr>
                    <tr>
                        <td>Equipment</td>
                        <td>55,500</td>             
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th>Subtotal</th>
                        <th>455,500</th>
                    </tr>
                </tfoot>
            </table>
            <br >
            <table>
                <thead>
                    <tr>
                        <th>Total Assets</th>
                        <th>705,500</th>
                    </tr>
                </thead>
            </table>
            <br >
            <br >
            
            <h1 style="text-align: center;">Liabilities</h1>
        
            <br >
            <br >
            <h3>Current Liabilities</h3>
        
            <table>
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Accounts Payable</td>
                        <td>1,500</td>              
                    </tr>
                    <tr>
                        <td>Tax</td>
                        <td>3,000</td>             
                    </tr>
                    <tr>
                        <td>Notes Payable</td>
                        <td>1,000</td>             
                    </tr>
                    <tr>
                        <td>Accrued Expenses</td>
                        <td>1,500</td>             
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th>Subtotal</th>
                        <th>7,500</th>
                    </tr>
                </tfoot>
            </table>
        
            <br >
            <h3>Long-term Liabilities</h3>
        
            <table>
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Bonds Payable</td>
                        <td>30,000</td>
                    </tr>
                    <tr>
                        <td>Loans Payable</td>
                        <td>25,000</td>              
                    </tr>
                    <tr>
                        <td>Pensions</td>
                        <td>10,000</td>             
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th>Subtotal</th>
                        <th>65,000</th>
                    </tr>
                </tfoot>
            </table>
            <br >
            <table>
                <thead>
                    <tr>
                        <th>Total Liabilities</th>
                        <th>42,500</th>
                    </tr>
                </thead>
            </table>
            <br >
            <br >
        
            <h1 style="text-align: center;">Equity</h1>
        
            <br >
            <br >
            <h3>Stakeholder's Equity</h3>
        
            <table>
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Equity Capital</td>
                        <td>613,000</td>              
                    </tr>
                    <tr>
                        <td>Retained Earnings</td>
                        <td>50,000</td>             
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th>Total Equity</th>
                        <th>663,000</th>
                    </tr>
                </tfoot>
            </table>
            <br >
            <table>
                <thead>
                    <tr>
                        <th>Total Liabilities and Equity</th>
                        <th>705,500</th>
                    </tr>
                </thead>
            </table>
            <br >
        
        
        
            </div>
        
        </div>
    </div>

    <div class="tab-pane fade" id="settings">
    <div class="card--container2">
        <h3>Update an Account</h3>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            Account: <input type="text" name="Acc" required placeholder="Ex. Asset"><br>
            Description: <input type="text" name="Desc" required placeholder="Ex. Cash"><br>
            Flow: <input type="text" name="Flow" required placeholder="Increase or Decrease"><br>
            Amount: <input type="number" name="Amount" required placeholder="00.00"><br>
            <input type="submit" name="insert" value="Update"><br>
        </form>

        <?php 
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Database connection settings
            $host = 'localhost';
            $dbname = 'finance_dept';
            $username = 'root';
            $password = '';

            try {
                // Establish a connection to the database using PDO
                $pdoConnect = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
                $pdoConnect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $acc = $_POST['Acc'];
                $Desc = $_POST['Desc'];
                $amount = $_POST['Amount'];

                // Step 1: Retrieve the current value
                $selectQuery = "SELECT Amount FROM balance_sheet WHERE description = :Desc";
                $stmt = $pdoConnect->prepare($selectQuery);
                $stmt->bindParam(':Desc', $Desc);
                $stmt->execute();
                $currentValue = $stmt->fetchColumn();
                
                // Step 2: Perform subtraction operation
                $newValue = $currentValue + $amount;
                
                // Step 3: Prepare SQL query to update the database with the new value
                $updateQuery = "UPDATE balance_sheet SET Amount = :new_value WHERE description = :Desc";
                $stmt = $pdoConnect->prepare($updateQuery);
                $stmt->bindParam(':new_value', $newValue);
                $stmt->bindParam(':Desc', $Desc);
                $stmt->execute();
                
                header("location: reports.php");
            exit;
            } catch (PDOException $e) {
                die("Error: " . $e->getMessage());
            }
        }
        
        ?>
    </div>
</div>

</div>


</section>
<script>
/*----------------SIDEBAR JS------------------*/
    const body = document.querySelector("body"),
    sidebar = body.querySelector(".sidebar"),
    toggle = body.querySelector(".toggle");
    toggle.addEventListener("click", () =>{
    sidebar.classList.toggle("close");
    });
    if(window.history.replaceState)
    { window.history.replaceState(null, null, window.location.href); }

const sidenavoptionMenu = document.querySelector(".sidenav-menu"),
    sidenavBtn = sidenavoptionMenu.querySelector(".sidenav-btn"),
    sidenavoptions = sidenavoptionMenu.querySelectorAll(".sidenavoption"),
    snavtntext = sidenavoptionMenu.querySelector(".snavtn-text");
sidenavBtn.addEventListener("click", () => sidenavoptionMenu.classList.toggle("active"));       
sidenavoptions.forEach(sidenavoption =>{
    sidenavoption.addEventListener("click", ()=>{
    let selectedOption = option.querySelector(".snavoption-text").innerText;
    snavtntext.innerText = selectedOption;
    sidenavoptionMenu.classList.remove("active");
});
});
</script>

<!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
    <!-- JQUERY SCRIPTS -->
    <script src="reports_asset/js/jquery-1.10.2.js"></script>
      <!-- BOOTSTRAP SCRIPTS -->
    <script src="reports_asset/js/bootstrap.min.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="reports_asset/js/jquery.metisMenu.js"></script>
      <!-- CUSTOM SCRIPTS -->
    <script src="reports_asset/js/custom.js"></script>

    <script src="js/dropdown.js"></script>

</body>
</html>