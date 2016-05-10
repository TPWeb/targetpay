<?php
use TPWeb\TargetPay\TargetPay;

class ExceptionTest extends \PHPUnit_Framework_TestCase
{
    private $config = ['klantcode' => 'xxx', 'layoutcode' => 'xxx', 'test' => true, 'debug' => false];
    
    public function setUp()
    {
        parent::setUp();
    }
    
    /**
     * @expectedException TPWeb\TargetPay\Exception\TransactionTypeException
     */
    public function testSetTransactionConstructor()
    {
        $targetPay = new TargetPay("WRONG TRANSACTION TYPE", $this->config);
    }
    
    /**
     * @expectedException TPWeb\TargetPay\Exception\TransactionTypeException
     */
    public function testSetTransactionMethod()
    {
        $targetPay = new TargetPay(null, $this->config);
        $targetPay->setTransaction("WRONG TRANSACTION TYPE");
    }
    
    /**
     * @expectedException TPWeb\TargetPay\Exception\TransactionTypeException
     */
    public function testGetTransaction()
    {
        $targetPay = new TargetPay(null, $this->config);
        $targetPay->getTransaction();
    }
    
    /**
     * @expectedException TPWeb\TargetPay\Exception\TargetPayException
     */
    public function testSetKlantcode()
    {
        $targetPay = new TargetPay(null, $this->config);
        $targetPay->setKlantcode(null);
    }
    
    /**
     * @expectedException TPWeb\TargetPay\Exception\TargetPayException
     */
    public function testSetLayoutcode()
    {
        $targetPay = new TargetPay(null, $this->config);
        $targetPay->setLayoutcode(null);
    }
    
    /**
     * @expectedException TPWeb\TargetPay\Exception\AmountException
     */
    public function testSetAmount()
    {
        $targetPay = new TargetPay(null, $this->config);
        $targetPay->setAmount("ABC");
    }
}