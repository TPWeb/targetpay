<?php
use TPWeb\TargetPay\TargetPay;
use \TPWeb\TargetPay\Transaction\IVR;

class PaymentInfoTest extends \PHPUnit_Framework_TestCase
{
    private $config = ['klantcode' => 'xxx', 'layoutcode' => 'xxx', 'test' => true, 'debug' => false];
    
    public function setUp()
    {
        parent::setUp();
    }
    
    public function testPaymentInfoPayPerMinute()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\IVR, $this->config);
        $targetPay->transaction->setCountry(IVR::BELGIUM);
        $targetPay->setAmount(10.00);
        $targetPay->getPaymentInfo();
        $this->assertEquals("0909-12345678", $targetPay->transaction->getServiceNumber());
        $this->assertEquals("123456", $targetPay->transaction->getPayCode());
        
        $targetPay->checkPaymentInfo();
        $this->assertEquals(10.00, $targetPay->getAmount());
    }
    
    public function testPaymentInfoPayPerCall()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\IVR, $this->config);
        $targetPay->transaction->setCountry(IVR::BELGIUM);
        $targetPay->setAmount(2.00);
        $targetPay->getPaymentInfo();
        $this->assertEquals("0909-12345678", $targetPay->transaction->getServiceNumber());
        $this->assertEquals("123456", $targetPay->transaction->getPayCode());
        
        $targetPay->checkPaymentInfo();
        $this->assertEquals(2.00, $targetPay->getAmount());
    }
    
    /**
     * @expectedException TPWeb\TargetPay\Exception\IVRException
     */
    public function testPaymentInfoInvalidMode()
    {
        $config = $this->config;
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\IVR, $config);
        $targetPay->transaction->setCountry(IVR::BELGIUM);
        $targetPay->setAmount(10.00);
        $targetPay->transaction->country->mode = "ABC";
        $targetPay->getPaymentInfo();
    }
    
    public function testPaymentInfo()
    {
        $config = $this->config;
        $config['test'] = false;
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\IVR, $config);
        $targetPay->transaction->setCountry(IVR::BELGIUM);
        $targetPay->setAmount(10.00);
        $targetPay->getPaymentInfo();
        
        
        $targetPay->checkPaymentInfo();
        $this->assertFalse($targetPay->transaction->getPaymentDone());
    }
}