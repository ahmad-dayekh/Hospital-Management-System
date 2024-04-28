<?php
namespace View\Pages\Registration;

class RegistrationManager {
    protected $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL) && substr($email, -4) === ".com";
    }

    public function isPhoneNumber($phone) {
        return is_numeric($phone);
    }
}
?>