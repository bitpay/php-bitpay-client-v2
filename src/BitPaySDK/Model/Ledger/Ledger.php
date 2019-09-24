<?php


namespace BitPaySDK\Model\Ledger;


class Ledger
{
    protected $_entries;
    protected $_currency;
    protected $_balance;

    public function __construct()
    {
    }

    public function getEntries()
    {
        $entries = [];

        foreach ($this->_entries as $entrie) {
            if ($entrie instanceof LedgerEntry) {
                array_push($entries, $entrie->toArray());
            } else {
                array_push($entries, $entrie);
            }
        }

        return $entries;
    }

    public function setEntries(array $entries)
    {
        $this->_entries = $entries;
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
            'entries'  => $this->getEntries(),
            'currency' => $this->getCurrency(),
            'balance'  => $this->getBalance(),
        ];

        return $elements;
    }
}