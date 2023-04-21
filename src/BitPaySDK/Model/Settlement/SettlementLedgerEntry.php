<?php

/**
 * Copyright (c) 2019 BitPay
 **/

declare(strict_types=1);

/*
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace BitPaySDK\Model\Settlement;

/**
 * Class SettlementLedgerEntry
 * @package BitPaySDK\Model\Settlement
 * @see <a href="https://bitpay.readme.io/reference/settlements">Settlements</a>
 */
class SettlementLedgerEntry
{
    protected ?int $code = null;
    protected ?string $invoiceId = null;
    protected ?float $amount = null;
    protected ?string $timestamp = null;
    protected ?string $description = null;
    protected ?string $reference = null;
    protected InvoiceData $invoiceData;

    public function __construct()
    {
        $this->invoiceData = new InvoiceData();
    }

    /**
     * Gets code
     *
     * Contains the Ledger entry code
     *
     * @return int|null the code
     */
    public function getCode(): ?int
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
    public function setCode(int $code): void
    {
        $this->code = $code;
    }

    /**
     * Gets BitPay invoice Id
     *
     * @return string|null BitPay invoice Id
     */
    public function getInvoiceId(): ?string
    {
        return $this->invoiceId;
    }

    /**
     * Sets BitPay invoice Id
     *
     * @param string $invoiceId BitPay invoice Id
     */
    public function setInvoiceId(string $invoiceId): void
    {
        $this->invoiceId = $invoiceId;
    }

    /**
     * Gets amount
     *
     * Amount for the ledger entry. Can be positive of negative depending on the type of entry (debit or credit)
     *
     * @return float|null the amount
     */
    public function getAmount(): ?float
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
    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * Gets Date and time of the ledger entry (UTC). ISO-8601 format yyyy-mm-ddThh:mm:ssZ
     *
     * @return string|null the timestamp
     */
    public function getTimestamp(): ?string
    {
        return $this->timestamp;
    }

    /**
     * Sets Date and time of the ledger entry (UTC). ISO-8601 format yyyy-mm-ddThh:mm:ssZ
     *
     * @param string $timestamp the timestamp
     */
    public function setTimestamp(string $timestamp): void
    {
        $this->timestamp = $timestamp;
    }

    /**
     * Gets Ledger entry description.
     *
     * This field often contains an id depending on the type of entry
     * (for instance payout id, settlement id, invoice orderId etc...)
     *
     * @return string|null the description
     */
    public function getDescription(): ?string
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
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * Gets reference
     *
     * @return string|null the reference
     */
    public function getReference(): ?string
    {
        return $this->reference;
    }

    /**
     * Sets reference
     *
     * @param string $reference the reference
     */
    public function setReference(string $reference): void
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
    public function getInvoiceData(): InvoiceData
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
    public function setInvoiceData(InvoiceData $invoiceData): void
    {
        $this->invoiceData = $invoiceData;
    }

    /**
     * Gets SettlementLedgerEntry as array
     *
     * @return array SettlementLedgerEntry as array
     */
    public function toArray(): array
    {
        return [
            'code' => $this->getCode(),
            'invoiceId' => $this->getInvoiceId(),
            'amount' => $this->getAmount(),
            'timestamp' => $this->getTimestamp(),
            'description' => $this->getDescription(),
            'reference' => $this->getReference(),
            'invoiceData' => $this->getInvoiceData() ? $this->getInvoiceData()->toArray() : null,
        ];
    }
}
