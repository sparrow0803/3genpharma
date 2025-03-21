<?php 
session_start();
require 'conn.php';

    try{
    $pdo = new PDO('mysql:host=localhost;dbname=hr', "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
    echo 'Connection Failed' .$e->getMessage();
    }

    if(isset($_POST['save']))
    {
      $name = $_POST['name'];
      $department = $_POST['department'];
      $date = $_POST['date'];
      $qua_work = $_POST['qua_work'];
      $char_rate = $_POST['char_rate'];
      $inter_rel = $_POST['inter_rel'];
      $creativity = $_POST['creativity'];

      $stmt = $pdo->prepare("INSERT into performance(name, department, date, qua_work, char_rate, inter_rel, creativity) 
      values (:name, :department, :date, :qua_work, :char_rate, :inter_rel, :creativity)");
      $stmt->bindParam(':name', $name);
      $stmt->bindParam(':department', $department);
      $stmt->bindParam(':date', $date);
      $stmt->bindParam(':qua_work', $qua_work);
      $stmt->bindParam(':char_rate', $char_rate);
      $stmt->bindParam(':inter_rel', $inter_rel);
      $stmt->bindParam(':creativity', $creativity);
      if($stmt->execute()){
          $_SESSION['perfadd'] = "Performance Data Added Successfully!";
      }

      else{
          $_SESSION['perffail'] = "Failed To Add Performance Data!";
      }
      
    }


    if(isset($_POST['deletedata']))
    {
      $perf_id = $_POST['perf_id'];

      $stmt = $pdo->prepare("DELETE from performance where perf_id=:perf_id");
      $stmt->bindParam(':perf_id', $perf_id);
      if($stmt->execute()){
        $_SESSION['deletesucc'] = "Performance Data Deleted Successfully!";
    }
    else{
        $_SESSION['deletefail'] = "Failed To Delete Performance Data!";
    }
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> EMPLOYEES </title>
    <link rel="stylesheet" href="styles/employee.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.2/css/dataTables.dataTables.css" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel="stylesheet">
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
        <h1> <i class='bx bx-group icon'>&nbsp</i> EMPLOYEES </h1> 
        <h2><i class='bx bxs-user usericon'>&nbsp</i> Super Admin </h2>  
    </div>

<!----- INPUT CODE HERE :) ----->

<!----- NAVBAR ----->
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">

      <a class="navbar-brand" href="employee.php">HUMAN RESOURCES</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>


      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Employees
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="listemployees.php">List of Employees</a></li>
              <li><a class="dropdown-item" href="listrecruits.php">List of Applicants</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="attendance.php">Attendance</a></li>
              <li><a class="dropdown-item" href="performance.php">Performance</a></li>
              <li><a class="dropdown-item" href="leave.php">Leave</a></li>
              <li><a class="dropdown-item" href="payroll.php">Payroll</a></li>
            </ul>
          </li>
        </ul>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link" href="departments.php">
                  Departments
                </a>
              </li>
            </ul>

      </div>
    </div>
  </nav>


<!-- SUCESS AND ERROR MESSAGE -->
<div class="p-3">
<?php
            if (isset($_SESSION['perfadd'])) {
            echo '<div class="badge text-bg-success text-wrap" style="width: 20rem;">'
            .$_SESSION['perfadd'].
            '</div>'; }
            unset($_SESSION['perfadd']);

                if (isset($_SESSION['deletesucc'])) {
                  echo '<div class="badge text-bg-success text-wrap" style="width: 20rem;">'
                  .$_SESSION['deletesucc'].
                  '</div>'; }
                  unset($_SESSION['deletesucc']);

            if (isset($_SESSION['perffail'])) {
              echo '<div class="badge text-bg-danger text-wrap" style="width: 20rem;">'
              .$_SESSION['perffail'].
              '</div>'; }
              unset($_SESSION['perffail']);

                    if (isset($_SESSION['deletefail'])) {
                      echo '<div class="badge text-bg-danger text-wrap" style="width: 20rem;">'
                      .$_SESSION['deletefail'].
                      '</div>'; }
                      unset($_SESSION['deletefail']);
?>


<!----- NAVBAR ----->

<div class="row g-0 text-center">
<div class="text-start col-sm-6 col-md-8">PERFORMANCE RATINGS</div>
<div class="col-6 col-md-4">

<div class="d-grid gap-2 d-md-flex justify-content-md-end">
<button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#insertdata">
Create New
</button>
</div>

</div>
</div>




<!-- CREATE NEW MODAL -->
<div class="modal fade" id="insertdata" tabindex="-1" aria-labelledby="insertdataLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="insertdataLabel">Add New Performance</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form action="performance.php" method="POST">
      <div class="modal-body">

      <label for="">5 - Highest | 1 - Lowest</label><br><br>

      <div class="form-group mb-3">
      <label for="">Employee</label>
      <?php
        $stmt2 = $pdo->prepare('SELECT * from employees');
        $stmt2->execute();
        if($stmt2->rowCount() > 0){
        $dropdown = "<select class='form-select' name='name' required>";
        foreach($stmt2 as $row){
        $dropdown .= "\r\n<option value='{$row['firstname']} {$row['lastname']}'>{$row['firstname']} {$row['lastname']}</option>";
        }
        $dropdown .= "\r\n</select>";
        echo $dropdown;
        echo '</select>';
        }   
        else{
        $dropdown2 = "<select class='form-select' name='name' required>";
        $dropdown2 .= "\r\n</select>";
        echo $dropdown2;
        echo '</select>';
        }
        ?>
      </div>

      <div class="form-group mb-3">
      <label for="">Department</label>
            <select class="form-select" name="department">
            <option selected>Department</option>
            <option value="Business Intelligence">Business Intelligence</option>
            <option value="Accounting & Finance">Accounting & Finance</option>
            <option value="Human Resources">Human Resources</option>
            <option value="Warehouse Management">Warehouse Management</option>
            <option value="Manufacturing & Logistics Management">Manufacturing & Logistics Management</option>
            <option value="Supply Chain Management">Supply Chain Management</option>
            <option value="Inventory Management">Inventory Management</option>
            <option value="Customer Relationship Management">Customer Relationship Management</option>
        </select>
        </div>
        
            <div class="form-group mb-3">
                <label for="">Date</label>
                <input type="date" name="date" class="form-control" placeholder="Enter Date" required>
            </div>

            <div class="form-group mb-3">
            <label for="">Quality of Work&nbsp;&nbsp;</label>
        
            <input class="form-check-input" type="radio" name="qua_work" value="5" checked>
            <label class="form-check-label" for="flexRadioDefault1">
            5
            </label>
        
        
            <input class="form-check-input" type="radio" name="qua_work" value="4">
            <label class="form-check-label" for="flexRadioDefault2">
            4
            </label>
        
        
            <input class="form-check-input" type="radio" name="qua_work" value="3">
            <label class="form-check-label" for="flexRadioDefault2">
            3
            </label>
        
            <input class="form-check-input" type="radio" name="qua_work" value="2">
            <label class="form-check-label" for="flexRadioDefault2">
            2
            </label>


            <input class="form-check-input" type="radio" name="qua_work" value="1">
            <label class="form-check-label" for="flexRadioDefault2">
            1
            </label>
            </div>

            <div class="form-group mb-3">
            <label for="">Character&nbsp;&nbsp;</label>
        
            <input class="form-check-input" type="radio" name="char_rate" value="5" checked>
            <label class="form-check-label" for="flexRadioDefault1">
            5
            </label>
        
        
            <input class="form-check-input" type="radio" name="char_rate" value="4">
            <label class="form-check-label" for="flexRadioDefault2">
            4
            </label>
        
        
            <input class="form-check-input" type="radio" name="char_rate" value="3">
            <label class="form-check-label" for="flexRadioDefault2">
            3
            </label>
        
            <input class="form-check-input" type="radio" name="char_rate" value="2">
            <label class="form-check-label" for="flexRadioDefault2">
            2
            </label>


            <input class="form-check-input" type="radio" name="char_rate" value="1">
            <label class="form-check-label" for="flexRadioDefault2">
            1
            </label>
            </div>

            <div class="form-group mb-3">
            <label for="">Interpersonal Relationsip&nbsp;&nbsp;</label>
        
            <input class="form-check-input" type="radio" name="inter_rel" value="5" checked>
            <label class="form-check-label" for="flexRadioDefault1">
            5
            </label>
        
        
            <input class="form-check-input" type="radio" name="inter_rel" value="4">
            <label class="form-check-label" for="flexRadioDefault2">
            4
            </label>
        
        
            <input class="form-check-input" type="radio" name="inter_rel" value="3">
            <label class="form-check-label" for="flexRadioDefault2">
            3
            </label>
        
            <input class="form-check-input" type="radio" name="inter_rel" value="2">
            <label class="form-check-label" for="flexRadioDefault2">
            2
            </label>


            <input class="form-check-input" type="radio" name="inter_rel" value="1">
            <label class="form-check-label" for="flexRadioDefault2">
            1
            </label>
            </div>
        
            <div class="form-group mb-3">
            <label for="">Creativity&nbsp;&nbsp;</label>
        
        <input class="form-check-input" type="radio" name="creativity" value="5" checked>
        <label class="form-check-label" for="flexRadioDefault1">
        5
        </label>
    
    
        <input class="form-check-input" type="radio" name="creativity" value="4">
        <label class="form-check-label" for="flexRadioDefault2">
        4
        </label>
    
    
        <input class="form-check-input" type="radio" name="creativity" value="3">
        <label class="form-check-label" for="flexRadioDefault2">
        3
        </label>
    
        <input class="form-check-input" type="radio" name="creativity" value="2">
        <label class="form-check-label" for="flexRadioDefault2">
        2
        </label>


        <input class="form-check-input" type="radio" name="creativity" value="1">
        <label class="form-check-label" for="flexRadioDefault2">
        1
        </label>
            </div>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" name="save" class="btn btn-warning">Save</button>
      </div>
      </form>
    </div>
  </div>
</div>


  <!-- DELETE MODAL -->

  <div class="modal fade" id="deletemodal" tabindex="-1" aria-labelledby="deletemodalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="deletemodalLabel">Remove Performance Data</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form action="performance.php" method="POST">
      <div class="modal-body">
        
        <input type="hidden" name="perf_id" id="perf_id">
        
        <div class="form-group mb-3">
          <label for="">Do You Want To Delete This Performance Data?</label>
        </div>

        </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
        <button type="submit" name="deletedata" class="btn btn-warning">Yes</button>
      </div>
      </form>
      </div>
    </div>
  </div>

  <!----- TABLE ----->

  <table id="myTable" class="table table-bordered border-warning">
    <thead>
      <tr>
        <th scope="col">Performance ID</th>
        <th scope="col">Name</th>
        <th scope="col">Department</th>
        <th scope="col">Date</th>
        <th scope="col">Quality of Work</th>
        <th scope="col">Character</th>
        <th scope="col">Interpersonal Relationship</th>
        <th scope="col">Creativity</th>
        <th scope="col">Manage</th>
      </tr>
    </thead>
  <?php 
  $stmt = $pdo->prepare("SELECT * from performance");
  $stmt->execute();
  $result = $stmt->fetchAll();
  foreach($result as $row){
  ?>
  <tr>
  <td><?= $row['perf_id']; ?></td>
  <td><?= $row['name']; ?></td>
  <td><?= $row['department']; ?></td>
  <td><?= $row['date']; ?></td>
  <td><?= $row['qua_work']; ?></td>
  <td><?= $row['char_rate']; ?></td>
  <td><?= $row['inter_rel']; ?></td>
  <td><?= $row['creativity']; ?></td>
  <td>
    <div class="btn-group" role="group" aria-label="Basic mixed styles example">
    <button type="button" class="btn btn-danger deletebtn" data-bs-target="#deletemodal">Delete</button>
    </div>                        
  </td>
  </tr>
  <?php } ?>
</table>

</div>

</section>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.datatables.net/2.0.2/js/dataTables.js"></script>

<script>
  new DataTable('#myTable', {
    paging: false,
    scrollCollapse: true,
    scrollY: '50vh',
    order: [[0, 'desc']]
});
</script>

<script>
  $(document).ready(function () {
    $('.deletebtn').on('click', function() {
      $('#deletemodal').modal('show');

        $tr = $(this).closest('tr');

        var data = $tr.children("td").map(function(){
            return $(this).text();
        }).get();

        console.log(data);

        $('#perf_id').val(data[0]);

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