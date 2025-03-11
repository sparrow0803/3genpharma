<?php
require_once ('connect/dbcon.php');
$output = '';
$sum = 0;



?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> CUSTOMERS </title>
  <link rel="stylesheet" href="styles/customerservices.css" />
  <link rel="stylesheet" href="styles/purchase_history.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
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



    <!----- INPUT CODE HERE :) ----->

    <div>
      <form method="POST" action="">
        <div class="history-title">
          <a class="button-back-history" href="customer.php"><i class="fa-solid fa-arrow-left"></i></a>
          <div class="search-enter-purchase">
            <input class="search-purchase" placeholder="Search here" name="keyword2">
            <input class="purchase-enter" type="submit" name="search2" value="enter" />
          </div>
        </div>
      </form>

    </div>



    <?php

    $output = '';
    $sum = 0;
    if (isset($_POST['search2'])) {

      ?>

    <?php
    $keyword = $_POST['keyword2'];
    $keyword = preg_replace("#[^0-9a-z]#i", "", $keyword);

    $query = $pdoConnect->prepare("SELECT * FROM purchase_history WHERE name LIKE '{$keyword}%' OR code LIKE '{$keyword}%' OR purchase_date LIKE '{$keyword}%'");
    $query->execute();
    if ($query->rowCount() > 0) { ?>
    <table class="content-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Customer</th>
          <th>Code</th>
          <th>Total Cost</th>
          <th>Date</th>
          <th>Time</th>
          <th>Delete</th>
        </tr>
      </thead>
      <tbody>
        <?php

        while ($row = $query->fetch()) {
          $datetime = $row['purchase_date'];
          $timestamp = strtotime($datetime);
          $date = date('n.j.Y', $timestamp);
          $time = date('H:i', $timestamp);
          ?>
        <tr id="CustomerTable">
          <td>
            <?php echo $id = $row['id']; ?>
          </td>
          <td>
            <?php echo $row['customer']; ?>
          </td>
          <td>
            <?php echo $row['code']; ?>
          </td>
          <td>
            <?php echo $row['totalcost']; ?>
          </td>
          <td>
            <?php echo $date; ?>
          </td>
          <td>
            <?php echo $time; ?>
          </td>
          <?php echo "<td><div class='delete-btn'><a href='purchase_delete.php?id=$id';> Delete</a></div></td>"; ?>
        </tr>
        <?php

        }
    } else {
      ?>
        <table class="content-table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Customer</th>
              <th>Code</th>
              <th>Total Cost</th>
              <th>Date</th>
              <th>Time</th>
              <th>Delete</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $query = $pdoConnect->prepare("SELECT * FROM purchase_history");
            $query->execute();
            while ($row = $query->fetch()) {
              $id = $row['id'];
              $datetime = $row['purchase_date'];
              $timestamp = strtotime($datetime);
              $date = date('n.j.Y', $timestamp);
              $time = date('H:i', $timestamp);
              ?>
            <tr id="CustomerTable">
              <td>
                <?php echo $id ?>
              </td>
              <td>
                <?php echo $row['customer']; ?>
              </td>
              <td>
                <?php echo $row['code']; ?>
              </td>
              <td>
                <?php echo $row['totalcost']; ?>
              </td>
              <td>
                <?php echo $date; ?>
              </td>
              <td>
                <?php echo $time; ?>
              </td>
              <?php echo "<td><div class='delete-btn'><a href='purchase_delete.php?id=$id';> Delete</a></div></td>"; ?>
            </tr>
            <?php
            }
    }
    } else { ?>
            <table class="content-table">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Customer</th>
                  <th>Code</th>
                  <th>Total Cost</th>
                  <th>Date</th>
                  <th>Time</th>
                  <th>Delete</th>
              </thead>
              <tbody>
                <?php
                $query = $pdoConnect->prepare("SELECT * FROM purchase_history");
                $query->execute();
                while ($row = $query->fetch()) {
                  $id = $row['id'];
                  $datetime = $row['purchase_date'];
                  $timestamp = strtotime($datetime);
                  $date = date('n.j.Y', $timestamp);
                  $time = date('H:i', $timestamp);
                  ?>
                <tr id="CustomerTable">
                  <td>
                    <?php echo $id ?>
                  </td>
                  <td>
                    <?php echo $row['customer']; ?>
                  </td>
                  <td>
                    <?php echo $row['code']; ?>
                  </td>
                  <td>
                    <?php echo $row['totalcost']; ?>
                  </td>
                  <td>
                    <?php echo $date; ?>
                  </td>
                  <td>
                    <?php echo $time; ?>
                  </td>
                  <?php echo "<td><div class='delete-btn'><a href='purchase_delete.php?id=$id';> Delete</a></div> </td>"; ?>
                </tr>
                <?php
                }
    }
    ?>
              </tbody>
            </table>


          </tbody>
        </table>
        </br>

        </br>
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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</body>

</html>