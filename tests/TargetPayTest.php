<?php
use TPWeb\TargetPay\TargetPay;

class TargetPayTest extends \PHPUnit_Framework_TestCase
{
    private $config = ['klantcode' => 'xxx', 'layoutcode' => 'xxx', 'test' => true, 'debug' => false];
    
    public function setUp()
    {
        parent::setUp();
    }
    
    public function testKlantcode()
    {
        $this->config['klantcode'] = "123456";
        $targetPay = new TargetPay(null, $this->config);
        $this->assertEquals("123456", $targetPay->getKlantcode());
        
        $targetPay->setKlantcode("123");
        $this->assertNotEquals("123456", $targetPay->getKlantcode());
    }
    
    public function testLayoutcode()
    {
        $this->config['layoutcode'] = "123456";
        $targetPay = new TargetPay(null, $this->config);
        $this->assertEquals("123456", $targetPay->getLayoutcode());
        
        $targetPay->setLayoutcode("123");
        $this->assertNotEquals("123456", $targetPay->getLayoutcode());
    }
    
    public function testTest()
    {
        $this->config['test'] = false;
        $targetPay = new TargetPay(null, $this->config);
        $this->assertFalse($targetPay->getTest());
        
        $targetPay->setTest(true);
        $this->assertTrue($targetPay->getTest());
    }
    
    public function testDebug()
    {
        $this->config['debug'] = false;
        $targetPay = new TargetPay(null, $this->config);
        $this->assertFalse($targetPay->getDebug());
        
        $targetPay->setDebug(true);
        $this->assertTrue($targetPay->getDebug());
    }
    
    public function testAmount() {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\IDeal, $this->config);
        $targetPay->setAmount(1.00);
        $this->assertEquals(1.00, $targetPay->getAmount());
        
        $targetPay->setAmount(10.00);
        $this->assertEquals(10.00, $targetPay->getAmount());
    }
    
    public function testPayout() {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\IDeal, $this->config);
        $targetPay->setAmount(1.00);
        $this->assertEquals(0.30, $targetPay->getPayout());
        
        $targetPay->setAmount(10.00);
        $this->assertEquals(9.3, $targetPay->getPayout());
    }
    
    public function testCurrency() {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\IDeal, $this->config);
        $this->assertEquals("EURO", $targetPay->getCurrency());
    }
}