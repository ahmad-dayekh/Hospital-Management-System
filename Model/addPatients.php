<?php
include '../View/Common Php Functions/ConnectSql.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $fullName = mysqli_real_escape_string($conn, $_POST['fullName']);
    $dateOfBirth = mysqli_real_escape_string($conn, $_POST['DateOfBirth']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $contactEmail = mysqli_real_escape_string($conn, $_POST['email']);
    $contactPhone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $medicalHistory = mysqli_real_escape_string($conn, $_POST['medicalHistory']);
    $allergies = mysqli_real_escape_string($conn, $_POST['allergies']);
    $currentMedications = mysqli_real_escape_string($conn, $_POST['currentMedications']);
    $isActive = 1;

    $passwordHash = password_hash('123', PASSWORD_DEFAULT);

    $sql = "INSERT INTO Patients (Username, PasswordHash, FullName, DateOfBirth, Gender, ContactEmail, ContactPhone, Address, MedicalHistory, Allergies, CurrentMedications, IsActive) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "sssssssssssi", $username, $passwordHash, $fullName, $dateOfBirth, $gender, $contactEmail, $contactPhone, $address, $medicalHistory, $allergies, $currentMedications, $isActive);
        if (mysqli_stmt_execute($stmt)) {
            header("Location: ../View/Pages/Admin/Patients.php");
            exit();
        } else {
            echo "Error: " . mysqli_stmt_error($stmt);
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($conn);
} else {
    header("Location: ../View/Pages/Admin/Patients.php");
    exit();
}
?>
