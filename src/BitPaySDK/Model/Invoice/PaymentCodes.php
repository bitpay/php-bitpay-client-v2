<?php


namespace BitPaySDK\Model\Invoice;


class PaymentCodes
{
    protected $_btc;
    protected $_bch;
    protected $_eth;

    public function __construct()
    {
        $this->_btc = new PaymentCode();
        $this->_bch = new PaymentCode();
        $this->_eth = new PaymentCode();
    }

    public function toArray()
    {
        $elements = [
            'BTC' => $this->getBTC()->toArray(),
            'BCH' => $this->getBCH()->toArray(),
            'ETH' => $this->getETH()->toArray(),
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

    public function setBTC(PaymentCode $btc)
    {
        $this->_btc = $btc;
    }

    public function getBCH()
    {
        return $this->_bch;
    }

    public function setBCH(PaymentCode $bch)
    {
        $this->_bch = $bch;
    }

    public function getETH()
    {
        return $this->_eth;
    }

    public function setETH(PaymentCode $eth)
    {
        $this->_eth = $eth;
    }
}