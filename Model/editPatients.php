<?php
include '../View/Common Php Functions/ConnectSql.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['patientID'])) {
    $patientID = $_POST['patientID'];
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $name = mysqli_real_escape_string($conn, $_POST['fullName']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $dob = mysqli_real_escape_string($conn, $_POST['DateOfBirth']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $medicalHistory = mysqli_real_escape_string($conn, $_POST['medicalHistory']);
    $allergies = mysqli_real_escape_string($conn, $_POST['allergies']);
    $currentMedications = mysqli_real_escape_string($conn, $_POST['currentMedications']);

    $sql = "UPDATE Patients SET 
                ContactEmail = ?, 
                FullName = ?, 
                ContactPhone = ?, 
                DateOfBirth = ?, 
                Gender = ?, 
                Address = ?, 
                MedicalHistory = ?, 
                Allergies = ?, 
                CurrentMedications = ?
            WHERE PatientID = ?";

    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "sssssssssi", $email, $name, $phone, $dob, $gender, $address, $medicalHistory, $allergies, $currentMedications, $patientID);
        
        if (mysqli_stmt_execute($stmt)) {
            header('Location: ../View/Pages/Admin/Patients.php');
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
    header('Location: ../View/Pages/Admin/Patients.php');
    exit();
}
?>
