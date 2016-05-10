<?php
use TPWeb\TargetPay\TargetPay;
use \TPWeb\TargetPay\Transaction\MisterCash;

class MisterCashTest extends \PHPUnit_Framework_TestCase
{
    private $config = ['klantcode' => 'xxx', 'layoutcode' => 'xxx', 'test' => true, 'debug' => false];
    
    public function setUp()
    {
        parent::setUp();
    }
    
    public function testConstructor()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\MisterCash("NL", 1.00), $this->config);
        $this->assertEquals("NL", $targetPay->transaction->getLang());
        $this->assertEquals(1.00, $targetPay->transaction->getAmount());
    }
    
    public function testMethod()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\MisterCash, $this->config);
        $targetPay->transaction->setLang("NL");
        $this->assertEquals("NL", $targetPay->transaction->getLang());
        
        $targetPay->transaction->setLang("FR");
        $this->assertEquals("FR", $targetPay->transaction->getLang());
        
        $targetPay->transaction->setLang("EN");
        $this->assertEquals("EN", $targetPay->transaction->getLang());
    }
    
    public function testPayout()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\MisterCash("NL", 10.00), $this->config);
        $this->assertEquals(9.58, $targetPay->transaction->getPayout());
    }
    
    /**
     * @expectedException TPWeb\TargetPay\Exception\MisterCashException
     */
    public function testMethodException()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\MisterCash, $this->config);
        $targetPay->transaction->setLang("ONBEKEND");
    }
    
    public function testDescription()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\MisterCash, $this->config);
        $targetPay->transaction->setDescription("Test description");
        $this->assertEquals("Test description", $targetPay->transaction->getDescription());
    }
    
    public function testReturnUrl()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\MisterCash, $this->config);
        $targetPay->transaction->setReturnUrl("http://www.tpweb.org");
        $this->assertEquals("http://www.tpweb.org", $targetPay->transaction->getReturnUrl());
    }
    
    public function testReportUrl()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\MisterCash, $this->config);
        $targetPay->transaction->setReportUrl("http://www.tpweb.org");
        $this->assertEquals("http://www.tpweb.org", $targetPay->transaction->getReportUrl());
    }
    
    public function testMistercashUrl()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\MisterCash, $this->config);
        $targetPay->transaction->setMisterCashUrl("http://www.tpweb.org");
        $this->assertEquals("http://www.tpweb.org", $targetPay->transaction->getMisterCashUrl());
    }
    
    public function testTransactionId()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\MisterCash, $this->config);
        $targetPay->transaction->setTransactionId(123456789);
        $this->assertEquals(123456789, $targetPay->transaction->getTransactionId());
    }
}