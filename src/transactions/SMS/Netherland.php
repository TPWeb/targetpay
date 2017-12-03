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
        array(0.25, 'BETAAL AA', 3010, 0.01),
        array(0.35, 'BETAAL AB', 3010, 0.03),
        array(0.40, 'BETAAL AC', 3010, 0.10),
        array(0.55, 'BETAAL AD', 3010, 0.18),
        array(0.60, 'BETAAL AE', 3010, 0.21),
        array(0.70, 'BETAAL AF', 3010, 0.27),
        array(0.90, 'BETAAL AG', 3010, 0.38),
        array(1.10, 'BETAAL AH', 3010, 0.48),
        array(1.35, 'BETAAL AI', 3010, 0.48),
        array(1.40, 'BETAAL AJ', 3010, 0.48),
        array(1.45, 'BETAAL AK', 3010, 0.48),
        array(1.50, 'BETAAL AL', 3010, 0.69),
        array(1.75, 'BETAAL AM', 3010, 0.69),
        array(1.80, 'BETAAL AN', 3010, 0.69),
        array(1.85, 'BETAAL AO', 3010, 0.69),
        array(1.90, 'BETAAL AQ', 3010, 0.69),
        array(2.00, 'BETAAL AR', 3010, 0.93),
        array(2.05, 'BETAAL AS', 3010, 0.93),
        array(2.10, 'BETAAL VS', 3010, 0.93),
        array(2.20, 'BETAAL AW', 3010, 0.93),
        array(2.40, 'BETAAL AY', 3010, 0.93),
        array(2.60, 'BETAAL AZ', 3010, 1.19),
        array(2.85, 'BETAAL BA', 3010, 1.19),
        array(2.90, 'BETAAL BB', 3010, 1.19),
        array(2.95, 'BETAAL BC', 3010, 1.19),
        array(3.00, 'BETAAL BD', 3010, 1.45),
        array(3.25, 'BETAAL BE', 3010, 1.45),
        array(3.30, 'BETAAL BF', 3010, 1.45),
        array(3.35, 'BETAAL BG', 3010, 1.45),
        array(3.40, 'BETAAL BH', 3010, 1.45),
        array(3.50, 'BETAAL BI', 3010, 1.84),
        array(3.55, 'BETAAL BJ', 3010, 1.84),
        array(3.60, 'BETAAL BK', 3010, 1.84),
        array(3.70, 'BETAAL BL', 3010, 1.84),
        array(3.90, 'BETAAL BN', 3010, 1.84),
        array(4.10, 'BETAAL BP', 3010, 2.12),
        array(4.35, 'BETAAL BQ', 3010, 2.12),
        array(4.40, 'BETAAL BR', 3010, 2.12),
        array(4.45, 'BETAAL BS', 3010, 2.12),
        array(4.50, 'BETAAL BV', 3010, 2.39),
        array(4.75, 'BETAAL BW', 3010, 2.39),
        array(4.80, 'BETAAL BX', 3010, 2.39),
        array(4.85, 'BETAAL BY', 3010, 2.39),
        array(4.90, 'BETAAL BZ', 3010, 2.39),
        array(5.00, 'BETAAL CA', 3010, 2.66),
        array(5.05, 'BETAAL CB', 3010, 2.66),
        array(5.10, 'BETAAL CC', 3010, 2.66),
        array(5.20, 'BETAAL CD', 3010, 2.66),
        array(5.40, 'BETAAL CF', 3010, 2.66),
        array(5.60, 'BETAAL CG', 3010, 2.94),
        array(6.00, 'BETAAL CH', 3010, 3.15),
    );

    /**
     * set amount
     * @param numeric
     * @return numeric
     * @throws AmountException
     */
    public function setAmount($amount)
    {
        $this->amount = null;
        if($this->minAmount > $amount)
            throw new AmountException('Amount is to low. (Min amount: ' . $this->minAmount . ')', 2);
        if($this->maxAmount < $amount)
            throw new AmountException('Amount is to high. (Max amount: ' . $this->maxAmount . ')', 3);
        foreach($this->listPrijs as $info) {
            if($info[0] <= $amount) {
                $this->keyword = $info[1];
                $this->shortcode = $info[2];
                $this->amount = $info[0];
                $this->payout = $info[3];
            }
        }
        if($this->amount == null) {
            throw new AmountException('Amount not found.', 4);
        }
        return $this->amount;
    }
}
