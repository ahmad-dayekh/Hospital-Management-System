<?php
include '../View/Common PHP Functions/ConnectSql.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);

    
    $username = explode("@", $email)[0]; 
    $passwordHash = password_hash('123', PASSWORD_DEFAULT); 
    $isActive = 1; 

    
    $sql = "INSERT INTO LabTechnicians (Username, PasswordHash, FullName, ContactEmail, ContactPhone, IsActive) VALUES (?, ?, ?, ?, ?, ?)";

    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "sssssi", $username, $passwordHash, $name, $email, $phone, $isActive);

        if (mysqli_stmt_execute($stmt)) {
            
            header("Location: ../View/Pages/Admin/LabTechs.php");
            exit();
        } else {
            echo "Something went wrong. Please try again later: " . mysqli_stmt_error($stmt);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing statement: " . mysqli_error($conn);
    }

    mysqli_close($conn);
} else {
    
    header("Location: ../View/Pages/Admin/LabTechs.php");
    exit();
}
?>
