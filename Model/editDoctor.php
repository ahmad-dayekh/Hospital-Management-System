<?php
include '../View/Common Php Functions/ConnectSql.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $doctorID = $_POST['doctorID'];

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $specialty = mysqli_real_escape_string($conn, $_POST['specialty']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $availability = mysqli_real_escape_string($conn, $_POST['availability']);
    $qualifications = mysqli_real_escape_string($conn, $_POST['qualifications']);

    
    $sql = "UPDATE Doctors SET 
                ContactEmail=?, 
                Name=?, 
                Specialty=?, 
                ContactPhone=?, 
                Availability=?, 
                Qualifications=? 
            WHERE DoctorID=?";

    
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "ssssssi", $email, $name, $specialty, $phone, $availability, $qualifications, $doctorID);
        
        
        if (mysqli_stmt_execute($stmt)) {
            echo "Doctor updated successfully.";
            
            header('Location: ../View/Pages/Admin/Doctors.php');
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
    
    header('Location: ../View/Pages/Admin/Doctors.php');
    exit();
}
?>
