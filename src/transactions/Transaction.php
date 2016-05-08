<?php
namespace TPWeb\TargetPay\Transaction;

use TPWeb\TargetPay\Exception\AmountException;

/**
 *
 * PHP TargetPay Library
 *
 * @version    1.0.0
 * @package    tpweb/targetpay
 * @copyright  Copyright (c) 2016 Made I.T. (http://www.madeit.be) - TPWeb.org (http://www.tpweb.org)
 * @author     Made I.T. <info@madeit.be>
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt    LGPL
 */
class Transaction {
    protected $name = "";
    public $minAmount = 0;
    public $maxAmount = 100;
    public $arraySelector = false;
	public $arrayAmount;
    public $amount;
	public $currency = "EURO";
	public $paymentDone = false;
    
    function __construct($amount = null)
	{
		if($amount != null) {
			$this->setAmount($amount);
		}
    }
    
    public function getName()
	{
		return $this->name;
    }
    
    public function setAmount($amount)
	{
		if(is_numeric($amount)) {
			$this->amount = $amount;
		} else {
			throw new AmountException("Amount isn't numeric.", 1);
		}
	}
    
    public function getAmount()
	{
		$this->amount;
    }
	
	
	public function getAmountList()
	{
		if($this->arraySelector) {
			return $this->arrayAmount;
		}
		return null;
	}
    
    public function getMinimumAmount()
	{
		return $this->minAmount;
    }
    
    public function getMaximumAmount()
	{
		return $this->maxAmount;
    }
	
	public function getCurrency()
	{
		return $this->country->getCurrency();
	}
	
	public function setPaymentDone($boolean)
	{
		$this->paymentDone = is_bool($boolean) ? $boolean : false;
	}
	
	public function getPaymentDone()
	{
		return $this->paymentDone;
	}
	
	public function getPayout()
	{
		return 0;
	}
}