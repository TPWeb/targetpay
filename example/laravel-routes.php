<?php
Route::get('test', function(Illuminate\Http\Request $request) {
    $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\IVR);
    if(!$request->has('country')) {
        $countryList = TPWeb\TargetPay\Transaction\IVR::countryList();
        foreach($countryList as $code => $country) {
            echo "<a href='?country=" . $code . "'>" . $country . "</a><br>";
        }
        return "";
    }
    $targetPay->setCountry($request->get('country'));
    
    //$targetPay->setCountry($request->get('country'));
    //$targetPay->setCountry(\TPWeb\TargetPay\Transaction\IVR::BELGIUM);
    
    if(!$request->has('amount')) {
        if(is_array($targetPay->getAmountList())) {
            foreach($targetPay->getAmountList() as $amount) {
                echo "<a href='?country=" . $request->get('country') . "&amount=" . $amount . "'>" . $amount . "</a><br>";
            }
        } else {
            echo "<form action='' method='GET'>";
            echo "<input type='hidden' name='country' value='" . $request->get('country') . "'>";
            echo "<input type='text' name='amount' value=''>";
            echo "<input type='submit' value='Verder'>";
            echo "</form>";
        }
        return "";
    }
    $targetPay->setAmount($request->get('amount'));
    $targetPay->getPaymentInfo();
    
    
    echo $targetPay->getCurrency() . " " . $targetPay->getAmount() . " - Bel naar: " . $targetPay->getServiceNumber() . " en geef '" . $targetPay->getPayCode() . "' in. Dit gesprek is een " . $targetPay->getMode() . " " . ($targetPay->getMode() == "PM" ? $targetPay->getDuration() . "s" : "");
    
    echo "<br><br><br>CHECK<br><br><br>";
    return '/test2?country=' . $request->get('country') . "&amount=" . $request->get('amount') . '&servicenumber=' . $targetPay->getServiceNumber() . '&paycode=' . $targetPay->getPayCode();
});
Route::get('test2', function(Illuminate\Http\Request $request) {
    $targetPayCheck = new TargetPay(new \TPWeb\TargetPay\Transaction\IVR);
    $targetPayCheck->setCountry($request->get('country'));
    $targetPayCheck->setAmount($request->get('amount'));
    $targetPayCheck->setServiceNumber($request->get('servicenumber'));
    $targetPayCheck->setPayCode($request->get('paycode'));
    $targetPayCheck->checkPaymentInfo();
    if($targetPayCheck->getPaymentDone()) {
        return "PAYMENT DONE PAYED:" . $targetPayCheck->getAmount() . " - Payout: " . $targetPayCheck->getPayout();
    } else {
        return "PAYMENT NOT DONE";
    }
});