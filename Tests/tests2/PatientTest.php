<?php
namespace Tests;

use Model\PatientManager;
use PHPUnit\Framework\TestCase;

class PatientTest extends TestCase {
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
        $email = "alice.brown@example.com"; // this email exists in the database

        $exists = $this->manager->emailExists($email);
        $this->assertTrue($exists);
    }
}
?>
