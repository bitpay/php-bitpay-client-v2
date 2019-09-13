<?php


namespace BitPay\model\Invoice;


use function foo\func;

class SupportedTransactionCurrencies
{
    protected $_btc;
    protected $_bch;

    public function __construct() {
        $this->_btc = new SupportedTransactionCurrency();
        $this->_bch = new SupportedTransactionCurrency();
    }

    public function getBtc() {
        return $this->_btc;
    }

    public function setBtc(SupportedTransactionCurrency $btc) {
        $this->_btc = $btc;
    }

    public function getBch() {
        return $this->_bch;
    }

    public function setBch(SupportedTransactionCurrency $bch) {
        $this->_bch = $bch;
    }
}