<?php
  // Include config file
  require_once "config.php";
  //error_reporting(E_ALL ^ E_DEPRECATED);

  $bManagerID = $_GET['id'];
  $nameArray = [];
  $empIDArray = [];
  $roleArray = [];


    
    $sql =  "select * from dcms.branchmanager";
    $ret = pg_query($dbconnect, $sql);
    while ($row = pg_fetch_row($ret)) {
        if ($bManagerID == $row[0]) {
            $branch_id = $row[1];
        }
        
      }

    $query = 'select * from dcms.Employee order by name';
    $rs = pg_query($dbconnect, $query) or die ("Error: ".pg_last_error());
    while ($row = pg_fetch_row($rs)) {
        if ($row[7] == $branch_id) {
        $nameArray[] = $row[1];
        $empIDArray[] = $row[0];
        $roleArray[] = $row[3];
      }
    }
    
  
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>DCMS: Branch Manager </title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
<a href="logout.php"><button>Log Out</button></a>
<div class="container">
  <h2>Branch Manager Page</h2>
    <a href="bManagerAddEmployee.php?branchId=<?php echo $branch_id?>&id=<?php echo $bManagerID?>">
      <button>Add New Employee</button>
    </a>
    <a href="viewBranch.php?branchId=<?php echo $branch_id?>&id=<?php echo $bManagerID?>">
      <button>View branch information</button>
    </a>
</div>

<div class="container"> 
  <?php
    $size = sizeof($nameArray);
    for ($x = 0; $x < $size; $x++) {
        if ($roleArray[$x] == "dentistHygienist") {
            $displayRole = "Occupation: Dentist/Hygienist";
        }
        else {
            $displayRole = "Occupation: Receptionist";
        }

        $displayEmpID = "Employee ID: ".$empIDArray[$x];
        $userQuery = "select username, password from dcms.\"User\" where user_id =".$empIDArray[$x];
        $userRs = pg_query($dbconnect, $userQuery) or die ("Error: ".pg_last_error());
        $arr1 = pg_fetch_all_columns($userRs,0);
        $username = $arr1[0];
        $password = "password";
        $displayUsername = "Username: ".$username;
        $displayPassword = "Password: ".$password;

        echo "<br/><h4 style='font-weight:bold;'>".$nameArray[$x]."</h4>".$displayEmpID."<br/>".$displayRole."<br/>".$displayUsername."<br/>".$displayPassword."<br/><br/><a href='bManagerEditEmployee.php?id=$empIDArray[$x]&managerID=$bManagerID'><button>Edit Information</button></a><a href='bManagerDeleteEmployee.php?id=$empIDArray[$x]&managerID=$bManagerID'><button>Delete Employee</button></a><br/>";
    }
  
  
  ?>

</div>



</body>
</html>