<?php
use TPWeb\TargetPay\TargetPay;
use \TPWeb\TargetPay\Transaction\IVR;

class SMSBelgiumTest extends \PHPUnit_Framework_TestCase
{
    private $config = ['klantcode' => 'xxx', 'layoutcode' => 'xxx', 'test' => true, 'debug' => false];
    
    public function setUp()
    {
        parent::setUp();
    }
    
    public function testAmount100()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\SMS(IVR::BELGIUM, 1.00), $this->config);
        $this->assertEquals(1.00, $targetPay->transaction->getAmount());
        $this->assertEquals(6033, $targetPay->transaction->getShortcode());
        $this->assertEquals("ORDER", $targetPay->transaction->getKeyword());
    }
    
    public function testAmount150()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\SMS(IVR::BELGIUM, 1.50), $this->config);
        $this->assertEquals(1.50, $targetPay->transaction->getAmount());
        $this->assertEquals(6638, $targetPay->transaction->getShortcode());
        $this->assertEquals("ORDER", $targetPay->transaction->getKeyword());
    }
    
    public function testAmount200()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\SMS(IVR::BELGIUM, 2.00), $this->config);
        $this->assertEquals(2.00, $targetPay->transaction->getAmount());
        $this->assertEquals(6045, $targetPay->transaction->getShortcode());
        $this->assertEquals("ORDER", $targetPay->transaction->getKeyword());
    }
}