<?php
use TPWeb\TargetPay\TargetPay;
use \TPWeb\TargetPay\Transaction\IVR;

class SMSNetherlandTest extends \PHPUnit_Framework_TestCase
{
    private $config = ['klantcode' => 'xxx', 'layoutcode' => 'xxx', 'test' => true, 'debug' => false];
    
    public function setUp()
    {
        parent::setUp();
    }
    
    public function testAmount025()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\SMS(IVR::NETHERLAND, 0.25), $this->config);
        $this->assertEquals(0.25, $targetPay->transaction->getAmount());
        $this->assertEquals(3011, $targetPay->transaction->getShortcode());
        $this->assertEquals("BETAAL AA", $targetPay->transaction->getKeyword());
    }
    
    public function testAmount150()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\SMS(IVR::NETHERLAND, 1.50), $this->config);
        $this->assertEquals(1.50, $targetPay->transaction->getAmount());
        $this->assertEquals(3011, $targetPay->transaction->getShortcode());
        $this->assertEquals("BETAAL AL", $targetPay->transaction->getKeyword());
    }
    
    public function testAmount200()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\SMS(IVR::NETHERLAND, 2.00), $this->config);
        $this->assertEquals(2.00, $targetPay->transaction->getAmount());
        $this->assertEquals(3011, $targetPay->transaction->getShortcode());
        $this->assertEquals("BETAAL AR", $targetPay->transaction->getKeyword());
    }
}