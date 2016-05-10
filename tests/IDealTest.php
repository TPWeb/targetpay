<?php
use TPWeb\TargetPay\TargetPay;
use \TPWeb\TargetPay\Transaction\IDeal;

class IDealTest extends \PHPUnit_Framework_TestCase
{
    private $config = ['klantcode' => 'xxx', 'layoutcode' => 'xxx', 'test' => true, 'debug' => false];
    
    public function setUp()
    {
        parent::setUp();
    }
    
    public function testBankList()
    {
        $this->assertEquals([
                    'ABNANL2A' => 'ABN AMRO',
                    'ASNBNL21' => 'ASN Bank',
                    'BUNQNL2A' => 'bunq',
                    'INGBNL2A' => 'ING',
                    'KNABNL2H' => 'Knab',
                    'RABONL2U' => 'Rabobank',
                    'RBRBNL21' => 'RegioBank',
                    'SNSBNL2A' => 'SNS Bank',
                    'TRIONL2U' => 'Triodos Bank',
                    'FVLBNL22' => 'van Lanschot',
        ], IDeal::bankList());
    }
    
    public function testConstructor()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\IDeal(IDeal::ABN_AMRO, 1.00), $this->config);
        $this->assertEquals("ABNANL2A", $targetPay->transaction->getBank());
        $this->assertEquals(1.00, $targetPay->transaction->getAmount());
    }
    
    public function testMethod()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\IDeal, $this->config);
        $targetPay->transaction->setBank(IDeal::SNS_BANK);
        $this->assertEquals("SNSBNL2A", $targetPay->transaction->getBank());
        
        $targetPay->transaction->setBank(IDeal::TRIODOS_BANK);
        $this->assertEquals("TRIONL2U", $targetPay->transaction->getBank());
        
        $targetPay->transaction->setBank(IDeal::VAN_LANDSCHOT);
        $this->assertEquals("FVLBNL22", $targetPay->transaction->getBank());
    }
    
    /**
     * @expectedException TPWeb\TargetPay\Exception\IDealException
     */
    public function testMethodException()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\IDeal, $this->config);
        $targetPay->transaction->setBank("ONBEKEND");
    }
    
    public function testDescription()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\IDeal(IDeal::ASN_BANK), $this->config);
        $targetPay->transaction->setDescription("Test description");
        $this->assertEquals("Test description", $targetPay->transaction->getDescription());
    }
    
    public function testReturnUrl()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\IDeal(IDeal::BUNQ), $this->config);
        $targetPay->transaction->setReturnUrl("http://www.tpweb.org");
        $this->assertEquals("http://www.tpweb.org", $targetPay->transaction->getReturnUrl());
    }
    
    public function testCancelUrl()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\IDeal(IDeal::ING), $this->config);
        $targetPay->transaction->setCancelUrl("http://www.tpweb.org");
        $this->assertEquals("http://www.tpweb.org", $targetPay->transaction->getCancelUrl());
    }
    
    public function testReportUrl()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\IDeal(IDeal::KNAB), $this->config);
        $targetPay->transaction->setReportUrl("http://www.tpweb.org");
        $this->assertEquals("http://www.tpweb.org", $targetPay->transaction->getReportUrl());
    }
    
    public function testIdealUrl()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\IDeal(IDeal::RABOBANK), $this->config);
        $targetPay->transaction->setIdealUrl("http://www.tpweb.org");
        $this->assertEquals("http://www.tpweb.org", $targetPay->transaction->getIdealUrl());
    }
    
    public function testTransactionId()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\IDeal(IDeal::REGIOBANK), $this->config);
        $targetPay->transaction->setTransactionId(123456789);
        $this->assertEquals(123456789, $targetPay->transaction->getTransactionId());
    }
}