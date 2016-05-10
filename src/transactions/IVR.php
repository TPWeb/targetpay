<?php
namespace TPWeb\TargetPay\Transaction;

use \TPWeb\TargetPay\Exception\IVRException;
use \TPWeb\TargetPay\Transaction\IVR\Austria;
use \TPWeb\TargetPay\Transaction\IVR\Belgium;
use \TPWeb\TargetPay\Transaction\IVR\Country;
use \TPWeb\TargetPay\Transaction\IVR\France;
use \TPWeb\TargetPay\Transaction\IVR\Germany;
use \TPWeb\TargetPay\Transaction\IVR\Italy;
use \TPWeb\TargetPay\Transaction\IVR\Luxembourg;
use \TPWeb\TargetPay\Transaction\IVR\Netherland;
use \TPWeb\TargetPay\Transaction\IVR\Suisse;
use \TPWeb\TargetPay\Transaction\IVR\UnitedKingdom;
use \TPWeb\TargetPay\Transaction\Transaction;

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
class IVR extends Transaction {
    protected $name = "IVR";
    public $country;
    public $serviceNumber;
    public $paycode;
    public $adult = false;
    public $urlPaymentInfo = "http://api.targetpay.nl/payment/startpayment.asp";
    public $urlPaymentCheck = "http://api.targetpay.nl/payment/checkpayment.asp";

    const BELGIUM = 32;
    const NETHERLAND = 31;
    const FRANCE = 33;
    const ITALY = 39;
    const SUISSE = 41;
    const AUSTRIA = 43;
    const UK = 44;
    const GERMANY = 49;
    const LUXEMBOURG = 352;

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
                    33 => 'France',
                    39 => 'Italia',
                    41 => 'Schweiz / Suisse / Svizzera / Svizra',
                    43 => 'Österreich',
                    44 => 'United Kingdom',
                    49 => 'Deutschland',
                    352 => 'Lëtzebuerg',
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
        } else if($country instanceof FRANCE || $country == 33) {
            $this->country = new France();
        } else if($country instanceof ITALY || $country == 39) {
            $this->country = new Italy();
        } else if($country instanceof SUISSE || $country == 41) {
            $this->country = new Suisse();
        } else if($country instanceof AUSTRIA || $country == 43) {
            $this->country = new Austria();
        } else if($country instanceof UK || $country == 44) {
            $this->country = new UnitedKingdom();
        } else if($country instanceof GERMANY || $country == 49) {
            $this->country = new Germany();
        } else if($country instanceof LUXEMBOURG || $country == 352) {
            $this->country = new Luxembourg();
        } else {
            throw new IVRException('Country not found', 1);
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
     * get list of amounts that can be used.
     * @return array|null
     */
    public function getAmountList()
    {
        return $this->country->getAmountList();
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
     * set payment mode
     * @param string $mode
     */
    public function setMode($mode)
    {
        $this->country->setMode($mode);
    }

    /**
     * get payment mode
     * @return string
     */
    public function getMode()
    {
        return $this->country->getMode();
    }

    /**
     * set if payment is used for adult only content
     * @param boolean (default: false)
     */
    public function setAdult($boolean)
    {
        $this->adult = is_bool($boolean) ? $boolean : false;
    }

    /**
     * get if payment is used for adult only content
     * @return boolean
     */
    public function getAdult() {
        return $this->adult;
    }

    /**
     * set call duration
     * @param int $duration in seconds
     */
    public function setDuration($duration)
    {
        $this->country->duration = $duration;
    }

    /**
     * get call duration
     * @return int duration in seconds
     */
    public function getDuration()
    {
        return $this->country->duration;
    }

    /**
     * set payment service phone number
     * @param phonenumber
     */
    public function setServiceNumber($number)
    {
        $this->serviceNumber = $number;
    }

    /**
     * get service phone number
     * @return string
     */
    public function getServiceNumber()
    {
        return $this->serviceNumber;
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
     * get amount per call or per minute
     * @return numeric
     */
    public function getAmountPerAction()
    {
        return $this->country->getAmountPerAction();
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
     * calculate payed amount. real called duration, mode and amountPerAction
     */
    public function calculateAmount()
    {
        $this->country->calculateAmount();
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