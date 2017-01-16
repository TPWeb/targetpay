<?php
namespace TPWeb\TargetPay\Transaction;

use \TPWeb\TargetPay\Exception\MisterCashException;
use \TPWeb\TargetPay\Transaction\Transaction;

/**
 *
 * PHP TargetPay Library
 *
 * @version    1.3.0
 * @package    tpweb/targetpay
 * @copyright  Copyright (c) 2016 Made I.T. (http://www.madeit.be) - TPWeb.org (http://www.tpweb.org)
 * @author     Made I.T. <info@madeit.be>
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt    LGPL
 */
class Paysafecard extends Transaction {
    protected $name = "Paysafecard";
    private $transactionProcent = 15;
    public $maxAmount = 150.00;
    public $minAmount = 0.1;
    public $psStartUrl = "https://www.targetpay.com/paysafecard/start";
    public $psCheckUrl = "https://www.targetpay.com/paysafecard/check";
    public $amount;
    public $description;
    public $returnUrl;
    public $reportUrl;
    public $transactionId;
    public $psUrl;

    /**
     * construct Paysafecard transaction
     * @param amount (default: null)
     */
    function __construct($amount = null)
    {
        if($amount != null) {
            $this->setAmount($amount);
        }
    }

    /**
     * get payout amount.
     * @return numeric
     */
    public function getPayout()
    {
        return round($this->amount - ($this->amount / 100 * $this->transactionProcent), 2);
    }

    /**
     * set payment description
     * @param string
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * get payment description
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * set return url
     * @param string
     */
    public function setReturnUrl($returnUrl)
    {
        $this->returnUrl = $returnUrl;
    }

    /**
     * get return url
     * @return string
     */
    public function getReturnUrl()
    {
        return $this->returnUrl;
    }

    /**
     * set report url
     * @param string
     */
    public function setReportUrl($reportUrl)
    {
        $this->reportUrl = $reportUrl;
    }

    /**
     * get report url
     * @return string
     */
    public function getReportUrl()
    {
        return $this->reportUrl;
    }
    
    /**
     * set transaction id
     * @param string
     */
    public function setTransactionId($transactionId)
    {
        $this->transactionId = $transactionId;
    }

    /**
     * get transaction id
     * @return string
     */
    public function getTransactionId()
    {
        return $this->transactionId;
    }

    /**
     * set ideal url
     * @param string
     */
    public function setPaysafecardUrl($mcUrl)
    {
        $this->psUrl = $mcUrl;
    }

    /**
     * get ideal url
     * @return string
     */
    public function getPaysafecardUrl()
    {
        return $this->psUrl;
    }
}