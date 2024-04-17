<?php
include '../View/Common Php Functions/ConnectSql.php';

if (isset($_GET['doctorId'])) {
    $doctorId = $_GET['doctorId'];
    $query = "SELECT * FROM Doctors WHERE DoctorID = ?";
    if ($stmt = mysqli_prepare($conn, $query)) {
        mysqli_stmt_bind_param($stmt, "i", $doctorId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $doctorData = mysqli_fetch_assoc($result);
        echo json_encode($doctorData);
        mysqli_stmt_close($stmt);
    } else {
        echo json_encode(["error" => "Error preparing statement"]);
    }
    mysqli_close($conn);
}
?>
