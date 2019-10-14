<?php


namespace BitPaySDK\Model\Invoice;


class PaymentTotal
{
    protected $_btc;
    protected $_bch;
    protected $_eth;

    public function __construct()
    {
    }

    public function toArray()
    {
        $elements = [
            'BTC' => $this->getBTC(),
            'BCH' => $this->getBCH(),
            'ETH' => $this->getETH(),
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

    public function setBTC(float $btc)
    {
        $this->_btc = $btc;
    }

    public function getBCH()
    {
        return $this->_bch;
    }

    public function setBCH(float $bch)
    {
        $this->_bch = $bch;
    }

    public function getETH()
    {
        return $this->_eth;
    }

    public function setETH(float $eth)
    {
        $this->_eth = $eth;
    }
}