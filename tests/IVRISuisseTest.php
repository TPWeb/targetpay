<?php
use TPWeb\TargetPay\TargetPay;
use \TPWeb\TargetPay\Transaction\IVR;

class IVRSuisseTest extends \PHPUnit_Framework_TestCase
{
    private $config = ['klantcode' => 'xxx', 'layoutcode' => 'xxx', 'test' => true, 'debug' => false];
    
    public function setUp()
    {
        parent::setUp();
    }
    
    public function testAmount422PM()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\IVR(IVR::SUISSE, 4.22), $this->config);
        $this->assertEquals(4.22, $targetPay->transaction->getAmount());
        $this->assertEquals("PM", $targetPay->transaction->getMode());
        $this->assertEquals(60, $targetPay->transaction->getDuration());
        $targetPay->transaction->calculateAmount();
        $this->assertEquals(4.22, $targetPay->transaction->getAmount());
    }
    
    /**
     * @expectedException TPWeb\TargetPay\Exception\AmountException
     */
    public function testMinimumAmountAmountIsLower()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\IVR, $this->config);
        $targetPay->transaction->setCountry(IVR::SUISSE);
        $targetPay->transaction->setAmount(2.99);
    }
    
    /**
     * @expectedException TPWeb\TargetPay\Exception\AmountException
     */
    public function testMaximumAmountAmountIsHiger()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\IVR, $this->config);
        $targetPay->transaction->setCountry(IVR::SUISSE);
        $targetPay->transaction->setAmount(42.01);
    }
}