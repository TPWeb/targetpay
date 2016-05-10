<?php
use TPWeb\TargetPay\TargetPay;

class TargetPayTest extends \PHPUnit_Framework_TestCase
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
}