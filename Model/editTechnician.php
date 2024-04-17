<?php
include '../View/Common Php Functions/ConnectSql.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $technicianID = $_POST['technicianID'];

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);

    $sql = "UPDATE LabTechnicians SET 
                ContactEmail=?, 
                FullName=?, 
                ContactPhone=? 
            WHERE TechnicianID=?";

    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "sssi", $email, $name, $phone, $technicianID);
        
        if (mysqli_stmt_execute($stmt)) {
            header('Location: ../View/Pages/Admin/LabTechs.php');
            exit();
        } else {
            echo "Error updating record: " . mysqli_stmt_error($stmt);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing statement: " . mysqli_error($conn);
    }

    mysqli_close($conn);
} else {
    header('Location: ../View/Pages/Admin/LabTechs.php');
    exit();
}
?>
