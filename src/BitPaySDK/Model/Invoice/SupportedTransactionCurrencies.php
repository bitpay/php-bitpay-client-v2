<?php


namespace BitPaySDK\Model\Invoice;


class SupportedTransactionCurrencies
{
    protected $_btc;
    protected $_bch;
    protected $_eth;

    public function __construct()
    {
        $this->_btc = new SupportedTransactionCurrency();
        $this->_bch = new SupportedTransactionCurrency();
        $this->_eth = new SupportedTransactionCurrency();
    }

    public function toArray()
    {
        $elements = [
            'btc' => $this->getBTC()->toArray(),
            'bch' => $this->getBCH()->toArray(),
            'eth' => $this->getETH()->toArray(),
        ];

        foreach ($elements as $key => $value) {
            if (empty($value)) {
                unset($elements[$key]);
            }
        }

        return $elements;
    }

    public function getBTC()
    {
        return $this->_btc;
    }

    public function setBTC(SupportedTransactionCurrency $btc)
    {
        $this->_btc = $btc;
    }

    public function getBCH()
    {
        return $this->_bch;
    }

    public function setBCH(SupportedTransactionCurrency $bch)
    {
        $this->_bch = $bch;
    }

    public function getETH()
    {
        return $this->_eth;
    }

    public function setETH(SupportedTransactionCurrency $eth)
    {
        $this->_eth = $eth;
    }
}