<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "HMS-Database";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, name, specialty, email, availability FROM doctors";
$result = $conn->query($sql);
?>