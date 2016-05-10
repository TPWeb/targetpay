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
}