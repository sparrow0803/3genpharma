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

try {
    // Prepare the SQL query
    if (!empty($search_date_created)) {
        $stmt = $pdo->prepare("SELECT * FROM genpharma.warehouse WHERE DATE(date_created) = :search_date_created LIMIT :limit_start, :records_per_page");
        $stmt->bindParam(':search_date_created', $search_date_created, PDO::PARAM_STR);
    } else {
        $stmt = $pdo->prepare("SELECT * FROM genpharma.warehouse LIMIT :limit_start, :records_per_page");
    }
    $stmt->bindParam(':limit_start', $limit_start, PDO::PARAM_INT);
    $stmt->bindParam(':records_per_page', $records_per_page, PDO::PARAM_INT);
    $stmt->execute();
    $medicines = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Count total number of records
    if (!empty($search_date_created)) {
        $stmt_count = $pdo->prepare("SELECT COUNT(*) as total_records FROM genpharma.warehouse WHERE DATE(date_created) = :search_date_created");
        $stmt_count->bindParam(':search_date_created', $search_date_created, PDO::PARAM_STR);
    } else {
        $stmt_count = $pdo->prepare("SELECT COUNT(*) as total_records FROM genpharma.warehouse");
    }
    $stmt_count->execute();
    $result = $stmt_count->fetch(PDO::FETCH_ASSOC);
    $total_records = $result['total_records'];

    $total_pages = ceil($total_records / $records_per_page);

    $uniqueMedicines = array();

foreach ($medicines as $med) {
    $medicineName = $med['medicine_name'];
    $quantity = $med['quantity'];
    $sent = $med['sent'];
    
  
    if ($sent == 0) {
        if (!isset($uniqueMedicines[$medicineName])) {
            $uniqueMedicines[$medicineName] = $quantity;
        } else {
            $uniqueMedicines[$medicineName] += $quantity;
        }
    }
}


foreach ($uniqueMedicines as $medicineName => $totalQuantity) {
    $stmt_check_sent = $pdo->prepare("SELECT COUNT(*) as count_sent FROM warehouse WHERE medicine_name = :medicine_name AND sent = 0");
    $stmt_check_sent->execute(['medicine_name' => $medicineName]);
    $row = $stmt_check_sent->fetch(PDO::FETCH_ASSOC);
    $count_sent = $row['count_sent'];
    if ($count_sent == 0) {
        $uniqueMedicines[$medicineName] = 0;
    }
}

if (isset($_POST['remove_button'])) { 
    foreach ($uniqueMedicines as $medicineName => $total) {
        $stmt = $pdo->prepare("SELECT * FROM supply WHERE medicine_name = :medicine_name");
        $stmt->execute(['medicine_name' => $medicineName]);
        $existingMedicine = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existingMedicine) {
            $stmt = $pdo->prepare("UPDATE supply SET total = total + :total WHERE medicine_name = :medicine_name");
            $stmt->execute(['total' => $total, 'medicine_name' => $medicineName]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO supply (medicine_name, total) VALUES (:medicine_name, :total)");
            $stmt->execute(['medicine_name' => $medicineName, 'total' => $total]);
        }

        $stmt_update_sent = $pdo->prepare("UPDATE warehouse SET sent = 1 WHERE medicine_name = :medicine_name");
        $stmt_update_sent->execute(['medicine_name' => $medicineName]);
    }

    

}

    
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warehouse Management</title>
    <link rel="stylesheet" href="css/logistics.css">
    <link rel="stylesheet" href="css/style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        /* Style for SORT dropdown */
        .dropdown1 {
            position: relative;
            display: inline-block;
            margin-right: 20px;
        }

        .inventory2 {
            font-size: 16px;
            font-weight: bold;
            color: #333;
            cursor: pointer;
        }

        .dropdown-content3 {
            display: none;
            position: absolute;
            background-color: #001f3f; /* Navy blue */
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
            padding: 5px 0;
            border-radius: 5px;
            color: #fff; /* White text */
        }

        .dropdown-content3 a {
            color: #fff; /* White text */
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content3 a:hover {
            background-color: #ddd;
        }

        .dropdown1:hover .dropdown-content3 {
            display: block;
        }

        /* Style for Update Status button */
        .btn-primary {
            background-color: #001f3f; /* Navy blue */
            color: #fff;
            border: none;
            padding: 8px 16px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 4px;
        }

        .btn-primary:hover {
            background-color: #0056b3; /* Darker shade of navy blue */
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
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
        <h1> <i class='bx bx-group icon'>&nbsp</i> Warehouse Management </h1> 
        <h2><i class='bx bxs-user usericon'>&nbsp</i> Super Admin </h2>  
    </div>

    
   
 <div class="table-container1">  
        <h1 class="header-container">MEDICINES SUMMARY</h1>
        <table class="table-materials">
            <thead>
                <tr>
                    <th style="width:60%">Medicine</th>
                    <th style="width:30%">Total Quantity</th>
                    <th style="width:6%;">Action</th>
                </tr>
            </thead>
            <tbody>
            
    <?php foreach ($uniqueMedicines as $medicineName => $totalQuantity): ?>
        <tr>
            <td ><?= $medicineName; ?></td>
            <td ><?= $totalQuantity; ?></td>
            <td >
            <form style="margin: 0; padding: 0; box-shadow: 0 0 0;" method="POST" action="">

                    <input type="hidden" name="medicine_name" value="<?= $medicineName; ?>">
                    <input type="hidden" name="quantity" value="<?= $totalQuantity; ?>">
                    <button type="submit" name="remove_button" class="btn-primary">Send</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>

            </tbody>
        </table>
    </div>

    <br>
    <div class="table-container1">
        
        
        <table class="table-materials">
            <thead>
                <h3>Medicine List</h3>
                <tr>
                    <th>Batch Number</th>
                    <th>Medicine</th>
                    <th>Quantity</th>
                    <th>Type</th>
                    <th>Manufacture Date</th>
                    <th>Expiry Date</th>
                    <th style="width:8%">Status</th>
                   
                   
                </tr>
            </thead>
            <tbody>
                <?php foreach ($medicines as $medrow) : ?> 
                    <tr>
                        <td><?= $medrow['id']; ?></td> 
                        <td><?= $medrow['medicine_name']; ?></td> 
                        <td><?= $medrow['quantity']; ?></td> 
                        <td><?= $medrow['type']; ?></td> 
                        <td><?= $medrow['date_created']; ?></td> 
                        <td><?= $medrow['expiry_date']; ?></td> 
                        <td><?= ($medrow['sent'] == 1) ? 'sent' : 'pending'; ?></td>
                    </tr> 
                <?php endforeach; ?> 
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
        <div class="add-container1">
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <input type="text" id="search_date_created" name="search_date_created" placeholder="Select date">
                <button type="submit" name="search_button" class="add-button2">Search</button>
            </form>
        </div><br>
        <button id="myBtn">Request Finance</button>
        <br>
    </div>





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
                <option value="Warehouse">Warehouse</option>
            </select>
        </div>
        <div class="form-group">
        <label for="desc">Description:</label>
            <select name="desc" id="desc" required>
            <option value="Operating Expenses">Operating Expenses</option>
            <option value="Food Allowance">Food Allowance</option>
            </select>
        </div>
        <label for="desc">Amount:</label>
        <input type="number" name="Amount" required placeholder="00.00" step="any"><br>
        <input type="submit" name="insert" value="Request" ><br>
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


                $pdoLedgerQuery = "SELECT * FROM financial_request WHERE department = 'Warehouse'";
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
</script>

</section>
<script>
    document.addEventListener("DOMContentLoaded", function() {
       
        const updateStatus = function(form) {
           
            const selectedStatus = form.elements.status.value;

            const statusCell = form.parentNode.previousElementSibling;

            statusCell.textContent = selectedStatus;

            fetch(form.action, {
                method: 'POST',
                body: new FormData(form)
            })
            .then(response => response.json())
            .then(data => {
               
                console.log(data); 
            })
            .catch(error => console.error('Error:', error));

            return false;
        };

       
        const updateStatusForms = document.querySelectorAll('.update-status-form');
        updateStatusForms.forEach(form => {
            form.addEventListener('submit', function(event) {
                event.preventDefault(); // Prevent default form submission
                updateStatus(this); // Call updateStatus function passing the form
            });
        });
    });
</script>
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
</body>
</html>


