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
	
    const BELGIUM = 32;
    const NETHERLAND = 31;
	const FRANCE = 33;
	const ITALY = 39;
	const SUISSE = 41;
	const AUSTRIA = 43;
	const UK = 44;
	const GERMANY = 49;
	const LUXEMBOURG = 352;
	
    function __construct($country = null, $amount = null)
	{
		if($country != null) {
			$this->setCountry($country);
		}
		if($amount != null) {
			$this->setAmount($amount);
		}
    }
    
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
    
    
    public function setAmount($amount)
	{
		if(is_numeric($amount)) {
			$this->amount = $this->country->setAmount($amount);
		}
	}
	
	public function getAmount()
	{
		return $this->country->amount;
	}
	
	public function getPayout()
	{
		return $this->country->getPayout();
	}
	
	public function getAmountList()
	{
		return $this->country->getAmountList();
	}
    
    public function getMinimumAmount()
	{
		return $this->country->getMinimumAmount();
    }
    
    public function getMaximumAmount()
	{
		return $this->country->getMaximumAmount();
    }
	
	
	public function setMode($mode)
	{
		$this->country->setMode($mode);
	}
	
	public function getMode()
	{
		return $this->country->getMode();
	}
	
	public function setAdult($boolean)
	{
		$this->adult = is_bool($boolean) ? $boolean : false;
	}
	
	public function getAdult() {
		return $this->adult;
	}
	
	public function setDuration($duration)
	{
		$this->country->duration = $duration;
	}
	public function getDuration()
	{
		return $this->country->duration;
	}
	
	public function setServiceNumber($nummer)
	{
		$this->serviceNumber = $nummer;
	}
	
	public function getServiceNumber()
	{
		return $this->serviceNumber;
	}
	
	public function setPayCode($code)
	{
		$this->paycode = $code;
	}
	
	public function getPayCode()
	{
		return $this->paycode;
	}
	
	public function getAmountPerAction()
	{
		return $this->country->getAmountPerAction();
	}
	
	public function getCurrency()
	{
		return $this->country->getCurrency();
	}
	
	public function calculateAmount()
	{
		$this->country->calculateAmount();
	}
	
	public function getCountry()
	{
		return $this->country->getCode();
	}
}