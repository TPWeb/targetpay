<?php
namespace TPWeb\TargetPay;

use Log;
use TPWeb\TargetPay\Exception\AmountException;
use TPWeb\TargetPay\Exception\TargetPayException;
use TPWeb\TargetPay\Exception\TransactionTypeException;
use TPWeb\TargetPay\Exception\IVRException;

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
    function __construct($transaction = null, $config = null) {
        if($config != null) {
            $this->setKlantcode($config['klantcode']);
            $this->setLayoutcode($config['layoutcode']);
            $this->setTest($config['test']);
            $this->setDebug($config['debug']);
        } else {
            $this->setKlantcode(config('targetpay.klantcode'));
            $this->setLayoutcode(config('targetpay.layoutcode'));
            $this->setTest(config('targetpay.test'));
            $this->setDebug(config('targetpay.debug'));
        }

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
        } elseif($transaction instanceof \TPWeb\TargetPay\Transaction\IDeal) {
            $this->transaction = $transaction;
        } elseif($transaction instanceof \TPWeb\TargetPay\Transaction\MisterCash) {
            $this->transaction = $transaction;
        } elseif($transaction instanceof \TPWeb\TargetPay\Transaction\Paysafecard) {
            $this->transaction = $transaction;
        } elseif($transaction instanceof \TPWeb\TargetPay\Transaction\SMS) {
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
     * get payment info, fetch remote payment info data
     * @throws TransactionTypeException, TargetPayException
     */
    public function getPaymentInfo()
    {
        if($this->transaction instanceof \TPWeb\TargetPay\Transaction\IVR) {
            $this->getPaymentInfoIVR();
        } elseif($this->transaction instanceof \TPWeb\TargetPay\Transaction\IDeal) {
            $this->getPaymentInfoIDeal();
        } elseif($this->transaction instanceof \TPWeb\TargetPay\Transaction\MisterCash) {
            $this->getPaymentInfoMiserCash();
        } elseif($this->transaction instanceof \TPWeb\TargetPay\Transaction\Paysafecard) {
            $this->getPaymentInfoPaysafecard();
        } else {
            throw new TransactionTypeException('Type not allowed', 2);
        }
    }

    /**
     * check if payment is done.
     * @throws TransactionTypeException
     */
    public function checkPaymentInfo($once = false)
    {
        if($this->transaction instanceof \TPWeb\TargetPay\Transaction\IVR) {
            $this->checkPaymentInfoIvr();
        } elseif($this->transaction instanceof \TPWeb\TargetPay\Transaction\IDeal) {
            $this->checkPaymentInfoIDeal($once);
        } elseif($this->transaction instanceof \TPWeb\TargetPay\Transaction\MisterCash) {
            $this->checkPaymentInfoMisterCash($once);
        } elseif($this->transaction instanceof \TPWeb\TargetPay\Transaction\Paysafecard) {
            $this->checkPaymentInfoPaysafecard($once);
        } elseif($this->transaction instanceof \TPWeb\TargetPay\Transaction\SMS) {
            $this->checkPaymentInfoSms();
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
    
    /**
     * get user IP
     * @return ip
     */
    private function getIp() {
        return isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : "101.10.10.02";
    }
    
    /**
     * get ivr info
     */
    private function getPaymentInfoIVR() {
        $mode = $this->transaction->getMode();
        if($mode == "PM") {
            $url = $this->transaction->urlPaymentInfo . '?' .
                            'rtlo=' . urlencode($this->layoutcode) .
                            '&ct=' . urlencode($mode) .
                            '&co=' . urlencode($this->transaction->country->getCode()) .
                            '&tb=' . urlencode($this->transaction->getAmountPerAction() * 100) .
                            '&cd=' . urlencode($this->transaction->getDuration()) .
                            '&iphash=' . urlencode($this->getIp()) . 
                            '&adult=' . ($this->transaction->getAdult() ? 1 : 0) .
                            '&test=' . ($this->test ? 1 : 0);
        } else if($mode == "PC") {
            $url = $this->transaction->urlPaymentInfo . '?' .
                            'rtlo=' . urlencode($this->layoutcode) .
                            '&ct=' . urlencode($mode) .
                            '&co=' . urlencode($this->transaction->country->getCode()) . 
                            '&tb=' . urlencode($this->transaction->getAmountPerAction() * 100) .
                            '&iphash=' . urlencode($this->getIp()) . 
                            '&adult=' . ($this->transaction->getAdult() ? 1 : 0) .
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
    }
    
    /**
     * get IDeal info
     */
    private function getPaymentInfoIDeal() {
        $url = $this->transaction->idealStartUrl . '?' .
                        'rtlo='. urlencode($this->layoutcode) .
                        '&bank='.urlencode($this->transaction->getBank()) .
                        '&description=' . urlencode($this->transaction->getDescription()) .
                        '&amount='.urlencode($this->getAmount() * 100) .
                        '&returnurl=' . urlencode($this->transaction->getReturnUrl()) .
                        '&cancelurl=' . urlencode($this->transaction->getCancelUrl()) .
                        '&reporturl=' . urlencode($this->transaction->getReportUrl()) .
                        '&test=' . ($this->test ? 1 : 0) .
                        '&v=3';
        $result = $this->getResponse($url);
        if($this->debug) {
            Log::info('TargetPay URL:' . $url);
            Log::info('TargetPay Response:' . $result);
        }
        if (!$result) {
            throw new TargetPayException("Can't load payment info", 3);
        }

        $data = explode('|', $result);
        $resCode = substr($data[0], 0, 6);
        if($resCode == "000000") {
            $this->transaction->setIdealUrl($data[1]);
            $this->transaction->setTransactionId(substr($data[0], 7));
        } else if($resCode == "TP0001") {
            throw new TargetPayException("No layoutcode. Geen layoutcode opgegeven", 4);
        } else if($resCode == "TP0002") {
            throw new TargetPayException("Amount too low. Bedrag te laag (minimaal 0,84 euro)", 4);
        } else if($resCode == "TP0003") {
            throw new TargetPayException("Amount too high. Bedrag te hoog (maximaal 10.000 euro)", 4);
        } else if($resCode == "TP0004") {
            throw new TargetPayException("No or invalid return URL. Geen of ongeldige return URL meegegeven", 4);
        } else if($resCode == "TP0005") {
            throw new TargetPayException("No bank ID. Geen bank ID meegegeven", 4);
        } else if($resCode == "TP0006") {
            throw new TargetPayException("No description. Geen omschrijving meegegeven", 4);
        } else if($resCode == "TP0016") {
            throw new TargetPayException("No iDEAL approval for this account yet. Het account is nog niet goedgekeurd voor iDeal", 4);
        } else if($resCode == "TP0017") {
            throw new TargetPayException("Incorrect rtlo code. De layoutcode (rtlo) is onjuist of bestaat niet", 4);
        } else if($resCode == "TP0019") {
            throw new TargetPayException("Account disabled. Het account staat op uitgeschakeld", 4);
        } else if($resCode == "TP9997") {
            throw new TargetPayException("Internal error, failed to create transaction. BANK is performing maintenance.", 4);
        } else if($resCode == "TP9998") {
            throw new TargetPayException("Failed to create transaction. De bank geeft geen transactienummer terug.", 4);
        } else if($resCode == "TP9999") {
            throw new TargetPayException("Internal error, failed to create transaction. BANK is performing maintenance. Your account has been blocked. Account geblokkeerd wegens vermeend misbruik.", 4);
        } else if($resCode == "SO1000") {
            throw new TargetPayException("Storing in systeem", 4);
        } else if($resCode == "SO1200") {
            throw new TargetPayException("Systeem te druk. Probeer later nogmaals", 4);
        } else if($resCode == "SO1400") {
            throw new TargetPayException("Onbeschikbaar door onderhoudswerkzaamheden", 4);
        } else {
            throw new TargetPayException("Can't load payment info, wrong parameters.", 4);
        }
    }
    
    /**
     * get MisterCash info
     */
    private function getPaymentInfoMiserCash() {
        $url = $this->transaction->mcStartUrl . '?' .
                        'rtlo=' . urlencode($this->layoutcode) .
                        '&lang=' . urlencode($this->transaction->getLang()) .
                        '&description=' . urlencode($this->transaction->getDescription()) .
                        '&amount=' . urlencode($this->getAmount() * 100) .
                        '&returnurl=' . urlencode($this->transaction->getReturnUrl()) .
                        '&reporturl=' . urlencode($this->transaction->getReportUrl()) .
                        '&userip=' . urlencode($this->getIp()) . 
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
        $resCode = substr($data[0], 0, 6);
        if($resCode == "000000") {
            $this->transaction->setMisterCashUrl($data[1]);
            $this->transaction->setTransactionId(substr($data[0], 7));
        } else if($resCode == "TP0001") {
            throw new TargetPayException("No layoutcode. Geen layoutcode opgegeven", 4);
        } else if($resCode == "TP0002") {
            throw new TargetPayException("Amount too low. Bedrag te laag (minimaal 0,84 euro)", 4);
        } else if($resCode == "TP0003") {
            throw new TargetPayException("Amount too high. Bedrag te hoog (maximaal 10.000 euro)", 4);
        } else if($resCode == "TP0004") {
            throw new TargetPayException("No or invalid return URL. Geen of ongeldige return URL meegegeven", 4);
        } else if($resCode == "TP0006") {
            throw new TargetPayException("No description. Geen omschrijving meegegeven", 4);
        } else if($resCode == "TP0009") {
            throw new TargetPayException("Invalid or no user IP given ", 4);
        } else if($resCode == "TP0011") {
            throw new TargetPayException("Invalid cancel URL ", 4);
        } else if($resCode == "TP0016") {
            throw new TargetPayException("Account disabled.", 4);
        } else if($resCode == "TP9999") {
            throw new TargetPayException("Forbidden. Your account is blocked from using MrCash. Contact TargetPay.", 4);
        } else {
            throw new TargetPayException("Can't load payment info, wrong parameters.", 4);
        }
    }
    
    /**
     * get MisterCash info
     */
    private function getPaymentInfoPaysafecard() {
        $url = $this->transaction->psStartUrl . '?' .
                        'rtlo=' . urlencode($this->layoutcode) .
                        '&description=' . urlencode($this->transaction->getDescription()) .
                        '&amount=' . urlencode($this->getAmount() * 100) .
                        '&returnurl=' . urlencode($this->transaction->getReturnUrl()) .
                        '&reporturl=' . urlencode($this->transaction->getReportUrl()) .
                        '&userip=' . urlencode($this->getIp()) . 
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
        $resCode = substr($data[0], 0, 6);
        if($resCode == "000000") {
            $this->transaction->setPaysafecardUrl($data[1]);
            $this->transaction->setTransactionId(substr($data[0], 7));
        } else if($resCode == "TP0001") {
            throw new TargetPayException("No layoutcode.", 4);
        } else if($resCode == "TP0002") {
            throw new TargetPayException("Amount too low.", 4);
        } else if($resCode == "TP0003") {
            throw new TargetPayException("Amount too high.", 4);
        } else if($resCode == "TP0004") {
            throw new TargetPayException("No or invalid return URL.", 4);
        } else if($resCode == "TP0006") {
            throw new TargetPayException("No description. Geen omschrijving meegegeven", 4);
        } else if($resCode == "TP0007") {
            throw new TargetPayException("Invalid or no country.", 4);
        } else if($resCode == "TP0008") {
            throw new TargetPayException("ountry not supported for Paysafecard", 4);
        } else if($resCode == "TP0009") {
            throw new TargetPayException("Invalid or no user IP given ", 4);
        } else if($resCode == "TP0016") {
            throw new TargetPayException("Account disabled.", 4);
        } else if($resCode == "TP9999") {
            throw new TargetPayException("Forbidden. Your account is blocked from using Paysafecard. Contact TargetPay.", 4);
        } else {
            throw new TargetPayException("Can't load payment info, wrong parameters.", 4);
        }
    }
    
    /**
     * check payment IVR
     */
    private function checkPaymentInfoIvr() {
        $url = $this->transaction->urlPaymentCheck . '?' .
                                'rtlo='. urlencode($this->layoutcode) .
                                '&paycode='.urlencode($this->transaction->getPayCode()) .
                                '&payline=' . urlencode($this->transaction->getServiceNumber()) . 
                                '&country='.urlencode($this->transaction->getCountry()) .
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
            $this->transaction->setPaymentDone(true);
            $this->transaction->country->setAmountPerAction($data[1]/100);
            $this->transaction->setMode($data[2]);
            $this->transaction->setDuration($data[3]);
            $this->transaction->calculateAmount();
        } else {
            $this->transaction->setPaymentDone(false);
        }
    }
    
    /**
     * Check payment check
     */
    private function checkPaymentInfoIDeal($once) {
        $url = $this->transaction->idealCheckUrl . '?' .
                                'rtlo='. urlencode($this->layoutcode) .
                                '&trxid='.urlencode($this->transaction->getTransactionId()) .
                                '&once=' . urlencode($once ? "1" : 0);
        $result = $this->getResponse($url);
        if($this->debug) {
            Log::info('TargetPay URL:' . $url);
            Log::info('TargetPay Response:' . $result);
        }
        if (!$result) {
            throw new TargetPayException("Can't load payment info", 3);
        }
        $resCode = substr($result, 0, 6);
        if($resCode == "000000") {
            $this->transaction->setPaymentDone(true);
        } else if($resCode == "TP0010") {
            throw new TargetPayException("Transaction has not been completed, try again later.", 4);
        } else if($resCode == "TP0011") {
            throw new TargetPayException("Transaction has been cancelled Transactie is geannuleerd", 4);
        } else if($resCode == "TP0012") {
            throw new TargetPayException("Transaction has expired Transactie is verlopen (max. 10 minuten)", 4);
        } else if($resCode == "TP0013") {
            throw new TargetPayException("The transaction could not be processed, Internal Error", 4);
        } else if($resCode == "TP0014") {
            throw new TargetPayException("Already used Reeds ingewisseld", 4);
        } else if($resCode == "TP0020") {
            throw new TargetPayException("Layoutcode not entered. Geen layoutcode opgegeven", 4);
        } else if($resCode == "TP0021") {
            throw new TargetPayException("Tansaction ID not entered. Geen transactie-id opgegeven", 4);
        } else if($resCode == "TP0022") {
            throw new TargetPayException("No transaction found with this ID. Geen transactie met dit ID gevonden", 4);
        } else if($resCode == "TP0023") {
            throw new TargetPayException("Layoutcode does not match this transaction.", 4);
        } else {
            $this->transaction->setPaymentDone(false);
        }
    }
    
    /**
     * Check payment check
     */
    private function checkPaymentInfoMisterCash($once) {
        $url = $this->transaction->mcCheckUrl . '?' .
                                'rtlo='. urlencode($this->layoutcode) .
                                '&trxid='.urlencode($this->transaction->getTransactionId()) .
                                '&once=' . urlencode($once ? "1" : 0) .
                                '&test=' . ($this->test ? 1 : 0);
        $result = $this->getResponse($url);
        if($this->debug) {
            Log::info('TargetPay URL:' . $url);
            Log::info('TargetPay Response:' . $result);
        }
        if (!$result) {
            throw new TargetPayException("Can't load payment info", 3);
        }
        $resCode = substr($result, 0, 6);
        if($resCode == "000000") {
            $this->transaction->setPaymentDone(true);
        } else if($resCode == "TP0010") {
            throw new TargetPayException("Transaction has not been completed, try again later.", 4);
        } else if($resCode == "TP0011") {
            throw new TargetPayException("Transaction has been cancelled Transactie is geannuleerd", 4);
        } else if($resCode == "TP0012") {
            throw new TargetPayException("Transaction has expired Transactie is verlopen (max. 10 minuten)", 4);
        } else if($resCode == "TP0013") {
            throw new TargetPayException("The transaction could not be processed, Internal Error", 4);
        } else if($resCode == "TP0014") {
            throw new TargetPayException("Already used Reeds ingewisseld", 4);
        } else if($resCode == "TP0020") {
            throw new TargetPayException("Layoutcode not entered. Geen layoutcode opgegeven", 4);
        } else if($resCode == "TP0021") {
            throw new TargetPayException("Tansaction ID not entered. Geen transactie-id opgegeven", 4);
        } else if($resCode == "TP0022") {
            throw new TargetPayException("No transaction found with this ID. Geen transactie met dit ID gevonden", 4);
        } else if($resCode == "TP0023") {
            throw new TargetPayException("Layoutcode does not match this transaction.", 4);
        } else {
            $this->transaction->setPaymentDone(false);
        }
    }
    
    /**
     * Check payment check
     */
    private function checkPaymentInfoPaysafecard($once) {
        $url = $this->transaction->mcCheckUrl . '?' .
                                'rtlo='. urlencode($this->layoutcode) .
                                '&trxid='.urlencode($this->transaction->getTransactionId()) .
                                '&once=' . urlencode($once ? "1" : 0) .
                                '&test=' . ($this->test ? 1 : 0);
        $result = $this->getResponse($url);
        if($this->debug) {
            Log::info('TargetPay URL:' . $url);
            Log::info('TargetPay Response:' . $result);
        }
        if (!$result) {
            throw new TargetPayException("Can't load payment info", 3);
        }
        $resCode = substr($result, 0, 6);
        if($resCode == "000000") {
            $this->transaction->setPaymentDone(true);
        } else if($resCode == "TP0010") {
            throw new TargetPayException("Transaction not finished, try again later.", 4);
        } else if($resCode == "TP0011") {
            throw new TargetPayException("Transaction cancelled by user", 4);
        } else if($resCode == "TP0012") {
            throw new TargetPayException("Transaction not finished and expired", 4);
        } else if($resCode == "TP0014") {
            throw new TargetPayException("Already redeemed at YYYY-MM-DD HH:MM:SS", 4);
        } else if($resCode == "TP0020") {
            throw new TargetPayException("Layoutcode not entered. Geen layoutcode opgegeven", 4);
        } else if($resCode == "TP0021") {
            throw new TargetPayException("Tansaction ID not entered. Geen transactie-id opgegeven", 4);
        } else if($resCode == "TP0022") {
            throw new TargetPayException("No transaction found with this ID. Geen transactie met dit ID gevonden", 4);
        } else if($resCode == "TP0023") {
            throw new TargetPayException("Layoutcode does not match this transaction.", 4);
        } else {
            $this->transaction->setPaymentDone(false);
        }
    }
    
    /**
     * check payment IVR
     */
    private function checkPaymentInfoSms() {
        $url = $this->transaction->urlPaymentCheck . '?' .
                                'rtlo='. urlencode($this->layoutcode) .
                                '&code='.urlencode($this->transaction->getPayCode()) .
                                '&keyword=' . urlencode($this->transaction->getKeyword()) . 
                                '&shortcode='.urlencode($this->transaction->getShortcode()) .
                                '&country=' . urlencode($this->transaction->country->getCode()) .
                                '&test=' . ($this->test ? 1 : 0);
        $result = $this->getResponse($url);
        if($this->debug) {
            Log::info('TargetPay URL:' . $url);
            Log::info('TargetPay Response:' . $result);
        }
        if (!$result) {
            throw new TargetPayException("Can't load payment info", 3);
        }
        $data = explode(' ', $result);
        $resCode = substr($data[0], 0, 3);
        if($resCode == "000") {
            $this->transaction->setPaymentDone(true);
        } else {
            $this->transaction->setPaymentDone(false);
        }
    }
    
}
