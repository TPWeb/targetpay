<?php
namespace TPWeb\TargetPay\Transaction\SMS;

use TPWeb\TargetPay\Exception\AmountException;
use \TPWeb\TargetPay\Transaction\SMS\Country;


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
class Belgium extends Country {
    protected $name = "België";
    protected $code = 32;
    public $minAmount = 1;
    public $maxAmount = 2;
    public $arraySelector = true;

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
        if($amount <= 1.25) {
            $this->keyword = "ORDER";
            $this->shortcode = "6033";
            $this->amount = 1.00;
            $this->payout = 0.35 - 0.01; //20%
        } else if($amount > 1.25 && $amount <= 1.75) {
            $this->keyword = "ORDER";
            $this->shortcode = "6638";
            $this->amount = 1.50;
            $this->payout = 0.53 - 0.01; //34
        } else if($amount > 1.75) {
            $this->keyword = "ORDER";
            $this->shortcode = "6045";
            $this->amount = 2.00;
            $this->payout = 0.78 - 0.01; //38.5
        }
        return $this->amount;
    }
}