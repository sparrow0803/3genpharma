<?php 
session_start();
require 'conn.php';
    try{
    $pdo = new PDO('mysql:host=localhost;dbname=hr', "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
    echo 'Connection Failed' .$e->getMessage();
    }

    $stmt2 = $pdo->prepare('SELECT * from employees');
    $stmt2->execute();
    $countemp = $stmt2->rowCount();

    try{
      $pdo = new PDO('mysql:host=localhost;dbname=sia_manufacturing', "root", "");
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch (PDOException $e) {
      echo 'Connection Failed' .$e->getMessage();
      }
    $stmt2 = $pdo->prepare('SELECT * from materials');
    $stmt2->execute();
    $countmat = $stmt2->rowCount();

    try{
      $pdo = new PDO('mysql:host=localhost;dbname=crm', "root", "");
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch (PDOException $e) {
      echo 'Connection Failed' .$e->getMessage();
      }
    $stmt2 = $pdo->prepare('SELECT * from purchase_history');
    $stmt2->execute();
    $countware = $stmt2->rowCount();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>DASHBOARD</title>
  <link rel="icon" href="img/logo_icon.png" type="image/png">
  <link rel="stylesheet" href="styles/dashboard.css" />
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet"/>
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
  <h1><i class="bx bx-home-alt icon">&nbsp</i> DASHBOARD</h1>
  <h2><i class="bx bxs-user usericon">&nbsp</i> Super Admin</h2>
</div>

<br>
<div class="card--container">
<div class="card--wrapper">

<div class="pharma--card">
<div class="card--header">
<div class="pharma"><br>
  <span class="card--detail"> <?php echo $countemp; ?> </span>
  <span class="title"> Total Employees </span><br />
</div>
  <a class="info" href="/3GENPHARMA/HR/employee.php"> more info <i class="bx bx-right-arrow-circle"></i>
  </a>
</div>
</div>

<div class="pharma--card">
<div class="card--header">
<div class="pharma">
  <span class="card--detail"> <?php echo $countmat; ?> </span>
  <span class="title"> Total Supply </span>
  </div>
  <a class="info" href="/3GENpharma/supply/index.php"> more info <i class="bx bx-right-arrow-circle"></i>
  </a>
</div>
</div>

<div class="pharma--card">
<div class="card--header">
<div class="pharma">
  <span class="card--detail"> <?php echo $countware; ?> </span>
  <span class="title"> Total Transactions </span>
</div>
  <a class="info" href="/3GENPHARMA/crm/customer.php"> more info <i class="bx bx-right-arrow-circle"></i>
  </a>
</div>
</div>
</div>
</div>

<div class="card--container2">
<div class="title-card"><h1> Expiring List </h1></div>
<table> 
  <tr>
  <th> Ingridients  </th>
  <th> Quantity </th>
  <th> Expired Date </th>
  </tr>
    <?php
    $conn = mysqli_connect("localhost", "root", "", "sia_manufacturing");
    if ($conn-> connect_error){
    die("Connection Failed:". $conn-> connect_error);}
    $sql = "SELECT material, quantity, expiry_date from materials order by expiry_date asc";
    $result = $conn-> query($sql);
    if($result-> num_rows > 0){
    while ($row = $result-> fetch_assoc()){
    echo "<tr><td>". $row["material"]. "</td><td>". $row["quantity"]. "</td><td>". $row["expiry_date"]. "</td></tr>";
    }
    echo "</table>";
    }
    $conn-> close();
    ?>
  <tr>
</table>
</div>
<br>

<br/>
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
</script>
</script>
</body>
</html>
