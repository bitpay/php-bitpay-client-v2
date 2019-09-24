<?php


namespace BitPaySDK\Model\Ledger;


class LedgerEntry
{
    protected $_type;
    protected $_amount;
    protected $_code;
    protected $_description;
    protected $_timestamp;
    protected $_txType;
    protected $_scale;
    protected $_invoiceId;
    /**
     * @var Buyer
     */
    protected $_buyer;
    protected $_invoiceAmount;
    protected $_invoiceCurrency;
    protected $_transactionCurrency;
    protected $_id;
    protected $_supportRequest;

    public function __construct()
    {
    }

    public function getType()
    {
        return $this->_type;
    }

    public function setType(string $type)
    {
        $this->_type = $type;
    }

    public function getAmount()
    {
        return $this->_amount;
    }

    public function setAmount(string $amount)
    {
        $this->_amount = $amount;
    }

    public function getCode()
    {
        return $this->_code;
    }

    public function setCode(string $code)
    {
        $this->_code = $code;
    }

    public function getDescription()
    {
        return $this->_description;
    }

    public function setDescription(string $description)
    {
        $this->_description = $description;
    }

    public function getTimestamp()
    {
        return $this->_timestamp;
    }

    public function setTimestamp(string $timestamp)
    {
        $this->_timestamp = $timestamp;
    }

    public function getTxType()
    {
        return $this->_txType;
    }

    public function setTxType(string $txType)
    {
        $this->_txType = $txType;
    }

    public function getScale()
    {
        return $this->_scale;
    }

    public function setScale(string $scale)
    {
        $this->_scale = $scale;
    }

    public function getInvoiceId()
    {
        return $this->_invoiceId;
    }

    public function setInvoiceId(string $invoiceId)
    {
        $this->_invoiceId = $invoiceId;
    }

    public function getBuyer()
    {
        return $this->_buyer;
    }

    public function setBuyer(Buyer $buyer)
    {
        $this->_buyer = $buyer;
    }

    public function getInvoiceAmount()
    {
        return $this->_invoiceAmount;
    }

    public function setInvoiceAmount(float $invoiceAmount)
    {
        $this->_invoiceAmount = $invoiceAmount;
    }

    public function getInvoiceCurrency()
    {
        return $this->_invoiceCurrency;
    }

    public function setInvoiceCurrency(string $invoiceCurrency)
    {
        $this->_invoiceCurrency = $invoiceCurrency;
    }

    public function getTransactionCurrency()
    {
        return $this->_transactionCurrency;
    }

    public function setTransactionCurrency(string $transactionCurrency)
    {
        $this->_transactionCurrency = $transactionCurrency;
    }

    public function getId()
    {
        return $this->_id;
    }

    public function setId(string $id)
    {
        $this->_id = $id;
    }

    public function getSupportRequest()
    {
        return $this->_supportRequest;
    }

    public function setSupportRequest(string $supportRequest)
    {
        $this->_supportRequest = $supportRequest;
    }

    public function toArray()
    {
        $elements = [
            'type'                => $this->getType(),
            'amount'              => $this->getAmount(),
            'code'                => $this->getCode(),
            'description'         => $this->getDescription(),
            'timestamp'           => $this->getTimestamp(),
            'txType'              => $this->getTxType(),
            'scale'               => $this->getScale(),
            'invoiceId'           => $this->getInvoiceId(),
            'buyerFields'         => $this->getBuyer()->toArray(),
            'invoiceAmount'       => $this->getInvoiceAmount(),
            'invoiceCurrency'     => $this->getInvoiceCurrency(),
            'transactionCurrency' => $this->getTransactionCurrency(),
            'id'                  => $this->getId(),
            'supportRequest'      => $this->getSupportRequest(),
        ];

        foreach ($elements as $key => $value) {
            if (empty($value)) {
                unset($elements[$key]);
            }
        }

        return $elements;
    }
}