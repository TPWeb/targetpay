<?php
namespace TPWeb\TargetPay\Transaction;

use \TPWeb\TargetPay\Exception\MisterCashException;
use \TPWeb\TargetPay\Transaction\Transaction;

/**
 *
 * PHP TargetPay Library
 *
 * @version    1.2.0
 * @package    tpweb/targetpay
 * @copyright  Copyright (c) 2016 Made I.T. (http://www.madeit.be) - TPWeb.org (http://www.tpweb.org)
 * @author     Made I.T. <info@madeit.be>
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt    LGPL
 */
class MisterCash extends Transaction {
    protected $name = "Bancontact/Mister Cash";
    private $transactionKost = 0.25; //Meer dan 10 transacties per dag?: 0.49
    private $transactionProcent = 1.75;
    public $maxAmount = 5000.00;
    public $minAmount = 0.49;
    public $mcStartUrl = "https://www.targetpay.com/mrcash/start";
    public $mcCheckUrl = "https://www.targetpay.com/mrcash/check";
    public $amount;
    public $description;
    public $lang;
    public $returnUrl;
    public $reportUrl;
    public $transactionId;
    public $mcUrl;

    /**
     * construct Mistercash transaction
     * @param bank (default: null), amount (default: null)
     */
    function __construct($lang = "NL", $amount = null)
    {
        if($lang != null) {
            $this->setLang($lang);
        }
        if($amount != null) {
            $this->setAmount($amount);
        }
    }

    /**
     * set lang 
     * @param $lang
     * @throws MisterCashException
     */
    public function setLang($lang)
    {
        if($lang == 'NL') {
            $this->lang = 'NL';
        } else if($lang == 'FR') {
            $this->lang = 'FR';
        } else if($lang == 'EN') {
            $this->lang = 'EN';
        } else {
            throw new MisterCashException('Lang not found', 1);
        }
    }
    
    /**
     * get lang 
     * @return $lang
     */
    public function getLang()
    {
        return $this->lang;
    }

    /**
     * get payout amount.
     * @return numeric
     */
    public function getPayout()
    {
        return round($this->amount - $this->transactionKost - ($this->amount / 100 * $this->transactionProcent), 2);
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
    public function setMisterCashUrl($mcUrl)
    {
        $this->mcUrl = $mcUrl;
    }

    /**
     * get ideal url
     * @return string
     */
    public function getMisterCashUrl()
    {
        return $this->mcUrl;
    }
}