<?php


namespace BitPaySDK;


interface Env
{
    const Test                  = "Test";
    const Prod                  = "Prod";
    const TestUrl               = "https://test.bitpay.com/";
    const ProdUrl               = "https://bitpay.com/";
    const BitpayApiVersion      = "2.0.0";
    const BitpayPluginInfo      = "BitPay_PHP_Client_v6.0.2111";
    const BitpayApiFrame        = "std";
    const BitpayApiFrameVersion = "1.0.0";
}