<?php
use TPWeb\TargetPay\TargetPay;
use \TPWeb\TargetPay\Transaction\IVR;

class IVRNetherlandTest extends \PHPUnit_Framework_TestCase
{
    private $config = ['klantcode' => 'xxx', 'layoutcode' => 'xxx', 'test' => true, 'debug' => false];
    
    public function setUp()
    {
        parent::setUp();
    }
    
    public function testAmount35PC()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\IVR(IVR::NETHERLAND, 0.35), $this->config);
        $this->assertEquals(0.35, $targetPay->transaction->getAmount());
        $this->assertEquals("PC", $targetPay->transaction->getMode());
        $targetPay->transaction->calculateAmount();
        $this->assertEquals(0.35, $targetPay->transaction->getAmount());
    }
    
    public function testAmount45PC()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\IVR(IVR::NETHERLAND, 0.45), $this->config);
        $this->assertEquals(0.45, $targetPay->transaction->getAmount());
        $this->assertEquals("PC", $targetPay->transaction->getMode());
        $targetPay->transaction->calculateAmount();
        $this->assertEquals(0.45, $targetPay->transaction->getAmount());
    }
    
    public function testAmount55PC()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\IVR(IVR::NETHERLAND, 0.55), $this->config);
        $this->assertEquals(0.55, $targetPay->transaction->getAmount());
        $this->assertEquals("PC", $targetPay->transaction->getMode());
        $targetPay->transaction->calculateAmount();
        $this->assertEquals(0.55, $targetPay->transaction->getAmount());
    }
    
    public function testAmount60PC()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\IVR(IVR::NETHERLAND, 0.60), $this->config);
        $this->assertEquals(0.60, $targetPay->transaction->getAmount());
        $this->assertEquals("PC", $targetPay->transaction->getMode());
        $targetPay->transaction->calculateAmount();
        $this->assertEquals(0.60, $targetPay->transaction->getAmount());
    }
    
    public function testAmount70PC()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\IVR(IVR::NETHERLAND, 0.70), $this->config);
        $this->assertEquals(0.70, $targetPay->transaction->getAmount());
        $this->assertEquals("PC", $targetPay->transaction->getMode());
        $targetPay->transaction->calculateAmount();
        $this->assertEquals(0.70, $targetPay->transaction->getAmount());
    }
    
    public function testAmount90PC()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\IVR(IVR::NETHERLAND, 0.90), $this->config);
        $this->assertEquals(0.90, $targetPay->transaction->getAmount());
        $this->assertEquals("PC", $targetPay->transaction->getMode());
        $targetPay->transaction->calculateAmount();
        $this->assertEquals(0.90, $targetPay->transaction->getAmount());
    }
    
    public function testAmount100PC()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\IVR(IVR::NETHERLAND, 1.00), $this->config);
        $this->assertEquals(1.00, $targetPay->transaction->getAmount());
        $this->assertEquals("PC", $targetPay->transaction->getMode());
        $targetPay->transaction->calculateAmount();
        $this->assertEquals(1.00, $targetPay->transaction->getAmount());
    }
    
    public function testAmount115PC()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\IVR(IVR::NETHERLAND, 1.15), $this->config);
        $this->assertEquals(1.15, $targetPay->transaction->getAmount());
        $this->assertEquals("PC", $targetPay->transaction->getMode());
        $targetPay->transaction->calculateAmount();
        $this->assertEquals(1.15, $targetPay->transaction->getAmount());
    }
    
    public function testAmount130PC()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\IVR(IVR::NETHERLAND, 1.30), $this->config);
        $this->assertEquals(1.30, $targetPay->transaction->getAmount());
        $this->assertEquals("PC", $targetPay->transaction->getMode());
        $targetPay->transaction->calculateAmount();
        $this->assertEquals(1.30, $targetPay->transaction->getAmount());
    }
    
    public function testAmount140PC()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\IVR(IVR::NETHERLAND, 1.40), $this->config);
        $this->assertEquals(1.40, $targetPay->transaction->getAmount());
        $this->assertEquals("PC", $targetPay->transaction->getMode());
        $targetPay->transaction->calculateAmount();
        $this->assertEquals(1.40, $targetPay->transaction->getAmount());
    }
    
    public function testAmount35PM()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\IVR(IVR::NETHERLAND, 0.50), $this->config);
        $this->assertEquals(0.50, $targetPay->transaction->getAmount());
        $this->assertEquals("PM", $targetPay->transaction->getMode());
        $this->assertEquals(86, $targetPay->transaction->getDuration());
        $targetPay->transaction->calculateAmount();
        $this->assertEquals(0.50, $targetPay->transaction->getAmount());
    }
    
    public function testAmount80PM()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\IVR(IVR::NETHERLAND, 0.80), $this->config);
        $this->assertEquals(0.80, $targetPay->transaction->getAmount());
        $this->assertEquals("PM", $targetPay->transaction->getMode());
        $this->assertEquals(60, $targetPay->transaction->getDuration());
        $targetPay->transaction->calculateAmount();
        $this->assertEquals(0.80, $targetPay->transaction->getAmount());
    }
    
    public function testAmount90PM()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\IVR(IVR::NETHERLAND, 11.80), $this->config);
        $this->assertEquals(11.81, $targetPay->transaction->getAmount());
        $this->assertEquals("PM", $targetPay->transaction->getMode());
        $this->assertEquals(787, $targetPay->transaction->getDuration());
        $targetPay->transaction->calculateAmount();
        $this->assertEquals(11.81, $targetPay->transaction->getAmount());
    }
}