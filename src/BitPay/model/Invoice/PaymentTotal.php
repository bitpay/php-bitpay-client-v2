<?php


namespace BitPay\Model\Invoice;


class PaymentTotal
{
    protected $_btc;
    protected $_bch;

    public function __construct()
    {
    }

    public function toArray()
    {
        $elements = [
            'btc' => $this->getBtc(),
            'bch' => $this->getBch(),
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

    public function setBtc(float $btc)
    {
        $this->_btc = $btc;
    }

    public function getBCH()
    {
        return $this->_bch;
    }

    public function setBch(float $bch)
    {
        $this->_bch = $bch;
    }
}