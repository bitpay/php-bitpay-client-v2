<?php

namespace BitPaySDK\Model\Invoice;

class UniversalCodes
{
    protected $_paymentString;
    protected $_verificationLink;

    public function __construct()
    {
    }

    public function getPaymentString()
    {
        return $this->_paymentString;
    }

    public function setPaymentString(string $paymentString)
    {
        $this->_paymentString = $paymentString;
    }

    public function getVerificationLink()
    {
        return $this->_verificationLink;
    }

    public function setVerificationLink(string $verificationLink)
    {
        $this->_verificationLink = $verificationLink;
    }


    public function toArray()
    {
        $elements = [
            'paymentString'               => $this->getPaymentString(),
            'verificationLink'            => $this->getVerificationLink(),
        ];

        return $elements;
    }
}
