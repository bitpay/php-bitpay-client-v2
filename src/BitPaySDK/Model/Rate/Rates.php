<?php


namespace BitPaySDK\Model\Rate;


use BitPaySDK\Client;
use BitPaySDK\Exceptions\BitPayException;
use BitPaySDK\Model\Currency;

class Rates
{
    protected $_bp;
    protected $_rates;

    public function __construct(array $rates, Client $bp)
    {
        $this->_bp = $bp;
        $this->_rates = $rates;
    }

    public function getRates()
    {
        $rates = [];

        foreach ($this->_rates as $rate) {
            if ($rate instanceof Rate) {
                array_push($rates, $rate->toArray());
            } else {
                array_push($rates, $rate);
            }
        }

        return $rates;
    }

    public function update()
    {
        $this->_rates = $this->_bp->getRates()->getRates();
    }

    public function getRate(String $currencyCode)
    {
        $val = null;

        if (!Currency::isValid($currencyCode)) {
            throw new BitPayException("currency code must be a type of Model.Currency");
        }

        foreach ($this->_rates as $rateObj) {
            if ($rateObj->getCode() == $currencyCode) {
                $val = $rateObj->getRate();
                break;
            }
        }

        return $val;
    }

    public function toArray()
    {
        $elements = [
            'rates' => $this->getRates(),
        ];

        foreach ($elements as $key => $value) {
            if (empty($value)) {
                unset($elements[$key]);
            }
        }

        return $elements;
    }
}