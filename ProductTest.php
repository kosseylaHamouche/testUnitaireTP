<?php
require("Product.php");
require("User.php");
use PHPUnit\Framework\TestCase;

class ProductTest {

    public function testisValid() {
        $user = new User("boris", "test", "test@test.fr", 20);
        $product = new Product("ps4", $user);

        $result = $product->isValid();

        $this->assertTrue($result);
    }

    public function testisNotValidBecauseName() {
        $user = new User("boris", "test", "test@test.fr", 20);
        $product = new Product("", $user);

        $result = $product->isValid();

        $this->assertFalse($result);
    }

    public function testisNotValidBecauseUser() {
        $user = new User("boris", "test", "test@test.fr", "20");
        $product = new Product("", $user);

        $result = $product->isValid();

        $this->assertFalse($result);
    }

    public function testisnotvalidownerisnotvalid() {
        $mockownerisnotvalid = $this->createMock(User::class, array('isValid'), array(null, null, null, null));
        $mockownerisnotvalid->expects($this->any())->method('isValid')->will($this->returnValue(false));

        $this->product->setOwner($mockownerisnotvalid);
        $result = $this->product->isValid();
        $this->assertFalse($result);
    }

    protected function setUp() : void
    {
        $mockOwner = $this->createMock(User::class, array('isValid'), array(null, null, null, null));
        $mockOwner->expects($this->any())->method('isValid')->will($this->returnValue(true));

        $this->product = new Product("mon objet", $mockOwner);
    }

    protected function tearDown() : void
    {
        $this->product = NULL;
    }
}