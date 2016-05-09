<?php
namespace TPWeb\TargetPay;

use Log;
use TPWeb\TargetPay\Exception\AmountException;
use TPWeb\TargetPay\Exception\TargetPayException;
use TPWeb\TargetPay\Exception\TransactionTypeException;

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
class TargetPay
{
    protected $version = '1.0.0';
    private $klantcode;
    private $layoutcode;
    private $test;
    private $debug;
    private $url;

    public $transaction;

    /**
     * Construct TargetPay
     * @param  Transaction|null		$transaction
     */
    function __construct($transaction = null) {
        $this->setKlantcode(config('targetpay.klantcode'));
        $this->setLayoutcode(config('targetpay.layoutcode'));
        $this->setTest(config('targetpay.test'));
        $this->setDebug(config('targetpay.debug'));

        if($transaction != null) {
            $this->setTransaction($transaction);
        }
    }

    /**
     * Set transaction
     * @param  Transaction		$transaction
     */
    public function setTransaction($transaction)
    {
        if($transaction instanceof \TPWeb\TargetPay\Transaction\IVR) {
            $this->transaction = $transaction;
        } else {
            throw new TransactionTypeException('Type not found.', 1);
        }
    }

    /**
     * Get transaction
     * @param  boolean		$string		false		-> true: String value of transaction type / false: Transaction object
     * @return String|Transaction
     * @throws TransactionTypeException
     */
    public function getTransaction($string = false) {
        if($this->transaction == null) {
            throw new TransactionTypeException('No transaction initialized.', 2);
        } else {
            if($string)
                return $this->transaction->getName();
            return $this->transaction;
        }
    }

    /**
     * Set klantcode
     * @param  String		$klantcode
     * @throws TargetPayException
     */
    public function setKlantcode($klantcode) {
        if($klantcode == null) {
            throw new TargetPayException('No klantcode found.', 1);
        }
        $this->klantcode = $klantcode;
    }

    /**
     * Get klantcode
     * @return String
     */
    public function getKlantcode()
    {
        return $this->klantcode;
    }

    /**
     * set layoutcode
     * @param String layoutcode
     * @throws TargetPayException
     */
    public function setLayoutcode($layoutcode)
    {
        if($layoutcode == null) {
            throw new TargetPayException('No layoutcode found.', 2);
        }
        $this->layoutcode = $layoutcode;
    }

    /**
     * get layoutcode
     * @return String
     */
    public function getLayoutcode()
    {
        return $this->layoutcode;
    }

    /**
     * set test mode
     * @param Boolean (default: false)
     */
    public function setTest($boolean)
    {
        $this->test = is_bool($boolean) ? $boolean : false;
    }

    /**
     * get test mode
     * @return boolean
     */
    public function getTest()
    {
        return $this->test;
    }

    /**
     * set debug (logging)
     * @param boolean (default: false)
     */
    public function setDebug($boolean)
    {
        $this->debug = is_bool($boolean) ? $boolean : false;
    }

    /**
     * get if debug mode is on.
     * @return boolean
     */
    public function getDebug()
    {
        return $this->debug;
    }

    /**
     * set amount to pay
     * @param numeric 
     * @throws AmountException
     */
    public function setAmount($amount)
    {
        if(is_numeric($amount)) {
            $this->transaction->setAmount($amount);
        } else {
            throw new AmountException("Amount isn't numeric.", 1);
        }
    }

    /**
     * get amount to pay
     * @return numeric
     */
    public function getAmount()
    {
        return $this->transaction->getAmount();
    }

    /**
     * get amount you will receive
     * @return numeric
     */
    public function getPayout()
    {
        return $this->transaction->getPayout();
    }

    /**
     * get currency
     * @return string
     */
    public function getCurrency()
    {
        return $this->transaction->getCurrency();
    }

    /**
     * mark payment complete status
     * @param boolean
     */
    public function setPaymentDone($boolean)
    {
        $this->transaction->setPaymentDone($boolean);
    }

    /**
     * get payment complete status
     * @return boolean
     */
    public function getPaymentDone()
    {
        return $this->transaction->getPaymentDone();
    }

    /***** IVR specific ******/
    /**
     * get list of amounts to use.
     * @return array|null
     * @throws TransactionTypeException
     */
    public function getAmountList()
    {
        if($this->transaction instanceof \TPWeb\TargetPay\Transaction\IVR) {
            return $this->transaction->getAmountList();
        } else {
            throw new TransactionTypeException('Type not allowed', 2);
        }
    }


    /**
     * set country code
     * @param country
     * @throws TransactionTypeException
     */
    public function setCountry($country)
    {
        if($this->transaction instanceof \TPWeb\TargetPay\Transaction\IVR) {
            $this->transaction->setCountry($country);
        } else {
            throw new TransactionTypeException('Type not allowed', 2);
        }
    }

    /**
     * get country code
     * @return country code
     * @throws TransactionTypeException
     */
    public function getCountry()
    {
        if($this->transaction instanceof \TPWeb\TargetPay\Transaction\IVR) {
            return $this->transaction->getCountry();
        } else {
            throw new TransactionTypeException('Type not allowed', 2);
        }
    }

    /**
     * set service phone number
     * @param phonenumber
     * @throws TransactionTypeException
     */
    public function setServiceNumber($number)
    {
        if($this->transaction instanceof \TPWeb\TargetPay\Transaction\IVR) {
            $this->transaction->setServiceNumber($number);
        } else {
            throw new TransactionTypeException('Type not allowed', 2);
        }
    }

    /**
     * get service phone number
     * @return phonenumber
     * @throws TransactionTypeException
     */
    public function getServiceNumber()
    {
        if($this->transaction instanceof \TPWeb\TargetPay\Transaction\IVR) {
            return $this->transaction->getServiceNumber();
        } else {
            throw new TransactionTypeException('Type not allowed', 2);
        }
    }

    /**
     * set service code to enter during call.
     * @param string $code
     * @throws TransactionTypeException
     */
    public function setPayCode($code)
    {
        if($this->transaction instanceof \TPWeb\TargetPay\Transaction\IVR) {
            $this->transaction->setPayCode($code);
        } else {
            throw new TransactionTypeException('Type not allowed', 2);
        }
    }

    /**
     * get service code to enter during call.
     * @return  string $code
     * @throws TransactionTypeException
     */
    public function getPayCode()
    {
        if($this->transaction instanceof \TPWeb\TargetPay\Transaction\IVR) {
            return $this->transaction->getPayCode();
        } else {
            throw new TransactionTypeException('Type not allowed', 2);
        }
    }

    /**
     * set payment mode
     * @param String $mode
     */
    public function setMode($mode)
    {
        if($this->transaction instanceof \TPWeb\TargetPay\Transaction\IVR) {
            $this->transaction->setMode($mode);
        } else {
            throw new TransactionTypeException('Type not allowed', 2);
        }
    }

    /**
     * get payment mode
     * @return String $mode
     * @throws TransactionTypeException
     */
    public function getMode()
    {
        if($this->transaction instanceof \TPWeb\TargetPay\Transaction\IVR) {
            return $this->transaction->getMode();
        } else {
            throw new TransactionTypeException('Type not allowed', 2);
        }
    }

    /**
     * set call duration
     * @param set payment duration
     * @throws TransactionTypeException
     */
    public function setDuration($duration)
    {
        if($this->transaction instanceof \TPWeb\TargetPay\Transaction\IVR) {
            $this->transaction->setDuration($duration);
        } else {
            throw new TransactionTypeException('Type not allowed', 2);
        }
    }

    /**
     * get call duration
     * @return int (seconds)
     * @throws TransactionTypeException
     */
    public function getDuration()
    {
        if($this->transaction instanceof \TPWeb\TargetPay\Transaction\IVR) {
            return $this->transaction->getDuration();
        } else {
            throw new TransactionTypeException('Type not allowed', 2);
        }
    }

    /**
     * get amount per action, amount pay per minute or amount pay per call
     * @return numeric
     * @throws TransactionTypeException
     */
    public function getAmountPerAction()
    {
        if($this->transaction instanceof \TPWeb\TargetPay\Transaction\IVR) {
            return $this->transaction->getAmountPerAction();
        } else {
            throw new TransactionTypeException('Type not allowed', 2);
        }
    }

    /**
     * set if payment is used for adult only content
     * @param boolean
     * @throws TransactionTypeException
     */
    public function setAdult($boolean)
    {
        if($this->transaction instanceof \TPWeb\TargetPay\Transaction\IVR) {
            $this->transaction->setAdult($boolean);
        } else {
            throw new TransactionTypeException('Type not allowed', 2);
        }
    }

    /**
     * get if payment is used for adult only content
     * @return boolean
     * @throws TransactionTypeException
     */
    public function getAdult()
    {
        if($this->transaction instanceof \TPWeb\TargetPay\Transaction\IVR) {
            return $this->transaction->getAdult();
        } else {
            throw new TransactionTypeException('Type not allowed', 2);
        }
    }

    /**
     * get payment info, fetch remote payment info data
     * @throws TransactionTypeException, TargetPayException
     */
    public function getPaymentInfo()
    {
        if($this->transaction instanceof \TPWeb\TargetPay\Transaction\IVR) {
            $mode = $this->transaction->getMode();
            if($mode == "PM") {
                $url = 'http://api.targetpay.nl/payment/startpayment.asp?' .
                                'rtlo='. urlencode($this->layoutcode) .
                                '&ct='.urlencode($mode) .
                                '&co=' . urlencode($this->transaction->country->getCode()) .
                                '&tb='.urlencode($this->getAmountPerAction() * 100) .
                                '&cd=' . urlencode($this->transaction->getDuration()) .
                                '&iphash=' . urlencode($_SERVER['REMOTE_ADDR']) . 
                                '&adult=' . ($this->getAdult() ? 1 : 0) .
                                '&test=' . ($this->test ? 1 : 0);
            } else if($mode == "PU") {
                $url = 'http://api.targetpay.nl/payment/startpayment.asp?' .
                                'rtlo='. urlencode($this->layoutcode) .
                                '&ct='.urlencode($mode) .
                                '&co=' . urlencode($this->transaction->country->getCode()) . 
                                '&tb='.urlencode($this->getAmountPerAction() * 100) .
                                '&cu=' . urlencode($this->url) .
                                '&iphash=' . urlencode($_SERVER['REMOTE_ADDR']) . 
                                '&adult=' . ($this->getAdult() ? 1 : 0) .
                                '&test=' . ($this->test ? 1 : 0);
            } else if($mode == "PC") {
                $url = 'http://api.targetpay.nl/payment/startpayment.asp?' .
                                'rtlo='. urlencode($this->layoutcode) .
                                '&ct='.urlencode($mode) .
                                '&co=' . urlencode($this->transaction->country->getCode()) . 
                                '&tb='.urlencode($this->getAmountPerAction() * 100) .
                                '&iphash=' . urlencode($_SERVER['REMOTE_ADDR']) . 
                                '&adult=' . ($this->getAdult() ? 1 : 0) .
                                '&test=' . ($this->test ? 1 : 0);
            } else {
                throw new IVRException('Mode not found.', 2);
            }
            $result = $this->getResponse($url);
            if($this->debug) {
                Log::info('TargetPay URL:' . $url);
                Log::info('TargetPay Response:' . $result);
            }
            if (!$result) {
                throw new TargetPayException("Can't load payment info", 3);
            }

            $data = explode('|', $result);
            $resCode = substr($data[0], 0, 3);
            if($resCode == "000") {
                $this->transaction->setServiceNumber($data[2]);
                $this->transaction->setPayCode($data[1]);
            } else if($resCode == "001") {
                throw new TargetPayException("Invalid call type", 4);
            } else if($resCode == "002") {
                throw new TargetPayException("Invalid tariff for call type PC and country", 4);
            } else if($resCode == "003") {
                throw new TargetPayException("Invalid tariff for call type PM and country", 4);
            } else if($resCode == "004") {
                throw new TargetPayException("Invalid tariff for call type PU and country", 4);
            } else if($resCode == "005") {
                throw new TargetPayException("Invalid call duration for this call type and country", 4);
            } else if($resCode == "006") {
                throw new TargetPayException("Call type not available in this country", 4);
            } else if($resCode == "007") {
                throw new TargetPayException("Invalid country code", 4);
            } else if($resCode == "008") {
                throw new TargetPayException("Confirm URL missing", 4);
            } else if($resCode == "009") {
                throw new TargetPayException("Call duration missing", 4);
            } else if($resCode == "010") {
                throw new TargetPayException("Invalid iphash", 4);
            } else {
                throw new TargetPayException("Can't load payment info, wrong parameters.", 4);
            }	
        } else {
            throw new TransactionTypeException('Type not allowed', 2);
        }
    }

    /**
     * check if payment is done.
     * @throws TransactionTypeException
     */
    public function checkPaymentInfo()
    {
        if($this->transaction instanceof \TPWeb\TargetPay\Transaction\IVR) {
            $url = 'http://api.targetpay.nl/payment/checkpayment.asp?' .
                                    'rtlo='. urlencode($this->layoutcode) .
                                    '&paycode='.urlencode($this->getPayCode()) .
                                    '&payline=' . urlencode($this->getServiceNumber()) . 
                                    '&country='.urlencode($this->getCountry()) .
                                    '&test=' . ($this->test ? 1 : 0);
            $result = $this->getResponse($url);
            if($this->debug) {
                Log::info('TargetPay URL:' . $url);
                Log::info('TargetPay Response:' . $result);
            }
            if (!$result) {
                throw new TargetPayException("Can't load payment info", 3);
            }
            $data = explode('|', $result);
            $resCode = substr($data[0], 0, 3);
            if($resCode == "000") {
                $this->setPaymentDone(true);
                $this->transaction->country->setAmountPerAction($data[1]);
                $this->setMode($data[2]);
                $this->setDuration($data[3]);
                $this->transaction->calculateAmount();
            } else {
                $this->setPaymentDone(false);
            }	
        } else {
            throw new TransactionTypeException('Type not allowed', 2);
        }
    }

    /*******/
    /**
     * get response data
     * @param $url
     * @return data
     */
    private function getResponse($url)
    {
        $ch = curl_init($url);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($ch, CURLOPT_USERAGENT, "TPWeb.org - MadeIT.be - TargetPay Library " . $this->version);
        $strResponse = curl_exec($ch);
        curl_close($ch);
        return $strResponse;
    }
}
