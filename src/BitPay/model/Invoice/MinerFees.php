<?php


namespace BitPay\Model\Invoice;


class MinerFees
{
    protected $_btc;
    protected $_bch;

    public function __construct() {
        $this->_btc = new MinerFeesItem();
        $this->_bch = new MinerFeesItem();
    }

    public function getBtc() {
        return $this->_btc;
    }

    public function setBtc(MinerFeesItem $btc) {
        $this->_btc = $btc;
    }

    public function getBch() {
        return $this->_bch;
    }

    public function setBch(MinerFeesItem $bch) {
        $this->_bch = $bch;
    }
}