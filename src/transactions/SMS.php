<?php
namespace TPWeb\TargetPay\Transaction;

use \TPWeb\TargetPay\Transaction\SMS\Belgium;
use \TPWeb\TargetPay\Transaction\SMS\Country;
use \TPWeb\TargetPay\Transaction\SMS\Netherland;
use \TPWeb\TargetPay\Transaction\Transaction;
use \TPWeb\TargetPay\Exception\SMSException;

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
class SMS extends Transaction {
    protected $name = "SMS";
    public $country;
    public $shortcode;
    public $keyword;
    public $paycode;
    public $urlPaymentCheck = "https://www.targetpay.com/api/sms-pincode";

    const BELGIUM = 32;
    const NETHERLAND = 31;

    /**
     * construct IVR transaction
     * @param country (default: null), amount (default: null)
     */
    function __construct($country = null, $amount = null)
    {
        if($country != null) {
            $this->setCountry($country);
        }
        if($amount != null) {
            $this->setAmount($amount);
        }
    }

    /**
     * get list of possible countrys
     * @return array
     */
    public static function countryList()
    {
        return [
                    31 => 'Nederland',
                    32 => 'België',
        ];
    }

    /**
     * set country 
     * @param $country
     * @throws IVRException
     */
    public function setCountry($country)
    {
        if($country instanceof NETHERLAND || $country == 31) {
            $this->country = new Netherland();
        } else if($country instanceof BELGIUM || $country == 32) {
            $this->country = new Belgium();
        } else {
            throw new SMSException('Country not found', 1);
        }
    }

    /**
     * set payment amount
     * @param $amount
     */
    public function setAmount($amount)
    {
        if(is_numeric($amount)) {
            $this->amount = $this->country->setAmount($amount);
        }
    }

    /**
     * get payment amount
     * @return numeric
     */
    public function getAmount()
    {
        return $this->country->amount;
    }

    /**
     * get payout amount.
     * @return numeric
     */
    public function getPayout()
    {
        return $this->country->getPayout();
    }

    /**
     * get minimum amount 
     * @return numeric
     */
    public function getMinimumAmount()
    {
        return $this->country->getMinimumAmount();
    }

    /**
     * get maximum amount
     * @return numeric
     */
    public function getMaximumAmount()
    {
        return $this->country->getMaximumAmount();
    }

    /**
     * set payment shortcode phone number
     * @param phonenumber
     */
    public function setShortcode($shortcode)
    {
        $this->country->setShortcode($shortcode);
    }

    /**
     * get service phone number
     * @return string
     */
    public function getShortcode()
    {
        return $this->country->getShortcode();
    }

    /**
     * set payment code 
     * @param string
     */
    public function setPayCode($code)
    {
        $this->paycode = $code;
    }

    /**
     * get payment code
     * @return string
     */
    public function getPayCode()
    {
        return $this->paycode;
    }

    /**
     * set keyword
     * @param string
     */
    public function setKeyword($keyword)
    {
        $this->country->setKeyword($keyword);
    }

    /**
     * get keyword
     * @return string
     */
    public function getKeyword()
    {
        return $this->country->getKeyword();
    }

    /**
     * get currency
     * @return string
     */
    public function getCurrency()
    {
        return $this->country->getCurrency();
    }

    /**
     * get country code.
     * @return int
     */
    public function getCountry()
    {
        return $this->country->getCode();
    }
}