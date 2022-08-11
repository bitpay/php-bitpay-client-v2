<?php

namespace BitPaySDK\Model\Invoice;

class MinerFeesItem
{
    protected $_satoshisPerByte;
    protected $_totalFee;
    protected $_fiatAmount = null;

    public function __construct()
    {
    }

    public function getSatoshisPerByte()
    {
        return $this->_satoshisPerByte;
    }

    public function setSatoshisPerByte(float $satoshisPerByte)
    {
        $this->_satoshisPerByte = $satoshisPerByte;
    }

    public function getTotalFee()
    {
        return $this->_totalFee;
    }

    public function setTotalFee(float $totalFee)
    {
        $this->_totalFee = $totalFee;
    }

    public function getFiatAmount()
    {
        return $this->_fiatAmount;
    }

    public function setFiatAmount(?float $fiatAmount)
    {
        $this->_fiatAmount = $fiatAmount;
    }

    public function toArray()
    {
        $elements = [
            'satoshisPerByte' => $this->getSatoshisPerByte(),
            'totalFee'        => $this->getTotalFee(),
            'fiatAmount'      => $this->getFiatAmount()
        ];

        foreach ($elements as $key => $value) {
            if (empty($value)) {
                unset($elements[$key]);
            }
        }

        return $elements;
    }
}
