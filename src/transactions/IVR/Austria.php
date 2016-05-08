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
class Austria extends Country {
	protected $name = "Österreich";
	protected $code = 43;
	public $minAmount = 1.1;
	public $maxAmount = 100;

	public function setAmount($amount)
	{
		if($this->minAmount > $amount)
			throw new AmountException('Amount is to low. (Min amount: ' . $this->minAmount . ')', 2);
		if($this->maxAmount < $amount)
			throw new AmountException('Amount is to high. (Max amount: ' . $this->maxAmount . ')', 3);
		
		$this->setMode("PM");
		$this->amountPerAction = 2.16;
		$this->amount = round($this->duration / 60 * $this->amountPerAction, 2);
		$this->payout = round(1.15 * round($this->amount / $this->amountPerAction), 2); //53
		return $this->amount;
	}
	
	public function calculateAmount()
	{
		if($this->amountPerAction == 216 && $this->getMode() == "PM") {
			$this->amountPerAction = 2.16;
			$this->amount = round($this->duration / 60 * $this->amountPerAction, 2);
			$this->payout = round(1.15 * round($this->amount / $this->amountPerAction), 2); //56%
		}
	}
}