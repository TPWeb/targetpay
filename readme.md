# PHP TargetPay Library
[![Build Status](https://travis-ci.org/TPWeb/targetpay.svg?branch=master)](https://travis-ci.org/TPWeb/targetpay)
[![Coverage Status](https://coveralls.io/repos/github/TPWeb/targetpay/badge.svg?branch=master)](https://coveralls.io/github/TPWeb/targetpay?branch=master)
[![Latest Stable Version](https://poser.pugx.org/tpweb/targetpay/v/stable.svg)](https://packagist.org/packages/tpweb/targetpay)
[![Latest Unstable Version](https://poser.pugx.org/tpweb/targetpay/v/unstable.svg)](https://packagist.org/packages/tpweb/targetpay)
[![Total Downloads](https://poser.pugx.org/tpweb/targetpay/d/total.svg)](https://packagist.org/packages/tpweb/targetpay)
[![License](https://poser.pugx.org/tpweb/targetpay/license.svg)](https://packagist.org/packages/tpweb/targetpay)

#Installation

Require this package in your `composer.json` and update composer.

```php
"tpweb/targetpay": "~1.*"
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

This will add a `targetpay.php` config file to your config folder. In your .env file you can use:
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
//$targetPay->transaction->setCountry(32);
$targetPay->transaction->setCountry(\TPWeb\TargetPay\Transaction\IVR::BELGIUM);
$targetPay->setAmount(3.00);
$targetPay->getPaymentInfo(); //Fetch payment info

echo $targetPay->transaction->getCurrency(); //Currency: EURO, GBP, ...
echo $targetPay->getAmount(); //Real payed amount.: 3.00
echo $targetPay->transaction->getServiceNumber(); //Number to call
echo $targetPay->transaction->getPayCode(); //Code to enter during call
echo $targetPay->transaction->getMode(); //Call type: PC or PM
echo ($targetPay->transaction->getMode() == "PM" ? $targetPay->transaction->getDuration() . "s" : ""); //duration in seconds
```
### Check payment
(This will only give you a one-time successful callback!)
```php
$targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\IVR);
$targetPay->transaction->setCountry($request->get('country'));
$targetPay->setAmount($request->get('amount'));
$targetPay->transaction->setServiceNumber($request->get('servicenumber'));
$targetPay->transaction->setPayCode($request->get('paycode'));
$targetPay->checkPaymentInfo();
if($targetPay->transaction->getPaymentDone()) {
    //Payment done
    echo $targetPay->getAmount(); //Real payed amount
    echo targetPay->transaction->getPayout(); //amount you 'll receive.
} else {
    //payment not completed
}
```

## IDEAL
### Get payment info & url
Save $transactionId, redirect user to $redirectUrl.
```php
$targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\IDeal);
$targetPay->transaction->setBank(IDeal::ING);
$targetPay->setAmount(10.00);
$targetPay->transaction->setDescription("Description");
$targetPay->transaction->setReturnUrl("https://www.example.com");
$targetPay->getPaymentInfo();
$redirectUrl = $targetPay->transaction->getIdealUrl();
$transactionId = $targetPay->transaction->getTransactionId();
```

### Check payment 
```php
$targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\IDeal);
$targetPay->transaction->setTransactionId($transactionId);
$targetPay->checkPaymentInfo();
$once = false;
$targetPay->transaction->getPaymentDone($once);
```    

## Mister Cash
### Get payment info & url
Save $transactionId, redirect user to $redirectUrl.
```php
$targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\MisterCash);
$targetPay->transaction->setLang("NL");
$targetPay->setAmount(10.00);
$targetPay->transaction->setDescription("Description");
$targetPay->transaction->setReturnUrl("https://www.example.com");
$targetPay->getPaymentInfo();
$redirectUrl = $targetPay->transaction->getMisterCashUrl();
$transactionId = $targetPay->transaction->getTransactionId();
```

### Check payment 
```php
$targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\MisterCash);
$targetPay->transaction->setTransactionId($transactionId);
$targetPay->checkPaymentInfo();
$once = false;
$targetPay->transaction->getPaymentDone($once);
```    

## Paysafecard
### Get payment info & url
Save $transactionId, redirect user to $redirectUrl.
```php
$targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\Paysafecard);
$targetPay->setAmount(10.00);
$targetPay->transaction->setDescription("Description");
$targetPay->transaction->setReturnUrl("https://www.example.com");
$targetPay->getPaymentInfo();
$redirectUrl = $targetPay->transaction->getPaysafecardUrl();
$transactionId = $targetPay->transaction->getPaysafecardId();
//redirect to $redirectUrl
```

### Check payment 
```php
$targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\Paysafecard);
$targetPay->transaction->setTransactionId($transactionId);
$targetPay->checkPaymentInfo();
$once = false;
$targetPay->transaction->getPaymentDone($once);
```    

The complete documentation can be found at: [http://www.tpweb.org/my-projects/php-targetpay-library/](http://www.tpweb.org/my-projects/php-targetpay-library/)

# Support

Support github or mail: tjebbe.lievens@madeit.be

# Contributing

Please try to follow the psr-2 coding style guide. http://www.php-fig.org/psr/psr-2/

# License

This package is licensed under LGPL. You are free to use it in personal and commercial projects. The code can be forked and modified, but the original copyright author should always be included!