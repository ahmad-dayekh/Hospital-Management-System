<?php
namespace Tests;

use View\Pages\Registration\LoginManager;
use mysqli;
use PHPUnit\Framework\TestCase;

class LoginTest extends TestCase {
    private $dbConnection;
    private $loginManager;

    protected function setUp(): void {
        $this->dbConnection = new mysqli("localhost","root","","HMS-database");
        $this->loginManager = new LoginManager($this->dbConnection);
    }

    public function testAuthenticateWithValidCredentials() {
        $email = "fake@gmail.com";
        $password = "dd";
        $result = $this->loginManager->authenticate($email, $password);
        $this->assertNotEquals("Invalid login credentials", $result);
    }

    protected function tearDown(): void {
        $this->dbConnection->close();
    }
}
