<?php include "../../Common PHP Functions/ConnectSql.php";  
$doctorsCountQuery = "SELECT COUNT(*) AS total FROM Doctors";
$patientsCountQuery = "SELECT COUNT(*) AS total FROM Patients";
$labTechsCountQuery = "SELECT COUNT(*) AS total FROM LabTechnicians";
$todayAppointmentsCountQuery = "SELECT COUNT(*) AS total FROM Appointments WHERE DATE(AppointmentDate) = CURDATE()";

$doctorsCount = $conn->query($doctorsCountQuery)->fetch_assoc()['total'];
$patientsCount = $conn->query($patientsCountQuery)->fetch_assoc()['total'];
$labTechsCount = $conn->query($labTechsCountQuery)->fetch_assoc()['total'];
$todayAppointmentsCount = $conn->query($todayAppointmentsCountQuery)->fetch_assoc()['total'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard</title>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
<link href="styles.css" rel="stylesheet">
</head>
<body>

<div class="sidebar">
  <div class="profile">
    <span class="material-icons-sharp">account_circle</span>
    <h3>Administrator</h3>
    <p>admin@edoc.com</p>
  </div>
  <a href="DashBoard.php" class="active">
    <span class="material-icons-sharp">dashboard</span>
    <h3>Dashboard</h3>
  </a>
  <a href="Messages.php">
    <span class="material-icons-sharp">mail</span>
    <h3>Messages</h3>
  </a>
  <div class="logout-button">
    <a href="#">Log out</a>
  </div>
</div>
<div class="main-content">
    <div class="header1">
        <div class="date-display">
          <span class="material-icons-sharp">today</span>
          <div id="current-date" class="date"></div>
        </div>
      </div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
      var dateElement = document.getElementById('current-date');
      var today = new Date();
      var options = { year: 'numeric', month: 'long', day: 'numeric' };
      var dateString = today.toLocaleDateString('en-US', options);
      dateElement.textContent = dateString;
    });
</script>
</body>
</html>

<?php $conn->close(); ?>