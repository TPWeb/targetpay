<?php
namespace TPWeb\TargetPay\Transaction\SMS;

use TPWeb\TargetPay\Exception\AmountException;
use TPWeb\TargetPay\Exception\SMSException;

/**
 *
 * PHP TargetPay Library
 *
 * @version    1.4.0
 * @package    tpweb/targetpay
 * @copyright  Copyright (c) 2016 Made I.T. (http://www.madeit.be) - TPWeb.org (http://www.tpweb.org)
 * @author     Made I.T. <info@madeit.be>
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt    LGPL
 */
class Country {
    protected $name = "Country";
    protected $code = 0;
    public $minAmount = 0.25;
    public $maxAmount = 6;
    public $amount = 0;
    public $payout;
    public $currency = "EURO";
    public $keyword;
    public $shortcode;

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
     * get country code
     * @return integer
     */
    public function getCode()
    {
        return $this->code;
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
        return round($this->payout, 2);
    }
    
    /**
     * set keyword
     * @param string
     */
    public function setKeyword($keyword) {
        $this->keyword = $keyword;
    }
    
    /**
     * get keyword
     * @return string
     */
    public function getKeyword() {
        return $this->keyword;
    }
    
    /**
     * set shortcode
     * @param string
     */
    public function setShortcode($shortcode) {
        $this->shortcode = $shortcode;
    }
    
    /**
     * get shortcode
     * @return string
     */
    public function getShortcode() {
        return $this->shortcode;
    }
}