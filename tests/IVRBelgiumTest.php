<?php
use TPWeb\TargetPay\TargetPay;
use \TPWeb\TargetPay\Transaction\IVR;

class IVRBelgiumTest extends \PHPUnit_Framework_TestCase
{
    private $config = ['klantcode' => 'xxx', 'layoutcode' => 'xxx', 'test' => true, 'debug' => false];
    
    public function setUp()
    {
        parent::setUp();
    }
    
    public function testAmount50PC()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\IVR(IVR::BELGIUM, 0.50), $this->config);
        $this->assertEquals(0.50, $targetPay->transaction->getAmount());
        $this->assertEquals("PC", $targetPay->transaction->getMode());
        $targetPay->transaction->calculateAmount();
        $this->assertEquals(0.50, $targetPay->transaction->getAmount());
    }
    
    public function testAmount75PC()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\IVR(IVR::BELGIUM, 0.75), $this->config);
        $this->assertEquals(0.75, $targetPay->transaction->getAmount());
        $this->assertEquals("PC", $targetPay->transaction->getMode());
        $targetPay->transaction->calculateAmount();
        $this->assertEquals(0.75, $targetPay->transaction->getAmount());
    }
    
    public function testAmount100PC()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\IVR(IVR::BELGIUM, 1.00), $this->config);
        $this->assertEquals(1.00, $targetPay->transaction->getAmount());
        $this->assertEquals("PC", $targetPay->transaction->getMode());
        $targetPay->transaction->calculateAmount();
        $this->assertEquals(1.00, $targetPay->transaction->getAmount());
    }
    
    public function testAmount125PC()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\IVR(IVR::BELGIUM, 1.25), $this->config);
        $this->assertEquals(1.25, $targetPay->transaction->getAmount());
        $this->assertEquals("PC", $targetPay->transaction->getMode());
        $targetPay->transaction->calculateAmount();
        $this->assertEquals(1.25, $targetPay->transaction->getAmount());
    }
    
    public function testAmount150PC()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\IVR(IVR::BELGIUM, 1.50), $this->config);
        $this->assertEquals(1.50, $targetPay->transaction->getAmount());
        $this->assertEquals("PC", $targetPay->transaction->getMode());
        $targetPay->transaction->calculateAmount();
        $this->assertEquals(1.50, $targetPay->transaction->getAmount());
    }
    
    public function testAmount175PC()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\IVR(IVR::BELGIUM, 1.75), $this->config);
        $this->assertEquals(1.75, $targetPay->transaction->getAmount());
        $this->assertEquals("PC", $targetPay->transaction->getMode());
        $targetPay->transaction->calculateAmount();
        $this->assertEquals(1.75, $targetPay->transaction->getAmount());
    }
    
    public function testAmount200PC()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\IVR(IVR::BELGIUM, 2.00), $this->config);
        $this->assertEquals(2.00, $targetPay->transaction->getAmount());
        $this->assertEquals("PC", $targetPay->transaction->getMode());
        $targetPay->transaction->calculateAmount();
        $this->assertEquals(2.00, $targetPay->transaction->getAmount());
    }
    
    public function testAmount50PM()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\IVR(IVR::BELGIUM, 0.60), $this->config);
        $this->assertEquals(0.60, $targetPay->transaction->getAmount());
        $this->assertEquals("PM", $targetPay->transaction->getMode());
        $this->assertEquals(72, $targetPay->transaction->getDuration());
        $targetPay->transaction->calculateAmount();
        $this->assertEquals(0.60, $targetPay->transaction->getAmount());
    }
    
    public function testAmount75PM()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\IVR(IVR::BELGIUM, 0.80), $this->config);
        $this->assertEquals(0.80, $targetPay->transaction->getAmount());
        $this->assertEquals("PM", $targetPay->transaction->getMode());
        $this->assertEquals(64, $targetPay->transaction->getDuration());
        $targetPay->transaction->calculateAmount();
        $this->assertEquals(0.80, $targetPay->transaction->getAmount());
    }
    
    public function testAmount100PM()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\IVR(IVR::BELGIUM, 1.10), $this->config);
        $this->assertEquals(1.10, $targetPay->transaction->getAmount());
        $this->assertEquals("PM", $targetPay->transaction->getMode());
        $this->assertEquals(66, $targetPay->transaction->getDuration());
        $targetPay->transaction->calculateAmount();
        $this->assertEquals(1.10, $targetPay->transaction->getAmount());
    }
    
    public function testAmount125PM()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\IVR(IVR::BELGIUM, 1.35), $this->config);
        $this->assertEquals(1.35, $targetPay->transaction->getAmount());
        $this->assertEquals("PM", $targetPay->transaction->getMode());
        $this->assertEquals(65, $targetPay->transaction->getDuration());
        $targetPay->transaction->calculateAmount();
        $this->assertEquals(1.35, $targetPay->transaction->getAmount());
    }
    
    public function testAmount150PM()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\IVR(IVR::BELGIUM, 1.60), $this->config);
        $this->assertEquals(1.60, $targetPay->transaction->getAmount());
        $this->assertEquals("PM", $targetPay->transaction->getMode());
        $this->assertEquals(64, $targetPay->transaction->getDuration());
        $targetPay->transaction->calculateAmount();
        $this->assertEquals(1.60, $targetPay->transaction->getAmount());
    }
    
    public function testAmount175PM()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\IVR(IVR::BELGIUM, 1.80), $this->config);
        $this->assertEquals(1.81, $targetPay->transaction->getAmount());
        $this->assertEquals("PM", $targetPay->transaction->getMode());
        $this->assertEquals(62, $targetPay->transaction->getDuration());
        $targetPay->transaction->calculateAmount();
        $this->assertEquals(1.81, $targetPay->transaction->getAmount());
    }
    
    public function testAmount200PM()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\IVR(IVR::BELGIUM, 10), $this->config);
        $this->assertEquals(10, $targetPay->transaction->getAmount());
        $this->assertEquals("PM", $targetPay->transaction->getMode());
        $this->assertEquals(300, $targetPay->transaction->getDuration());
        $targetPay->transaction->calculateAmount();
        $this->assertEquals(10, $targetPay->transaction->getAmount());
    }
}