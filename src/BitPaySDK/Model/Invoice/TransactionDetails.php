<?php

namespace BitPaySDK\Model\Invoice;

class TransactionDetails
{
    protected $_amount;
    protected $_description;
    protected $_isFee;

    /**
     * Constructs a TransactionDetails object.
     *
     * @param float  $amount      The amount of the transaction.
     * @param string $description The three digit currency string.
     * @param bool   $isFee       Designates if the amount is a fee.
     */
    public function __construct(?float $amount = null, ?string $description = null, ?bool $isFee = null)
    {
        $this->_amount = $amount;
        $this->_description = $description;
        $this->_isFee = $isFee;
    }

    public function getAmount(): ?float
    {
        return $this->_amount;
    }

    public function setAmount(float $amount)
    {
        $this->_amount = $amount;
    }

    public function getDescription(): ?string
    {
        return $this->_description;
    }

    public function setDescription(string $description)
    {
        $this->_description = $description;
    }

    public function getIsFee(): ?bool
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
