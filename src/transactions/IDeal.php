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
 * @version    1.1.0
 * @package    tpweb/targetpay
 * @copyright  Copyright (c) 2016 Made I.T. (http://www.madeit.be) - TPWeb.org (http://www.tpweb.org)
 * @author     Made I.T. <info@madeit.be>
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt    LGPL
 */
class IDeal extends Transaction {
    protected $name = "IDeal";
    private $transactionKost = 0.70; //Meer dan 10 transacties per dag?: 0.49
    public $maxAmount = 10000.00;
    public $minAmount = 0.84;
    public $bank;
    public $amount;
    public $description;
    public $returnUrl;
    public $cancelUrl;
    public $reportUrl;
    public $transactionId;
    public $idealUrl;
    

    const ABN_AMRO = 'ABNANL2A';
    const ASN_BANK = 'ASNBNL21';
    const BUNQ = 'BUNQNL2A';
    const ING = 'INGBNL2A';
    const KNAB = 'KNABNL2H';
    const RABOBANK = 'RABONL2U';
    const REGIOBANK = 'RBRBNL21';
    const SNS_BANK = 'SNSBNL2A';
    const TRIODOS_BANK = 'TRIONL2U';
    const VAN_LANDSCHOT = 'FVLBNL22';

    /**
     * construct IDeal transaction
     * @param bank (default: null), amount (default: null)
     */
    function __construct($bank = null, $amount = null)
    {
        if($bank != null) {
            $this->setBank($bank);
        }
        if($amount != null) {
            $this->setAmount($amount);
        }
    }

    /**
     * get list of possible banks
     * @return array
     */
    public static function bankList()
    {
        return [
                    'ABNANL2A' => 'ABN AMRO',
                    'ASNBNL21' => 'ASN Bank',
                    'BUNQNL2A' => 'bunq',
                    'INGBNL2A' => 'ING',
                    'KNABNL2H' => 'Knab',
                    'RABONL2U' => 'Rabobank',
                    'RBRBNL21' => 'RegioBank',
                    'SNSBNL2A' => 'SNS Bank',
                    'TRIONL2U' => 'Triodos Bank',
                    'FVLBNL22' => 'van Lanschot',
        ];
    }

    /**
     * set bank 
     * @param $bank
     * @throws IDealException
     */
    public function setBank($bank)
    {
        if($bank instanceof ABN_AMRO || $bank == 'ABNANL2A') {
            $this->bank = ABN_AMRO;
        } else if($bank instanceof ASN_BANK || $bank == 'ASNBNL21') {
            $this->bank = ASN_BANK;
        } else if($bank instanceof BUNQ || $bank == 'BUNQNL2A') {
            $this->bank = BUNQ;
        } else if($bank instanceof ING || $bank == 'INGBNL2A') {
            $this->bank = ING;
        } else if($bank instanceof KNAB || $bank == 'KNABNL2H') {
            $this->bank = KNAB;
        } else if($bank instanceof RABOBANK || $bank == 'RABONL2U') {
            $this->bank = RABOBANK;
        } else if($bank instanceof REGIOBANK || $bank == 'RBRBNL21') {
            $this->bank = REGIOBANK;
        } else if($bank instanceof SNS_BANK || $bank == 'SNSBNL2A') {
            $this->bank = SNSBNL2A;
        } else if($bank instanceof TRIODOS_BANK || $country == 'TRIONL2U') {
            $this->bank = TRIODOS_BANK;
        } else if($bank instanceof VAN_LANDSCHOT || $country == 'FVLBNL22') {
            $this->bank = VAN_LANDSCHOT;
        } else {
            throw new IDealException('Bank not found', 1);
        }
    }
    
    /**
     * get bank 
     * @return $bank
     */
    public function getBank($bank)
    {
        return $this->bank;
    }

    /**
     * get payout amount.
     * @return numeric
     */
    public function getPayout()
    {
        return round($this->amount - $this->transactionKost, 2);
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
     * set cancel url
     * @param string
     */
    public function setCancelUrl($cancelUrl)
    {
        $this->cancelUrl = $cancelUrl;
    }

    /**
     * get cancel url
     * @return string
     */
    public function getCancelUrl()
    {
        return $this->cancelUrl;
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
    public function setIdealUrl($idealUrl)
    {
        $this->idealUrl = $idealUrl;
    }

    /**
     * get ideal url
     * @return string
     */
    public function getIdealUrl()
    {
        return $this->idealUrl;
    }
}