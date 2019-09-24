<?php


namespace BitPaySDK\Model\Payout;


class PayoutInstructionBtcSummary
{
    protected $_paid;
    protected $_unpaid;

    public function __construct(float $paid, float $unpaid)
    {
        $this->_paid = $paid;
        $this->_unpaid = $unpaid;
    }

    public function getPaid()
    {
        return $this->_paid;
    }

    public function getUnpaid()
    {
        return $this->_unpaid;
    }

    public function toArray()
    {
        $elements = [
            'paid'   => $this->getPaid(),
            'unpaid' => $this->getUnpaid(),
        ];

        return $elements;
    }
}