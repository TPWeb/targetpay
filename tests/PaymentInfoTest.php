<?php
use TPWeb\TargetPay\TargetPay;
use \TPWeb\TargetPay\Transaction\IDeal;
use \TPWeb\TargetPay\Transaction\IVR;

class PaymentInfoTest extends \PHPUnit_Framework_TestCase
{
    private $config = ['klantcode' => 'xxx', 'layoutcode' => 'xxx', 'test' => true, 'debug' => false];
    
    public function setUp()
    {
        parent::setUp();
    }
    
    /**
     * @expectedException TPWeb\TargetPay\Exception\TransactionTypeException
     */
    public function testPaymentInfoNoTransactionType()
    {
        $targetPay = new TargetPay(null, $this->config);
        $targetPay->getPaymentInfo();
    }
    
    /**
     * @expectedException TPWeb\TargetPay\Exception\TransactionTypeException
     */
    public function testCheckPaymentNoTransactionType()
    {
        $targetPay = new TargetPay(null, $this->config);
        $targetPay->checkPaymentInfo();
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
    
    /**
     * @expectedException TPWeb\TargetPay\Exception\TargetPayException
     */
    public function testPaymentInfoIDealNoLayoutcode()
    {
        $config = $this->config;
        $config['layoutcode'] = "";
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\IDeal, $config);
        $targetPay->transaction->setBank(IDeal::ING);
        $targetPay->setAmount(10.00);
        $targetPay->getPaymentInfo();
    }
    
    
    /**
     * @expectedException TPWeb\TargetPay\Exception\TargetPayException
     */
    public function testPaymentInfoIDealNoIdealAcc()
    {
        $config = $this->config;
        $config['layoutcode'] = "1000";
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\IDeal, $config);
        $targetPay->transaction->setBank(IDeal::ING);
        $targetPay->setAmount(10.00);
        $targetPay->getPaymentInfo();
    }
    
    /**
     * @expectedException TPWeb\TargetPay\Exception\TargetPayException
     */
    public function testPaymentInfoIDealNoDescription()
    {
        $config = $this->config;
        $config['layoutcode'] = "56445";
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\IDeal, $config);
        $targetPay->transaction->setBank(IDeal::ING);
        $targetPay->setAmount(10.00);
        $targetPay->getPaymentInfo();
    }
    
    /**
     * @expectedException TPWeb\TargetPay\Exception\TargetPayException
     */
    public function testPaymentInfoIDealInvalidReturnUrl()
    {
        $config = $this->config;
        $config['layoutcode'] = "56445";
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\IDeal, $config);
        $targetPay->transaction->setBank(IDeal::ING);
        $targetPay->setAmount(10.00);
        $targetPay->transaction->setDescription("UNIT Testing");
        $targetPay->getPaymentInfo();
    }
    
    /**
     * @expectedException TPWeb\TargetPay\Exception\TargetPayException
     */
    public function testPaymentInfoIDealNotCompleted()
    {
        $config = $this->config;
        $config['layoutcode'] = "56445";
        $config['test'] = false;
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\IDeal, $config);
        $targetPay->transaction->setBank(IDeal::ING);
        $targetPay->setAmount(10.00);
        $targetPay->transaction->setDescription("UNIT Testing");
        $targetPay->transaction->setReturnUrl("https://www.tpweb.org");
        $targetPay->getPaymentInfo();
        $this->assertContains("https://bankieren.ideal.ing.nl/ideal/betalen/inlog-annuleren/static/detect_mob?trxid=", $targetPay->transaction->getIdealUrl());
        $this->assertTrue($targetPay->transaction->getTransactionId() > 0);
        
        $targetPay->checkPaymentInfo();
        $this->assertEquals(10.00, $targetPay->getAmount());
    }
    
    /*public function testPaymentInfoIDealNotCompleted()
    {
        $config = $this->config;
        $config['layoutcode'] = "56445";
        $config['test'] = false;
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\IDeal, $config);
        $targetPay->transaction->setBank(IDeal::ING);
        $targetPay->setAmount(10.00);
        $targetPay->transaction->setDescription("UNIT Testing");
        $targetPay->transaction->setReturnUrl("https://www.tpweb.org");
        $targetPay->getPaymentInfo();
        $this->assertContains("https://bankieren.ideal.ing.nl/ideal/betalen/inlog-annuleren/static/detect_mob?trxid=", $targetPay->transaction->getIdealUrl());
        $this->assertTrue($targetPay->transaction->getTransactionId() > 0);
        
        $targetPay->checkPaymentInfo();
        $this->assertEquals(10.00, $targetPay->getAmount());
    }*/
}