<?php
namespace View\Pages\Registration;

use mysqli;

class LoginManager {
    private $dbConnection;

    public function __construct(mysqli $dbConnection) {
        $this->dbConnection = $dbConnection;
    }

    public function authenticate($email, $password, $rememberMe = '') {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || substr($email, -4) !== ".com") {
            return 'Invalid email format. Email must contain @ and end with .com';
        }

        $roles = [
            ['table' => 'patients', 'passwordColumn' => 'passwordhash', 'idColumn' => 'patientid', 'redirect' => '../Admin/Patients.php'],
            ['table' => 'doctors', 'passwordColumn' => 'passwordhash', 'idColumn' => 'doctorid', 'redirect' => '../Admin/Doctors.php'],
            ['table' => 'labtechnicians', 'passwordColumn' => 'passwordhash', 'idColumn' => 'technicianid', 'redirect' => '../Admin/LabTechs.php'],
            ['table' => 'admins', 'passwordColumn' => 'passwordhash', 'idColumn' => 'adminid', 'redirect' => '../Admin/Dashboard.php']
        ];

        foreach ($roles as $role) {
            if ($stmt = $this->dbConnection->prepare("SELECT {$role['idColumn']}, {$role['passwordColumn']} FROM {$role['table']} WHERE contactemail = ?")) {
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows == 1) {
                    $row = $result->fetch_assoc();
                    if (password_verify($password, $row[$role['passwordColumn']])) {
                        if ($rememberMe == 'on') {
                            $this->setRememberMeCookie($email);
                        }
                        return $role['redirect'];
                    }
                }
                $stmt->close();
            }
        }
        return "Invalid login credentials";
    }

    protected function setRememberMeCookie($email) {
        setcookie("user_email", $email, time() + (86400 * 30), "/", "", isset($_SERVER["HTTPS"]), true);
    }
}
?>