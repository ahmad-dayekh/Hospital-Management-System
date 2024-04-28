<?php
namespace Tests;

use Model\FetchAppointmentsManager;
use mysqli;
use PHPUnit\Framework\TestCase;

class FetchAppointmentsTest extends TestCase {
    private $dbConnection;
    private $fetchAppointmentsManager;

    protected function setUp(): void {
        $this->dbConnection = new mysqli("localhost", "root", "", "HMS-database");
        $this->dbConnection->begin_transaction();
        $this->fetchAppointmentsManager = new FetchAppointmentsManager($this->dbConnection);
    }

    public function testFetchMessages() {
        $testMessage = 'Testing for invalidation.';
        $sql = "INSERT INTO Messages (Body) VALUES (?)";
        $stmt = $this->dbConnection->prepare($sql);
        $stmt->bind_param("s", $testMessage);
        $stmt->execute();
        $stmt->close();
        $messages = $this->fetchAppointmentsManager->fetchMessages();
    
        $this->assertNotEmpty($messages);
        $this->assertEquals($testMessage, $messages[0]['Body']);
    
        $this->dbConnection->rollback();
    }

    protected function tearDown(): void {
        $this->dbConnection->close();
    }
}
