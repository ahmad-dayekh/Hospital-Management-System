<?php
include '../View/Common Php Functions/ConnectSql.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['technicianID'])) {
    $technicianID = $_POST['technicianID'];

    
    $sql = "DELETE FROM LabTechnicians WHERE TechnicianID = ?";

    
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $technicianID);

        
        if (mysqli_stmt_execute($stmt)) {
            
            
            header('Location: ../View/Pages/Admin/LabTechs.php');
            exit();
        } else {
            echo "Error deleting record: " . mysqli_stmt_error($stmt);
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
