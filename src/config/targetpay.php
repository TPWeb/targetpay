<?php
return [
  'layoutcode' => env('TARGETPAY_LAYOUTCODE'),
  'klantcode' => env('TARGETPAY_KLANTCODE'),
  'test' => env('TARGETPAY_TEST', false),
  'debug' => env('TARGETPAY_DEBUG', false),
];