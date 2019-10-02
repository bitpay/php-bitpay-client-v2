<?php


namespace BitPaySDK\Model\Payout;


class PayoutInstructionTransaction
{
    protected $_txid;
    protected $_amount;
    protected $_date;

    public function __construct()
    {
    }

    public function getTxid()
    {
        return $this->_txid;
    }

    public function setTxid(string $txid)
    {
        $this->_txid = $txid;
    }

    public function getAmount()
    {
        return $this->_amount;
    }

    public function setAmount(float $amount)
    {
        $this->_amount = $amount;
    }

    public function getDate()
    {
        return $this->_date;
    }

    public function setDate(string $date)
    {
        $this->_date = $date;
    }

    public function toArray()
    {
        $elements = [
            'txid'   => $this->getTxid(),
            'amount' => $this->getAmount(),
            'date'   => $this->getDate(),
        ];

        return $elements;
    }
}