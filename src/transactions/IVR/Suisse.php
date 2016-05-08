<?php
namespace TPWeb\TargetPay\Transaction\IVR;

use TPWeb\TargetPay\Exception\AmountException;
use \TPWeb\TargetPay\Transaction\IVR\Country;

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
class Suisse extends Country {
	protected $name = "Suisse";
	protected $code = 41;
	public $minAmount = 0;
	public $maxAmount = 20;
	public $currency = "CHF";

	public function setAmount($amount)
	{
		if($this->minAmount > $amount)
			throw new AmountException('Amount is to low. (Min amount: ' . $this->minAmount . ')', 2);
		if($this->maxAmount < $amount)
			throw new AmountException('Amount is to high. (Max amount: ' . $this->maxAmount . ')', 3);
		
		$this->setMode("PM");
		$this->amountPerAction = 4.22;
		$this->duration = round(60 * $amount/$this->amountPerAction);
		$this->amount = round($this->duration / 60 * $this->amountPerAction, 2);
		$this->payout = round(2.14 * round($this->amount / $this->amountPerAction), 2); //50.7% payout €1.93 = 2,14CHF (8/05/2016)
		return $this->amount;
	}
	
	public function calculateAmount()
	{
		if($this->amountPerAction == 422 && $this->getMode() == "PM") {
			$this->amountPerAction = 4.22;
			$this->amount = round($this->duration / 60 * $this->amountPerAction, 2);
			$this->payout = round(2.14 * round($this->amount / $this->amountPerAction), 2); //50%
		}
	}
	
}