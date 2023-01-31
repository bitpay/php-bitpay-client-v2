<?php

/**
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace BitPaySDK\Model\Settlement;

class SettlementLedgerEntry
{
    protected $code;
    protected $invoiceId;
    protected $amount;
    protected $timestamp;
    protected $description;
    protected $reference;
    protected $invoiceData;

    public function __construct()
    {
        $this->invoiceData = new InvoiceData();
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
        return $this->code;
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
        $this->code = $code;
    }

    /**
     * Gets BitPay invoice Id
     *
     * @return string BitPay invoice Id
     */
    public function getInvoiceId()
    {
        return $this->invoiceId;
    }

    /**
     * Sets BitPay invoice Id
     *
     * @param string $invoiceId BitPay invoice Id
     */
    public function setInvoiceId(string $invoiceId)
    {
        $this->invoiceId = $invoiceId;
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
        return $this->amount;
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
        $this->amount = $amount;
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
     * Gets Ledger entry description.
     *
     * This field often contains an id depending on the type of entry
     * (for instance payout id, settlement id, invoice orderId etc...)
     *
     * @return string the description
     */
    public function getDescription()
    {
        return $this->description;
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
        $this->description = $description;
    }

    /**
     * Gets reference
     *
     * @return string the reference
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Sets reference
     *
     * @param string $reference the reference
     */
    public function setReference(string $reference)
    {
        $this->reference = $reference;
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
        return $this->invoiceData;
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
        $this->invoiceData = $invoiceData;
    }

    /**
     * Gets SettlementLedgerEntry as array
     *
     * @return array SettlementLedgerEntry as array
     */
    public function toArray()
    {
        return [
            'code'        => $this->getCode(),
            'invoiceId'   => $this->getInvoiceId(),
            'amount'      => $this->getAmount(),
            'timestamp'   => $this->getTimestamp(),
            'description' => $this->getDescription(),
            'reference'   => $this->getReference(),
            'invoiceData' => $this->getInvoiceData()->toArray(),
        ];
    }
}
