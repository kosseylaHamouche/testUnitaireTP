<?php
require("User.php");
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase{

    public function testIsValidNominal() {
        $user = new User("boris", "test", "test@test.fr", 20);
        $result = $user->isValid();
        $this->assertTrue($result);
    }

    public function testisNotValidBecauseEmailFormat() {
        $user = new User("test", "test", "test.fr", 23);
        $result = $user->isValid();
        $this->assertFalse($result);
    }

    public function testisnotalidbecausefirstname() {
        $user = new User("", "test", "test.fr", 23);
        $result = $user->isValid();
        $this->assertFalse($result);
    }

    public function testisnotvalidbecauselastname() {
        $user = new User("test", "", "test.fr", 23);
        $result = $user->isValid();
        $this->assertFalse($result);
    }

    public function testisnotvalidbecausetoyoung() {
        $user = new User("test", "test", "test.fr", 9);
        $result = $user->isValid();
        $this->assertFalse($result);
    }


}