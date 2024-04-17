<?php
include '../View/Common PHP Functions/ConnectSql.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $fullName = mysqli_real_escape_string($conn, $_POST['fullName']);
    $contactEmail = mysqli_real_escape_string($conn, $_POST['contactEmail']);
    $contactPhone = mysqli_real_escape_string($conn, $_POST['contactPhone']);
    
    
    
    $passwordHash = password_hash('123', PASSWORD_DEFAULT);
    $isActive = 1; 

    
    $sql = "INSERT INTO LabTechnicians (Username, PasswordHash, FullName, ContactEmail, ContactPhone, IsActive) VALUES (?, ?, ?, ?, ?, ?)";
    
    if ($stmt = mysqli_prepare($conn, $sql)) {
        
        mysqli_stmt_bind_param($stmt, "sssssi", $param_username, $param_passwordHash, $param_fullName, $param_contactEmail, $param_contactPhone, $param_isActive);
        
        
        $param_username = $username;
        $param_passwordHash = $passwordHash;
        $param_fullName = $fullName;
        $param_contactEmail = $contactEmail;
        $param_contactPhone = $contactPhone;
        $param_isActive = $isActive;
        
        if (mysqli_stmt_execute($stmt)) {
            
            header("Location: ../View/Pages/Admin/LabTechs.php");
            exit();
        } else {
            echo "Something went wrong. Please try again later.";
        }

        
        mysqli_stmt_close($stmt);
    }
    
    
    mysqli_close($conn);
} else {
    header("Location: ../View/Pages/Admin/LabTechs.php");
    exit();
}
?>
