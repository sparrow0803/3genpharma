<?php 
include_once("connections/connection.php"); 
$pdo = connection(); 

$stmt = $pdo->prepare("SELECT * FROM medicine"); 
$stmt->execute(); 
$medicines = $stmt->fetchAll(PDO::FETCH_ASSOC); 

if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    // Insert new medicine
    if(isset($_POST["medicine_name"]) && isset($_POST["quantity"]) && isset($_POST["type"]) && isset($_POST["expiry_date"]) && isset($_POST["dosage"]) && isset($_POST["prescription"])) {
        $medicineName = $_POST["medicine_name"]; 
        $quantity = $_POST["quantity"]; 
        $type = $_POST["type"]; 
        $expiry_date = $_POST["expiry_date"]; 
        $dosage = $_POST["dosage"]; 
        $prescription = $_POST["prescription"]; 
        
        $stmt = $pdo->prepare("INSERT INTO medicine (medicine_name, quantity, type, expiry_date, dosage, prescription) VALUES (:medicine_name, :quantity, :type, :expiry_date, :dosage, :prescription)"); 
        $stmt->bindParam(':medicine_name', $medicineName); 
        $stmt->bindParam(':quantity', $quantity); 
        $stmt->bindParam(':expiry_date', $expiry_date); 
        $stmt->bindParam(':type', $type); 
        $stmt->bindParam(':dosage', $dosage); 
        $stmt->bindParam(':prescription', $prescription); 
        
        $stmt->execute(); 
        // No need to echo anything here
        exit();
    }
    // Delete medicine
    if(isset($_POST['delete_medicine'])) { 
        $id = $_POST['delete_medicine']; 
        $stmt = $pdo->prepare("DELETE FROM medicine WHERE id = :id"); 
        $stmt->bindParam(':id', $id); 
        $stmt->execute(); 

        // No need to echo anything here
        exit();
    } 
} 

$records_per_page = 10; // Number of records to show per page
$total_records = count($medicines);
$total_pages = ceil($total_records / $records_per_page);

if (!isset($_GET['page'])) {
    $page = 1;
} else {
    $page = $_GET['page'];
}

$start_from = ($page - 1) * $records_per_page;
$limited_medicines = array_slice($medicines, $start_from, $records_per_page);

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

    <div class="table-container1">
        <h1 class="header-container1">ADD MEDICINE</h1>
        <div class="add-container1">

        <form class="inline-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <label for="medicine">Medicine:</label>
            <input type="text" id="medicine" name="medicine_name">
                
            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity">
                
            <label for="type">Type:</label>
            <input type="text" id="type" name="type">

            <label for="expiry_date">Expiry Date:</label>
            <input type="text" id="expiry_date" name="expiry_date">
<br>
            <label for="dosage">Dosage:</label>
            <input type="number" id="dosage" name="dosage">

            <label for="prescription">Prescription:</label>
            <select id="prescription" name="prescription">
                <option value="Need">Need</option>
                <option value="Not">Not</option>
            </select>

            <input type="submit" value="Submit" class="add-button2">
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
                    <th>Action</th>

                </tr>
            </thead>
            <tbody>
            <?php foreach ($limited_medicines as $medrow) : ?> 
                <tr data-medicine-id="<?= $medrow['id']; ?>"> 
                <td><?= $medrow['id']; ?></td> 
                <td><?= $medrow['medicine_name']; ?></td> 
                <td><?= $medrow['quantity']; ?></td> 
                <td><?= $medrow['type']; ?></td> 
                <td><?= $medrow['dosage']; ?></td> 
                <td><?= $medrow['prescription']; ?></td> 
                <td><?= $medrow['date_created']; ?></td> 
                <td><?= $medrow['expiry_date']; ?></td> 
                <td> 
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"> 
                <input type="hidden" name="delete_medicine" value="<?= $medrow['id']; ?>"> 
                <button type="submit" class="delete-btn">Delete</button> 
                </form> 
                </td> 
                </tr> 
            <?php endforeach; ?> 
            </tbody>
        </table>
            </div>
        </div>


        <script>
            document.addEventListener("DOMContentLoaded", function() {
    // Handle form submission
    document.querySelector('.inline-form').addEventListener('submit', function(event) {
        event.preventDefault();
        const form = this;
        const formData = new FormData(form);
        
        fetch(form.action, {
            method: 'POST',
            body: formData
        })
        .then(() => {
            // Reset the form if needed
            form.reset();
            // Reload the table content
            location.reload();
        });
    });

    // Handle deletion
    document.querySelectorAll('.delete-btn').forEach(deleteBtn => {
        deleteBtn.addEventListener('click', function(event) {
            event.preventDefault();
            const id = this.parentElement.querySelector('[name="delete_medicine"]').value;
            
            fetch(window.location.href, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `delete_medicine=${id}`
            })
            .then(() => {
                // Reload the table content
                location.reload();
            });
        });
    });
});

        </script>

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
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
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
//--------------------DELETE---------------------


//--------------------DELETE---------------------

//--------------------RELOAD---------------------

document.addEventListener("DOMContentLoaded", function() {
    const addMaterialBtn = document.getElementById('addMaterialBtn');
    addMaterialBtn.addEventListener('click', function() {
        // Reload the page
        window.location.reload();
    });
});
//--------------------RELOAD---------------------

//--------------------DATEPICKER---------------------
document.addEventListener("DOMContentLoaded", function() {
                flatpickr("#expiry_date", {
                    dateFormat: "Y-m-d" // Specify the date format
                });
            });
//--------------------DATEPICKER---------------------            
</script>
</body>
</html>
