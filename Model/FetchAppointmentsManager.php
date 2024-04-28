<?php
namespace Model;

use mysqli;

class FetchAppointmentsManager {
    private $dbConnection;

    public function __construct(mysqli $dbConnection) {
        $this->dbConnection = $dbConnection;
    }

    public function fetchMessages() {
        $sql = "SELECT * FROM Messages";
        $result = $this->dbConnection->query($sql);
        $messages = [];

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $messages[] = $row;
            }
        }

        return $messages;
    }
}
