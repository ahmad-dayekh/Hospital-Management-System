<?php
include '../View/Common Php Functions/ConnectSql.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['appointmentId'])) {
    $appointmentId = intval($_POST['appointmentId']);  

    
    $sql = "DELETE FROM Appointments WHERE AppointmentID = ?";

    
    if ($stmt = mysqli_prepare($conn, $sql)) {
        
        mysqli_stmt_bind_param($stmt, "i", $appointmentId);

        
        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => mysqli_stmt_error($stmt)]);
        }

        
        mysqli_stmt_close($stmt);
    } else {
        echo json_encode(['success' => false, 'error' => mysqli_error($conn)]);
    }

    
    mysqli_close($conn);
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request']);
}
?>
