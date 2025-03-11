<?php
require_once 'reports_asset/connection/dbcon.php';
session_start();


if(isset($_GET['error']) && $_GET['error'] == 1) {
    // Set your error message here
    $errorMessage = "Accounting Error: Cash cannot be deducted on account.";
    echo "<script type='text/javascript'>
        window.onload = function() {
            alert('$errorMessage');
            window.location.href = 'reports.php';
        };
    </script>";
}


$current_year = date("Y");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> FINANCIAL REPORTS </title>
    <link rel="icon" href="img/logo_icon.png" type="image/png">
    <link rel="stylesheet" href="styles/reports.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel="stylesheet">

    <!-- BOOTSTRAP STYLES
    <link href="reports_asset/css/bootstrap.css" rel="stylesheet" />-->
     <!-- FONTAWESOME STYLES-->
    <link href="reports_asset/css/font-awesome.css" rel="stylesheet" />
        <!-- CUSTOM STYLES-->
    <link href="reports_asset/css/custom.css" rel="stylesheet" />
     <!-- GOOGLE FONTS-->
   <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
<style>
    button.approve, button.decline {
        margin-left: 10px;
    text-decoration: none;
    padding: 2px 5px;
    border: 1px solid transparent;
    border-radius: 3px;
  }
  
  button.approve {
    background-color: #28a745; /* Green color for edit */
    color: #ffffff; /* White color for text */
  }
  
  button.decline {
    background-color: #dc3545; /* Red color for delete */
    color: #ffffff; /* White color for text */
  }
  
  button.approve:hover {
    background-color: transparent;
    border-color: #000000; /* Black color for border on hover */
    color: #28a745
  }
  button.decline:hover {
    background-color: transparent;
    border-color: #000000; /* Black color for border on hover */
    color: #dc3545
  }
</style>
</head>

<body>
<nav class="sidebar close">
<header>
    <div class="image-text">
    <span class="image">
    <img src="img/logo.png" alt="logo">
    </span>
    </div>
    <i class='bx bx-menu toggle'></i>
</header>

<div class="menu-bar">
    <div class="menu">
        <ul class="menu-links">
            <li class="nav-link"> 
                <a href="../BI/dashboard.php">
                <i class='bx bx-home-alt icon' ></i>
                <span class="text nav-text"> Dashboard </span>
                </a>
            </li>
            <li class="nav-link"> 
                <a href="../HR/employee.php">
                <i class='bx bx-group icon' ></i>
                <span class="text nav-text"> Employees </span>
                </a>
            </li>
            <li class="nav-link"> 
                <a href="../crm/customer.php">
                <i class='bx bx-user-pin icon' ></i>
                <span class="text nav-text"> Customers </span>
                </a> 
            </li>
            <li class="nav-link"> 
                <a href="reports.php">
                <i class='bx bxs-book icon' ></i>
                <span class="text nav-text"> Reports </span>
                </a> 
            </li>
            <li class="nav-link"> 
                <a href="../inventory/inventory.php">
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
                    <a href="../sia/logistics.php">
                    <span class="snavoption-text">Logistics & Manufacturing</span>
                    </a>
                </li>
                <li class="sidenavoption">
                    <a href="../Warehouse/index.php" class="snavoption-text">Warehouse Management</a>
                </li>
                <li class="sidenavoption">
                    <a href="../Supply/index.php" class="snavoption-text">Supply Chain</a>
                </li>
            </ul>
                
            </div>
                        
            <div class="bottom-content">
                <hr style="height:1px;opacity:40%;border-width:0;background-color:#FFD041;">
                <li class="nav-link"> 
                    <a href="/3GENPHARMACY/settings.html">
                    <i class='bx bx-cog icon' ></i>
                    <span class="text nav-text"> Settings </span>
                    </a>
                </li>
                <li class="nav-link"> 
                    <a href="/3GENPHARMACY/logout.php">
                    <i class='bx bx-log-out icon' ></i>
                    <span class="text nav-text"> Logout </span>
                    </a>
                </li>
            </div>
        </ul>
    </div>    
    </div>

<script>
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
</nav>

<section class="home">
    <div class="userheader"> 
        <h1> <i class='bx bxs-book icon'>&nbsp</i> FINANCIAL REPORTS </h1> 
        <h2><i class='bx bxs-user usericon'>&nbsp</i> Super Admin </h2>  
    </div>

<!----- INPUT CODE HERE :) ----->

<ul class="nav nav-tabs">
    <li class="active"><a href="#generalledger" data-toggle="tab">General Ledger</a>
    </li>
    <li class=""><a href="#audittrail" data-toggle="tab">Audit Trail</a>
    </li>
    <li class=""><a href="#balancesheet" data-toggle="tab">Balance Sheet</a>
    </li>
    <li class=""><a href="#update" data-toggle="tab" >Update Account</a>
    </li>
    <li class=""><a href="#financialrequest" data-toggle="tab" >Financial Request</a>
    </li>
</ul>

<!-----------------General Ledger---------------------->
<div class="tab-content">
    <div class="tab-pane fade active in" id="generalledger">
        <div class="card--container2"> 
<!--
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
                <script src="js/dropdown.js"></script>
            </div>
-->        
            <div class="todaysreport">
            <div class="title-card3"><h3>General Ledger</h3></div>
                
            <div class="datepicker-container">
                <i class="bx bx-calendar datepicker-icon"></i>
                <input type="date" id="datepicker" class="datepicker-input" required>
                <button id="fetchDataBtn">Search Date</button>
                <button id="ResetDataBtn">Reset</button>
            </div>
            <br />
            <table class="responsive-table">
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
                <?php
                $pdoLedgerQuery = "SELECT * FROM general_ledger /*ORDER BY CONCAT(year, '-', month, '-', day) DESC*/ ";
                $pdoResult = $pdoConnect->prepare($pdoLedgerQuery);
                $pdoExec = $pdoResult->execute();
                while ($row = $pdoResult->fetch(PDO::FETCH_ASSOC)){
                    extract($row);
                    echo "<tr>";
                    echo "<td>$date</td>";
                    echo "<td>$time</td>";
                    echo "<td>$account</td>";
                    echo "<td>$description</td>";
                    echo "<td>₱ " . number_format((float)$debit, 2) . "</td>";
                    echo "<td>₱ " . number_format((float)$credit, 2) . "</td>";
                    echo "<td>₱ " . number_format((float)$balance, 2) . "</td>";
                    echo "</tr>";
                }
                ?>

                </tbody>
            </table>
<script>
    document.getElementById('fetchDataBtn').addEventListener('click', function() {
        var date = document.getElementById('datepicker').value;
        if (date === null || date === undefined || date === '' || date.length === 0 || Object.keys(date).length === 0){
            alert("Please select a date.");
        } else {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    document.getElementById('ledgerData').innerHTML = xhr.responseText;
                } else {
                    console.error('Request failed: ' + xhr.status);
                }
            }
        };
            xhr.open('GET', 'fetch_ledger_data.php?date=' + date, true);
            xhr.send();
        }
        
    });

    document.getElementById('ResetDataBtn').addEventListener('click', function() {
        document.getElementById('datepicker').value = '';

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                document.getElementById('ledgerData').innerHTML = xhr.responseText;
            } else {
                console.error('Request failed: ' + xhr.status);
            }
        }
    };
    xhr.open('GET', 'fetch_ledger_data.php', true);
    xhr.send();
});



    
</script>
        
            </div>
        
        </div>
    </div>  
<!-----------------AUDIT TRAIL---------------------->
    <div class="tab-pane fade" id="audittrail">
        <div class="card--container2"> 
        
            <div class="todaysreport">
            <div class="title-card3"><h3>Audit Trail</h3></div>

            <div class="datepicker-container">
                <i class="bx bx-calendar datepicker-icon"></i>
                <input type="date" id="datepicker1" class="datepicker-input" required>
                <button id="fetchBtn">Search Date</button>
                <button id="resetBtn">Reset</button>
            </div>
            <br />
            <table class="responsive-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Transaction Type</th>
                        <th>Account</th>
                        <th>Description</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody id="auditData">
                <?php
                $pdoLedgerQuery = "SELECT * FROM audit_trail";
                $pdoResult = $pdoConnect->prepare($pdoLedgerQuery);
                $pdoExec = $pdoResult->execute();
                while ($row = $pdoResult->fetch(PDO::FETCH_ASSOC)){
                    extract($row);
                    echo "<tr>";
                    echo "<td>$date</td>";
                    echo "<td>$time</td>";
                    echo "<td>$transaction_type</td>";
                    echo "<td>$account</td>";
                    echo "<td>$description</td>";
                    if ($flow == "Increase") {
                        echo "<td>₱ " . number_format((float)$amount, 2) . "</td>";
                    } else {
                        echo "<td>( ₱ " . number_format((float)$amount, 2) . " )</td>";
                    } 
                    echo "</tr>";
                }
                ?>
                    
                </tbody>
            </table>

            <script>
    document.getElementById('fetchBtn').addEventListener('click', function() {
        var date = document.getElementById('datepicker1').value;
        if (!date) {
            alert("Please select a date.");
        } else {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        document.getElementById('auditData').innerHTML = xhr.responseText;
                    } else {
                        console.error('Request failed: ' + xhr.status);
                    }
                }
            };
            xhr.open('GET', 'fetch_audit_data.php?date=' + date, true);
            xhr.send();
        }
    });

    document.getElementById('resetBtn').addEventListener('click', function() {
        document.getElementById('datepicker1').value = '';

        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    document.getElementById('auditData').innerHTML = xhr.responseText;
                } else {
                    console.error('Request failed: ' + xhr.status);
                }
            }
        };
        xhr.open('GET', 'fetch_audit_data.php', true); // No date parameter passed
        xhr.send();
    });
</script>
            </div>
        
        </div>
    </div>
<!-----------------BALANCE SHEET---------------------->
    <div class="tab-pane fade" id="balancesheet">
        <div class="card--container2"> 
        <div class="select-menu">
                        <label for="year">Select a Year:</label>
                        <select id="year" name="year">
                        <!-- JavaScript will dynamically generate options here -->
                        </select>

                </div>
                
<script>
// Get the dropdown element
var dropdown = document.getElementById("year");

// Function to fetch current asset data and total
function fetchCurrentAssetData(year) {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                document.getElementById('currentasset').innerHTML = xhr.responseText;
            } else {
                console.error('Request failed: ' + xhr.status);
            }
        }
    };
    xhr.open('GET', 'bs/current_asset.php?year=' + year, true);
    xhr.send();
}

function fetchCurrentAssetTotal(year) {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                document.getElementById('currentassettotal').innerHTML = xhr.responseText;
            } else {
                console.error('Request failed: ' + xhr.status);
            }
        }
    };
    xhr.open('GET', 'bs/current_asset_total.php?year=' + year, true);
    xhr.send();
}

function fetchLongTermAssetData(year) {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                document.getElementById('longtermasset').innerHTML = xhr.responseText;
            } else {
                console.error('Request failed: ' + xhr.status);
            }
        }
    };
    xhr.open('GET', 'bs/long-term_asset.php?year=' + year, true);
    xhr.send();
}

function fetchLongTermAssetTotal(year) {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                document.getElementById('longtermassettotal').innerHTML = xhr.responseText;
            } else {
                console.error('Request failed: ' + xhr.status);
            }
        }
    };
    xhr.open('GET', 'bs/long-term_asset_total.php?year=' + year, true);
    xhr.send();
}

function fetchTotalAsset(year) {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                document.getElementById('totalassets').innerHTML = xhr.responseText;
            } else {
                console.error('Request failed: ' + xhr.status);
            }
        }
    };
    xhr.open('GET', 'bs/total_asset.php?year=' + year, true);
    xhr.send();
}

function fetchCurrentLiabilitiesData(year) {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                document.getElementById('currentliabilities').innerHTML = xhr.responseText;
            } else {
                console.error('Request failed: ' + xhr.status);
            }
        }
    };
    xhr.open('GET', 'bs/current_liabilities.php?year=' + year, true);
    xhr.send();
}

function fetchCurrentLiabilitiesTotal(year) {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                document.getElementById('currentliabilitiestotal').innerHTML = xhr.responseText;
            } else {
                console.error('Request failed: ' + xhr.status);
            }
        }
    };
    xhr.open('GET', 'bs/current_liabilities_total.php?year=' + year, true);
    xhr.send();
}

function fetchLongTermLiabilitiesData(year) {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                document.getElementById('longtermliabilities').innerHTML = xhr.responseText;
            } else {
                console.error('Request failed: ' + xhr.status);
            }
        }
    };
    xhr.open('GET', 'bs/long-term_liabilities.php?year=' + year, true);
    xhr.send();
}

function fetchLongTermLiabilitiesTotal(year) {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                document.getElementById('longtermliabilitiestotal').innerHTML = xhr.responseText;
            } else {
                console.error('Request failed: ' + xhr.status);
            }
        }
    };
    xhr.open('GET', 'bs/long-term_liabilities_total.php?year=' + year, true);
    xhr.send();
}

function fetchTotalLiabilities(year) {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                document.getElementById('totalliabilities').innerHTML = xhr.responseText;
            } else {
                console.error('Request failed: ' + xhr.status);
            }
        }
    };
    xhr.open('GET', 'bs/total_liabilities.php?year=' + year, true);
    xhr.send();
}

function fetchEquityData(year) {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                document.getElementById('equity').innerHTML = xhr.responseText;
            } else {
                console.error('Request failed: ' + xhr.status);
            }
        }
    };
    xhr.open('GET', 'bs/equity.php?year=' + year, true);
    xhr.send();
}

function fetchEquityTotal(year) {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                document.getElementById('totalequity').innerHTML = xhr.responseText;
            } else {
                console.error('Request failed: ' + xhr.status);
            }
        }
    };
    xhr.open('GET', 'bs/total_equity.php?year=' + year, true);
    xhr.send();
}

function fetchLiabilityEquity(year) {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                document.getElementById('liabilityequity').innerHTML = xhr.responseText;
            } else {
                console.error('Request failed: ' + xhr.status);
            }
        }
    };
    xhr.open('GET', 'bs/liability_equity.php?year=' + year, true);
    xhr.send();
}

// Add event listener for the change event on the dropdown
dropdown.addEventListener("change", function() {
    // Get the selected value
    var year = dropdown.value;
    console.log("Selected Year: " + year);

    // Call the functions to fetch current asset data and total
    fetchCurrentAssetData(year);
    fetchCurrentAssetTotal(year);
    fetchLongTermAssetData(year);
    fetchLongTermAssetTotal(year);
    fetchTotalAsset(year);

    fetchCurrentLiabilitiesData(year);
    fetchCurrentLiabilitiesTotal(year);
    fetchLongTermLiabilitiesData(year);
    fetchLongTermLiabilitiesTotal(year);
    fetchTotalLiabilities(year);

    fetchEquityData(year);
    fetchEquityTotal(year);

    fetchLiabilityEquity(year);
});

// Get the current year
var currentYear = new Date().getFullYear();

// Add options for the current year and the 10 years preceding it
for (var i = 0; i <= 10; i++) {
    var option = document.createElement("option");
    option.text = currentYear - i;
    option.value = currentYear - i;
    dropdown.add(option);
}

// Fetch data for the initial selected year
var initialYear = dropdown.value;
fetchCurrentAssetData(initialYear);
fetchCurrentAssetTotal(initialYear);

    </script>

            <div class="todaysreport">
            <div class="title-card3"><h3>Balance Sheet</h3></div>
            
            <h3 style="text-align: center;">ASSETS</h3>
            <br >
            <h3>Current Assets</h3>
    
            <table class="responsive-table" style="table-layout: fixed;">
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody id="currentasset">
                <?php
                
                $currentasset = "Current Assets";
                $pdoQuery = "SELECT * FROM balance_sheet WHERE accounts = :account AND year = :year";
                $pdoResult = $pdoConnect->prepare($pdoQuery);
                $pdoResult->bindParam(':account', $currentasset);
                $pdoResult->bindParam(':year', $current_year);
                $pdoExec = $pdoResult->execute();
                while ($row = $pdoResult->fetch(PDO::FETCH_ASSOC)){
                    extract($row);
                    echo "<tr>";
                    echo "<td>$sub_account</td>";
                    echo "<td>₱ " . number_format((float)$amount, 2) . "</td>";
                    echo "</tr>";
                }
                ?>
                </tbody>
                <tfoot id="currentassettotal">
                    <tr>
<?php 

try {
    // Prepare and execute the query
    $sql = "SELECT amount FROM balance_sheet WHERE accounts = :account AND year = :year";
    $stmt = $pdoConnect->prepare($sql);
    $stmt->bindParam(':account', $currentasset);
    $stmt->bindParam(':year', $current_year);
    $stmt->execute();

    // Initialize sum variable
    $currentassetsum = 0;

    // Fetch each row and add its number to the sum
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $currentassetsum += $row['amount'];
    }

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

// Close the connection
$pdo = null;  
                        
    echo "<th>Subtotal</th>";
    echo "<th>₱ " . number_format((float)$currentassetsum, 2) . "</th>";
?>    
                    </tr>
                </tfoot>
                
            </table>
        
            <br >
            <h3>Long-term Assets</h3>
        
            <table class="responsive-table" style="table-layout: fixed;">
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody id="longtermasset">
                <?php
                $current_year = date("Y");
                $longtermasset = "Long-Term Assets";
                $pdoQuery = "SELECT * FROM balance_sheet WHERE accounts = :account  AND year = :year";
                $pdoResult = $pdoConnect->prepare($pdoQuery);
                $pdoResult->bindParam(':account', $longtermasset);
                $pdoResult->bindParam(':year', $current_year);
                $pdoExec = $pdoResult->execute();
                while ($row = $pdoResult->fetch(PDO::FETCH_ASSOC)){
                    extract($row);
                    echo "<tr>";
                    echo "<td>$sub_account</td>";
                    echo "<td>₱ " . number_format((float)$amount, 2) . "</td>";
                    echo "</tr>";
                }
                ?>
                </tbody>
                <tfoot id="longtermassettotal">
<?php 
$current_year = date("Y");
$longtermasset = "Long-Term Assets";

$sql = "SELECT amount FROM balance_sheet WHERE accounts = :account AND year = :year";

try {
    // Prepare and execute the query
    $stmt = $pdoConnect->prepare($sql);
    $stmt->bindParam(':account', $longtermasset);
    $stmt->bindParam(':year', $current_year);
    $stmt->execute();

    // Initialize sum variable
    $longtermassetsum = 0;

    // Fetch each row and add its number to the sum
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $longtermassetsum += $row['amount'];
    }

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

// Close the connection
$pdo = null;
                        
?>
                    <tr>
                        <th>Subtotal</th>
                        <th><?php echo "₱ " . number_format((float)$longtermassetsum, 2); ?></th>
                    </tr>
                </tfoot>
            </table>
            <br >
            <table class="responsive-table" style="table-layout: fixed;">
                <thead id="totalassets">
                    <?php
                    $totalassetsum = $currentassetsum + $longtermassetsum
                    ?>
                    <tr>
                        <th>Total Assets</th>
                        <th><?php echo "₱ " . number_format((float)$totalassetsum, 2); ?></th>
                    </tr>
                </thead>
            </table>
            <br >
            <br >
            
            <h3 style="text-align: center;">Liabilities</h3>
        
            <br >
            <br >
            <h3>Current Liabilities</h3>
        
            <table class="responsive-table" style="table-layout: fixed;">
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody id="currentliabilities">
                <?php
                $current_year = date("Y");
                $currentliabilities = "Current Liabilities";
                $pdoQuery = "SELECT * FROM balance_sheet WHERE accounts = :account AND year = :year";
                $pdoResult = $pdoConnect->prepare($pdoQuery);
                $pdoResult->bindParam(':account', $currentliabilities);
                $pdoResult->bindParam(':year', $current_year);
                $pdoExec = $pdoResult->execute();
                while ($row = $pdoResult->fetch(PDO::FETCH_ASSOC)){
                    extract($row);
                    echo "<tr>";
                    echo "<td>$sub_account</td>";
                    echo "<td>₱ " . number_format((float)$amount, 2) . "</td>";
                    echo "</tr>";
                }
                ?>
                </tbody>
                <tfoot id="currentliabilitiestotal">
                    <tr>
<?php 
$current_year = date("Y");
$currentliabilities = "Current Liabilities";

$sql = "SELECT amount FROM balance_sheet WHERE accounts = :account AND year = :year";

try {
    // Prepare and execute the query
    $stmt = $pdoConnect->prepare($sql);
    $stmt->bindParam(':account', $currentliabilities);
    $stmt->bindParam(':year', $current_year);
    $stmt->execute();

    // Initialize sum variable
    $currentliabiliteissum = 0;

    // Fetch each row and add its number to the sum
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $currentliabiliteissum += $row['amount'];
    }

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

// Close the connection
$pdo = null;
                        
?>
                    
                        <th>Subtotal</th>
                        <th><?php echo "₱ " . number_format((float)$currentliabiliteissum, 2); ?></th>
                    </tr>
                </tfoot>
            </table>
        
            <br >
            <h3>Long-term Liabilities</h3>
        
            <table class="responsive-table" style="table-layout: fixed;">
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody id="longtermliabilities">
                <?php
                $current_year = date("Y");
                $longtermliabilities = "Long-Term Liabilities";
                $pdoQuery = "SELECT * FROM balance_sheet WHERE accounts = :account AND year = :year";
                $pdoResult = $pdoConnect->prepare($pdoQuery);
                $pdoResult->bindParam(':account', $longtermliabilities);
                $pdoResult->bindParam(':year', $current_year);
                $pdoExec = $pdoResult->execute();
                while ($row = $pdoResult->fetch(PDO::FETCH_ASSOC)){
                    extract($row);
                    echo "<tr>";
                    echo "<td>$sub_account</td>";
                    echo "<td>₱ " . number_format((float)$amount, 2) . "</td>";
                    echo "</tr>";
                }
                ?>
                </tbody>
                <tfoot id="longtermliabilitiestotal">
                    <tr>
<?php 
$current_year = date("Y");
$longtermliabilities = "Long-Term Liabilities";
$sql = "SELECT amount FROM balance_sheet WHERE accounts = :account AND year = :year";

try {
    // Prepare and execute the query
    $stmt = $pdoConnect->prepare($sql);
    $stmt->bindParam(":account", $longtermliabilities);
    $stmt->bindParam(":year", $current_year);
    $stmt->execute();

    // Initialize sum variable
    $longtermliabilitiessum = 0;

    // Fetch each row and add its number to the sum
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $longtermliabilitiessum += $row['amount'];
    }

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

// Close the connection
$pdo = null;
                        
?>
                    
                        <th>Subtotal</th>
                        <th><?php echo "₱ " . number_format((float)$longtermliabilitiessum, 2); ?></th>
                    </tr>
                </tfoot>
            </table>
            <br >
            <table class="responsive-table" style="table-layout: fixed;">
                <thead id="totalliabilities">
                    <?php
                    $totalliabilitiessum = $currentliabiliteissum + $longtermliabilitiessum
                    ?>
                    <tr>
                        <th>Total Liabilities</th>
                        <th><?php echo "₱ " . number_format((float)$totalliabilitiessum, 2); ?></th>
                    </tr>
                </thead>
            </table>
            <br >
            <br >
        
            <h3 style="text-align: center;">Equity</h3>
        
            <br >
            <br >
            <h3>Stakeholder's Equity</h3>
        
            <table class="responsive-table" style="table-layout: fixed;">
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody id="equity">
                <?php
                $current_year = date("Y");
                $equity = "Equity";
                $pdoQuery = "SELECT * FROM balance_sheet WHERE accounts = :account AND year = :year";
                $pdoResult = $pdoConnect->prepare($pdoQuery);
                $pdoResult->bindParam(':account', $equity);
                $pdoResult->bindParam(':year', $current_year);
                $pdoExec = $pdoResult->execute();
                while ($row = $pdoResult->fetch(PDO::FETCH_ASSOC)){
                    extract($row);
                    echo "<tr>";
                    echo "<td>$sub_account</td>";
                    echo "<td>₱ " . number_format((float)$amount, 2) . "</td>";
                    echo "</tr>";
                }
                ?>
                </tbody>
                <tfoot id="totalequity">
                    <tr>
<?php 
$current_year = date("Y");
$equity = "Equity";

$sql = "SELECT amount FROM balance_sheet WHERE accounts = :account AND year = :year";

try {
    // Prepare and execute the query
    $stmt = $pdoConnect->prepare($sql);
    $stmt->bindParam(":account", $equity);
    $stmt->bindParam(":year", $current_year);
    $stmt->execute();
    // Initialize sum variable
    $equitysum = 0;

    // Fetch each row and add its number to the sum
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $equitysum += $row['amount'];
    }

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

// Close the connection
$pdo = null;
                        
?>
                    
                        <th>Total Equity</th>
                        <th><?php echo "₱ " . number_format((float)$equitysum, 2);?></th>
                    </tr>
                </tfoot>
            </table>
            <br >
            <table class="responsive-table" style="table-layout: fixed;">
                <thead id="liabilityequity">
                    <?php
                    $totalliabilitiesandequitysum =  $equitysum + $totalliabilitiessum
                    ?>
                    <tr>
                        <th>Total Liabilities and Equity</th>
                        <th><?php echo "₱ " . number_format((float)$totalliabilitiesandequitysum, 2); ?></th>
                    </tr>
                </thead>
            </table>
            <br >
        
        
        
            </div>
        
        </div>
    </div>
<!-----------------Update Account---------------------->
    <div class="tab-pane fade" id="update">
    <div class="card--container2">
        <h3>Add New Account</h3>
        <form class="update" method="post" action="Update_Account.php">
        <div class="form-group">
        <label for="Acc">Account:</label>
            <select name="Acc" id="Acc" required>
                <option value="Current Assets">Current Assets</option>
                <option value="Long-Term Assets">Long-Term Assets</option>
                <option value="Current Liabilities">Current Liabilities</option>
                <option value="Long-Term Liabilities">Long-Term Liabilities</option>
                <option value="Equity">Equity</option>
            </select>
        </div>
        <div class="form-group">
        <label for="Sub">Sub Account:</label>
            <select name="Sub" id="Sub" required>

            </select>
        </div>
        <div class="form-group">
        <label for="Payment">Form of Payment:</label>
            <select name="Payment" id="Payment" required>
            <option value="On Cash">On Cash</option>
            <option value="On Credit">On Credit</option>
            </select>
        </div>
        <div class="form-group">
        <label for="Flow">Flow:</label>
            <select name="Flow" id="Flow" required>
            <option value="Increase">Increase</option>
            <option value="Decrease">Decrease</option>
            </select>
        </div>
        Amount: 
        <input type="number" name="Amount" required placeholder="00.00"><br>
        <input type="submit" name="insert" value="Add"  ><br>
        </form>

    <script>
        /*----------------Sub-Account------------------*/

    // Function to update the options in the Description dropdown based on the selected Account
    function updateAccountOptions() {
        var accountDropdown = document.getElementById("Acc");
        var SubDropdown = document.getElementById("Sub");
        var paymentDropdown  = document.getElementById("Payment");
        var flowDropdown  = document.getElementById("Flow");
        
        // Clear existing options
        SubDropdown.innerHTML = "";
        paymentDropdown.innerHTML = "";
        flowDropdown.innerHTML = "";

        // Get selected account
        var selectedAccount = accountDropdown.value;

        // Define options based on selected account
        var options = [];
        var paymentOptions = [];
        var flowOptions = [];

        // Add options based on selected account
        if (selectedAccount === "Current Assets") {
            var options = ["Cash", "Accounts Receivable", "Inventory", "Investments"];
            paymentOptions = ["On Cash", "On Credit"];
            flowOptions = ["Increase","Decrease"];
        } else if (selectedAccount === "Long-Term Assets") {
            var options = ["Land", "Buildings", "Equipment"];
            paymentOptions = ["On Cash", "On Credit"];
            flowOptions = ["Increase","Decrease"];
        } else if (selectedAccount === "Current Liabilities") {
            var options = ["Accounts Payable", "Tax", "Notes Payable", "Expenditure Liabilities"];
            paymentOptions = ["On Cash"];
            flowOptions = ["Decrease"];
        } else if (selectedAccount === "Long-Term Liabilities") {
            var options = ["Bonds Payable", "Loans Payable", "Pensions"];
            paymentOptions = ["On Cash"];
            flowOptions = ["Increase","Decrease"];
        } else if (selectedAccount === "Equity") {
            var options = ["Equity Capital", "Retained Earnings"];
            paymentOptions = ["On Cash"];
            flowOptions = ["Increase","Decrease"];
        }

        // Add options to the Description dropdown
        for (var i = 0; i < options.length; i++) {
            var option = document.createElement("option");
            option.text = options[i];
            option.value = options[i];
            SubDropdown.add(option);
        }

        // Add options to the Payment dropdown
        for (var i = 0; i < paymentOptions.length; i++) {
            var option = document.createElement("option");
            option.text = paymentOptions[i];
            option.value = paymentOptions[i];
            paymentDropdown.add(option);
        }
        
        for (var i = 0; i < flowOptions.length; i++) {
            var option = document.createElement("option");
            option.text = flowOptions[i];
            option.value = flowOptions[i];
            flowDropdown.add(option);
        }
    }

    


    // Call the function when the Account dropdown value changes
    document.getElementById("Acc").addEventListener("change", updateAccountOptions);
    

    // Call the function initially to set the options based on the default selected account
    updateAccountOptions();
    

    function updateSubOptions() {
        var SubDropdown = document.getElementById("Sub");
        var paymentDropdown  = document.getElementById("Payment");
        var flowDropdown  = document.getElementById("Flow");
        
        // Clear existing options
        paymentDropdown.innerHTML = "";
        flowDropdown.innerHTML = "";

        // Get selected account
        var selectedAccount = SubDropdown.value;
        var selected1Account = flowDropdown.value;

        // Define options based on selected account
        var paymentOptions = [];
        var flowOptions = [];

        // Add options based on selected account
        if (selectedAccount === "Cash") {
            paymentOptions = ["On Cash", "On Credit"];
            flowOptions = ["Increase","Decrease"];

        } else if (selectedAccount === "Accounts Receivable") {
            paymentOptions = ["On Cash"];
            flowOptions = ["Decrease"];

        } else if (selectedAccount === "Inventory") {
            paymentOptions = ["On Cash", "On Credit"];
            flowOptions = ["Increase","Decrease"];

        } else if (selectedAccount === "Investments") {
            paymentOptions = ["On Cash"];
            flowOptions = ["Increase","Decrease"];  

        } else if (selectedAccount === "Land" || selectedAccount === "Buildings" || selectedAccount === "Equipment") {
            paymentOptions = ["On Cash", "On Credit"];
            flowOptions = ["Increase","Decrease"];
        } else if (selectedAccount === "Accounts Payable" || selectedAccount === "Tax" || selectedAccount === "Notes Payable" || selectedAccount === "Expenditure Liabilities") {
            paymentOptions = ["On Cash"];
            flowOptions = ["Decrease"];
        } else if (selectedAccount === "Bonds Payable" || selectedAccount === "Loans Payable" || selectedAccount === "Pensions") {
            paymentOptions = ["On Cash"];
            flowOptions = ["Increase","Decrease"];
        } else if (selectedAccount === "Equity Capital" || selectedAccount === "Retained Earnings") {
            paymentOptions = ["On Cash"];
            flowOptions = ["Increase","Decrease"];
        }
//        } else if (selectedAccount === "Land" || selectedAccount === "Buildings" ||selectedAccount === "Equipment") {
//            paymentOptions = ["On Cash", "On Credit"];
//            flowOptions = ["Increase","Decrease"];
//        } 




        // Add options to the Payment dropdown
        for (var i = 0; i < paymentOptions.length; i++) {
            var option = document.createElement("option");
            option.text = paymentOptions[i];
            option.value = paymentOptions[i];
            paymentDropdown.add(option);
        }
        
        for (var i = 0; i < flowOptions.length; i++) {
            var option = document.createElement("option");
            option.text = flowOptions[i];
            option.value = flowOptions[i];
            flowDropdown.add(option);
        }
    }

    document.getElementById("Sub").addEventListener("change", updateSubOptions);
    updateSubOptions();

    </script>
    </div>
    </div>
<!-----------------Financial Request---------------------->
    <div class="tab-pane fade" id="financialrequest">
        <div class="card--container2"> 

        <div class="todaysreport">
            <div class="title-card3"><h3>Financial Request </h3></div>
            <table class="responsive-table" >
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Department</th>
                        <th>Description</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Response</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $pdoLedgerQuery = "SELECT * FROM financial_request ORDER BY `id` DESC ";
                $pdoResult = $pdoConnect->prepare($pdoLedgerQuery);
                $pdoExec = $pdoResult->execute();
                while ($row = $pdoResult->fetch(PDO::FETCH_ASSOC)){
                    extract($row);
                    echo "<tr>";
                    echo "<td>$date</td>";
                    echo "<td>$time</td>";
                    echo "<td>$department</td>";
                    echo "<td>$description</td>";
                    echo "<td>₱ " . number_format((float)$amount, 2) . "</td>";
                    echo "<td>$status</td>";
                    
                    if ($status == "Pending") {
                        echo "<td><a href='approved_request.php?id=$id' ><button class='approve' name='insert' onsubmit='return confirmSubmit();'>Approve</button></a>
                                    <a href='declined_request.php?id=$id' ><button class='decline'>Decline</button></a></td>";
                    } else {
                        echo "<td>No action available</td>";
                    }
                    echo "</tr>";
                }
                ?>
                </tbody>
            </table>
<script>
function confirmSubmit() {
    return confirm("Are you sure you want to submit the form?");}
</script>

<!--            <form class="request" method="post" action="approved_request.php" onsubmit="return confirmSubmit();"></form>-->
            </form>
            </div>
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



</body>
</html>