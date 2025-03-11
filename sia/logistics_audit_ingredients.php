<?php
include_once("connections/connection.php");
$pdo = connection();

$records_per_page = 10; // Number of records to show per page

// Retrieve the current page number
if (!isset($_GET['page']) || !is_numeric($_GET['page'])) {
    $page = 1;
} else {
    $page = intval($_GET['page']);
}

// Calculate the limit for the SQL query
$limit_start = ($page - 1) * $records_per_page;

$search_date_created = isset($_POST['search_date_created']) ? $_POST['search_date_created'] : '';

// Prepare the SQL query
if (!empty($search_date_created)) {
    $sql = "SELECT * FROM materials WHERE DATE(date) = :search_date_created LIMIT :limit_start, :records_per_page";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':search_date_created', $search_date_created, PDO::PARAM_STR);
} else {
    $sql = "SELECT * FROM materials LIMIT :limit_start, :records_per_page";
    $stmt = $pdo->prepare($sql);
}
$stmt->bindParam(':limit_start', $limit_start, PDO::PARAM_INT);
$stmt->bindParam(':records_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
$dbs = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Count total number of records
if (!empty($search_date_created)) {
    $stmt = $pdo->prepare("SELECT COUNT(*) as total_records FROM materials WHERE DATE(date) = :search_date_created");
    $stmt->bindParam(':search_date_created', $search_date_created, PDO::PARAM_STR);
} else {
    $stmt = $pdo->prepare("SELECT COUNT(*) as total_records FROM materials");
}
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$total_records = $result['total_records'];

$total_pages = ceil($total_records / $records_per_page);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Logistics & Manufacturing </title>
    <link rel="stylesheet" href="css/logistics.css">
    <link rel="stylesheet" href="css/style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script src="js/sia.js"></script>
    <script src="js/totalproduct.js"></script>
</head>

<body>
<nav class="sidebar close">
<header>
    <div class="image-text">
    <span class="image">
    <img src="/3GENPHARMA/img/logo.png" alt="logo">
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
                    <a href="/3GENPHARMA/sia/logistics.php" class="snavoption-text">Logistics & Manufacturing </a>
                </li>
                <li class="sidenavoption">
                    <a href="/3GENPHARMA/Warehouse/index.php" class="snavoption-text">Warehouse Management</a>
                </li>
                <li class="sidenavoption">
                    <a href="/3GENPHARMA/Supply/index.php" class="snavoption-text">Supply Chain</a>
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
        <h1> <i class='bx bx-group icon'>&nbsp</i> Logistics & Manufacturing </h1> 
        <h2><i class='bx bxs-user usericon'>&nbsp</i> Super Admin </h2>  
    </div>

    <div class="dropdown1">
        <span class="inventory"> OPTION ></span>
        <div class="dropdown-content1" id="myDropdown1">
            <a class="content1" href="logistics.php">Audit</a>
            <a class="content1" href="logistics_medicine.php">Add Medicine</a>
            <a class="content1" href="logistics_materials.php">Add Ingredients</a>
            <a class="content1" href="logistics_receive_order.php">Order</a>
        </div>
    </div>

    <div class="dropdown1">
        <span class="inventory1"> AUDIT ></span>
        <div class="dropdown-content2" id="myDropdown1">
            <a class="content2" href="logistics.php">Audit Medicine</a>
            <a class="content2" href="logistics_audit_ingredients.php">Audit Ingredients</a>
        </div>
    </div>
    <br>
    <div class="table-container1">
        <h1 class="header-container1">AUDIT INGREDIENT </h1>
        
        <div class="add-container1">
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <input type="text" id="search_date_created" name="search_date_created" placeholder="Select date">
                <button type="submit" name="search_button" class="add-button2">Search</button>
            </form>
            
        </div>
        <table class="table-materials">
            <thead>
                <tr>
                    <th>Batch Number</th>
                    <th>Ingredient</th>
                    <th>Quantity</th>
                    <th>Time</th>
                    <th>Date</th>
                    <th>Expiry Date</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($dbs as $mRow){ ?>
                <tr data-material-id="<?= $mRow['id']; ?>">
                    <td><?= $mRow['id'];?></td>
                    <td><?= $mRow['material'];?></td>
                    <td><?= $mRow['quantity'];?></td>
                    <td><?= date('H:i:s', strtotime($mRow['date'])); ?></td>
                    <td><?= date('Y-m-d', strtotime($mRow['date']));?></td>
                    <td><?= $mRow['expiry_date'];?></td>
                </tr>
            <?php }?>
            </tbody>
        </table>

        <div class="pagination-container">
            <ul class="pagination">
                <!-- Previous page link -->
                <li><a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?page=<?php echo ($page > 1) ? $page - 1 : 1; ?>">&laquo;</a></li>
                <!-- Page links -->
                <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                    <li><a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                <?php endfor; ?>
                <!-- Next page link -->
                <li><a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?page=<?php echo ($page < $total_pages) ? $page + 1 : $total_pages; ?>">&raquo;</a></li>
            </ul>
        </div>
        <br>
        <div class="custom-modal">
<!----- INPUT CODE HERE 🙂 ----->
<button id="myBtn">Request Finance</button>

<!-- The Modal -->
<div id="myModal" class="modal">
<!-- Modal content -->
<div class="modal-content">
    <div class="modal-header">
        <span class="close">&times;</span>
        <h3>Make a Financial Request?</h3>
    </div>
    <br />
    <div class="modal-body">
        <div class="flex-child" id="form">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" onsubmit="return confirmSubmit();">
                <div class="form-group">
                    <label for="dept">Department:</label>
                    <select name="dept" id="dept" required>
                        <option value="Logistics and Manufacturing">Logistics and Manufacturing</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="desc">Description:</label>
                    <select name="desc" id="desc" required>
                        <option value="Ingredients">Ingredients</option>
                        <option value="Imported Medicine">Imported Medicine</option>
                        <option value="Manufacturing Expenses">Manufacturing Expenses</option>
                        <option value="Food Allowance">Food Allowance</option>
                    </select>
                </div>
                <label for="desc">Amount:</label>
                <input type="number" name="Amount" required placeholder="00.00" step="any"><br>
                <input type="submit" name="insert" value="Request"><br>
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
                                    (date, time, department, description, amount, status) 
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
            <table>
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

                    $pdoLedgerQuery = "SELECT * FROM financial_request WHERE department = 'Logistics and Manufacturing'";
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
        <a href=""><h6>Need some help?</h6></a>
    </div>
</div>


</div>
<script>
// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
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
</script>
        </div>
        <br>

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

/*---------------flatpicker-------------*/
document.addEventListener("DOMContentLoaded", function() {
    flatpickr("#search_date_created", {
        dateFormat: "Y-m-d", // Specify the date format
    });
});
/*---------------flatpicker-------------*/

</script>
</body>
</html>
