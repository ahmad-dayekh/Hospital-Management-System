<?php 

include "../../Common PHP Functions/ConnectSql.php";  
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
  <a href="Doctors.php">
    <span class="material-icons-sharp">medical_services</span>
    <h3>Doctors</h3>
  </a>
  <a href="LabTechs.php">
    <span class="material-icons-sharp">science</span>
    <h3>Lab Technicians</h3>
  </a>
  <a href="Patients.php">
    <span class="material-icons-sharp">personal_injury</span>
    <h3>Patients</h3>
  </a>
  <a href="Appointments.php">
    <span class="material-icons-sharp">bookmark</span>
    <h3>Appointments</h3>
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
    <!-- Status Boxes -->
    <div class="status-overview">
      <div class="status-box">
        <span class="material-icons-sharp status-icon doctor-icon">local_hospital</span>
        <h3>Doctors</h3>
        <p><?php echo $doctorsCount; ?></p>
      </div>
      <div class="status-box">
        <span class="material-icons-sharp status-icon patient-icon">person</span>
        <h3>Patients</h3>
        <p><?php echo $patientsCount; ?></p>
      </div>
      <div class="status-box">
        <span class="material-icons-sharp status-icon labtech-icon">science</span>
        <h3>Lab Techs</h3>
        <p><?php echo $labTechsCount; ?></p>
      </div>
      <div class="status-box">
        <span class="material-icons-sharp status-icon appointment-icon">event_note</span>
        <h3>Today's Appointments</h3>
        <p><?php echo $todayAppointmentsCount; ?></p>
      </div>
    </div>
  
    <!-- Upcoming Appointments -->
    <div class="data-table-container">
      <h2>Upcoming Appointments for the Next 7 Days</h2>
      <table>
        <thead>
          <tr>
            <th>Appointment ID</th>
            <th>Patient Name</th>
            <th>Date</th>
            <th>Time</th>
            <th>Doctor Assigned</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $query = "SELECT a.AppointmentID, p.FullName AS PatientName, a.AppointmentDate, d.Name AS DoctorName 
                    FROM Appointments a
                    JOIN Patients p ON a.PatientID = p.PatientID
                    JOIN Doctors d ON a.DoctorID = d.DoctorID
                    WHERE a.AppointmentDate BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY)
                    ORDER BY a.AppointmentDate ASC
                    LIMIT 2";
          $result = $conn->query($query);
          if ($result->num_rows > 0) {
              while($row = $result->fetch_assoc()) {
                  echo "<tr>
                        <td>APPT-" . htmlspecialchars($row['AppointmentID']) . "</td>
                        <td>" . htmlspecialchars($row['PatientName']) . "</td>
                        <td>" . date('M d, Y', strtotime($row['AppointmentDate'])) . "</td>
                        <td>" . date('h:i A', strtotime($row['AppointmentDate'])) . "</td>
                        <td>" . htmlspecialchars($row['DoctorName']) . "</td>
                        </tr>";
              }
          } else {
              echo "<tr><td colspan='5'>No upcoming appointments</td></tr>";
          }
          ?>
        </tbody>
      </table>
      <button><a href="Appointments.php" style="text-decoration:none; color:white">Show all Appointments</a></button>
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