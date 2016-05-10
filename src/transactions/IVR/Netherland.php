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
class Netherland extends Country {
    protected $name = "Nederland";
    protected $code = 31;
    public $minAmount = 0.35;
    public $maxAmount = 15.00;

    /**
     * set amount
     * @param numeric
     * @return numeric
     * @throws AmountException
     */
    public function setAmount($amount)
    {
        if($this->minAmount > $amount)
            throw new AmountException('Amount is to low. (Min amount: ' . $this->minAmount . ')', 2);
        if($this->maxAmount < $amount)
            throw new AmountException('Amount is to high. (Max amount: ' . $this->maxAmount . ')', 3);
        if($amount <= 0.40) {
            $this->setMode("PC");
            $this->amount = 0.35;
            $this->amountPerAction = 0.35;
            $this->payout = 0.17;	//48,57%
        } else if($amount == 0.45) {
            $this->setMode("PC");
            $this->amount = 0.45;
            $this->amountPerAction = 0.45;
            $this->payout = 0.25;	//55,55%
        } else if($amount == 0.55) {
            $this->setMode("PC");
            $this->amount = 0.55;
            $this->amountPerAction = 0.55;
            $this->payout = 0.33;	//60%
        } else if($amount == 0.60) {
            $this->setMode("PC");
            $this->amount = 0.60;
            $this->amountPerAction = 0.60;
            $this->payout = 0.37;	//61%
        } else if($amount == 0.70) {
            $this->setMode("PC");
            $this->amount = 0.70;
            $this->amountPerAction = 0.70;
            $this->payout = 0.45;	//64
        } else if($amount == 0.90) {
            $this->setMode("PC");
            $this->amount = 0.90;
            $this->amountPerAction = 0.90;
            $this->payout = 0.61;	//0.67
        } else if($amount == 1.00) {
            $this->setMode("PC");
            $this->amount = 1.00;
            $this->amountPerAction = 1.00;
            $this->payout = 0.68;	//68%
        } else if($amount == 1.15) {
            $this->setMode("PC");
            $this->amount = 1.15;
            $this->amountPerAction = 1.15;
            $this->payout = 0.79;	//68%
        } else if($amount == 1.30) {
            $this->setMode("PC");
            $this->amount = 1.30;
            $this->amountPerAction = 1.30;
            $this->payout = 0.92;	//70%
        } else if($amount == 1.40) {
            $this->setMode("PC");
            $this->amount = 1.40;
            $this->amountPerAction = 1.40;
            $this->payout = 0.98;	//70%
        } else if($amount >= 0.35 && $amount < 0.80) {
            $this->setMode("PM");
            $this->amountPerAction = 0.35;
            $this->duration = round(60 * $amount/$this->amountPerAction);
            $this->amount = round($this->duration / 60 * $this->amountPerAction, 2);
            $this->payout = round(0.12 * round($this->amount / $this->amountPerAction), 2); //34%
        } else if($amount >= 0.80 && $amount <= 10.00) {
            $this->setMode("PM");
            $this->amountPerAction = 0.80;
            $this->duration = round(60 * $amount/$this->amountPerAction);
            $this->amount = round($this->duration / 60 * $this->amountPerAction, 2);
            $this->payout = round(0.56 * round($this->amount / $this->amountPerAction), 2); //70%
        } else {
            $this->setMode("PM");
            $this->amountPerAction = 0.90;
            $this->duration = round(60 * $amount/$this->amountPerAction);
            $this->amount = round($this->duration / 60 * $this->amountPerAction, 2);
            $this->payout = round(0.61 * round($this->amount / $this->amountPerAction), 2); //67%
        }
        return $this->amount;
    }

    /**
     * calculate amount from amountPerAction, mode and duration.
     */
    public function calculateAmount()
    {
        if($this->amountPerAction == 0.35 && $this->getMode() == "PC") {
            $this->amountPerAction = 0.35;
            $this->amount = 0.35;
            $this->payout = 0.17; //48,57%
        } else if($this->amountPerAction == 0.45 && $this->getMode() == "PC") {
            $this->amountPerAction = 0.45;
            $this->amount = 0.45;
            $this->payout = 0.25; //55,55%
        } else if($this->amountPerAction == 0.55 && $this->getMode() == "PC") {
            $this->amountPerAction = 0.55;
            $this->amount = 0.55;
            $this->payout = 0.33; //60%
        } else if($this->amountPerAction == 0.60 && $this->getMode() == "PC") {
            $this->amountPerAction = 0.60;
            $this->amount = 0.60;
            $this->payout = 0.37; //61%
        } else if($this->amountPerAction == 0.70 && $this->getMode() == "PC") {
            $this->amountPerAction = 0.70;
            $this->amount = 0.70;
            $this->payout = 0.45; //64
        } else if($this->amountPerAction == 0.90 && $this->getMode() == "PC") {
            $this->amountPerAction = 0.90;
            $this->amount = 0.90;
            $this->payout = 0.61; //0.67
        } else if($this->amountPerAction == 1.00 && $this->getMode() == "PC") {
            $this->amountPerAction = 1.00;
            $this->amount = 1.00;
            $this->payout = 0.68; //68%
        } else if($this->amountPerAction == 1.15 && $this->getMode() == "PC") {
            $this->amountPerAction = 1.15;
            $this->amount = 1.15;
            $this->payout = 0.79; //68%
        } else if($this->amountPerAction == 1.30 && $this->getMode() == "PC") {
            $this->amountPerAction = 1.30;
            $this->amount = 1.30;
            $this->payout = 0.92; //70%
        } else if($this->amountPerAction == 1.40 && $this->getMode() == "PC") {
            $this->amountPerAction = 1.40;
            $this->amount = 1.40;
            $this->payout = 0.98; //70%
        } else if($this->amountPerAction == 0.35 && $this->getMode() == "PM") {
            $this->amountPerAction = 0.35;
            $this->amount = round($this->duration / 60 * $this->amountPerAction, 2);
            $this->payout = round(0.12 * round($this->amount / $this->amountPerAction), 2);
        } else if($this->amountPerAction == 0.80 && $this->getMode() == "PM") {
            $this->amountPerAction = 0.80;
            $this->amount = round($this->duration / 60 * $this->amountPerAction, 2);
            $this->payout = round(0.56 * round($this->amount / $this->amountPerAction), 2);
        } else if($this->amountPerAction == 0.90 && $this->getMode() == "PM") {
            $this->amountPerAction = 0.90;
            $this->amount = round($this->duration / 60 * $this->amountPerAction, 2);
            $this->payout = round(0.61 * round($this->amount / $this->amountPerAction), 2);
        }
    }
}