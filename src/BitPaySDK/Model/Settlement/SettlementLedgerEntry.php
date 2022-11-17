<?php

/**
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */

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

    /**
     * Gets code
     *
     * Contains the Ledger entry code
     *
     * @return int the code
     */
    public function getCode()
    {
        return $this->_code;
    }

    /**
     * Sets code
     *
     * Contains the Ledger entry code
     *
     * @param int $code the code
     */
    public function setCode(int $code)
    {
        $this->_code = $code;
    }

    /**
     * Gets BitPay invoice Id
     *
     * @return string BitPay invoice Id
     */
    public function getInvoiceId()
    {
        return $this->_invoiceId;
    }

    /**
     * Sets BitPay invoice Id
     *
     * @param string $invoiceId BitPay invoice Id
     */
    public function setInvoiceId(string $invoiceId)
    {
        $this->_invoiceId = $invoiceId;
    }

    /**
     * Gets amount
     *
     * Amount for the ledger entry. Can be positive of negative depending on the type of entry (debit or credit)
     *
     * @return float the amount
     */
    public function getAmount()
    {
        return $this->_amount;
    }

    /**
     * Sets amount
     *
     * Amount for the ledger entry. Can be positive of negative depending on the type of entry (debit or credit)
     *
     * @param float $amount the amount
     */
    public function setAmount(float $amount)
    {
        $this->_amount = $amount;
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
     * Gets Ledger entry description.
     *
     * This field often contains an id depending on the type of entry
     * (for instance payout id, settlement id, invoice orderId etc...)
     *
     * @return string the description
     */
    public function getDescription()
    {
        return $this->_description;
    }

    /**
     * Sets Ledger entry description.
     *
     * This field often contains an id depending on the type of entry
     * (for instance payout id, settlement id, invoice orderId etc...)
     *
     * @param string $description the description
     */
    public function setDescription(string $description)
    {
        $this->_description = $description;
    }

    /**
     * Gets reference
     *
     * @return string the reference
     */
    public function getReference()
    {
        return $this->_reference;
    }

    /**
     * Sets reference
     *
     * @param string $reference the reference
     */
    public function setReference(string $reference)
    {
        $this->_reference = $reference;
    }

    /**
     * Gets Invoice Data
     *
     * Object containing relevant information from the paid invoice
     *
     * @return InvoiceData
     */
    public function getInvoiceData()
    {
        return $this->_invoiceData;
    }

    /**
     * Sets Invoice Data
     *
     * Object containing relevant information from the paid invoice
     *
     * @param InvoiceData $invoiceData
     */
    public function setInvoiceData(InvoiceData $invoiceData)
    {
        $this->_invoiceData = $invoiceData;
    }

    /**
     * Gets SettlementLedgerEntry as array
     *
     * @return array SettlementLedgerEntry as array
     */
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
