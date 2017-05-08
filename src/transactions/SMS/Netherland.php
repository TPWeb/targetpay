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
class Netherland extends Country {
    protected $name = "Nederland";
    protected $code = 31;
    public $minAmount = 0.25;
    public $maxAmount = 6;
    public $arraySelector = true;
    private $listPrijs = array(
        0.25 => array('BETAAL AA', 3010, 0.01),
        0.35 => array('BETAAL AB', 3010, 0.03),
        0.40 => array('BETAAL AC', 3010, 0.10),
        0.55 => array('BETAAL AD', 3010, 0.18),
        0.60 => array('BETAAL AE', 3010, 0.21),
        0.70 => array('BETAAL AF', 3010, 0.27),
        0.90 => array('BETAAL AG', 3010, 0.38),
        1.10 => array('BETAAL AH', 3010, 0.48),
        1.35 => array('BETAAL AI', 3010, 0.48),
        1.40 => array('BETAAL AJ', 3010, 0.48),
        1.45 => array('BETAAL AK', 3010, 0.48),
        1.50 => array('BETAAL AL', 3010, 0.69),
        1.75 => array('BETAAL AM', 3010, 0.69),
        1.80 => array('BETAAL AN', 3010, 0.69),
        1.85 => array('BETAAL AO', 3010, 0.69),
        1.90 => array('BETAAL AQ', 3010, 0.69),
        2.00 => array('BETAAL AR', 3010, 0.93),
        2.05 => array('BETAAL AS', 3010, 0.93),
        2.10 => array('BETAAL VS', 3010, 0.93),
        2.20 => array('BETAAL AW', 3010, 0.93),
        2.40 => array('BETAAL AY', 3010, 0.93),
        2.60 => array('BETAAL AZ', 3010, 1.19),
        2.85 => array('BETAAL BA', 3010, 1.19),
        2.90 => array('BETAAL BB', 3010, 1.19),
        2.95 => array('BETAAL BC', 3010, 1.19),
        3.00 => array('BETAAL BD', 3010, 1.45),
        3.25 => array('BETAAL BE', 3010, 1.45),
        3.30 => array('BETAAL BF', 3010, 1.45),
        3.35 => array('BETAAL BG', 3010, 1.45),
        3.40 => array('BETAAL BH', 3010, 1.45),
        3.50 => array('BETAAL BI', 3010, 1.84),
        3.55 => array('BETAAL BJ', 3010, 1.84),
        3.60 => array('BETAAL BK', 3010, 1.84),
        3.70 => array('BETAAL BL', 3010, 1.84),
        3.90 => array('BETAAL BN', 3010, 1.84),
        4.10 => array('BETAAL BP', 3010, 2.12),
        4.35 => array('BETAAL BQ', 3010, 2.12),
        4.40 => array('BETAAL BR', 3010, 2.12),
        4.45 => array('BETAAL BS', 3010, 2.12),
        4.50 => array('BETAAL BV', 3010, 2.39),
        4.75 => array('BETAAL BW', 3010, 2.39),
        4.80 => array('BETAAL BX', 3010, 2.39),
        4.85 => array('BETAAL BY', 3010, 2.39),
        4.90 => array('BETAAL BZ', 3010, 2.39),
        5.00 => array('BETAAL CA', 3010, 2.66),
        5.05 => array('BETAAL CB', 3010, 2.66),
        5.10 => array('BETAAL CC', 3010, 2.66),
        5.20 => array('BETAAL CD', 3010, 2.66),
        5.40 => array('BETAAL CF', 3010, 2.66),
        5.60 => array('BETAAL CG', 3010, 2.94),
        6.00 => array('BETAAL CH', 3010, 3.15),
    );

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
        foreach($this->listPrijs as $bedrag => $info) {
            if($bedrag <= $amount) {
                $this->keyword = $info[0];
                $this->shortcode = $info[1];
                $this->amount = $bedrag;
                $this->payout = $info[2];
                break;
            }
        }
        return $this->amount;
    }
}