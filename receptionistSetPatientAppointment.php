<?php
// Include config file
require_once "config.php";

    /*
    appointment_ID INTEGER, 
	treatment_ID INTEGER,
    patient_ID INTEGER,
    dentist INTEGER,
    date DATE,
    startTime VARCHAR(20),
    endTime VARCHAR(20),
    appointmentType VARCHAR(20),
    status VARCHAR(20),
    room VARCHAR(20),
    */

$patientID = [];
$query = 'select * from dcms.Patient';
$rs = pg_query($dbconnect, $query) or die ("Error: ".pg_last_error());
while ($row = pg_fetch_row($rs)) {
    $patientID[] = $row[0];
}

$dentistNames = [];
$dentistID = [];
$queryEmployees = 'select * from dcms.employee';
$rs2 = pg_query($dbconnect, $queryEmployees) or die ("Error: ".pg_last_error());
while ($row = pg_fetch_row($rs2)){
    $dentistNames[] = $row[1];
    $dentistID[] = $row[0];
}

$randomNum = random_int(1,99999999);
$apptNum = $randomNum;
$treatmentNum = $randomNum;

if(isset($_POST['submit'])&&!empty($_POST['submit'])){
  if ($_POST['date'] != NULL && $_POST['startTime'] != NULL && $_POST['endTime'] != NULL && $_POST['apptType'] != NULL && $_POST['status'] != NULL && $_POST['room'] != NULL) {
    $sql = "insert into dcms.Appointment(appointment_ID,treatment_ID,patient_ID,dentist,date,startTime,endTime,appointmentType,status,room) values('".$apptNum."','".$treatmentNum."','".$patientID[0]."','".$_POST['dentist']."','".$_POST['date']."','".$_POST['startTime']."','".$_POST['endTime']."','".$_POST['apptType']."','".$_POST['status']."','".$_POST['room']."')";
    $ret = pg_query($dbconnect, $sql);
  
  }
  else {
    echo "<p style='color:#EA0730;font-weight: bold;'>"."Please fill out all required fields marked with an *"."</p>";
  }
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>DCMS: Set Patient Appointment </title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2>Set Patient Appointment</h2>
  <a href="receptionist.php">
      <button>Go back</button>
    </a>
  <form method="post">

    <div class="form-group">
      <label for="patientID"><?php echo "<h3>Patient ID: $patientID[0] <br></h3>" ?> </label>
    </div>

    <div class="form-group">
      <label for="apptID"><?php echo "<h3>Appointment ID: $apptNum</h3>"?></label>
    </div>

    <div class="form-group">
      <label for="treatmentID"><?php echo "<h3>Treatment ID: $treatmentNum</h3>" ?></label>
    </div>
    
     <br>
    <h3>Dentist</h3>
    <div class="form-group">
        
      <label for="dentist">Select The Dentist's Name:</label>
            <select name="dentist" id="dentist">
                <?php
                    $length = sizeof($dentistNames);
                    for ($i = 0; $i < $length; $i++){
                        echo "<option id='dentist' value='$dentistID[$i]'>$dentistNames[$i]</option>";
                    }
                ?>
            </select>
    </div>
   
    <br>
    <h3>Time</h3>
    <div class="form-group">
      <label for="date">Appointment Date:</label>
      <input type="text" class="form-control" id="date" placeholder="yyyy/mm/dd" name="date">
    </div>

    <div class="form-group">
      <label for="startTime">Start Time:</label>
      <input type="text" class="form-control" id="startTime" placeholder="Enter Start Time" name="startTime">
    </div>

    <div class="form-group">
      <label for="endTime">End Time:</label>
      <input type="text" class="form-control" id="endTime" placeholder="Enter End Time" name="endTime">
    </div>
    <br>

    <h3>General Info</h3>
    <div class="form-group">
      <label for="apptType">Appointment Type:</label>
      <input type="text" class="form-control" id="apptType" placeholder="Enter Appointment Type" name="apptType">
    </div>

    <div class="form-group">
      <label for="status">Status:</label>
      <input type="text" class="form-control" id="status" placeholder="Enter Status (Complete / Not Complete)" name="status">
    </div>

    <div class="form-group">
      <label for="room">Room:</label>
      <input type="text" class="form-control" id="room" placeholder="Enter Room Number" name="room">
    </div>
    <br>

    <input type="submit" name="submit" class="btn btn-primary" value="Submit">
  </form>
</div>


</body>
</html>