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

    /**
     * Transaction constructure
     * @param $amount (default: null)
     */
    function __construct($amount = null)
    {
        if($amount != null) {
            $this->setAmount($amount);
        }
    }

    /**
     * get transaction name
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * set payment amount
     * @param numeric $amount
     * @throws AmountException
     */
    public function setAmount($amount)
    {
        if(!is_numeric($amount))
            throw new AmountException('Amount is not numeric', 1);
        if($this->minAmount > $amount)
            throw new AmountException('Amount is to low. (Min amount: ' . $this->minAmount . ')', 2);
        if($this->maxAmount < $amount)
            throw new AmountException('Amount is to high. (Max amount: ' . $this->maxAmount . ')', 3);
        $this->amount = $amount;
        return $this->amount;
    }

    /**
     * get payment amount
     * @return numeric
     */
    public function getAmount()
    {
        $this->amount;
    }


    /**
     * get list of amounts that can be used
     * @return array | null: all amounts possible between min and max.
     */
    public function getAmountList()
    {
        if($this->arraySelector) {
            return $this->arrayAmount;
        }
        return null;
    }

    /**
     * get minimum payable amount
     * @return numeric
     */
    public function getMinimumAmount()
    {
        return $this->minAmount;
    }

    /**
     * get maximum payable amount
     * @return numeric
     */
    public function getMaximumAmount()
    {
        return $this->maxAmount;
    }

    /**
     * get currency
     * @param 
     * @return 
     * @throws
     */
    public function getCurrency()
    {
        return $this->country->getCurrency();
    }

    /**
     * set payment completion status
     * @param boolean (default:false)
     */
    public function setPaymentDone($boolean)
    {
        $this->paymentDone = is_bool($boolean) ? $boolean : false;
    }

    /**
     * get payment completen status
     * @return boolean
     */
    public function getPaymentDone()
    {
        return $this->paymentDone;
    }

    /**
     * get payout amount
     * @return numeric
     */
    public function getPayout()
    {
        return null;
    }
}