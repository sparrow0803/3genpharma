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
    $sql = "SELECT * FROM ordered_items WHERE DATE(date) = :search_date_created LIMIT :limit_start, :records_per_page";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':search_date_created', $search_date_created, PDO::PARAM_STR);
} else {
    $sql = "SELECT * FROM ordered_items LIMIT :limit_start, :records_per_page";
    $stmt = $pdo->prepare($sql);
}
$stmt->bindParam(':limit_start', $limit_start, PDO::PARAM_INT);
$stmt->bindParam(':records_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
$dbs = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Function to update status in the database
function updateStatus($productId, $currentStatus, $pdo) {
    $newStatus = '';
    if ($currentStatus == '0') {
        $newStatus = '1';
    } elseif ($currentStatus == '1') {
        $newStatus = '2';
    }
    $sql = "UPDATE ordered_items SET status = :new_status WHERE product_Id = :product_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':new_status', $newStatus, PDO::PARAM_INT);
    $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
    $stmt->execute();
}

// Check if the button is clicked
if (isset($_POST['send_button']) && isset($_POST['product_Id'])) {
    $productId = $_POST['product_Id'];
    $currentStatus = ''; // Fetch current status from database
    foreach ($dbs as $row) {
        if ($row['product_Id'] == $productId) {
            $currentStatus = $row['status'];
            break;
        }
    }
    updateStatus($productId, $currentStatus, $pdo);
    // Redirect to the same page to avoid resubmission
    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}

// Count total number of records
if (!empty($search_date_created)) {
    $stmt = $pdo->prepare("SELECT COUNT(*) as total_records FROM ordered_items WHERE DATE(date) = :search_date_created");
    $stmt->bindParam(':search_date_created', $search_date_created, PDO::PARAM_STR);
} else {
    $stmt = $pdo->prepare("SELECT COUNT(*) as total_records FROM ordered_items");
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
    <style>
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


    <div class="table-container1">
        <h1 class="header-container1"> ORDER </h1>
        
        <div class="add-container1">
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <input type="text" id="search_date_created" name="search_date_created" placeholder="Select date">
                <button type="submit" name="search_button" class="add-button2">Search</button>
            </form>
        </div>
        <table class="table-materials">
            <thead>
                <tr>
                <th>Order id</th>
                    <th>Category</th>
                    <th>Product Name</th>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($dbs as $mRow){ ?>
                    <tr data-material-id="<?= $mRow['product_Id']; ?>">
                        <!-- Table data -->
                        <td><?= $mRow['product_Id'];?></td>
                        <td><?= $mRow['category'];?></td>
                        <td><?= $mRow['product_name'];?></td>
                        <td><?= $mRow['description'];?></td>
                        <td><?= $mRow['quantity'];?></td>
                        <td><?= $mRow['date'];?></td>
                        <td>
                            <?php
                            $status = $mRow['status'];
                            if ($status == '0') {
                                echo 'Pending';
                            } elseif ($status == '1') {
                                echo 'Manufacturing';
                            } elseif ($status == '2') {
                                echo 'Transfered to Warehouse';
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            if ($status != '2') { // Check if status is not "Transfered"
                            ?>
                            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                <input type="hidden" name="product_Id" value="<?= $mRow['product_Id']; ?>">
                                <button type="submit" class="btn btn-primary" name="send_button" <?php if ($status == '2') echo 'disabled'; ?>>update status</button>
                            </form>
                            <?php
                            }
                            ?>
                        </td>
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
