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
class Belgium extends Country {
	protected $name = "België";
	protected $code = 32;
	public $minAmount = 0.5;
	public $maxAmount = 19.99;

	public function setAmount($amount)
	{
		if($this->minAmount > $amount)
			throw new AmountException('Amount is to low. (Min amount: ' . $this->minAmount . ')', 2);
		if($this->maxAmount < $amount)
			throw new AmountException('Amount is to high. (Max amount: ' . $this->maxAmount . ')', 3);
		if($amount <= 0.50) {
			$this->setMode("PC");
			$this->amount = 0.50;
			$this->amountPerAction = 0.50;
			$this->payout = 0.24 - 0.09;			//30%
		} else if($amount == 0.75) {
			$this->setMode("PC");
			$this->amount = 0.75;
			$this->amountPerAction = 0.75;
			$this->payout = 0.42 - 0.11;			//41
		} else if($amount == 1.00) {
			$this->setMode("PC");
			$this->amount = 1.00;
			$this->amountPerAction = 1.00;
			$this->payout = 0.60 - 0.13;			//47
		} else if($amount == 1.25) {
			$this->setMode("PC");
			$this->amount = 1.25;
			$this->amountPerAction = 1.25;
			$this->payout = 0.78 - 0.15;			//50
		} else if($amount == 1.50) {
			$this->setMode("PC");
			$this->amount = 1.50;
			$this->amountPerAction = 1.50;
			$this->payout = 0.96 - 0.15;			//64
		} else if($amount == 1.75) {
			$this->setMode("PC");
			$this->amount = 1.75;
			$this->amountPerAction = 1.75;
			$this->payout = 1.13 - 0.17;			//54
		} else if($amount == 2.00) {
			$this->setMode("PC");
			$this->amount = 2.00;
			$this->amountPerAction = 2.00;
			$this->payout = 1.31 - 0.18;			//56
		} else if($amount >= 0.50 && $amount < 0.75) {
			$this->setMode("PM");
			$this->amountPerAction = 0.50;
			$this->duration = round(60 * round(($amount * 100) / 50, 2));
			$this->amount = round($this->duration / 60 * $this->amount, 2);
			
			$this->payout = round((0.23 - 0.14) * round($this->amount / $this->amountPerAction), 2); //18%
		} else if($amount >= 0.75 && $amount < 1.00) {
			$this->setMode("PM");
			$this->amountPerAction = 0.75;
			$this->duration = round(60 * round(($amount * 100) / 75, 2));
			$this->amount = round($this->duration / 60 * $this->amount, 2);
			$this->payout = round((0.41 - 0.16) * round($this->amount / $this->amountPerAction), 2); //33%
		} else if($amount >= 1.00 && $amount < 1.25) {
			$this->setMode("PM");
			$this->amountPerAction = 1.00;
			$this->duration = round(60 * round($amount / $this->amountPerAction, 2));
			$this->amount = round($this->duration / 60 * $this->amount, 2);
			$this->payout = round((0.56 - 0.18) * round($this->amount / $this->amountPerAction), 2); //38%
		} else if($amount >= 1.25 && $amount < 1.50) {
			$this->setMode("PM");
			$this->amountPerAction = 1.25;
			$this->duration = round(60 * round($amount / $this->amountPerAction, 2));
			$this->amount = round($this->duration / 60 * $this->amount, 2);
			$this->payout = round((0.76 - 0.20) * round($this->amount / $this->amountPerAction), 2); //56%
		} else if($amount >= 1.50 && $amount < 1.75) {
			$this->setMode("PM");
			$this->amountPerAction = 1.50;
			$this->duration = round(60 * round($amount / $this->amountPerAction, 2));
			$this->amount = round($this->duration / 60 * $this->amount, 2);
			$this->payout = round((0.98 - 0.21) * round($this->amount / $this->amountPerAction), 2); //51%
		} else if($amount >= 1.75 && $amount < 2.00) {
			$this->setMode("PM");
			$this->amountPerAction = 1.75;
			$this->duration = round(60 * round($amount / $this->amountPerAction, 2));
			$this->amount = round($this->duration / 60 * $this->amount, 2);
			$this->payout = round((1.12 - 0.22) * round($this->amount / $this->amountPerAction), 2); //51%
		} else if($amount >= 2.00 && $amount < 20.00) {
			$this->setMode("PM");
			$this->amountPerAction = 2.00;
			$this->duration = round(60 * round($amount / $this->amountPerAction, 2));
			$this->amount = round($this->duration / 60 * $this->amount, 2);
			$this->payout = round((1.30 - 0.23) * round($this->amount / $this->amountPerAction), 2); //53%
		} else {
			$this->setMode("PM");
			$this->amountPerAction = 2.00;
			$this->duration = round(60 * round($amount / $this->amountPerAction, 2));
			$this->amount = round($this->duration / 60 * $this->amount, 2);
			$this->payout = round((1.30 - 0.23) * round($this->amount / $this->amountPerAction), 2); //53%
		}
		return $this->amount;
	}
	
	public function calculateAmount()
	{
		if($this->amountPerAction == 50 && $this->getMode() == "PC") {
			$this->amountPerAction = 0.50;
			$this->amount = 0.50;
			$this->payout = 0.24 - 0.09; //30%
		}
		else if($this->amountPerAction == 75 && $this->getMode() == "PC") {
			$this->amountPerAction = 0.75;
			$this->amount = 0.75;
			$this->payout = 0.42 - 0.11; //41
		}
		else if($this->amountPerAction == 100 && $this->getMode() == "PC") {
			$this->amountPerAction = 1.00;
			$this->amount = 1.00;
			$this->payout = 0.60 - 0.13; //47
		}
		else if($this->amountPerAction == 125 && $this->getMode() == "PC") {
			$this->amountPerAction = 1.25;
			$this->amount = 1.25;
			$this->payout = 0.78 - 0.15; //50
		}
		else if($this->amountPerAction == 150 && $this->getMode() == "PC") {
			$this->amountPerAction = 1.50;
			$this->amount = 1.50;
			$this->payout = 0.96 - 0.15; //64
		}
		else if($this->amountPerAction == 175 && $this->getMode() == "PC") {
			$this->amountPerAction = 1.75;
			$this->amount = 1.75;
			$this->payout = 1.13 - 0.17; //54
		}
		else if($this->amountPerAction == 200 && $this->getMode() == "PC") {
			$this->amountPerAction = 2.00;
			$this->amount = 2.00;
			$this->payout = 1.31 - 0.18; //56
		}
		else if($this->amountPerAction == 50 && $this->getMode() == "PM") {
			$this->amountPerAction = 0.50;
			$this->amount = round($this->duration / 60 * $this->amountPerAction, 2);
			$this->payout = round((0.23 - 0.14) * round($this->amount / $this->amountPerAction), 2); //56%
		}
		else if($this->amountPerAction == 75 && $this->getMode() == "PM") {
			$this->amountPerAction = 0.75;
			$this->amount = round($this->duration / 60 * $this->amountPerAction, 2);
			$this->payout = round((0.41 - 0.16) * round($this->amount / $this->amountPerAction), 2);
		}
		else if($this->amountPerAction == 100 && $this->getMode() == "PM") {
			$this->amountPerAction = 1.00;
			$this->amount = round($this->duration / 60 * $this->amountPerAction, 2);
			$this->payout = round((0.56 - 0.18) * round($this->amount / $this->amountPerAction), 2);
		}
		else if($this->amountPerAction == 125 && $this->getMode() == "PM") {
			$this->amountPerAction = 1.25;
			$this->amount = round($this->duration / 60 * $this->amountPerAction, 2);
			$this->payout = round((0.76 - 0.20) * round($this->amount / $this->amountPerAction), 2);
		}
		else if($this->amountPerAction == 150 && $this->getMode() == "PM") {
			$this->amountPerAction = 1.50;
			$this->amount = round($this->duration / 60 * $this->amountPerAction, 2);
			$this->payout = round((0.98 - 0.21) * round($this->amount / $this->amountPerAction), 2);
		}
		else if($this->amountPerAction == 175 && $this->getMode() == "PM") {
			$this->amountPerAction = 1.75;
			$this->amount = round($this->duration / 60 * $this->amountPerAction, 2);
			$this->payout = round((1.12 - 0.22) * round($this->amount / $this->amountPerAction), 2);
		}
		else if($this->amountPerAction == 200 && $this->getMode() == "PM") {
			$this->amountPerAction = 2.00;
			$this->amount = round($this->duration / 60 * $this->amountPerAction, 2);
			$this->payout = round((1.30 - 0.23) * round($this->amount / $this->amountPerAction), 2);
		}
	}
}