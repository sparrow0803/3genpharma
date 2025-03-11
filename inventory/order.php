<?php
include_once("connection/connection.php");
$pdo = connection();

$sql = "SELECT * FROM ordertb";
$stmt = $pdo->query($sql);
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);


        ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/inventoryorder.css">
    <title>Add Items</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel="stylesheet">
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
            <li class="nav-link"> 
                <a href="/3GENpharma/dashboard.php">
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
                <a href="inventory.php">
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
        <a href="/3GENPHARMA/settings.php">
        <i class='bx bx-cog icon' ></i>
        <span class="text nav-text"> Settings </span>
        </a>
      </li>
      <li class="nav-link"> 
      <a href="/3GENPHARMA/logout.php">
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
    <h2>Order items</h2>
    <div class="container">
    <div class="column">
        <form method="post" action="" id="addItemForm">
        <div>
    <label for="itemCategory">Category:</label><br>
    <input class="boxx" type="text" id="itemCategory" name="itemCategory" list="categories" >
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
        <label for="itemName">Name:</label><br>
        <input class="boxx" type="text" id="itemName" name="itemName" >
            <br>
        <label for="itemDescription">Description:</label><br>   
        <textarea class="boxx" id="itemDescription" name="itemDescription" ></textarea>
            <br>
        <label for="itemQuantity">Quantity:</label><br>
        <input class="boxx" type="number" id="itemQuantity" name="itemQuantity" min="1" >

            <div class="but">
            <button class="buts" type="button" id="addItemBtn">Add Item</button>
            <button class="buts" type="button" onclick="document.location='inventory.php'">Close</button>
            </div>
        </form>
    </div>
    <div class="column">
        <table class ="table" id="orderTable">
            <thead>
                <tr>
                    <th>Category</th>
                    <th>Product Name</th>
                    <th>Description</th>
                    <th>Qunatity</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $row){ ?>
                <tr>
                    <td><?= $row['category'];?></td>
                    <td><?= $row['product_name'];?></td>
                    <td><?= $row['description'];?></td>
                    <td><?= $row['quantity'];?></td>
                    <td>
                        <!-- Delete button form -->
                        <form method="POST" action="deleteorder.php" class="delete-form">
                            <input type="hidden" name="product_id" value="<?= $row['product_Id'];?>">
                            <button type="button" class="delete-btn">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php }?>
            </tbody>
        </table>
                <form action="#" method="post" class="send-form">
                <button class="buts" type="button" id="sendOrdersBtn">Send Orders</button>
                </form>
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

document.addEventListener('DOMContentLoaded', function() {
    // Function to clear form inputs
    function clearFormInputs() {
        document.getElementById('itemCategory').value = '';
        document.getElementById('itemName').value = '';
        document.getElementById('itemDescription').value = '';
        document.getElementById('itemQuantity').value = '';
    }

    // Function to add item using AJAX
    addItemBtn.addEventListener('click', () => {
        const formData = new FormData(document.getElementById('addItemForm'));
        fetch('add_item.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            console.log(data); // Log the response for debugging
            // Clear form inputs after adding item
            clearFormInputs();
            // Refresh the table after adding item
            fetchTableData();
        })
        .catch(error => console.error('Error:', error));
    });

    // Function to send orders using AJAX
    sendOrdersBtn.addEventListener('click', () => {
        fetch('send.php', {
            method: 'POST'
        })
        .then(response => response.text())
        .then(data => {
            console.log(data); // Log the response for debugging
            // Refresh the table after sending orders
            fetchTableData();
        })
        .catch(error => console.error('Error:', error));
    });

    // Function to fetch and update table data
    function fetchTableData() {
        fetch('gettable.php')
        .then(response => response.text())
        .then(data => {
            // Update the table content
            orderTable.innerHTML = data;
            // Reattach event listeners for delete buttons
            attachDeleteButtonListeners();
        })
        .catch(error => console.error('Error:', error));
    }

    // Function to attach event listeners for delete buttons
    function attachDeleteButtonListeners() {
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', () => {
                button.closest('.delete-form').submit();
            });
        });
    }

    // Initial fetch for table data on page load
    fetchTableData();
});
</script>
</script>
</body>
</html>