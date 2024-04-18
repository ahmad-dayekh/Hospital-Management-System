<?php
include '../View/Common Php Functions/ConnectSql.php';

// Initialize an array to hold the appointment data
$response = [];

// Check if doctorId is set and valid
$doctorId = isset($_GET['doctorId']) ? intval($_GET['doctorId']) : 0;

// Create SQL query
if ($doctorId > 0) {
    $sql = "SELECT a.AppointmentID, p.FullName AS PatientName, d.Name AS DoctorName, 
            a.AppointmentDate, a.Status, a.Notes
            FROM Appointments a
            JOIN Patients p ON a.PatientID = p.PatientID
            JOIN Doctors d ON a.DoctorID = d.DoctorID
            WHERE a.DoctorID = ?";
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $doctorId);
    }
} else {
    // If no doctor is selected, fetch all appointments
    $sql = "SELECT a.AppointmentID, p.FullName AS PatientName, d.Name AS DoctorName, 
            a.AppointmentDate, a.Status, a.Notes
            FROM Appointments a
            JOIN Patients p ON a.PatientID = p.PatientID
            JOIN Doctors d ON a.DoctorID = d.DoctorID";
    $stmt = mysqli_prepare($conn, $sql);
}

// Execute the query
if ($stmt) {
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_assoc($result)) {
        $response[] = $row;
    }
    mysqli_stmt_close($stmt);
}

// Close the database connection
mysqli_close($conn);

// Return the data in JSON format
echo json_encode($response);
?>
