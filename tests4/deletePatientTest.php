<?php
namespace Tests;

use Model\PatientManager;
use PHPUnit\Framework\TestCase;

class deletePatientTest extends TestCase {
    private $conn;
    private $manager;

    protected function setUp(): void {
        $this->conn = new \mysqli("localhost", "root", "", "HMS-Database");
        $this->manager = new PatientManager($this->conn);
    }

    protected function tearDown(): void {
        $this->conn->close();
    }

    public function testEmailExists() {
        $email = "d@gmail.com";

        $exists = $this->manager->emailExists($email);
        $this->assertTrue($exists);
    }
}
?>
