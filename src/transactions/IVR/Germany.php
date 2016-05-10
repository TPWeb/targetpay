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
class Germany extends Country {
    protected $name = "Deutschland";
    protected $code = 49;
    public $minAmount = 1.50;
    public $maxAmount = 20;

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

        $this->setMode("PM");
        $this->amountPerAction = 1.99;
        $this->duration = round(60 * $amount/$this->amountPerAction);
        $this->amount = round($this->duration / 60 * $this->amountPerAction, 2);
        $this->payout = round(1.31 * round($this->amount / $this->amountPerAction), 2); //65%
        return $this->amount;
    }

    /**
     * calculate amount from amountPerAction, mode and duration.
     */
    public function calculateAmount()
    {
        if($this->amountPerAction == 1.99 && $this->getMode() == "PM") {
            $this->amountPerAction = 1.99;
            $this->amount = round($this->duration / 60 * $this->amountPerAction, 2);
            $this->payout = round(1.31 * round($this->amount / $this->amountPerAction), 2); //65%
        }
    }
}