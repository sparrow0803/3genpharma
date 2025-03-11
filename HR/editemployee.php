<?php 
session_start();
require 'conn.php';

    try{
    $pdo = new PDO('mysql:host=localhost;dbname=hr', "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
    echo 'Connection Failed' .$e->getMessage();
    }

    if(isset($_GET['editemployee']))
    {
        $emp_id = $_GET['editemployee'];
        $stmt = $pdo->prepare('SELECT * from employees where emp_id = :emp_id');
        $stmt->bindParam(':emp_id', $emp_id);
        $stmt->execute();
        $result = $stmt->fetchAll();
        foreach($result as $row){
        }

    

    if(isset($_POST['update']))
    {
        $emp_id3 = $_GET['editemployee'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $middlename = $_POST['middlename'];
        $suffix = $_POST['suffix'];
        $fullname = $firstname.' '.$lastname;
        $email = $_POST['email'];
        $contact = $_POST['contact'];
        $birthday = $_POST['birthday'];
        $marital_status = $_POST['marital_status'];
        $department = $_POST['department'];
        $gender = $_POST['gender'];
        $nationality = $_POST['nationality'];
        $zip_code = $_POST['zip_code'];
        $address = $_POST['address'];
        $hire_date = $_POST['hire_date'];
        $emp_status = $_POST['emp_status'];
        $shift_per_day = $_POST['shift_per_day'];
        $shift_start = $_POST['shift_start'];
        $position = $_POST['position'];
        $monthly_salary = $_POST['monthly_salary'];

      $stmt3 = $pdo->prepare("UPDATE employees SET firstname=:firstname, lastname=:lastname, middlename=:middlename, suffix=:suffix, 
      fullname=:fullname, email=:email, contact=:contact, birthday=:birthday, marital_status=:marital_status, department=:department, 
        gender=:gender, nationality=:nationality, zip_code=:zip_code, address=:address, hire_date=:hire_date,
        emp_status=:emp_status, shift_per_day=:shift_per_day, shift_start=:shift_start, position=:position, monthly_salary=:monthly_salary where emp_id=:emp_id3");
        $stmt3->bindParam(':emp_id3', $emp_id3);
        $stmt3->bindParam(':firstname', $firstname);
        $stmt3->bindParam(':lastname', $lastname);
        $stmt3->bindParam(':middlename', $middlename);
        $stmt3->bindParam(':suffix', $suffix);
        $stmt3->bindParam(':fullname', $fullname);
        $stmt3->bindParam(':email', $email);
        $stmt3->bindParam(':contact', $contact);
        $stmt3->bindParam(':birthday', $birthday);
        $stmt3->bindParam(':marital_status', $marital_status);
        $stmt3->bindParam(':department', $department);
        $stmt3->bindParam(':gender', $gender);
        $stmt3->bindParam(':nationality', $nationality);
        $stmt3->bindParam(':zip_code', $zip_code);
        $stmt3->bindParam(':address', $address);
        $stmt3->bindParam(':hire_date', $hire_date);
        $stmt3->bindParam(':emp_status', $emp_status);
        $stmt3->bindParam(':shift_per_day', $shift_per_day);
        $stmt3->bindParam(':shift_start', $shift_start);
        $stmt3->bindParam(':position', $position);
        $stmt3->bindParam(':monthly_salary', $monthly_salary);
      if($stmt3->execute()){
        $_SESSION['editsucc'] = "Employee Data Has Been Edited Successfully!";
        header('location:listemployees.php');
    }

    else{
        $_SESSION['editfail'] = "Failed To Edit Employee Data!";
        header('location:listemployees.php');
    }
    }
}

    if(isset($_POST['editpicture'])){
      $emp_id2 = $_POST['change'];
      $filename = $_FILES['choosefile']['name'];
      $tempfile = $_FILES['choosefile']['tmp_name'];
      $folder = "picture/".$filename;

      $stmt2 = $pdo->prepare("UPDATE employees SET photo=:filename where emp_id=:emp_id2");
      $stmt2->bindParam(':emp_id2', $emp_id2);
      $stmt2->bindParam(':filename', $filename);
      if($stmt2->execute()){
        $_SESSION['picsucc'] = "Employee's Picture Has Been Updated Successfully!";
        move_uploaded_file($tempfile, $folder);
        header('location: listemployees.php');
    }
    else{
        $_SESSION['picfail'] = "Failed To Update Employee's Picture!";
        header('location: listemployees.php');
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

  <!-- CHANGE PICTURE MODAL -->

  <div class="modal fade" id="picturemodal" tabindex="-1" aria-labelledby="picturemodalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="picturemodalLabel">Update Picture</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form action="editemployee.php" method="POST" enctype="multipart/form-data">
      <div class="modal-body">
        
        <input type="hidden" name="change" value="<?php echo $row['emp_id']; ?>">
        
        <div class="form-group mb-3">
          <label for="">2x2 Picture</label>
          <input type="file" name="choosefile" class="form-control" accept="image/jpg, image/png, image/jpeg" required>
        </div>

        </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" name="editpicture" class="btn btn-warning">Update</button>
      </div>
      </form>
      </div>
    </div>
  </div>


<!----- NAVBAR ----->
<div class="p-3">
<div class="row g-0 text-center">
<div class="text-start col-sm-6 col-md-8">EMPLOYEE INFORMATION</div>
</div>

<br>

<form method="POST" action="#">

<div class="text-center">
<?php
if (empty($row['photo'])){
    echo "<img class='img-thumbnail' width='300rem' src='picture/employee.jpg'>";
}
else
{
    echo "<img class='img-thumbnail' width='300rem' src='picture/" .$row['photo']. "'>";
}
?>

<br><br>

<div class="col">
<button type="button" class="btn btn-warning picturebtn" data-bs-target="picturemodal">Change Picture</button>
</div>

</div>

<br>

<div class="row">
  <div class="col">
  <label>First Name</label>
    <input type="text" class="form-control" name="firstname" placeholder="First Name" value="<?php echo $row['firstname']; ?>" required>
  </div>
  <div class="col">
  <label>Last Name</label>
    <input type="text" class="form-control" name="lastname" placeholder="Last Lame" value="<?php echo $row['lastname']; ?>" required>
  </div>
  <div class="col">
  <label>Middle Name</label>
    <input type="text" class="form-control" name="middlename" placeholder="Middle Name" value="<?php echo $row['middlename']; ?>" required>
  </div>
  <div class="col">
  <label>Suffix</label>
    <input type="text" class="form-control" name="suffix" placeholder="Suffix" value="<?php echo $row['suffix']; ?>" required>
  </div>
</div>

<br>

<div class="row">
  <div class="col">
  <label>Birthday</label>
  <div class="input-group">
    <div class="input-group-text">Birthday</div>
    <input type="date" class="form-control" value="<?php echo $row['birthday']; ?>" name="birthday" required>
  </div>
  </div>
  <div class="col">
  <label>Marital Status</label>
    <input type="text" class="form-control" name="marital_status" placeholder="Marital Status" value="<?php echo $row['marital_status']; ?>" required>
  </div>
</div>

<br>

<div class="row">
  <div class="col">
  <label>Email</label>
    <input type="email" class="form-control" name="email" placeholder="Email" value="<?php echo $row['email']; ?>" required>
  </div>
  <div class="col">
  <label>Contact #</label>
    <input type="text" class="form-control" name="contact" placeholder="Contact #" value="<?php echo $row['contact']; ?>" required>
  </div>
</div>

<br>

<div class="row">
  <div class="col">
  <label>Department</label>
    <select class="form-select" name="department">
    <option selected><?php echo $row['department']; ?></option>
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
  <div class="col">
  <label>Nationality</label>
    <input type="text" class="form-control" name="nationality" placeholder="Nationality" value="<?php echo $row['nationality']; ?>" required>
  </div>
  <div class="col">
  <label>Zip Code</label>
    <input type="number" class="form-control" name="zip_code" placeholder="Zip Code" value="<?php echo $row['zip_code']; ?>" required>
  </div>
  <div class="col">
  <label>Gender</label>
    <input type="text" class="form-control" name="gender" placeholder="Gender" value="<?php echo $row['gender']; ?>" required>
  </div>
</div>

<br>

<div class="row">
  <div class="col">
  <label>Address</label>
    <input type="text" class="form-control" name="address" placeholder="Address" value="<?php echo $row['address']; ?>" required>
  </div>
</div>

<br>

<div class="row">
  <div class="col">
  <label>Date Hired</label>
  <div class="input-group">
    <div class="input-group-text">Date Hired</div>
    <input type="date" class="form-control" value="<?php echo $row['hire_date']; ?>" name="hire_date" required>
  </div>
  </div>
  <div class="col">
  <label>Employment Status</label>
    <input type="text" class="form-control" name="emp_status" placeholder="Employment Status" value="<?php echo $row['emp_status']; ?>" required>
  </div>
  <div class="col">
  <label>Shift Per Day (Hours)</label>
    <input type="number" class="form-control" name="shift_per_day" placeholder="Shift Per Day (Hours)" value="<?php echo $row['shift_per_day']; ?>" required>
  </div>
  <div class="col">
  <label>Shift Start</label>
  <div class="input-group">
    <div class="input-group-text">Shift Start</div>
    <input type="time" class="form-control" value="<?php echo $row['shift_start']; ?>" name="shift_start" required>
  </div>
  </div>
</div>

<br>

<div class="row">
  <div class="col">
  <label>Position</label>
    <input type="text" class="form-control" name="position" placeholder="Position" value="<?php echo $row['position']; ?>" required>
  </div>
  <div class="col">
  <label>Monthly Salary</label>
    <input type="number" class="form-control" name="monthly_salary" placeholder="Monthly Salary" value="<?php echo $row['monthly_salary']; ?>" required>
  </div>
</div>

<br>

<div class="modal-footer">
<button type="button" name="back" class="btn btn-secondary" onclick="history.back()">Back</button>
<button type="submit" name="update" class="btn btn-warning">Update</button>
</div>

</form>

</div>

</section>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.datatables.net/2.0.2/js/dataTables.js"></script>

<script>
  $(document).ready(function () {
    $('.picturebtn').on('click', function() {
      $('#picturemodal').modal('show');
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