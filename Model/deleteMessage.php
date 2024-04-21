<?php
include '../View/Common Php Functions/ConnectSql.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['messageId'])) {
    $messageId = $_POST['messageId'];
    $sql = "DELETE FROM Messages WHERE MessageID = ?";

    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $messageId);
        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(['success' => true, 'message' => 'Message deleted successfully']);
        } else {
            echo json_encode(['success' => false, 'error' => mysqli_stmt_error($stmt)]);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo json_encode(['success' => false, 'error' => mysqli_error($conn)]);
    }
    $conn->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method or parameters']);
}
?>
