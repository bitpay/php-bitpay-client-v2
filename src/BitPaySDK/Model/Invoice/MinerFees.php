<?php


namespace BitPaySDK\Model\Invoice;


class MinerFees
{
    protected $_btc;
    protected $_bch;
    protected $_eth;

    public function __construct()
    {
        $this->_btc = new MinerFeesItem();
        $this->_bch = new MinerFeesItem();
        $this->_eth = new MinerFeesItem();
    }

    public function getBTH()
    {
        return $this->_btc;
    }

    public function setBTH(MinerFeesItem $btc)
    {
        $this->_btc = $btc;
    }

    public function getBCH()
    {
        return $this->_bch;
    }

    public function setBCH(MinerFeesItem $bch)
    {
        $this->_bch = $bch;
    }

    public function getETH()
    {
        return $this->_bch;
    }

    public function setETH(MinerFeesItem $eth)
    {
        $this->_eth = $eth;
    }

    public function toArray()
    {
        $elements = [
            'btc' => $this->getBTH()->toArray(),
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
}