<?php

/**
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace BitPaySDK\Model\Ledger;

class LedgerEntry
{
    protected $type;
    protected $amount;
    protected $code;
    protected $timestamp;
    protected $currency;
    protected $txType;
    protected $scale;
    protected $id;
    protected $supportRequest;
    protected $description;
    protected $invoiceId;

    protected $buyerFields;

    protected $invoiceAmount;
    protected $invoiceCurrency;
    protected $transactionCurrency;

    public function __construct()
    {
        $this->buyerFields = new Buyer();
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
        return $this->type;
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
        $this->type = $type;
    }

    /**
     * Gets Ledger entry amount, relative to the scale.
     * The decimal amount can be obtained by dividing the amount field by the scale parameter.
     *
     * @return string
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Sets Ledger entry amount, relative to the scale.
     * The decimal amount can be obtained by dividing the amount field by the scale parameter.
     *
     * @param string $amount the amount
     */
    public function setAmount(string $amount)
    {
        $this->amount = $amount;
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
        return $this->code;
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
        $this->code = $code;
    }

    /**
     * Gets Date and time of the ledger entry (UTC). ISO-8601 format yyyy-mm-ddThh:mm:ssZ
     *
     * @return string the timestamp
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Sets Date and time of the ledger entry (UTC). ISO-8601 format yyyy-mm-ddThh:mm:ssZ
     *
     * @param string $timestamp the timestamp
     */
    public function setTimestamp(string $timestamp)
    {
        $this->timestamp = $timestamp;
    }

    /**
     * Gets Ledger entry currency for the corresponding amount
     *
     * @return string the currency
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Sets Ledger entry currency for the corresponding amount
     *
     * @param string $currency the currency
     */
    public function setCurrency(string $currency)
    {
        $this->currency = $currency;
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
        return $this->txType;
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
        $this->txType = $txType;
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
        return $this->scale;
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
        $this->scale = $scale;
    }

    /**
     * Gets Ledger resource Id
     *
     * @return string the id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets Ledger resource Id
     *
     * @param string $id the id
     */
    public function setId(string $id)
    {
        $this->id = $id;
    }

    /**
     * Gets The refund requestId
     *
     * @return string the support request
     */
    public function getSupportRequest()
    {
        return $this->supportRequest;
    }

    /**
     * Sets The refund requestId
     *
     * @param string $supportRequest the support request
     */
    public function setSupportRequest(string $supportRequest)
    {
        $this->supportRequest = $supportRequest;
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
        return $this->description;
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
        $this->description = $description;
    }

    /**
     * Gets BitPay invoice Id
     *
     * @return string the invoice id
     */
    public function getInvoiceId()
    {
        return $this->invoiceId;
    }

    /**
     * Sets BitPay invoice Id
     *
     * @param string $invoiceId the invoice id
     */
    public function setInvoiceId(string $invoiceId)
    {
        $this->invoiceId = $invoiceId;
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
        return $this->buyerFields;
    }

    /**
     * Sets buyer fields
     *
     * @param Buyer $buyerFields the buyer
     */
    public function setBuyerFields($buyerFields)
    {
        $this->buyerFields = $buyerFields;
    }

    /**
     * Gets Invoice price in the invoice original currency
     *
     * @return float the invoice amount
     */
    public function getInvoiceAmount()
    {
        return $this->invoiceAmount;
    }

    /**
     * Sets Invoice price in the invoice original currency
     *
     * @param float $invoiceAmount the invoice amount
     */
    public function setInvoiceAmount(float $invoiceAmount)
    {
        $this->invoiceAmount = $invoiceAmount;
    }

    /**
     * Gets Currency used for invoice creation
     *
     * @return string the invoice currency
     */
    public function getInvoiceCurrency()
    {
        return $this->invoiceCurrency;
    }

    /**
     * Sets Currency used for invoice creation
     *
     * @param string $invoiceCurrency the invoice currency
     */
    public function setInvoiceCurrency(string $invoiceCurrency)
    {
        $this->invoiceCurrency = $invoiceCurrency;
    }

    /**
     * Gets Cryptocurrency selected by the consumer when paying an invoice.
     *
     * @return string the transaction currency
     */
    public function getTransactionCurrency()
    {
        return $this->transactionCurrency;
    }

    /**
     * Sets Cryptocurrency selected by the consumer when paying an invoice.
     *
     * @param string $transactionCurrency the transaction currency
     */
    public function setTransactionCurrency(string $transactionCurrency)
    {
        $this->transactionCurrency = $transactionCurrency;
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
