<?php
include '../View/Common Php Functions/ConnectSql.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['doctorID'])) {
    $doctorID = $_POST['doctorID'];

    
    $sql = "DELETE FROM Doctors WHERE DoctorID = ?";

    
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $doctorID);

        
        if (mysqli_stmt_execute($stmt)) {
            echo "Doctor deleted successfully.";
        } else {
            echo "Error deleting record: " . mysqli_stmt_error($stmt);
        }

        
        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing statement: " . mysqli_error($conn);
    }

    
    mysqli_close($conn);

    
    header('Location: ../View/Pages/Admin/Doctors.php');
    exit();
} else {
    
    header('Location: ../View/Pages/Admin/Doctors.php');
    exit();
}
?>
