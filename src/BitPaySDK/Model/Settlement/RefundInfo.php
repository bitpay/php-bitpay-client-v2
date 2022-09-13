<?php

namespace BitPaySDK\Model\Settlement;

class RefundInfo
{
    protected $_supportRequest;
    protected $_currency;
    protected $_amounts;
    protected $_reference;

    public function __construct()
    {
    }

    public function getSupportRequest()
    {
        return $this->_supportRequest;
    }

    public function setSupportRequest(string $supportRequest)
    {
        $this->_supportRequest = $supportRequest;
    }

    public function getCurrency()
    {
        return $this->_currency;
    }

    public function setCurrency(string $currency)
    {
        $this->_currency = $currency;
    }

    public function getAmounts()
    {
        return $this->_amounts;
    }

    public function setAmounts(array $amounts)
    {
        $this->_amounts = $amounts;
    }

    public function getReference()
    {
        return $this->_reference;
    }

    public function setReference(string $reference)
    {
        $this->_reference = $reference;
    }

    public function toArray()
    {
        $elements = [
            'supportRequest' => $this->getSupportRequest(),
            'currency'       => $this->getCurrency(),
            'amounts'        => $this->getAmounts(),
            'reference'      => $this->getReference()
        ];

        return $elements;
    }
}
