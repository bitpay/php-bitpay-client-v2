<?php


namespace BitPaySDK\Model\Invoice;


class SupportedTransactionCurrencies
{
    protected $_btc;
    protected $_bch;

    public function __construct()
    {
        $this->_btc = new SupportedTransactionCurrency();
        $this->_bch = new SupportedTransactionCurrency();
    }

    public function toArray()
    {
        $elements = [
            'btc' => $this->getBtc()->toArray(),
            'bch' => $this->getBch()->toArray(),
        ];

        foreach ($elements as $key => $value) {
            if (empty($value)) {
                unset($elements[$key]);
            }
        }

        return $elements;
    }

    public function getBtc()
    {
        return $this->_btc;
    }

    public function setBtc(SupportedTransactionCurrency $btc)
    {
        $this->_btc = $btc;
    }

    public function getBch()
    {
        return $this->_bch;
    }

    public function setBch(SupportedTransactionCurrency $bch)
    {
        $this->_bch = $bch;
    }
}