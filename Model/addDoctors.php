<?php
include '../View/Common PHP Functions/ConnectSql.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // to prevent sql injections
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $specialty = mysqli_real_escape_string($conn, $_POST['specialty']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $availability = mysqli_real_escape_string($conn, $_POST['availability']);
    $qualifications = mysqli_real_escape_string($conn, $_POST['qualifications']);
    $username = explode("@", $email)[0];
    $passwordHash = password_hash('123', PASSWORD_DEFAULT);

    $sql = "INSERT INTO Doctors (Username, PasswordHash, Name, Specialty, ContactEmail, ContactPhone, Availability, Qualifications) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "ssssssss", $username, $passwordHash, $name, $specialty, $email, $phone, $availability, $qualifications);
        
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            
            
            header('Location: ../View/Pages/Admin/Doctors.php');
            exit();
        } else {
            echo "Error: " . mysqli_stmt_error($stmt);
            mysqli_stmt_close($stmt);
        }
    } else {
        echo "Error preparing statement: " . mysqli_error($conn);
    }
    
    mysqli_close($conn);
} 
else {
    header('Location: ../View/Pages/Admin/Doctors.php');
    exit();
}
?>
