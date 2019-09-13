<?php


namespace BitPay\Model\Invoice;


class PaymentCodes
{
    protected $_btc;
    protected $_bch;

    public function __construct() {
        $this->_btc = new PaymentCode();
        $this->_bch = new PaymentCode();
    }

    public function getBtc() {
        return $this->_btc;
    }

    public function setBtc(PaymentCode $btc) {
        $this->_btc = $btc;
    }

    public function getBch() {
        return $this->_bch;
    }

    public function setBch(PaymentCode $bch) {
        $this->_bch = $bch;
    }
}