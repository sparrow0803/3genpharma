<?php
include_once("connection/connection.php");
$pdo = connection();

$sql = "SELECT * FROM inventory";
$stmt = $pdo->query($sql);
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sum = "SELECT SUM(quantity) As value_total FROM inventory";
$stmts = $pdo->query($sum);
$total = $stmts->fetchAll(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> INVENTORY </title>
    <link rel="icon" href="./img/logo_icon.png" type="image/png">
    <link rel="stylesheet" href="styles/inventory.css">
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
        <h1> <i class='bx bx-package icon'>&nbsp</i> INVENTORY </h1> 
        <h2><i class='bx bxs-user usericon'>&nbsp</i> Super Admin </h2>  
    </div>

<div class="ordered">
<div class="dropdown">
        <i class='bx bx-bell notification-icon'></i>
        <label id="notificationCount" class="notification-count"></label>
            <div id="notificationDropdown" class="dropdown-content">
            <div>Loading...</div>
            </div>
        </div>
<button class="btn btn-primary" type="button" onclick="document.location='inventory_add.php'"><i class='bx bx-package icon'>&nbsp</i>Add Items</button>
    <button class="btn btn-primary" type="button"   onclick="document.location='order.php'"><i class='bx bx-cart icon'>&nbsp</i>Order Items</button>
    <button class="btn btn-primary" type="button" id="myBtn">Request Finance</button>

</div>


<!-- The Modal -->
<div id="myModal" class="modal">

    <!-- Modal content -->
    <div class="modal-content">
    
        <div class="modal-header">
            <span class="close">&times;</span>
            <h3>Make a Financial Request?</h3> 
        </div>
        <br>
        <div class="modal-body">
        <div class="flex-child" id="form">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" onsubmit="return confirmSubmit();">
            <div class="form-group">
            <label for="dept">Department:</label>
                <select name="dept" id="dept" required>
                    <option value="Inventory">Inventory</option>
                </select>
            <label for="desc">Description:</label>
                <select name="desc" id="desc" required>
                <option value="Food Allowance">Food Allowance</option>
                </select>
            </div>
            <label for="desc">Amount:</label>
            <input type="number" name="Amount" required placeholder="00.00" step="any"><br>
            <input type="submit" name="insert" value="Request"  ><br>
            </form>
        </div>
    
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Check if the form fields are set and not empty
        if (isset($_POST['dept']) && isset($_POST['desc']) && isset($_POST['Amount'])) {
            $pdoConnect = new PDO("mysql:host=localhost;dbname=finance_dept","root","");
            $pdoConnect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
            // Get the form data
            date_default_timezone_set('Asia/Manila');
            $date = date('Y-m-d');
            $time = date('H:i:s');
    
            $dept = $_POST['dept'];
            $desc = $_POST['desc'];
            $amount = $_POST['Amount'];
            $status = 'Pending';
    
            $insertQuery = "INSERT INTO financial_request 
                            (`date`, `time`, `department`, `description`, `amount`, `status`) 
                            VALUES (:date, :time, :department, :description, :amount, :status)";
            $stmt = $pdoConnect->prepare($insertQuery);
            $stmt->bindParam(':date', $date, PDO::PARAM_STR);
            $stmt->bindParam(':time', $time, PDO::PARAM_STR);
            $stmt->bindParam(':department', $dept);
            $stmt->bindParam(':description', $desc);
            $stmt->bindParam(':amount', $amount);
            $stmt->bindParam(':status', $status);
            $stmt->execute();
        }
    }
    ?>
    
        <div class="flex-child" id="table">
            <h3>History</h3>
        <table class = "tablee">
        <thead>
                        <tr>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Department</th>
                            <th>Description</th>
                            <th>Amount</th>
                            <th>Status</th>
                        </tr>
        </thead>
        <tbody>
        <?php
                    $pdoConnect = new PDO("mysql:host=localhost;dbname=finance_dept","root","");
                    $pdoConnect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
                    $pdoLedgerQuery = "SELECT * FROM financial_request WHERE department = 'Inventory'";
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
                        echo "</tr>";
                    }
        ?>
        </tbody>
        </table>
        </div>
         
        </div>
            <br />
        <div class="modal-footer">
            <a href="#"><h6>Need some help?</h6></a>
        </div>
    
    
        
    </div>
    
    </div>
    </div>




<div class="card--container">
    <div class="card--wrapper">
        <div class="pharma--card">
            <div class="card--header">
            <div class="pharma">
            <span class="card--detail"> <?php foreach ($total as $totals){ ?>
            <?=$totals['value_total'];?>
             <?php }?> </span>
            <span class="title"> Total Items Available</span><br>
            </div>
            </div>
        </div>
        <div class="pharma--card">
            <div class="card--header">
            <div class="pharma">
            <span class="card--detail"> <td><?php 
            $sqls = "SELECT * FROM inventory";
             $stmts = $pdo->query($sqls);
             $rowCount = $stmts->rowCount();
            echo $rowCount?></td> </span>
            <span class="title"> Total Produts</span><br>
            </div>
            </div>
        </div>
</div>
    </div>
<div class="box2">
<div class="search-container">
    <input type="text" id="searchInput" placeholder="Search..." style="font-size: 16px;">
    <button onclick="searchTable()"><i class='bx bx-search icon'>&nbsp</i>Search</button>
    <button onclick="clearSearch()"><i class='bx bx-x-circle icon'>&nbsp</i>Clear</button>
</div>
    <table class="table1">
        <thead>
            <tr>
                <th>Category</th>
                <th>Product Name</th>
                <th>Description</th>
                <th style="width:10%">Quantity</th>
                <th style="width:10%">Price</th>
                <th style="width:10%">Actions</th> <!-- New header for actions -->
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $row){ ?>
                <tr>
                    <td><?= $row['category'];?></td>
                    <td><?= $row['product_name'];?></td>
                    <td><?= $row['description'];?></td>
                    <td><?= $row['quantity'];?></td>
                    <td><?= $row['price'];?></td>
                    <td>
                        <!-- Delete button -->
                        <form method="POST" action="delete.php"> <!-- Change action to your delete script -->
                            <input type="hidden" name="product_id" value="<?= $row['product_Id'];?>">
                            <button type="submit" class="delete-btn">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php }?>
        </tbody>
    </table>
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

function searchTable() {
    var input, filter, table, tr, td, i, j, txtValue;
    input = document.getElementById("searchInput");
    filter = input.value.toUpperCase();
    table = document.querySelector(".table1");
    tr = table.getElementsByTagName("tr");

    for (i = 0; i < tr.length; i++) {
        var found = false;
        for (j = 0; j < tr[i].getElementsByTagName("td").length; j++) {
            td = tr[i].getElementsByTagName("td")[j];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    found = true;
                    break;
                }
            }
        }
        if (found || tr[i].getElementsByTagName("th").length > 0) {
            tr[i].style.display = "";
        } else {
            tr[i].style.display = "none";
        }
    }
}
function clearSearch() {
    var input, filter, table, tr, i;
    input = document.getElementById("searchInput");
    input.value = "";
    table = document.querySelector(".table1");
    tr = table.getElementsByTagName("tr");

 
    for (i = 0; i < tr.length; i++) {
        tr[i].style.display = "";
    }
}
</script>

<script>

function confirmSubmit() {
    return confirm("Are you sure you want to submit the form?");
}

// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[1];

// When the user clicks on the button, open the modal
btn.onclick = function() {
modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
if (event.target == modal) {
modal.style.display = "none";
}
}


document.addEventListener("DOMContentLoaded", function() {
    const notificationIcon = document.querySelector('.notification-icon');
    const dropdown = document.getElementById('notificationDropdown');
    let dropdownOpen = false;

    // Event listener for bell icon and notification count badge
    notificationIcon.addEventListener("mouseenter", function() {
        dropdown.style.display = 'block';
        dropdownOpen = true;
    });

    // Event listener to toggle dropdown on click
    notificationIcon.addEventListener("click", function() {
        dropdown.style.display = dropdownOpen ? 'none' : 'block';
        dropdownOpen = !dropdownOpen;
    });

    // Fetch low stock data
    fetch('lownotif.php')
    .then(response => response.json())
    .then(data => {
        const notificationCount = document.getElementById('notificationCount');
        dropdown.innerHTML = '';

        if (data.lowStock.length === 0) {
            dropdown.innerHTML = '<div>No notifications</div>';
            notificationCount.style.display = 'none';
        } else {
            dropdown.innerHTML += '<div><strong>Low Stock Products:</strong></div>';
            data.lowStock.forEach(product => {
                dropdown.innerHTML += `<div>${product.category} ${product.product_name} (Remaining Stock: ${product.quantity})</div>`;
            });
            notificationCount.textContent = data.lowStock.length;
            notificationCount.style.display = 'inline-block';
        }
    })
    .catch(error => {
        console.error('Error fetching data:', error);
        dropdown.innerHTML = '<div>Error loading notifications</div>';
        notificationCount.style.display = 'none';
    });
});
</script>

</body>
</html>