<?php
namespace TPWeb\TargetPay\Transaction\IVR;

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
class Country {
    protected $name = "Country";
    protected $code = 0;
    public $minAmount = 0;
    public $maxAmount = 100;
    public $arraySelector = false;
    public $arrayAmount;
    public $amount = 0;
    public $payout;
    public $amountPerAction = 0; //amount per minute or per call
    public $type;
    public $duration;
    public $mode;
    public $currency = "EURO";

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
        $this->amount = $amount;
        return $this->amount;
    }

    /**
     * get list of possible amounts
     * @return array|null
     */
    public function getAmountList()
    {
        if($this->arraySelector) {
            return $this->arrayAmount;
        }
        return null;
    }

    /**
     * get maximum payment amount
     * @return numeric
     */
    public function getMinimumAmount()
    {
        return $this->minAmount;
    }

    /**
     * get maximum payment amount
     * @return numeric
     */
    public function getMaximumAmount()
    {
        return $this->maxAmount;
    }

    /**
     * set payment mode
     * @param string 
     * @throws IVRException
     */
    public function setMode($mode) {
        if(in_array($mode, ['PM', 'PC'])) {
            $this->mode = $mode;
        } else {
            throw new IVRException('Mode not found.', 2);
        }
    }

    /**
     * get payment mode
     * @return string
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * get country code
     * @return integer
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * get amount per action (Amount per call, Amount per minute)
     * @return numeric
     */
    public function getAmountPerAction()
    {
        return $this->amountPerAction;
    }

    /**
     * set amount per action (Amount per call, Amount per minute)
     * @param numeric
     * @return numeric
     */
    public function setAmountPerAction($amount)
    {
        $this->amountPerAction = $amount;
        return $this->amountPerAction;
    }

    /**
     * get currency
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * get amount payout
     * @return numeric
     */
    public function getPayout()
    {
        return $this->payout;
    }
}