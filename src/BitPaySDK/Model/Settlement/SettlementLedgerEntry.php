<?php


namespace BitPaySDK\Model\Settlement;


class SettlementLedgerEntry
{
    protected $_code;
    protected $_invoiceId;
    protected $_amount;
    protected $_timestamp;
    protected $_description;
    protected $_reference;
    protected $_invoiceData;

    public function __construct()
    {
        $this->_invoiceData = new InvoiceData();
    }

    public function getCode()
    {
        return $this->_code;
    }

    public function setCode(int $code)
    {
        $this->_code = $code;
    }

    public function getInvoiceId()
    {
        return $this->_invoiceId;
    }

    public function setInvoiceId(string $invoiceId)
    {
        $this->_invoiceId = $invoiceId;
    }

    public function getAmount()
    {
        return $this->_amount;
    }

    public function setAmount(float $amount)
    {
        $this->_amount = $amount;
    }

    public function getTimestamp()
    {
        return $this->_timestamp;
    }

    public function setTimestamp(string $timestamp)
    {
        $this->_timestamp = $timestamp;
    }

    public function getDescription()
    {
        return $this->_description;
    }

    public function setDescription(string $description)
    {
        $this->_description = $description;
    }

    public function getReference()
    {
        return $this->_reference;
    }

    public function setReference(string $reference)
    {
        $this->_reference = $reference;
    }

    public function getInvoiceData()
    {
        return $this->_invoiceData;
    }

    public function setInvoiceData(InvoiceData $invoiceData)
    {
        $this->_invoiceData = $invoiceData;
    }

    public function toArray()
    {
        $elements = [
            'code'        => $this->getCode(),
            'invoiceId'   => $this->getInvoiceId(),
            'amount'      => $this->getAmount(),
            'timestamp'   => $this->getTimestamp(),
            'description' => $this->getDescription(),
            'reference'   => $this->getReference(),
            'invoiceData' => $this->getInvoiceData()->toArray(),
        ];

        return $elements;
    }
}