<?php
session_start(); // Start the session to use session variables
include "../../Common PHP Functions/ConnectSql.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);

    // SQL to fetch user from the database
    $sql = "SELECT patientid, passwordhash FROM patients WHERE contactemail = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Check if the user exists
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['passwordhash'])) {
            // Password is correct, set the session
            $_SESSION['user_id'] = $row['patientid']; // make sure to use the correct column name here as well
            $_SESSION['email'] = $email;

            // Redirect to the admin dashboard
            header("Location: ../Admin/Dashboard.php");
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No user found with that email address.";
    }

    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="login-style.css">
    <title>Login Form</title>
</head>

<body>
    <div class="container">
        <div class="forms">
            <div class="form login">
                <span class="title">Login</span>
                <form action="#" method="post">
                    <div class="input-field">
                        <input type="text" placeholder="Enter your email" name="email" required>
                        <i class="uil uil-envelope icon"></i>
                    </div>
                    <div class="input-field">
                        <input type="password" class="password" placeholder="Enter your password" name="password" required>
                        <i class="uil uil-lock icon"></i>
                        <i class="uil uil-eye-slash showHidePw"></i>
                    </div>
                    <div class="checkbox-text">
                        <div class="checkbox-content">
                            <input type="checkbox" id="logCheck">
                            <label for="logCheck" class="text">Remember me</label>
                        </div>
                        <a href="#" class="text">Forgot password?</a>
                    </div>
                    <div class="input-field button">
                        <input type="submit" value="Login" name="submit">
                    </div>
                </form>
                <div class="login-signup">
                    <span class="text">Not a member?
                        <a href="reg.php" class="text signup-link">Sign up Now</a>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <script src="script.js"></script>
</body>

</html>