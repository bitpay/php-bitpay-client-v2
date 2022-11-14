<?php

/**
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */

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

    /**
     * Gets type
     *
     * Contains the Ledger entry name.
     * See the list of Ledger Entry Codes: https://bitpay.com/api/?php#ledger-entry-codes
     *
     * @return string the type
     */
    public function getType()
    {
        return $this->_type;
    }

    /**
     * Sets type
     *
     * Contains the Ledger entry name.
     * See the list of Ledger Entry Codes: https://bitpay.com/api/?php#ledger-entry-codes
     *
     * @param string $type the type
     */
    public function setType(string $type)
    {
        $this->_type = $type;
    }

    /**
     * Gets Ledger entry amount, relative to the scale.
     * The decimal amount can be obtained by dividing the amount field by the scale parameter.
     *
     * @return string
     */
    public function getAmount()
    {
        return $this->_amount;
    }

    /**
     * Sets Ledger entry amount, relative to the scale.
     * The decimal amount can be obtained by dividing the amount field by the scale parameter.
     *
     * @param string $amount the amount
     */
    public function setAmount(string $amount)
    {
        $this->_amount = $amount;
    }

    /**
     * Gets code
     *
     * Contains the Ledger entry code.
     * See the list of Ledger Entry Codes: https://bitpay.com/api/?php#ledger-entry-codes
     *
     * @return string the code
     */
    public function getCode()
    {
        return $this->_code;
    }

    /**
     * Sets code
     *
     * Contains the Ledger entry code.
     * See the list of Ledger Entry Codes: https://bitpay.com/api/?php#ledger-entry-codes
     *
     * @param string $code the code
     */
    public function setCode(string $code)
    {
        $this->_code = $code;
    }

    /**
     * Gets Date and time of the ledger entry (UTC). ISO-8601 format yyyy-mm-ddThh:mm:ssZ
     *
     * @return string the timestamp
     */
    public function getTimestamp()
    {
        return $this->_timestamp;
    }

    /**
     * Sets Date and time of the ledger entry (UTC). ISO-8601 format yyyy-mm-ddThh:mm:ssZ
     *
     * @param string $timestamp the timestamp
     */
    public function setTimestamp(string $timestamp)
    {
        $this->_timestamp = $timestamp;
    }

    /**
     * Gets Ledger entry currency for the corresponding amount
     *
     * @return string the currency
     */
    public function getCurrency()
    {
        return $this->_currency;
    }

    /**
     * Sets Ledger entry currency for the corresponding amount
     *
     * @param string $currency the currency
     */
    public function setCurrency(string $currency)
    {
        $this->_currency = $currency;
    }

    /**
     * Gets tx type
     *
     * [DEPRECRATED] see type
     *
     * @return string the txType
     */
    public function getTxType()
    {
        return $this->_txType;
    }

    /**
     * Sets tx type
     *
     * [DEPRECRATED] see type
     *
     * @param string $txType the txType
     */
    public function setTxType(string $txType)
    {
        $this->_txType = $txType;
    }

    /**
     * Gets scale
     *
     * Power of 10 used for conversion
     *
     * @return string the scale
     */
    public function getScale()
    {
        return $this->_scale;
    }

    /**
     * Sets scale
     *
     * Power of 10 used for conversion
     *
     * @param string $scale the scale
     */
    public function setScale(string $scale)
    {
        $this->_scale = $scale;
    }

    /**
     * Gets Ledger resource Id
     *
     * @return string the id
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * Sets Ledger resource Id
     *
     * @param string $id the id
     */
    public function setId(string $id)
    {
        $this->_id = $id;
    }

    /**
     * Gets The refund requestId
     *
     * @return string the support request
     */
    public function getSupportRequest()
    {
        return $this->_supportRequest;
    }

    /**
     * Sets The refund requestId
     *
     * @param string $supportRequest the support request
     */
    public function setSupportRequest(string $supportRequest)
    {
        $this->_supportRequest = $supportRequest;
    }

    /**
     * Gets description
     *
     * Ledger entry description. Also contains an id depending on the type of entry
     * (for instance payout id, settlement id, invoice orderId etc...)
     *
     * @return string the description
     */
    public function getDescription()
    {
        return $this->_description;
    }

    /**
     * Sets description
     *
     * Ledger entry description. Also contains an id depending on the type of entry
     * (for instance payout id, settlement id, invoice orderId etc...)
     *
     * @param string $description the description
     */
    public function setDescription(string $description)
    {
        $this->_description = $description;
    }

    /**
     * Gets BitPay invoice Id
     *
     * @return string the invoice id
     */
    public function getInvoiceId()
    {
        return $this->_invoiceId;
    }

    /**
     * Sets BitPay invoice Id
     *
     * @param string $invoiceId the invoice id
     */
    public function setInvoiceId(string $invoiceId)
    {
        $this->_invoiceId = $invoiceId;
    }

    /**
     * Gets buyer fields
     *
     * If provided by the merchant in the buyer object during invoice creation
     *
     * @return Buyer
     */
    public function getBuyerFields()
    {
        return $this->_buyerFields;
    }

    /**
     * Sets buyer fields
     *
     * @param $buyerFields Buyer the buyer
     */
    public function setBuyerFields($buyerFields)
    {
        $this->_buyerFields = $buyerFields;
    }

    /**
     * Gets Invoice price in the invoice original currency
     *
     * @return float the invoice amount
     */
    public function getInvoiceAmount()
    {
        return $this->_invoiceAmount;
    }

    /**
     * Sets Invoice price in the invoice original currency
     *
     * @param float $invoiceAmount the invoice amount
     */
    public function setInvoiceAmount(float $invoiceAmount)
    {
        $this->_invoiceAmount = $invoiceAmount;
    }

    /**
     * Gets Currency used for invoice creation
     *
     * @return string the invoice currency
     */
    public function getInvoiceCurrency()
    {
        return $this->_invoiceCurrency;
    }

    /**
     * Sets Currency used for invoice creation
     *
     * @param string $invoiceCurrency the invoice currency
     */
    public function setInvoiceCurrency(string $invoiceCurrency)
    {
        $this->_invoiceCurrency = $invoiceCurrency;
    }

    /**
     * Gets Cryptocurrency selected by the consumer when paying an invoice.
     *
     * @return string the transaction currency
     */
    public function getTransactionCurrency()
    {
        return $this->_transactionCurrency;
    }

    /**
     * Sets Cryptocurrency selected by the consumer when paying an invoice.
     *
     * @param string $transactionCurrency the transaction currency
     */
    public function setTransactionCurrency(string $transactionCurrency)
    {
        $this->_transactionCurrency = $transactionCurrency;
    }

    /**
     * Gets LedgerEntry as array
     *
     * @return array LedgerEntry as array
     */
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
