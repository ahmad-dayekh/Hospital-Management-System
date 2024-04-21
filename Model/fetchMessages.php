<?php
include '../View/Common Php Functions/ConnectSql.php';

header('Content-Type: application/json');

$sql = "SELECT * FROM Messages";

$result = $conn->query($sql);
$messages = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $messages[] = $row;
    }
}

echo json_encode($messages);

$conn->close();
?>
