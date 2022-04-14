<?php
  // Include config file
  require_once "config.php";
  //error_reporting(E_ALL ^ E_DEPRECATED);

  $nameArray = [];
  $addressArray = [];
  $emailArray = [];
  $idArray = [];




  $query = 'select * from dcms.Patient order by name';
  $rs = pg_query($dbconnect, $query) or die ("Error: ".pg_last_error());
  while ($row = pg_fetch_row($rs)) {
    $idArray[] = $row[0];
    $nameArray[] = $row[1];
    $emailArray[] = $row[5];
    $addressArray[] = $row[7];
  }
  
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>DCMS: Receptionist </title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
<a href="logout.php"><button>Log Out</button></a>
<div class="container">
  <h2>Receptionist Page</h2>
    <a href="receptionistAddPatient.php">
      <button>Add Patient</button>

    </a>
</div>

<div class="container"> 
  <?php
    $size = sizeof($nameArray);
    for ($x = 0; $x < $size; $x++) {
      echo "<br/><h4 style='font-weight:bold;'>".$nameArray[$x]."</h4>".$addressArray[$x]."<br/>".$emailArray[$x]."<br/><br/><a href='receptionistEditPatient.php?id=$idArray[$x]'><button>Edit Information</button></a><a href='receptionistSetPatientAppointment.php?id=$idArray[$x]'><button>Set Appointment</button></a><br/>";
    }
  
  
  ?>

</div>



</body>
</html>