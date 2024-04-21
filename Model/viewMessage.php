<?php
include '../View/Common Php Functions/ConnectSql.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['messageId'])) {
    $messageId = intval($_GET['messageId']);

    $sql = "SELECT m.MessageID, m.Type, m.Subject, m.Body, m.SenderEmail, m.ReceiverEmail, m.SentDate, m.IsRead,
                   COALESCE(a.FullName, d.Name, p.FullName, l.FullName) AS SenderName
            FROM Messages m
            LEFT JOIN Admins a ON m.SenderEmail = a.ContactEmail
            LEFT JOIN Doctors d ON m.SenderEmail = d.ContactEmail
            LEFT JOIN Patients p ON m.SenderEmail = p.ContactEmail
            LEFT JOIN LabTechnicians l ON m.SenderEmail = l.ContactEmail
            WHERE m.MessageID = ?";

    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $messageId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            echo json_encode(['success' => true, 'message' => $row]);
            exit();
        } else {
            echo json_encode(['success' => false, 'error' => 'No message found']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Error preparing SQL statement: ' . mysqli_error($conn)]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request']);
}
?>
