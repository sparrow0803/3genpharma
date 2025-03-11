<?php
require_once ('connect/dbcon.php');



?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> CUSTOMERS </title>
  <link rel="stylesheet" href="styles/customerservices.css" />
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
        <ul class="menu-links">
          <li class="nav-link">
            <a href="dashboard.html">
              <i class='bx bx-home-alt icon'></i>
              <span class="text nav-text"> Dashboard </span>
            </a>
          </li>
          <li class="nav-link">
            <a href="employee.html">
              <i class='bx bx-group icon'></i>
              <span class="text nav-text"> Employees </span>
            </a>
          </li>
          <li class="nav-link">
            <a href="customer.html">
              <i class='bx bx-user-pin icon'></i>
              <span class="text nav-text"> Customers </span>
            </a>
          </li>
          <li class="nav-link">
            <a href="sales.html">
              <i class='bx bx-money-withdraw icon'></i>
              <span class="text nav-text"> Sales </span>
            </a>
          </li>
          <li class="nav-link">
            <a href="reports.html">
              <i class='bx bxs-book icon'></i>
              <span class="text nav-text"> Reports </span>
            </a>
          </li>
          <li class="nav-link">
            <a href="inventory.html">
              <i class='bx bx-package icon'></i>
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
                <span class="snavoption-text">Logistics & Manufacturing </span>
              </li>
              <li class="sidenavoption">
                <span class="snavoption-text">Warehouse Management</span>
              </li>
              <li class="sidenavoption">
                <span class="snavoption-text">Supply Chain</span>
              </li>
            </ul>

          </div>
          <li class="nav-link">
            <a href="purchase.html">
              <i class='bx bx-purchase-tag icon'></i>
              <span class="text nav-text"> Purchases </span>
            </a>
          </li>

          <div class="bottom-content">
            <hr style="height:1px;opacity:40%;border-width:0;background-color:#FFD041;">
            <li class="nav-link">
              <a href="settings.html">
                <i class='bx bx-cog icon'></i>
                <span class="text nav-text"> Settings </span>
              </a>
            </li>
            <li class="nav-link">
              <a href="logout.php">
                <i class='bx bx-log-out icon'></i>
                <span class="text nav-text"> Logout </span>
              </a>
            </li>
          </div>
        </ul>
      </div>
    </div>
  </nav>

  <section class="home">
    <div class="userheader">
      <h1> <i class='bx bx-user-pin icon'>&nbsp</i> CUSTOMERS </h1>
      <h2><i class='bx bxs-user usericon'>&nbsp</i> Super Admin </h2>
    </div>

<?php



if (isset($_POST["add_customer"])) {
  $Name = $_POST["Name"];
  $Phone = $_POST['Phone'];
  $Email = $_POST['Email'];
  $Address = $_POST['Address'];
  $Code = $_POST['Code'];
  $Note = $_POST['Note'];
  $add = $pdoConnect->prepare("SELECT * FROM customers WHERE email = ?");
  $add->execute([$Email]);

  if ($add->rowCount() > 0) {
    echo '<h1>Customer Email Already Taken</h1>';
  } else {
    
    $add = $pdoConnect->prepare("SELECT * FROM customers WHERE code = ?");
    $add->execute([$Code]);
    if($add->rowCount() > 0){
      echo '<h1>Customer Code Already Taken</h1>';
    } else{
    $pdoQuery = "INSERT INTO customers (name,phone,email,address,code,note) VALUES (:Name,:Phone,:Email,:Address,:Code,:Note)";
    $pdoResult = $pdoConnect->prepare($pdoQuery);
    $pdoExec = $pdoResult->execute([
      ":Name" => $Name,
      ":Phone" => $Phone,
      ":Email" => $Email,
      ":Address" => $Address,
      ":Code" => $Code,
      ":Note" => $Note,
    ]);
    if ($pdoExec) {
      header("location:customer.php");
    } else {
      echo 'Failed to add.';
    }

  }
 }
}
 ?>


    <!----- INPUT CODE HERE :) ----->
    <div class="container-add-item-center">
      <div class="container-add-item">
        <section class="add_item" id="add_item">
          <div class="title-customer">
            <a class="button-back-customer" href="customer.php"><i class="fa-solid fa-arrow-left"></i></a>
            <h2>Add Customer</h2>
          </div>
          <form method="POST">
            <div class="user-details">
              <div class="form-group">
                <label class="details" for="name">Name:</label>
                <input placeholder="Enter Name" type="text" name="Name" id="name1" required/>
              </div>
              <div class="form-group">
                <label class="details" for="phone">Phone:</label>
                <input placeholder="Enter Phone" type="text" name="Phone" id="phone1" required/>
              </div>
              <div class="form-group">
                <label class="details" for="email">Email:</label>
                <input placeholder="Enter Email" type="text" name="Email" id="email1" required/>
              </div>
              <div class="form-group">
                <label class="details" for="address">Address:</label>
                <input placeholder="Enter Addres" type="text" name="Address" id="address1" required/>
              </div>
              <div class="form-group">
                <label class="details" for="customer code">Customer code:</label>
                <input placeholder="Enter Code" type="text" name="Code" id="code1" required/>
              </div>

              <div class="form-group">
                <label for="note">Note:</label>
                <input placeholder="Type notes" type="text" name="Note" id="note1">
              </div>
              <input class="button-item" type="submit" name="add_customer" value="Submit">
            </div>
      </div>
    </div>
    </form>
  </section>

  <script>
    const body = document.querySelector("body"),
      sidebar = body.querySelector(".sidebar"),
      toggle = body.querySelector(".toggle");
    toggle.addEventListener("click", () => {
      sidebar.classList.toggle("close");
    });
    if (window.history.replaceState) {
      window.history.replaceState(null, null, window.location.href);
    }
  </script>
</body>

</html>