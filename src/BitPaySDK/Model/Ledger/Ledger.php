<?php


namespace BitPaySDK\Model\Ledger;


class Ledger
{
    protected $_currency;
    protected $_balance;

    public function __construct()
    {
    }

    public function getCurrency()
    {
        return $this->_currency;
    }

    public function setCurrency(string $currency)
    {
        $this->_currency = $currency;
    }

    public function getBalance()
    {
        return $this->_balance;
    }

    public function setBalance(float $balance)
    {
        $this->_balance = $balance;
    }

    public function toArray()
    {
        $elements = [
            'currency' => $this->getCurrency(),
            'balance'  => $this->getBalance(),
        ];

        return $elements;
    }
}