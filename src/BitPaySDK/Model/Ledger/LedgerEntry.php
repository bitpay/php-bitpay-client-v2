<?php


namespace BitPaySDK\Model\Ledger;


class LedgerEntry
{
    protected $_type;
    protected $_amount;
    protected $_code;
    protected $_timestamp;
    protected $_currency;
    protected $_txType;
    protected $_scale;
    protected $_id;
    protected $_supportRequest;
    protected $_description;
    protected $_invoiceId;
    /**
     * @var Buyer
     */
    protected $_buyerFields;

    protected $_invoiceAmount;
    protected $_invoiceCurrency;
    protected $_transactionCurrency;

    public function __construct()
    {
        $this->_buyerFields = new Buyer();
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

    public function getTimestamp()
    {
        return $this->_timestamp;
    }

    public function setTimestamp(string $timestamp)
    {
        $this->_timestamp = $timestamp;
    }

    public function getCurrency()
    {
        return $this->_currency;
    }

    public function setCurrency(string $currency)
    {
        $this->_currency = $currency;
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

    public function getDescription()
    {
        return $this->_description;
    }

    public function setDescription(string $description)
    {
        $this->_description = $description;
    }

    public function getInvoiceId()
    {
        return $this->_invoiceId;
    }

    public function setInvoiceId(string $invoiceId)
    {
        $this->_invoiceId = $invoiceId;
    }

    public function getBuyerFields()
    {
        return $this->_buyerFields;
    }

    public function setBuyerFields($buyerFields)
    {
        $this->_buyerFields = $buyerFields;
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

    public function toArray()
    {
        $elements = [
            'type'                => $this->getType(),
            'amount'              => $this->getAmount(),
            'code'                => $this->getCode(),
            'timestamp'           => $this->getTimestamp(),
            'currency'            => $this->getCurrency(),
            'txType'              => $this->getTxType(),
            'scale'               => $this->getScale(),
            'id'                  => $this->getId(),
            'supportRequest'      => $this->getSupportRequest(),
            'description'         => $this->getDescription(),
            'invoiceId'           => $this->getInvoiceId(),
            'buyerFields'         => $this->getBuyerFields()->toArray(),
            'invoiceAmount'       => $this->getInvoiceAmount(),
            'invoiceCurrency'     => $this->getInvoiceCurrency(),
            'transactionCurrency' => $this->getTransactionCurrency(),
        ];

        foreach ($elements as $key => $value) {
            if (empty($value)) {
                unset($elements[$key]);
            }
        }

        return $elements;
    }
}