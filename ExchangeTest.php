<?php

require("Product.php");
require("User.php");
require("DBConnection.php");
require("EmailSender.php");
require("Exchange.php");

use PHPUnit\Framework\TestCase;

class ExchangeTest extends TestCase{


    public function testisvalid() {
        $result = $this->exchange->isValid();
        $this->assertTrue($result);
    }

    public function testSaveisValid()
    {
        $result = $this->exchange->save();
        $this->assertTrue($result);
    }

    public function testSaveisNotValidProductOwnerNotValid() {
        $mockproductownerisnotvalid = $this->createMock(User::class, array('isValid'), array(null, null, null, null));
        $mockproductownerisnotvalid->expects($this->any())->method('isValid')->will($this->returnValue(false));

        $this->product->setOwner($mockproductownerisnotvalid);
        $result = $this->exchange->save();
        $this->assertFalse($result);
    }

    public function testIsNotValidReceiverNotValid() {
        $mockreceiverisnotvalid = $this->createMock(User::class, array('isValid'), array(null, null, null, null));
        $mockreceiverisnotvalid->expects($this->any())->method('isValid')->will($this->returnValue(false));

        $this->exchange->setReceiver($mockreceiverisnotvalid);
        $result = $this->exchange->isValid();
        $this->assertFalse($result);
    }

    public function testIsNotSavedBecauseEndDateLowerThanStartDate()
    {
        $this->exchange->setDateDebut((new DateTime())->add(new DateInterval("PT2H")));
        $this->exchange->setDateFin((new DateTime())->add(new DateInterval("PT1H")));
        $this->assertFalse($this->exchange->save());
    }

    public function testIsNotSavedBecauseStartDateLowerThanNow()
    {
        $this->exchange->setDateDebut((new DateTime())->sub(new DateInterval("PT2H")));
        $this->assertFalse($this->exchange->save());
    }

    public function testDatesAreValid()
    {
        $this->assertGreaterThan($this->exchange->getDateDebut(), $this->exchange->getDateFin());
        $this->assertTrue($this->exchange->isValid());
    }

    protected function setUp() : void
    {
        $mockOwner = $this->createMock(User::class, array('isValid'), array(null, null, null, null));
        $mockOwner->expects($this->any())->method('isValid')->will($this->returnValue(true));

        $this->product = new Product("mon objet", $mockOwner);

        $mockReceiver = $this->createMock(User::class, array('isValid'), array(null, null, null, null));
        $mockReceiver->expects($this->any())->method('isValid')->will($this->returnValue(true));

        $mockemailSender = $this->emailSender = $this->createMock(EmailSender::class);
        $this->emailSender->expects($this->any())->method('sendEmail')->will($this->returnValue(true));

        $mockdbConnection = $this->dbConnection = $this->createMock(DatabaseConnection::class);
        $this->dbConnection->expects($this->any())->method('saveExchange')->will($this->returnValue(true));


        $this->exchange = new Exchange($mockReceiver, $this->product, '2021-06-01', '2022-07-01', $mockemailSender, $mockdbConnection);


    }

    protected function tearDown() : void
    {
        $this->exchange = NULL;
    }
}

?>