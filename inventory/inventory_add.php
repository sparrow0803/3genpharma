<?php
include_once("connection/connection.php");
$pdo = connection();

            if ($_SERVER["REQUEST_METHOD"] == "POST") {

                $itemCategory = htmlspecialchars($_POST['itemCategory']);
                $itemName = htmlspecialchars($_POST['itemName']);
                $itemDescription = htmlspecialchars($_POST['itemDescription']);
                $itemQuantity = intval($_POST['itemQuantity']);
                $itemPrice = htmlspecialchars($_POST['itemPrice']);

                $stmt = $pdo->prepare("SELECT * FROM inventory WHERE category=:itemCategory AND description=:itemDescription AND product_name = :itemName");
                $stmt->bindParam(':itemCategory', $itemCategory);
                $stmt->bindParam(':itemName', $itemName);
                $stmt->bindParam(':itemDescription', $itemDescription);
                $stmt->execute();
        
                if ($stmt->rowCount() > 0) {

                    $sql_update = "UPDATE inventory SET quantity = quantity + :itemQuantity WHERE product_name = :itemName";
                    $stmt = $pdo->prepare($sql_update);
                    $stmt->bindParam(':itemQuantity', $itemQuantity);
                    $stmt->bindParam(':itemName', $itemName);
                    $stmt->execute();

                } else {
                   
                    $sql_insert = "INSERT INTO inventory (category, product_name, description, quantity, price) VALUES (:itemCategory, :itemName, :itemDescription, :itemQuantity, :itemPrice)";
                    $stmt = $pdo->prepare($sql_insert);
                    $stmt->bindParam(':itemCategory', $itemCategory);
                    $stmt->bindParam(':itemName', $itemName);
                    $stmt->bindParam(':itemDescription', $itemDescription);
                    $stmt->bindParam(':itemQuantity', $itemQuantity);
                    $stmt->bindParam(':itemPrice', $itemPrice);
                    $stmt->execute();  
                }

                try {
                    
                    $pdoConnect = new PDO("mysql:host=localhost;dbname=finance_dept","root","");
                    $pdoConnect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    $itemPrice = htmlspecialchars($_POST['itemPrice']);
                    $itemQuantity = intval($_POST['itemQuantity']);

                    $sub = 'Inventory';
                    $amount = $itemPrice * $itemQuantity;
                    $sub2 = 'Cash';
                    $desc = 'Inventory Purchased';
                    $information = 'Inventory Purchased';
                    $debit = $amount;
                    $crebit = '0';
                    $type = 'Purchases'; 
                    $flow = 'Increase';        
            
            //---------------------------------Balance Sheet------------------------------------------//
            
                    // Prepare and execute the query to update the account
                    
                    $updateQuery1 = "UPDATE balance_sheet SET Amount = Amount + :amount WHERE sub_account = :sub";
                    $stmt = $pdoConnect->prepare($updateQuery1);
                    $stmt->bindParam(':amount', $amount);
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
            
                    // Set a session variable to indicate successful update
                    $_SESSION['update_success'] = true;
            
                    // Redirect to the same page to prevent form resubmission
                    header("location: inventory.php");
                    exit();
                } catch (PDOException $e) {
                    // Handle database errors
                    echo "Error: " . $e->getMessage();
                    exit(); // Exit after handling the error
                }

            }
    
        ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/inventory.css">
    <title>Add Items</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel="stylesheet">
</head>
<body>

<nav class="sidebar close">
<header>
    <div class="image-text">
    <span class="image">
    <img src="../img/logo.png" alt="logo">
    </span>
    </div>
    <i class='bx bx-menu toggle'></i>
</header>

<div class="menu-bar">
  <div class="menu">
            <li class="nav-link"> 
                <a href="/3GENpharma/BI/dashboard.php">
                <i class='bx bx-home-alt icon' ></i>
                <span class="text nav-text"> Dashboard </span>
                </a>
            </li>
            <li class="nav-link"> 
                <a href="/3GENPHARMA/HR/employee.php">
                <i class='bx bx-group icon' ></i>
                <span class="text nav-text"> Employees </span>
                </a>
            </li>
            <li class="nav-link"> 
                <a href="/3genpharma/crm/customer.php">
                <i class='bx bx-user-pin icon' ></i>
                <span class="text nav-text"> Customers </span>
                </a> 
            </li>
            <li class="nav-link"> 
                <a href="/3GENpharma/accounting/reports.php">
                <i class='bx bxs-book icon' ></i>
                <span class="text nav-text"> Reports </span>
                </a> 
            </li>
            <li class="nav-link"> 
                <a href="/3genpharma/inventory/inventory.php">
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
                    <a href="/3genpharma/sia/logistics.php" class="snavoption-text">Logistics & Manufacturing </a>
                </li>
                <li class="sidenavoption">
                    <a href="/3genpharma/Warehouse/index.php" class="snavoption-text">Warehouse Management</a>
                </li>
                <li class="sidenavoption">
                    <a href="/3genpharma/Supply/index.php" class="snavoption-text">Supply Chain</a>
                </li>
            </ul>
        </div>      
  </div>
      <div class="bottom-content">
        <hr style="height:1px;opacity:40%;border-width:0;background-color:#FFD041;">
      <li class="nav-link"> 
      <a href="logout.php">
      <i class='bx bx-log-out icon' ></i>
      <span class="text nav-text"> Logout </span>
      </a>
      </li>
      </div>
      </ul>
    </div>    
</nav>

<section class="home">
    <div class="userheader"> 
        <h1> <i class='bx bx-group icon'>&nbsp</i> Inventory </h1> 
        <h2><i class='bx bxs-user usericon'>&nbsp</i> Super Admin </h2>  
    </div>
<div class="box0">
    <h2>Add items</h2>
    <div class="outbox">
<form method="post" action="" id="addItemForm">
<div>
    <label for="itemCategory">Category:</label><br>
    <input class="boxxx" type="text" id="itemCategory" name="itemCategory" list="categories" required>
    <datalist id="categories">
        <option value="Analgesics">
        <option value="Antacids">
        <option value="Antianxiety Drugs">
        <option value="Antiarrhythmics">
        <option value="Antibacterials">
        <option value="Antibiotics">
        <option value="Anticoagulants and Thrombolytics">
        <option value="Anticonvulsants">
        <option value="Antidepressants">
        <option value="Antidiarrheals">
        <option value="Antiemetics">
        <option value="Antifungals">
        <option value="Antihistamines">
        <option value="Antihypertensives">
        <option value="Anti-Inflammatories">
        <option value="Antineoplastics">
        <option value="Antipsychotics">
        <option value="Antipyretics">
        <option value="Antivirals">
        <option value="Barbiturates">
        <option value="Beta-Blockers">
        <option value="Bronchodilators">
        <option value="Cold Cures">
        <option value="Corticosteroids">
        <option value="Cough Suppressants">
        <option value="Cytotoxics">
        <option value="Decongestants">
        <option value="Diuretics">
        <option value="Expectoran">
        <option value="Hormones">
        <option value="Hypoglycemics (Oral">
        <option value="Immunosuppressives">
        <option value="Laxatives">
        <option value="Muscle Relaxants">
        <option value="Sedatives">
        <option value="Sex Hormones (Female)">
        <option value="Sex Hormones (Male)">
        <option value="Sleeping Drugs">
        <option value="Tranquilizer">
        <option value="Vitamins">
    </datalist>
</div>
        <div>
        <label for="itemName">Name:</label><br>
        <input class="boxx" type="text" id="itemName" name="itemName" required>
        <div>
            <br>
        <label for="itemDescription">Description:</label><br>   
        <textarea class="boxx" id="itemDescription" name="itemDescription" required></textarea>
        <div>
            <br>
        <label for="itemQuantity">Quantity:</label><br>
        <input class="boxx" type="number" id="itemQuantity" name="itemQuantity" min="1" required>
        </div>
        <div>
            <br>
        <label for="itemQuantity">Price:</label><br>
        <input class="boxx" type="number" id="itemPrice" name="itemPrice" min="1" required>
        </div>
        </div>
        </div>
        <br>
        </div>
    <div class="but">
<button class="buts" type="submit">Add Products</button>
<button class="buts" type="button" onclick="document.location='inventory.php'">Cancel</button>
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
document.getElementById('itemCategory').addEventListener('blur', function() {
    var input = this.value;
    var options = document.getElementById('categories').getElementsByTagName('option');
    var valid = false;
    for (var i = 0; i < options.length; i++) {
        var option = options[i];
        if (option.value.toLowerCase() === input.toLowerCase()) {
            valid = true;
            break;
        }
    }
    if (!valid) {
        alert('Please select a category from the list.');
        this.value = '';
    }
});
</script>

</body>
</html>