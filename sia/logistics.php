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
        $stmt = $pdo->prepare("SELECT * FROM genpharma.medicine WHERE DATE(date_created) = :search_date_created LIMIT :limit_start, :records_per_page");
        $stmt->bindParam(':search_date_created', $search_date_created, PDO::PARAM_STR);
    } else {
        $stmt = $pdo->prepare("SELECT * FROM genpharma.medicine LIMIT :limit_start, :records_per_page");
    }
    $stmt->bindParam(':limit_start', $limit_start, PDO::PARAM_INT);
    $stmt->bindParam(':records_per_page', $records_per_page, PDO::PARAM_INT);
    $stmt->execute();
    $medicines = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Count total number of records
    if (!empty($search_date_created)) {
        $stmt_count = $pdo->prepare("SELECT COUNT(*) as total_records FROM genpharma.medicine WHERE DATE(date_created) = :search_date_created");
        $stmt_count->bindParam(':search_date_created', $search_date_created, PDO::PARAM_STR);
    } else {
        $stmt_count = $pdo->prepare("SELECT COUNT(*) as total_records FROM genpharma.medicine");
    }
    $stmt_count->execute();
    $result = $stmt_count->fetch(PDO::FETCH_ASSOC);
    $total_records = $result['total_records'];

    $total_pages = ceil($total_records / $records_per_page);

    // Fetch unique medicines with total quantity
    $uniqueMedicines = array();
    foreach ($medicines as $med) {
        $medicineName = $med['medicine_name'];
        $quantity = $med['quantity'];
        if (!isset($uniqueMedicines[$medicineName])) {
            $uniqueMedicines[$medicineName] = $quantity;
        } else {
            $uniqueMedicines[$medicineName] += $quantity;
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["remove_button"])) {
    
        $medicineName = $_POST["medicine_name"];
    
        // Fetch the "sent" value from the database for this medicine
        $sql = "SELECT sent FROM medicine WHERE medicine_name = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(1, $medicineName, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($result !== false && $result["sent"] == 0) {
            // "sent" is 0, so remove the medicine and update "sent"
            $deleteSql = "DELETE FROM medicine WHERE medicine_name = ?";
            $deleteStmt = $pdo->prepare($deleteSql);
            $deleteStmt->bindParam(1, $medicineName, PDO::PARAM_STR);
            $deleteStmt->execute();
        
            $updateSql = "UPDATE medicine SET sent = 1 WHERE medicine_name = ?";
            $updateStmt = $pdo->prepare($updateSql);
            $updateStmt->bindParam(1, $medicineName, PDO::PARAM_STR);
            $updateStmt->execute();
        
        
        } // If "sent" is 1, no action is taken
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
    <title>Logistics & Manufacturing</title>
    <link rel="stylesheet" href="css/logistics.css">
    <link rel="stylesheet" href="css/style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        /* Style for SORT dropdown */
        .dropdown1 {
            position: relative;
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
        <span class="inventory1"> AUDIT > </span>
        <div class="dropdown-content2" id="myDropdown1">
            <a class="content2" href="logistics.php"> Audit Medicine</a>
            <a class="content2" href="logistics_audit_ingredients.php"> Audit Ingredients</a>
        </div>
    </div>

   
    <br>
    <div class="table-container1">
        <h1 class="header-container1">AUDIT MEDICINE</h1>
        
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
                    <th>Medicine</th>
                    <th>Quantity</th>
                    <th>Type</th>
                    <th>Dosage</th>
                    <th>Prescription</th>
                    <th>Manufacture Date</th>
                    <th>Expiry Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
<?php

$inserted_this_session = false; // Flag to prevent multiple inserts per page load

foreach ($medicines as $medrow): 
?>
    <tr>
        <td><?= $medrow['id']; ?></td>
        <td><?= $medrow['medicine_name']; ?></td>
        <td><?= $medrow['quantity']; ?></td>
        <td><?= $medrow['type']; ?></td>
        <td><?= $medrow['dosage']; ?></td>
        <td><?= $medrow['prescription']; ?></td>
        <td><?= $medrow['date_created']; ?></td>
        <td><?= $medrow['expiry_date']; ?></td>

        <td class="text-center">
            <?php 
            switch ($medrow['status']) {
                case 0: echo "Pending"; break;
                case 1: echo "Partially received"; break;
                case 2: echo "Received"; break;
                case 3: echo "Packed"; break;
                case 4: echo "Stored"; break;
                default: echo "<span class=\"badge badge-danger rounded-pill\">Delivered</span>"; break;
            } 
            ?>
        </td>

        <td>
            <form method="post" action="status.php">
                <input type="hidden" name="id" value="<?= $medrow['id']; ?>">
                <button type="submit" class="btn btn-primary" <?= ($medrow['status'] >= 4) ? "disabled" : ""; ?>>Update Status</button>
            </form>
        </td>
    </tr>
<?php endforeach; ?>
</tbody>

<?php
// Check flag before proceeding with inserts and status updates
if (!$inserted_this_session):
    foreach ($medicines as $medrow):
        if ($medrow['status'] == 4):
            $checkSql = "SELECT COUNT(*) FROM warehouse WHERE id = :id";
            $checkStmt = $pdo->prepare($checkSql);
            $checkStmt->execute([':id' => $medrow['id']]);
            $exists = $checkStmt->fetchColumn();

            if (!$exists):
                try {
                    $insertSql = "INSERT INTO warehouse (id, medicine_name, quantity, type, dosage, prescription, date_created, expiry_date, status)
                    VALUES (:id, :medicine_name, :quantity, :type, :dosage, :prescription, :date_created, :expiry_date, :status)";
      $insertStmt = $pdo->prepare($insertSql);
      $insertStmt->execute([
        ':id' => $medrow['id'],
        ':medicine_name' => $medrow['medicine_name'],
        ':quantity' => $medrow['quantity'],
        ':type' => $medrow['type'],
        ':dosage' => $medrow['dosage'],
        ':prescription' => $medrow['prescription'],
        ':date_created' => $medrow['date_created'],
        ':expiry_date' => $medrow['expiry_date'],
        ':status' => $medrow['status'] // Store original status
      ]);

                    $inserted_this_session = true; // Set flag after successful insert
                } catch (PDOException $e) {
                    error_log("Warehouse insertion error: " . $e->getMessage());
                }
            endif; // end if !$exists
        endif; // end if $medrow['status'] == 4
    endforeach;
endif; // end if !$inserted_this_session

// Update statuses outside the main loop 
if ($inserted_this_session):
    try {
        $updateSql = "UPDATE medicines SET status = 5 WHERE status = 4";
        $pdo->exec($updateSql);
    } catch (PDOException $e) {
        error_log("Status update error: " . $e->getMessage());
    }
endif; 
?>

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
    </div>
<br>


 
</section>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Function to handle form submission and update status cell
        const updateStatus = function(form) {
            // Get the selected value from the dropdown
            const selectedStatus = form.elements.status.value;

            // Get the cell of the status
            const statusCell = form.parentNode.previousElementSibling;

            // Update the cell content with the selected status
            statusCell.textContent = selectedStatus;

            // Optionally, you can submit the form via AJAX if you need to update server-side data
            // Example AJAX request
            fetch(form.action, {
                method: 'POST',
                body: new FormData(form)
            })
            .then(response => response.json())
            .then(data => {
                // Handle response from server if needed
                console.log(data); // Log the response to the console
            })
            .catch(error => console.error('Error:', error));

            // Prevent form submission
            return false;
        };

        // Add event listener to handle form submissions
        const updateStatusForms = document.querySelectorAll('.update-status-form');
        updateStatusForms.forEach(form => {
            form.addEventListener('submit', function(event) {
                event.preventDefault(); // Prevent default form submission
                updateStatus(this); // Call updateStatus function passing the form
            });
        });
    });
</script>

</body>
</html>


