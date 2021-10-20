<?php


namespace BitPaySDK\Model\Invoice;

class ItemizedDetails{
    protected $_amount;
    protected $_description;
    protected $_isFee;

    public function __construct(
        float $amount = null,
        string $description = null,
        bool $isFee = null
    ) {
        $this->_amount = $amount;
        $this->_description = $description;
        $this->_isFee = $isFee;
    }

    public function getAmount()
    {
        return $this->_amount;
    }

    public function setAmount(float $amount)
    {
        $this->_amount = $amount;
    }

    public function getDescription()
    {
        return $this->_description;
    }

    public function setDescription(string $description)
    {
        $this->_description = $description;
    }

    public function getIsFee()
    {
        return $this->_isFee;
    }

    public function setIsFee(bool $isFee)
    {
        $this->_isFee = $isFee;
    }

    public function toArray()
    {
        $elements = [
            'amount'        => $this->getAmount(),
            'description'   => $this->getDescription(),
            'isFee'         => $this->getIsFee()
        ];

        return $elements;
    }
}
