<?php
use TPWeb\TargetPay\TargetPay;
use \TPWeb\TargetPay\Transaction\Paysafecard;

class PaysafecardTest extends \PHPUnit_Framework_TestCase
{
    private $config = ['klantcode' => 'xxx', 'layoutcode' => 'xxx', 'test' => true, 'debug' => false];
    
    public function setUp()
    {
        parent::setUp();
    }
    
    public function testConstructor()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\Paysafecard(1.00), $this->config);
        $this->assertEquals(1.00, $targetPay->transaction->getAmount());
    }
    
    public function testPayout()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\Paysafecard(10.00), $this->config);
        $this->assertEquals(8.5, $targetPay->transaction->getPayout());
    }
    
    public function testDescription()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\Paysafecard, $this->config);
        $targetPay->transaction->setDescription("Test description");
        $this->assertEquals("Test description", $targetPay->transaction->getDescription());
    }
    
    public function testReturnUrl()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\Paysafecard, $this->config);
        $targetPay->transaction->setReturnUrl("http://www.tpweb.org");
        $this->assertEquals("http://www.tpweb.org", $targetPay->transaction->getReturnUrl());
    }
    
    public function testReportUrl()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\Paysafecard, $this->config);
        $targetPay->transaction->setReportUrl("http://www.tpweb.org");
        $this->assertEquals("http://www.tpweb.org", $targetPay->transaction->getReportUrl());
    }
    
    public function testPaysafecardUrl()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\Paysafecard, $this->config);
        $targetPay->transaction->setPaysafecardUrl("http://www.tpweb.org");
        $this->assertEquals("http://www.tpweb.org", $targetPay->transaction->getPaysafecardUrl());
    }
    
    public function testTransactionId()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\Paysafecard, $this->config);
        $targetPay->transaction->setTransactionId(123456789);
        $this->assertEquals(123456789, $targetPay->transaction->getTransactionId());
    }
}