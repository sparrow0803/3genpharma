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

    <div class="add-search">
      <div class="add-go-to">
        <a class="add-part" href="add_customer.php">ADD<i class="fa-solid fa-plus"></i></a>
        <a class="add-part" href="order.php">Order<i class="fa-solid fa-plus"></i></a>
        <a class="purchase-go-to" href="purchase_history.php">Purchase<i class="fa-solid fa-right-to-bracket"></i></a>
      </div>
      <div>
        <form method="POST" action="">
          <input class="box" type="search" name="keyword" placeholder="Search here" />
          <input class="btn-enter" type="submit" name="search" value="enter" />
        </form>
      </div>

    </div>

    <?php


    if (isset($_POST['search'])) {

      $keyword = $_POST['keyword'];
      $keyword = preg_replace("#[^0-9a-z]#i", "", $keyword);

      $query = $pdoConnect->prepare("SELECT * FROM customers WHERE name LIKE '{$keyword}%'");
      $query->execute();
      if ($query->rowCount() > 0) { ?>
    <table class="content-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Customer</th>
          <th>Contacts</th>
          <th>First Visit</th>
          <th>Last Visit</th>
          <th>Total Visit</th>
          <th>Points Balance</th>
          <th>Edit</th>
          <th>Delete</th>
        </tr>
      </thead>
      <tbody>
        <?php

        while ($row = $query->fetch()) {
          $id = $row['id'];
          $code = $row['code'];
          $points= $row['points'];

          $queryss = $pdoConnect->prepare("SELECT COUNT(*) FROM purchase_history WHERE code LIKE '$code'");
          $queryss->execute();
          $count = $queryss->fetchColumn();
          if (empty($count)) {
            $counts = 0;
          } else {
            $counts = $count;
          }

          $querys = $pdoConnect->prepare("SELECT MAX(purchase_date) FROM purchase_history WHERE code LIKE '$code'");
          $querys->execute();
          $res = $querys->fetchColumn();
          if (empty($res)) {
            $date = '-';
            $time = '-';
          } else {
            $timestamp = strtotime($res);
            $date = date('n.j.Y', $timestamp);
            $time = date('H:i', $timestamp);
          }

          $querys = $pdoConnect->prepare("SELECT MIN(purchase_date) FROM purchase_history WHERE code LIKE '$code'");
          $querys->execute();
          $ros = $querys->fetchColumn();
          if (empty($ros)) {
            $date2 = '-';
            $time2 = '-';
          } else {
            $timestamp2 = strtotime($ros);
            $date2 = date('n.j.Y', $timestamp2);
            $time2 = date('H:i', $timestamp2);
          }
          ?>
        <?php echo "<tr data-href='customer_purchase.php?id=$id'>"; ?>
        <td>
          <?php echo $id; ?>
        </td>
        <td>
          <?php echo $row['name']; ?> <br />
          <?php echo $row['note']; ?>
        </td>
        <td>
          <?php echo $row['email']; ?> <br />
          <?php echo $row['phone']; ?>
        </td>
        <td>
          <?php echo "Date: $date2"; ?> <br />
          <?php echo "Time: $time2" ?>
        </td>
        <td>
          <?php echo "Date: $date"; ?> <br />
          <?php echo "Time: $time" ?>
        </td>
        <td>
          <?php echo $counts; ?>
        </td>
        <td>
          <?php echo $points; ?>
        </td>
        <?php echo "<td><div class='edit-btn'><a href='update_customer.php?id=$id';>Edit</a></div></td>"; ?>
        <?php echo "<td><div class='delete-btn'><a href='delete.php?id=$id';> Delete</a></div></td>"; ?>
        </tr>
        <?php

        }
      } else {
        ?>
        <h1>No Data Found</h1>

        <?php

      }
    } else { ?>
        <table class="content-table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Customer</th>
              <th>Contacts</th>
              <th>First Visit</th>
              <th>Last Visit</th>
              <th>Total Visit</th>
              <th>Points Balance</th>
              <th>Edit</th>
              <th>Delete</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $query = $pdoConnect->prepare("SELECT * FROM customers");
            $query->execute();
            while ($row = $query->fetch()) {
              $id = $row['id'];
              $code = $row['code'];
              $points= $row['points'];

              $queryss = $pdoConnect->prepare("SELECT COUNT(*) FROM purchase_history WHERE code LIKE '$code'");
              $queryss->execute();
              $count = $queryss->fetchColumn();
              if (empty($count)) {
                $counts = 0;
              } else {
                $counts = $count;
              }

              $querys = $pdoConnect->prepare("SELECT MAX(purchase_date) FROM purchase_history WHERE code LIKE '$code'");
              $querys->execute();
              $res = $querys->fetchColumn();
              if (empty($res)) {
                $date = '-';
                $time = '-';
              } else {
                $timestamp = strtotime($res);
                $date = date('n.j.Y', $timestamp);
                $time = date('H:i', $timestamp);
              }

              $querys = $pdoConnect->prepare("SELECT MIN(purchase_date) FROM purchase_history WHERE code LIKE '$code'");
              $querys->execute();
              $ros = $querys->fetchColumn();
              if (empty($ros)) {
                $date2 = '-';
                $time2 = '-';
              } else {
                $timestamp2 = strtotime($ros);
                $date2 = date('n.j.Y', $timestamp2);
                $time2 = date('H:i', $timestamp2);
              }

              echo "<tr data-href='customer_purchase.php?id=$id'>";
              echo "<td>$id</td>";
              echo "<td>$row[name]<br />$row[note]</td>";
              echo "<td>$row[email]<br />$row[phone]</td>";
              echo "<td>Date: $date2<br />Time: $time2</td>";
              echo "<td>Date: $date<br />Time: $time</td>";
              echo "<td>$counts</td>";
              echo "<td>$points</td>";
              echo "<td><div class='edit-btn'><a href='update_customer.php?id=$id';>Edit</a></div></td>";
              echo "<td><div class='delete-btn'><a href='delete.php?id=$id';>Delete</a></div></td>";
              echo "</tr>";

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



    document.addEventListener("DOMContentLoaded", () => {
      const row = document.querySelectorAll("tr[data-href]");

      row.forEach(row => {
        row.addEventListener("click", () => {
          window.location.href = row.dataset.href;
        })
      })
    })

  </script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</body>

</html>