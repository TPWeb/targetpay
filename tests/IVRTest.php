<?php
use TPWeb\TargetPay\TargetPay;
use \TPWeb\TargetPay\Transaction\IVR;

class IVRTest extends \PHPUnit_Framework_TestCase
{
    private $config = ['klantcode' => 'xxx', 'layoutcode' => 'xxx', 'test' => true, 'debug' => false];
    
    public function setUp()
    {
        parent::setUp();
    }
    
    public function testConstructor()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\IVR(IVR::BELGIUM, 1.00), $this->config);
        $this->assertEquals(32, $targetPay->transaction->getCountry());
        $this->assertEquals(1.00, $targetPay->transaction->getAmount());
    }
    
    public function testSetTransactionConstructor()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\IVR, $this->config);
        $this->assertTrue($targetPay->getTransaction() instanceof \TPWeb\TargetPay\Transaction\Transaction);
        $this->assertTrue($targetPay->getTransaction() instanceof \TPWeb\TargetPay\Transaction\IVR);
    }
    
    public function testSetTransactionMethod()
    {
        $targetPay = new TargetPay(null, $this->config);
        $targetPay->setTransaction(new \TPWeb\TargetPay\Transaction\IVR);
        $this->assertTrue($targetPay->getTransaction() instanceof \TPWeb\TargetPay\Transaction\Transaction);
        $this->assertTrue($targetPay->getTransaction() instanceof \TPWeb\TargetPay\Transaction\IVR);
    }
    
    public function testGetTransaction()
    {
        $targetPay = new TargetPay(null, $this->config);
        $targetPay->setTransaction(new \TPWeb\TargetPay\Transaction\IVR);
        $this->assertEquals("IVR", $targetPay->getTransaction(true));
    }
    
    public function testCountryList()
    {
        $this->assertEquals([
                                31 => 'Nederland',
                                32 => 'België',
                                33 => 'France',
                                39 => 'Italia',
                                41 => 'Schweiz / Suisse / Svizzera / Svizra',
                                43 => 'Österreich',
                                44 => 'United Kingdom',
                                49 => 'Deutschland',
                                352 => 'Lëtzebuerg',
                            ], IVR::countryList());
    }
    
    public function testCountry()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\IVR, $this->config);
        $targetPay->transaction->setCountry(IVR::BELGIUM);
        $this->assertEquals(32, $targetPay->transaction->getCountry());
        
        
        $targetPay->transaction->setCountry(IVR::NETHERLAND);
        $this->assertEquals(31, $targetPay->transaction->getCountry());
        
        $targetPay->transaction->setCountry(IVR::FRANCE);
        $this->assertEquals(33, $targetPay->transaction->getCountry());
        
        $targetPay->transaction->setCountry(IVR::ITALY);
        $this->assertEquals(39, $targetPay->transaction->getCountry());
        
        $targetPay->transaction->setCountry(IVR::SUISSE);
        $this->assertEquals(41, $targetPay->transaction->getCountry());
        
        $targetPay->transaction->setCountry(IVR::AUSTRIA);
        $this->assertEquals(43, $targetPay->transaction->getCountry());
        
        $targetPay->transaction->setCountry(IVR::UK);
        $this->assertEquals(44, $targetPay->transaction->getCountry());
        
        $targetPay->transaction->setCountry(IVR::GERMANY);
        $this->assertEquals(49, $targetPay->transaction->getCountry());
        
        $targetPay->transaction->setCountry(IVR::LUXEMBOURG);
        $this->assertEquals(352, $targetPay->transaction->getCountry());
    }
    
    /**
     * @expectedException TPWeb\TargetPay\Exception\IVRException
     */
    public function testCountryException()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\IVR, $this->config);
        $targetPay->transaction->setCountry("WRONG COUNTRY");
    }
    
    public function testAmount()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\IVR, $this->config);
        $targetPay->transaction->setCountry(IVR::BELGIUM);
        $targetPay->transaction->setAmount(1.00);
        $this->assertEquals(1.00, $targetPay->transaction->getAmount());
    }
    
    public function testPayout()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\IVR, $this->config);
        $targetPay->transaction->setCountry(IVR::BELGIUM);
        $targetPay->transaction->setAmount(1.00);
        $this->assertEquals(0.47, $targetPay->transaction->getPayout());
    }
    
    public function testAmountListNull()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\IVR, $this->config);
        $targetPay->transaction->setCountry(IVR::BELGIUM);
        $this->assertEquals(null, $targetPay->transaction->getAmountList());
    }
    
    public function testAmountListArray()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\IVR, $this->config);
        $targetPay->transaction->setCountry(IVR::FRANCE);
        $this->assertEquals([1.35], $targetPay->transaction->getAmountList());
    }
    
    public function testMinimumAmount()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\IVR, $this->config);
        $targetPay->transaction->setCountry(IVR::BELGIUM);
        $this->assertEquals(0.50, $targetPay->transaction->getMinimumAmount());
    }
    
    /**
     * @expectedException TPWeb\TargetPay\Exception\AmountException
     */
    public function testMinimumAmountAmountIsLower()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\IVR, $this->config);
        $targetPay->transaction->setCountry(IVR::BELGIUM);
        $targetPay->transaction->setAmount(0.49);
    }
    
    public function testMaximumAmount()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\IVR, $this->config);
        $targetPay->transaction->setCountry(IVR::BELGIUM);
        $this->assertEquals(19.99, $targetPay->transaction->getMaximumAmount());
    }
    
    /**
     * @expectedException TPWeb\TargetPay\Exception\AmountException
     */
    public function testMaximumAmountAmountIsHiger()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\IVR, $this->config);
        $targetPay->transaction->setCountry(IVR::BELGIUM);
        $targetPay->transaction->setAmount(20);
    }
    
    public function testMode()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\IVR, $this->config);
        $targetPay->transaction->setCountry(IVR::BELGIUM);
        $targetPay->transaction->setMode("PC");
        $this->assertEquals("PC", $targetPay->transaction->getMode());
        
        $targetPay->transaction->setMode("PM");
        $this->assertEquals("PM", $targetPay->transaction->getMode());
        
        
        $targetPay->transaction->setAmount(1.00);
        $this->assertEquals("PC", $targetPay->transaction->getMode());
        
        $targetPay->transaction->setAmount(15.00);
        $this->assertEquals("PM", $targetPay->transaction->getMode());
    }
    
    /**
     * @expectedException TPWeb\TargetPay\Exception\IVRException
     */
    public function testModeException()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\IVR, $this->config);
        $targetPay->transaction->setCountry(IVR::BELGIUM);
        $targetPay->transaction->setMode("SOMETHINGELSE");
    }
    
    public function testAdult()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\IVR, $this->config);
        $targetPay->transaction->setCountry(IVR::BELGIUM);
        $targetPay->transaction->setAdult(true);
        $this->assertEquals(true, $targetPay->transaction->getAdult());
        
        $targetPay->transaction->setAdult(false);
        $this->assertEquals(false, $targetPay->transaction->getAdult());
    }
    
    public function testDuration()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\IVR, $this->config);
        $targetPay->transaction->setCountry(IVR::BELGIUM);
        $targetPay->transaction->setDuration(100);
        $this->assertEquals(100, $targetPay->transaction->getDuration());
    }
    
    public function testServiceNumber()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\IVR, $this->config);
        $targetPay->transaction->setServiceNumber("0900-000000");
        $this->assertEquals("0900-000000", $targetPay->transaction->getServiceNumber());
    }
    
    public function testPayCode()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\IVR, $this->config);
        $targetPay->transaction->setPayCode("123456");
        $this->assertEquals("123456", $targetPay->transaction->getPayCode());
    }
    
    public function testAmountPerAction()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\IVR, $this->config);
        $targetPay->transaction->setCountry(IVR::BELGIUM);
        $targetPay->transaction->setAmount(1.00);
        $this->assertEquals(1.00, $targetPay->transaction->getAmountPerAction());
        
        $targetPay->transaction->setAmount(15.00);
        $this->assertEquals(2.00, $targetPay->transaction->getAmountPerAction());
    }
    
    public function testCurrency()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\IVR, $this->config);
        $targetPay->transaction->setCountry(IVR::BELGIUM);
        $this->assertEquals("EURO", $targetPay->transaction->getCurrency());
        
        $targetPay->transaction->setCountry(IVR::UK);
        $this->assertEquals("GBP", $targetPay->transaction->getCurrency());
    }
    
    public function testCalculateAmount()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\IVR, $this->config);
        $targetPay->transaction->setCountry(IVR::BELGIUM);
        $targetPay->transaction->setPaymentDone(true);
        $targetPay->transaction->country->setAmountPerAction(2.00);
        $targetPay->transaction->setMode("PM");
        $targetPay->transaction->setDuration(300);
        $targetPay->transaction->calculateAmount();
        $this->assertEquals(10.00, $targetPay->getAmount());
    }
}