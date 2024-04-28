<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use View\Pages\Registration\RegistrationManager;
use mysqli;

class RegistrationTest extends TestCase {
    private $manager;
    private $mockMysqli;

    protected function setUp(): void {
        $this->mockMysqli = $this->createMock(mysqli::class);
        $this->manager = new RegistrationManager($this->mockMysqli);
    }

    public function testEmailValidation() {
        $this->assertTrue($this->manager->validateEmail("test@example.com"));
    }

    public function testPhoneNumberValidation() {
        $this->assertTrue($this->manager->isPhoneNumber("1234567890"));
    }
}
