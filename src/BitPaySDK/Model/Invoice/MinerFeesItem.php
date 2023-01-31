<?php

namespace BitPaySDK\Model\Invoice;

class MinerFeesItem
{
    protected $satoshisPerByte;
    protected $totalFee;
    protected $fiatAmount = null;

    public function __construct()
    {
    }

    public function getSatoshisPerByte()
    {
        return $this->satoshisPerByte;
    }

    public function setSatoshisPerByte(float $satoshisPerByte)
    {
        $this->satoshisPerByte = $satoshisPerByte;
    }

    public function getTotalFee()
    {
        return $this->totalFee;
    }

    public function setTotalFee(float $totalFee)
    {
        $this->totalFee = $totalFee;
    }

    public function getFiatAmount()
    {
        return $this->fiatAmount;
    }

    public function setFiatAmount(?float $fiatAmount)
    {
        $this->fiatAmount = $fiatAmount;
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
