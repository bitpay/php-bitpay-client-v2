<?php


namespace BitPaySDK\Model\Invoice;


class PaymentCodes
{
    protected $_btc;
    protected $_bch;

    public function __construct()
    {
        $this->_btc = new PaymentCode();
        $this->_bch = new PaymentCode();
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

    public function setBtc(PaymentCode $btc)
    {
        $this->_btc = $btc;
    }

    public function getBch()
    {
        return $this->_bch;
    }

    public function setBch(PaymentCode $bch)
    {
        $this->_bch = $bch;
    }
}