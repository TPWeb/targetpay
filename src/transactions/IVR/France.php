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
class France extends Country {
    protected $name = "France";
    protected $code = 33;
    public $minAmount = 1.35;
    public $maxAmount = 1.35;
    public $arraySelector = true;
    public $arrayAmount = [1.35];

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
        $this->setMode("PC");
        $this->amount = 1.35;
        $this->amountPerAction = 1.35;
        $this->payout = 0.90; //66%
        return $this->amount;
    }

    /**
     * calculate amount from amountPerAction, mode and duration.
     */
    public function calculateAmount()
    {
        if($this->amountPerAction == 1.35 && $this->getMode() == "PC") {
            $this->amountPerAction = 1.35;
            $this->amount = 1.35;
            $this->payout = 0.90;
        }
    }

}