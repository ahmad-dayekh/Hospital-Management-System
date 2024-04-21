<?php
session_start();
include '../View/Common Php Functions/ConnectSql.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $messageType = $_POST['messageType'] ?? '';
    $subject = $_POST['messageSubject'] ?? '';
    $body = $_POST['messageBody'] ?? '';
    $receiverEmail = $_POST['messageReceiver'] ?? '';
    $senderEmail = $_SESSION['ContactEmail'] ?? 'jane.smith@hospital.com'; // Fallback to a default if not set

    if (empty($subject) || empty($body) || empty($receiverEmail) || empty($senderEmail)) {
        echo json_encode(['success' => false, 'error' => 'Required fields are missing']);
        exit;
    }

    $senderInfo = getUserInfo($conn, $senderEmail);
    $receiverInfo = getUserInfo($conn, $receiverEmail);

    if (!$senderInfo || !$receiverInfo) {
        echo json_encode(['success' => false, 'error' => 'Sender or receiver email not found']);
        exit;
    }

    $sql = "INSERT INTO Messages (SenderEmail, ReceiverEmail, Type, Subject, Body, SenderID, ReceiverID, SentDate, IsRead)
            VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), 0)";

    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "sssssii", $senderEmail, $receiverEmail, $messageType, $subject, $body, $senderInfo['ID'], $receiverInfo['ID']);
        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to send message: ' . mysqli_stmt_error($stmt)]);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo json_encode(['success' => false, 'error' => 'Error preparing SQL statement']);
    }

    mysqli_close($conn);
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
}

function getUserInfo($conn, $email) {
    $tables = [
        'Doctors' => 'DoctorID',
        'Admins' => 'AdminID',
        'Patients' => 'PatientID',
        'LabTechnicians' => 'TechnicianID'
    ];

    foreach ($tables as $table => $idField) {
        $sql = "SELECT $idField FROM $table WHERE ContactEmail = ?";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if ($row = mysqli_fetch_assoc($result)) {
                mysqli_stmt_close($stmt);
                return ['ID' => $row[$idField]];
            }
            mysqli_stmt_close($stmt);
        }
    }
    return false;
}

?>
