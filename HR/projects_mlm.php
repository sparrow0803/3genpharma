<?php 
session_start();
require 'conn.php';

    try{
    $pdo = new PDO('mysql:host=localhost;dbname=hr', "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
    echo 'Connection Failed' .$e->getMessage();
    }

    if(isset($_POST['savedata']))
    {
      $project = $_POST['project'];
      $description = $_POST['description'];
      $status = $_POST['status'];
      $budget = $_POST['budget'];
      $duration = $_POST['duration'];
      $start = $_POST['start'];
      $end = $_POST['end'];

      $stmt = $pdo->prepare("INSERT into department(project, description, status, budget, duration, start, end, department) values (:project, :description, :status, :budget, :duration, :start, :end, 'Manufacturing & Logistics Management')");
      $stmt->bindParam(':project', $project);
      $stmt->bindParam(':description', $description);
      $stmt->bindParam(':status', $status);
      $stmt->bindParam(':budget', $budget);
      $stmt->bindParam(':duration', $duration);
      $stmt->bindParam(':start', $start);
      $stmt->bindParam(':end', $end);
      if($stmt->execute()){
          $_SESSION['projadd'] = "Project Added Successfully!";
      }

      else{
          $_SESSION['projfail'] = "Failed To Add Project!";
      }
      
    }


    if(isset($_POST['editdata']))
    {
      $proj_id = $_POST['proj_id'];
      $project = $_POST['project'];
      $description = $_POST['description'];
      $status = $_POST['status'];
      $budget = $_POST['budget'];
      $duration = $_POST['duration'];
      $start = $_POST['start'];
      $end = $_POST['end'];

      $stmt = $pdo->prepare("UPDATE department SET project=:project, description=:description, status=:status, budget=:budget, duration=:duration, start=:start, end=:end  where deptproj_id=:proj_id");
      $stmt->bindParam(':proj_id', $proj_id);
      $stmt->bindParam(':project', $project);
      $stmt->bindParam(':description', $description);
      $stmt->bindParam(':status', $status);
      $stmt->bindParam(':budget', $budget);
      $stmt->bindParam(':duration', $duration);
      $stmt->bindParam(':start', $start);
      $stmt->bindParam(':end', $end);
      if($stmt->execute()){
        $_SESSION['editsucc'] = "Project Data Has Been Edited Successfully!";
    }

    else{
        $_SESSION['editfail'] = "Failed To Edit Project Data!";
    }
    }


    if(isset($_POST['deletedata']))
    {
      $proj_id2 = $_POST['proj_id2'];

      $stmt = $pdo->prepare("DELETE from department where deptproj_id=:proj_id2");
      $stmt->bindParam(':proj_id2', $proj_id2);
      if($stmt->execute()){
        $_SESSION['deletesucc'] = "Project Deleted Successfully!";
    }
    else{
        $_SESSION['deletefail'] = "Failed To Delete Project!";
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
            if (isset($_SESSION['projadd'])) {
            echo '<div class="badge text-bg-success text-wrap" style="width: 20rem;">'
            .$_SESSION['projadd'].
            '</div>'; }
            unset($_SESSION['projadd']);

            if (isset($_SESSION['editsucc'])) {
              echo '<div class="badge text-bg-success text-wrap" style="width: 20rem;">'
              .$_SESSION['editsucc'].
              '</div>'; }
              unset($_SESSION['editsucc']);

                if (isset($_SESSION['deletesucc'])) {
                  echo '<div class="badge text-bg-success text-wrap" style="width: 20rem;">'
                  .$_SESSION['deletesucc'].
                  '</div>'; }
                  unset($_SESSION['deletesucc']);

            if (isset($_SESSION['projfail'])) {
              echo '<div class="badge text-bg-danger text-wrap" style="width: 20rem;">'
              .$_SESSION['projfail'].
              '</div>'; }
              unset($_SESSION['projfail']);

              if (isset($_SESSION['editfail'])) {
                echo '<div class="badge text-bg-danger text-wrap" style="width: 20rem;">'
                .$_SESSION['editfail'].
                '</div>'; }
                unset($_SESSION['editfail']);

                    if (isset($_SESSION['deletefail'])) {
                      echo '<div class="badge text-bg-danger text-wrap" style="width: 20rem;">'
                      .$_SESSION['deletefail'].
                      '</div>'; }
                      unset($_SESSION['deletefail']);
?>


<!----- NAVBAR ----->

<div class="row g-0 text-center">
<div class="text-start col-sm-6 col-md-8">MANUFACTURING & LOGISTICS MANAGEMENT PROJECTS</div>
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
        <h1 class="modal-title fs-5" id="insertdataLabel">Add New Project</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form action="projects_mlm.php" method="POST">
      <div class="modal-body">
        
        <div class="form-group mb-3">
          <label for="">Project</label>
          <input type="text" name="project" class="form-control" placeholder="Enter Project" required>
        </div>

        <div class="form-group mb-3">
          <label for="">Description</label>
          <input type="text" name="description" class="form-control" placeholder="Enter Description" required>
        </div>

        <div class="form-group mb-3">
          <label for="">Status</label>
          <select class="form-select" name="status">
          <option selected>Status</option>
          <option value="On-Going">On-Going</option>
          <option value="Hiatus">Hiatus</option>
          <option value="Pending Approval">Pending Approval</option>
          <option value="Finished">Finished</option>
          <option value="Canceled">Canceled</option>
          </select>
        </div>

        <div class="form-group mb-3">
          <label for="">Budget</label>
          <input type="text" name="budget" class="form-control" placeholder="Enter Budget" required>
        </div>

        <div class="form-group mb-3">
          <label for="">Duration</label>
          <input type="text" name="duration" class="form-control" placeholder="Enter Duration" required>
        </div>

        <div class="form-group mb-3">
          <label for="">Start Date</label>
          <input type="date" name="start" class="form-control" placeholder="Enter Start Date" required>
        </div>

        <div class="form-group mb-3">
          <label for="">End Date</label>
          <input type="date" name="end" class="form-control" placeholder="Enter End Date">
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" name="savedata" class="btn btn-warning">Save</button>
      </div>
      </form>
    </div>
  </div>
</div>


<!-- EDIT MODAL -->

<div class="modal fade" id="editmodal" tabindex="-1" aria-labelledby="editmodalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="editmodalLabel">Edit Project Data</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form action="projects_mlm.php" method="POST">
      
      <div class="modal-body">
        
      <input type="hidden" name="proj_id" id="proj_id">

        <div class="form-group mb-3">
          <label for="">Project</label>
          <input type="text" name="project" id="project" class="form-control" placeholder="Enter Project" required>
        </div>

        <div class="form-group mb-3">
          <label for="">Description</label>
          <input type="text" name="description" id="description" class="form-control" placeholder="Enter Description" required>
        </div>

        <div class="form-group mb-3">
          <label for="">Status</label>
          <select class="form-select" name="status" id="status">
          <option value="On-Going">On-Going</option>
          <option value="Hiatus">Hiatus</option>
          <option value="Pending Approval">Pending Approval</option>
          <option value="Finished">Finished</option>
          <option value="Canceled">Canceled</option>
          </select>
        </div>

        <div class="form-group mb-3">
          <label for="">Budget</label>
          <input type="text" name="budget" id="budget" class="form-control" placeholder="Enter Budget" required>
        </div>

        <div class="form-group mb-3">
          <label for="">Duration</label>
          <input type="text" name="duration" id="duration" class="form-control" placeholder="Enter Duration" required>
        </div>

        <div class="form-group mb-3">
          <label for="">Start Date</label>
          <input type="date" name="start" id="start" class="form-control" placeholder="Enter Start Date" required>
        </div>

        <div class="form-group mb-3">
          <label for="">End Date</label>
          <input type="date" name="end" id="end" class="form-control" placeholder="Enter End Date">
        </div>

        </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" name="editdata" class="btn btn-warning">Update</button>
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
        <h1 class="modal-title fs-5" id="deletemodalLabel">Remove Project</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form action="projects_mlm.php" method="POST">
      <div class="modal-body">
        
        <input type="hidden" name="proj_id2" id="proj_id2">
        
        <div class="form-group mb-3">
          <label for="">Do You Want To Delete This Project?</label>
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
        <th scope="col">Project ID</th>
        <th scope="col">Project</th>
        <th scope="col">Description</th>
        <th scope="col">Status</th>
        <th scope="col">Budget</th>
        <th scope="col">Duration</th>
        <th scope="col">Start</th>
        <th scope="col">End</th>
        <th scope="col">Manage</th>
      </tr>
    </thead>
  <?php 
  $stmt = $pdo->prepare("SELECT * from department where department = 'Manufacturing & Logistics Management' ");
  $stmt->execute();
  $result = $stmt->fetchAll();
  foreach($result as $row){
  ?>
  <tr>
  <td><?= $row['deptproj_id']; ?></td>
  <td><?= $row['project']; ?></td>
  <td><?= $row['description']; ?></td>
  <td><?= $row['status']; ?></td>
  <td><?= $row['budget']; ?></td>
  <td><?= $row['duration']; ?></td>
  <td><?= $row['start']; ?></td>
  <td><?= $row['end']; ?></td>
  <td>
    <div class="btn-group" role="group" aria-label="Basic mixed styles example">
    <button type="button" class="btn btn-warning editbtn" data-bs-target="#editmodal">Edit</button>
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
    scrollY: '50vh'
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

        $('#proj_id2').val(data[0]);

    });
  });
</script>

<script>
  $(document).ready(function () {
    $('.editbtn').on('click', function() {
      $('#editmodal').modal('show');

        $tr = $(this).closest('tr');

        var data = $tr.children("td").map(function(){
            return $(this).text();
        }).get();

        console.log(data);

        $('#proj_id').val(data[0]);
        $('#project').val(data[1]);
        $('#description').val(data[2]);
        $('#status').val(data[3]);
        $('#budget').val(data[4]);
        $('#duration').val(data[5]);
        $('#start').val(data[6]);
        $('#end').val(data[7]);

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