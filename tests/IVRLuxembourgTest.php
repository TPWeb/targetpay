<?php
use TPWeb\TargetPay\TargetPay;
use \TPWeb\TargetPay\Transaction\IVR;

class IVRLuxembourgTest extends \PHPUnit_Framework_TestCase
{
    private $config = ['klantcode' => 'xxx', 'layoutcode' => 'xxx', 'test' => true, 'debug' => false];
    
    public function setUp()
    {
        parent::setUp();
    }
    
    public function testAmount115PM()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\IVR(IVR::LUXEMBOURG, 2.30), $this->config);
        $this->assertEquals(2.30, $targetPay->transaction->getAmount());
        $this->assertEquals("PM", $targetPay->transaction->getMode());
        $this->assertEquals(120, $targetPay->transaction->getDuration());
        $targetPay->transaction->calculateAmount();
        $this->assertEquals(2.30, $targetPay->transaction->getAmount());
    }
    
    /**
     * @expectedException TPWeb\TargetPay\Exception\AmountException
     */
    public function testMinimumAmountAmountIsLower()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\IVR, $this->config);
        $targetPay->transaction->setCountry(IVR::LUXEMBOURG);
        $targetPay->transaction->setAmount(0.64);
    }
    
    /**
     * @expectedException TPWeb\TargetPay\Exception\AmountException
     */
    public function testMaximumAmountAmountIsHiger()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\IVR, $this->config);
        $targetPay->transaction->setCountry(IVR::LUXEMBOURG);
        $targetPay->transaction->setAmount(21);
    }
}