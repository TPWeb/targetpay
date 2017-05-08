<?php
use TPWeb\TargetPay\TargetPay;
use \TPWeb\TargetPay\Transaction\SMS;

class SMSTest extends \PHPUnit_Framework_TestCase
{
    private $config = ['klantcode' => 'xxx', 'layoutcode' => 'xxx', 'test' => true, 'debug' => false];
    
    public function setUp()
    {
        parent::setUp();
    }
    
    public function testConstructor()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\SMS(SMS::BELGIUM, 1.00), $this->config);
        $this->assertEquals(32, $targetPay->transaction->getCountry());
        $this->assertEquals(1.00, $targetPay->transaction->getAmount());
    }
    
    public function testSetTransactionConstructor()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\SMS, $this->config);
        $this->assertTrue($targetPay->getTransaction() instanceof \TPWeb\TargetPay\Transaction\Transaction);
        $this->assertTrue($targetPay->getTransaction() instanceof \TPWeb\TargetPay\Transaction\SMS);
    }
    
    public function testSetTransactionMethod()
    {
        $targetPay = new TargetPay(null, $this->config);
        $targetPay->setTransaction(new \TPWeb\TargetPay\Transaction\SMS);
        $this->assertTrue($targetPay->getTransaction() instanceof \TPWeb\TargetPay\Transaction\Transaction);
        $this->assertTrue($targetPay->getTransaction() instanceof \TPWeb\TargetPay\Transaction\SMS);
    }
    
    public function testGetTransaction()
    {
        $targetPay = new TargetPay(null, $this->config);
        $targetPay->setTransaction(new \TPWeb\TargetPay\Transaction\SMS);
        $this->assertEquals("SMS", $targetPay->getTransaction(true));
    }
    
    public function testCountryList()
    {
        $this->assertEquals([
                                31 => 'Nederland',
                                32 => 'België',
                            ], SMS::countryList());
    }
    
    public function testCountry()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\SMS, $this->config);
        $targetPay->transaction->setCountry(SMS::BELGIUM);
        $this->assertEquals(32, $targetPay->transaction->getCountry());
        
        
        $targetPay->transaction->setCountry(SMS::NETHERLAND);
        $this->assertEquals(31, $targetPay->transaction->getCountry());
        
    }
    
    /**
     * @expectedException TPWeb\TargetPay\Exception\SMSException
     */
    public function testCountryException()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\SMS, $this->config);
        $targetPay->transaction->setCountry("WRONG COUNTRY");
    }
    
    public function testAmount()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\SMS, $this->config);
        $targetPay->transaction->setCountry(SMS::BELGIUM);
        $targetPay->transaction->setAmount(1.00);
        $this->assertEquals(1.00, $targetPay->transaction->getAmount());
    }
    
    public function testPayout()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\SMS, $this->config);
        $targetPay->transaction->setCountry(SMS::BELGIUM);
        $targetPay->transaction->setAmount(1.00);
        $this->assertEquals(0.34, $targetPay->transaction->getPayout());
    }
    
    public function testAmountListNull()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\SMS, $this->config);
        $targetPay->transaction->setCountry(SMS::BELGIUM);
        $this->assertEquals(null, $targetPay->transaction->getAmountList());
    }
    
    public function testMinimumAmount()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\SMS, $this->config);
        $targetPay->transaction->setCountry(SMS::BELGIUM);
        $this->assertEquals(1.00, $targetPay->transaction->getMinimumAmount());
    }
    
    /**
     * @expectedException TPWeb\TargetPay\Exception\AmountException
     */
    public function testMinimumAmountAmountIsLower()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\SMS, $this->config);
        $targetPay->transaction->setCountry(SMS::BELGIUM);
        $targetPay->transaction->setAmount(0.49);
    }
    
    public function testMaximumAmount()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\SMS, $this->config);
        $targetPay->transaction->setCountry(SMS::BELGIUM);
        $this->assertEquals(2.00, $targetPay->transaction->getMaximumAmount());
    }
    
    /**
     * @expectedException TPWeb\TargetPay\Exception\AmountException
     */
    public function testMaximumAmountAmountIsHiger()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\SMS, $this->config);
        $targetPay->transaction->setCountry(SMS::BELGIUM);
        $targetPay->transaction->setAmount(2.01);
    }
    
    public function testKeyword()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\SMS, $this->config);
        $targetPay->transaction->setCountry(SMS::BELGIUM);
        $targetPay->transaction->setKeyword("ORDER");
        $this->assertEquals("ORDER", $targetPay->transaction->getKeyword());
    }
    
    public function testShortcode()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\SMS, $this->config);
        $targetPay->transaction->setCountry(SMS::BELGIUM);
        $targetPay->transaction->setShortcode("6033");
        $this->assertEquals("6033", $targetPay->transaction->getShortcode());
    }
    
    public function testPayCode()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\SMS, $this->config);
        $targetPay->transaction->setCountry(SMS::BELGIUM);
        $targetPay->transaction->setPayCode("123456");
        $this->assertEquals("123456", $targetPay->transaction->getPayCode());
    }
    
    
    public function testCurrency()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\SMS, $this->config);
        $targetPay->transaction->setCountry(SMS::BELGIUM);
        $this->assertEquals("EURO", $targetPay->transaction->getCurrency());
    }
    
    public function testCalculateAmount()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\SMS, $this->config);
        $targetPay->transaction->setCountry(SMS::BELGIUM);
        $targetPay->transaction->country->setAmount(1.00);
        $targetPay->transaction->setPaymentDone(true);
        $this->assertEquals(1.00, $targetPay->getAmount());
    }
}