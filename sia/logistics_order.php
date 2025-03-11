<?php 
include_once("connections/connection.php"); 
$pdo = connection(); 

// Pagination variables
$records_per_page = 10; // Number of records to display per page
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1; // Current page number, default is 1

$start_from = ($page - 1) * $records_per_page; // Calculate the starting point for the query

$stmt = $pdo->prepare("SELECT * FROM sia_order LIMIT :start_from, :records_per_page"); 
$stmt->bindParam(':start_from', $start_from, PDO::PARAM_INT);
$stmt->bindParam(':records_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute(); 
$medicines = $stmt->fetchAll(PDO::FETCH_ASSOC); 

// Count total number of records
$total_sql = "SELECT COUNT(*) AS total FROM sia_order";
$total_stmt = $pdo->query($total_sql);
$total_result = $total_stmt->fetch(PDO::FETCH_ASSOC);
$total_records = $total_result['total'];
$total_pages = ceil($total_records / $records_per_page); // Calculate total pages

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Insert new medicine
    if(isset($_POST["ingredient"]) && isset($_POST["quantity"])) {
        $ingredientName = $_POST["ingredient"];
        $quantity = $_POST["quantity"];

        $stmt = $pdo->prepare("INSERT INTO sia_order (ingredient, quantity) VALUES (:ingredient, :quantity)");
        $stmt->bindParam(':ingredient', $ingredientName);
        $stmt->bindParam(':quantity', $quantity);

        $stmt->execute();

        $id = $pdo->lastInsertId();
        echo json_encode(array('success' => true, 'id' => $id, 'ingredient' => $ingredientName, 'quantity' => $quantity, 'time' => date('H:i:s'), 'date' => date('Y-m-d')));
        exit;
    }
    // Delete medicine
    if(isset($_POST['delete_medicine'])) {
        $id = $_POST['delete_medicine'];
        $stmt = $pdo->prepare("DELETE FROM sia_order WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $stmt = $pdo->prepare("SET @num := 0; UPDATE sia_order SET id = @num := (@num+1); ALTER TABLE sia_order AUTO_INCREMENT = 1;");
        $stmt->execute();

        echo json_encode(array('success' => true));
        exit;
    }
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
        <h1 class="header-container1">SEND ORDER</h1>
        <div class="add-container1">

        <form class="inline-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <label for="ingredient">Ingredient:</label>
            <input type="text" id="ingredient" name="ingredient">

            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity">

            <input type="submit" value="Submit" class="add-button2">
        </form>


        </div>
        <table class="table-materials" id="medicine-table">
            <thead>
                <tr>
                    <th>Order Number</th>
                    <th>Ingredient</th>
                    <th>Quantity</th>
                    <th>Time</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($medicines as $medrow) : ?> 
                <tr data-medicine-id="<?= $medrow['id']; ?>"> 
                <td><?= $medrow['id']; ?></td> 
                <td><?= $medrow['Ingredient']; ?></td> 
                <td><?= $medrow['quantity']; ?></td> 
                <td><?= date('H:i:s', strtotime($medrow['date'])); ?></td>
                <td><?= date('Y-m-d', strtotime($medrow['date']));?></td>
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
const form = document.querySelector('form');
form.addEventListener('submit', function(e) {
    e.preventDefault(); // Prevent the default form submission

    const ingredient = document.getElementById('ingredient').value;
    const quantity = document.getElementById('quantity').value;

    const xhr = new XMLHttpRequest();
    xhr.open('POST', '<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            if (response.success) {
                // Add new row to the table
                const table = document.getElementById('medicine-table');
                const row = table.insertRow(-1);
                const cell1 = row.insertCell(0);
                const cell2 = row.insertCell(1);
                const cell3 = row.insertCell(2);
                const cell4 = row.insertCell(3);
                const cell5 = row.insertCell(4);
                const cell6 = row.insertCell(5);
                cell1.innerHTML = response.id;
                cell2.innerHTML = response.ingredient;
                cell3.innerHTML = response.quantity;
                cell4.innerHTML = response.time;
                cell5.innerHTML = response.date;
                cell6.innerHTML = '<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"><input type="hidden" name="delete_medicine" value="' + response.id + '"><button type="submit" class="delete-btn">Delete</button></form>';
            }
        }
    };
    xhr.send('ingredient=' + ingredient + '&quantity=' + quantity);
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
