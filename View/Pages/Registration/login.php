<?php
session_start();
include "../../Common PHP Functions/ConnectSql.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $rememberMe = isset($_POST['remember']) ? $_POST['remember'] : '';

    $roles = [
        ['table' => 'patients', 'passwordColumn' => 'passwordhash', 'idColumn' => 'patientid', 'redirect' => '../Admin/Patients.php'],
        ['table' => 'doctors', 'passwordColumn' => 'passwordhash', 'idColumn' => 'doctorid', 'redirect' => '../Admin/Doctors.php'],
        ['table' => 'labtechnicians', 'passwordColumn' => 'passwordhash', 'idColumn' => 'technicianid', 'redirect' => '../Admin/LabTechs.php'],
        ['table' => 'admins', 'passwordColumn' => 'passwordhash', 'idColumn' => 'adminid', 'redirect' => '../Admin/Dashboard.php']
    ];
    
    
    $emailFound = false;
    $stillConnected=true;
    foreach ($roles as $role) {
        if ($stmt = $conn->prepare("SELECT {$role['idColumn']},{$role['passwordColumn']} FROM {$role['table']} WHERE contactemail = ?")) {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            $is_email=true;
            if (!filter_var($email, FILTER_VALIDATE_EMAIL) || substr($email, -4) !== ".com") {
                echo "<script>alert('Invalid email format. Email must contain @ and end with .com');</script>";
                $is_email=false;
            }
            if (!$is_email) {
                $conn->close();
                $stillConnected=false;
                break;
            }
            if ($result->num_rows == 1) {
                $emailFound = true;
                $row = $result->fetch_assoc();
                if ($emailFound) {
                    if (password_verify($password, $row[$role['passwordColumn']])) {
                        $_SESSION['user_id'] = $row[$role['idColumn']];
                        $_SESSION['ContactEmail'] = $email;
                        $_SESSION['role'] = $role['table'];
            
                        if ($rememberMe == 'on') {
                            setcookie("user_email", $email, time() + (86400 * 30), "/", "", isset($_SERVER["HTTPS"]), true);
                        }
            
                        header("Location: " . $role['redirect']);
                        exit();
                    } else {
                        echo "<script>alert('Invalid password.');</script>";
                    }
                } else {
                    echo "<script>alert('Email was not found.');</script>";
                }
            }
            $stmt->close();
        }
    }

    if($stillConnected){
        if (!$emailFound) {
            echo "<script>alert('Email was not found.');</script>";
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
    <link rel="stylesheet" href="login-style.css">
    <title>Login Form</title>
</head>
<body>
    <div class="container">
        <div class="forms">
            <div class="form login">
                <div class="hospital-icon" style="text-align: center;">
                    <img src="../../Images/hospital-login.png" alt="Hospital Icon" style="width:75px; height:75px; display: block; margin: auto;">
                </div>
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
