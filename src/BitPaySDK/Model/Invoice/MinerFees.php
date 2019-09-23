<?php


namespace BitPaySDK\Model\Invoice;


class MinerFees
{
    protected $_btc;
    protected $_bch;

    public function __construct()
    {
        $this->_btc = new MinerFeesItem();
        $this->_bch = new MinerFeesItem();
    }

    public function getBtc()
    {
        return $this->_btc;
    }

    public function setBtc(MinerFeesItem $btc)
    {
        $this->_btc = $btc;
    }

    public function getBch()
    {
        return $this->_bch;
    }

    public function setBch(MinerFeesItem $bch)
    {
        $this->_bch = $bch;
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
}