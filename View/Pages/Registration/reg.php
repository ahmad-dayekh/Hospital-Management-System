<?php
// Include your database connection script
include "../../Common PHP Functions/ConnectSql.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user inputs
    $username = $conn->real_escape_string($_POST['username']);
    $fullName = $conn->real_escape_string($_POST['fullName']);
    $email = $_POST['email'];  // We use prepared statements, so no need to escape this here
    $password = $_POST['password'];
    $phone = $conn->real_escape_string($_POST['phone']);
    $location = $conn->real_escape_string($_POST['location']);
    $is_int=true;
    if (!is_numeric($phone)) {
        echo "<script>alert('Phone number should be an integer.');</script>";
        $is_int=false;
    }
    $is_email=true;
    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || substr($email, -4) !== ".com") {
        echo "<script>alert('Invalid email format. Email must contain @ and end with .com');</script>";
        $is_email=false;
    }
    // Check if email already exists in any of the tables
    $emailExists = false;
    $tables = [
        ['patients', 'contactemail'],
        ['labtechnicians', 'contactemail'],
        ['doctors', 'contactemail'],
        ['admins', 'contactemail']
    ];

    foreach ($tables as $table) {
        $stmt = $conn->prepare("SELECT 1 FROM {$table[0]} WHERE {$table[1]} = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result && $result->num_rows > 0) {
            $emailExists = true;
            $stmt->close();
            break;
        }
        $stmt->close();
    }

    if (!$is_int || !$is_email) {
        $conn->close();
    }else
    if ($emailExists) {
        echo "<script>alert('This email is already registered. Please use a different email.');</script>";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO patients (username, fullname,contactemail, passwordhash, contactphone) VALUES ('$username', '$fullName', '$email', '$hashed_password', '$phone')";
        if ($conn->query($sql) === TRUE) {
            header("Location: login.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    
        $conn->close();
    }

}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="reg-style.css">
    <title>Registration Form</title>
</head>
<body>
    <div class="container">
        <div class="forms">
            <div class="form signup">
                <span class="title">Registration</span>
                <form action="#" method="post">
                    <div class="input-field">
                        <input type="text" placeholder="Enter your username" name="username" required>
                        <i class="uil uil-user"></i>
                    </div>
                    <div class="input-field">
                        <input type="text" placeholder="Enter your full name" name="fullName" required>
                        <i class="uil uil-user"></i>
                    </div>
                    <div class="input-field">
                        <input type="text" placeholder="Enter your email" name="email" required>
                        <i class="uil uil-envelope icon"></i>
                    </div>
                    <div class="input-field">
                        <input type="password" class="password" placeholder="Create a password" name="password" required>
                        <i class="uil uil-lock icon"></i>
                    </div>
                    <div class="input-field">
                        <input type="password" class="password" placeholder="Confirm a password" name="confirm-password" required>
                        <i class="uil uil-lock icon"></i>
                        <i class="uil uil-eye-slash showHidePw"></i>
                    </div>
                    <div class="input-field">
                        <input type="tel" placeholder="Enter your phone number" name="phone" required>
                        <i class="uil uil-phone"></i>
                    </div>
                    <div class="input-field">
                        <input type="text" placeholder="Enter your location" name="location" required>
                        <i class="uil uil-location-point"></i>
                    </div>
                    <div class="checkbox-text">
                        <div class="checkbox-content">
                            <input type="checkbox" id="termCon">
                            <label for="termCon" class="text">I accepted all terms and conditions</label>
                        </div>
                    </div>
                    <div class="input-field button">
                        <input type="submit" value="Signup" name="submit">
                    </div>
                </form>
                <div class="login-signup">
                    <span class="text">Already a member?
                        <a href="login.php" class="text login-link">Login Now</a>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>
