<?php
namespace Model;

use mysqli;

class PatientManager {
    private $conn;

    public function __construct(mysqli $conn) {
        $this->conn = $conn;
    }

    public function emailExists($email) {
        $tables = [
            ['patients', 'contactemail'],
            ['labtechnicians', 'contactemail'],
            ['doctors', 'contactemail'],
            ['admins', 'contactemail']
        ];

        foreach ($tables as $table) {
            $query = "SELECT 1 FROM {$table[0]} WHERE {$table[1]} = ?";
            $stmt = $this->conn->prepare($query);
            if (!$stmt) {
                throw new \Exception("Prepare failed: " . $this->conn->error);
            }
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $stmt->close();
                return true;
            }
            $stmt->close();
        }
        return false;
    }
}
?>
