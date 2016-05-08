# PHP TargetPay Library
[![Total Downloads](https://poser.pugx.org/tpweb/targetpay/d/total.svg)](https://packagist.org/packages/tpweb/targetpay)
[![Latest Stable Version](https://poser.pugx.org/tpweb/targetpay/v/stable.svg)](https://packagist.org/packages/tpweb/targetpay)
[![Latest Unstable Version](https://poser.pugx.org/tpweb/targetpay/v/unstable.svg)](https://packagist.org/packages/tpweb/targetpay)
[![License](https://poser.pugx.org/tpweb/targetpay/license.svg)](https://packagist.org/packages/tpweb/targetpay)

#Installation

Require this package in your `composer.json` and update composer.

```php
"tpweb/targetpay": "~1.0.0"
```

After updating composer, add the ServiceProvider to the providers array in `config/app.php`

```php
TPWeb\TargetPay\TargetPayServiceProvider::class,
```

You can use the facade for shorter code. Add this to your aliases:

```php
'TargetPay' => TPWeb\TargetPay\TargetPayFacade::class,
```

To publish the config settings in Laravel 5 use:

```php
php artisan vendor:publish --provider="TPWeb\TargetPay\TargetPayServiceProvider"
```

This will add an `targetpay.php` config file to your config folder. In your .env file you can use:
```php
TARGETPAY_LAYOUTCODE=xxxxx
TARGETPAY_KLANTCODE=xxxxx
TARGETPAY_TEST=false
TARGETPAY_DEBUG=true
```

# Documentation
## IVR 090X- (Pay Per Call & Pay Per Minute)
### Get payment info
```php
$targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\IVR);
$targetPay->setCountry(32);
$targetPay->setCountry(\TPWeb\TargetPay\Transaction\IVR::BELGIUM);
$targetPay->setAmount(3.00);
$targetPay->getPaymentInfo(); //Fetch payment info

echo $targetPay->getCurrency(); //Currency: EURO, GBP, ...
echo $targetPay->getAmount(); //Real payed amount.: 3.00
echo $targetPay->getServiceNumber(); //Number to call
echo $targetPay->getPayCode(); //Code to enter during call
echo $targetPay->getMode(); //Call type: PC or PM
echo ($targetPay->getMode() == "PM" ? $targetPay->getDuration() . "s" : ""); //duration in seconds
```
### Check payment
(This will only 1 time give you a successfull callback!)
```php
$targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\IVR);
$targetPay->setCountry($request->get('country'));
$targetPay->setAmount($request->get('amount'));
$targetPay->setServiceNumber($request->get('servicenumber'));
$targetPay->setPayCode($request->get('paycode'));
$targetPay->checkPaymentInfo();
if($targetPay->getPaymentDone()) {
    //Payment done
    echo $targetPay->getAmount(); //Real payed amount
    echo targetPay->getPayout(); //amount you 'll receive.
} else {
    //payment not completed
}
```

## IDEAL
Comming soon



The complete documentation can be found soon at: [http://www.tpweb.org](http://www.tpweb.org)

# Support

Support github or mail: tjebbe.lievens@madeit.be

# License

This package is licensed under LGPL. You are free to use it in personal and commercial projects. The code can be forked and modified, but the original copyright author should always be included!