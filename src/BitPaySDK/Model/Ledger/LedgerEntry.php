<?php

/**
 * Copyright (c) 2019 BitPay
 **/

declare(strict_types=1);

/*
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace BitPaySDK\Model\Ledger;

/**
 * Class LedgerEntry
 * @package BitPaySDK\Model\Ledger
 * @see <a href="https://bitpay.readme.io/reference/ledgers">REST API Ledgers</a>
 */
class LedgerEntry
{
    protected ?string $type = null;
    protected ?string $amount = null;
    protected ?string $code = null;
    protected ?string $timestamp = null;
    protected ?string $currency = null;
    protected ?string $txType = null;
    protected ?string $scale = null;
    protected ?string $id = null;
    protected ?string $supportRequest = null;
    protected ?string $description = null;
    protected ?string $invoiceId = null;
    protected Buyer $buyerFields;
    protected ?float $invoiceAmount = null;
    protected ?string $invoiceCurrency = null;
    protected ?string $transactionCurrency = null;

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
     * @return string|null the type
     */
    public function getType(): ?string
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
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * Gets Ledger entry amount, relative to the scale.
     * The decimal amount can be obtained by dividing the amount field by the scale parameter.
     *
     * @return string|null
     */
    public function getAmount(): ?string
    {
        return $this->amount;
    }

    /**
     * Sets Ledger entry amount, relative to the scale.
     * The decimal amount can be obtained by dividing the amount field by the scale parameter.
     *
     * @param string $amount the amount
     */
    public function setAmount(string $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * Gets code
     *
     * Contains the Ledger entry code.
     * See the list of Ledger Entry Codes: https://bitpay.com/api/?php#ledger-entry-codes
     *
     * @return string|null the code
     */
    public function getCode(): ?string
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
    public function setCode(string $code): void
    {
        $this->code = $code;
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
     * Gets Ledger entry currency for the corresponding amount
     *
     * @return string|null the currency
     */
    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    /**
     * Sets Ledger entry currency for the corresponding amount
     *
     * @param string $currency the currency
     */
    public function setCurrency(string $currency): void
    {
        $this->currency = $currency;
    }

    /**
     * Gets tx type
     *
     * [DEPRECRATED] see type
     *
     * @return string|null the txType
     */
    public function getTxType(): ?string
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
    public function setTxType(string $txType): void
    {
        $this->txType = $txType;
    }

    /**
     * Gets scale
     *
     * Power of 10 used for conversion
     *
     * @return string|null the scale
     */
    public function getScale(): ?string
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
    public function setScale(string $scale): void
    {
        $this->scale = $scale;
    }

    /**
     * Gets Ledger resource Id
     *
     * @return string|null the id
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Sets Ledger resource Id
     *
     * @param string $id the id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * Gets The refund requestId
     *
     * @return string|null the support request
     */
    public function getSupportRequest(): ?string
    {
        return $this->supportRequest;
    }

    /**
     * Sets The refund requestId
     *
     * @param string $supportRequest the support request
     */
    public function setSupportRequest(string $supportRequest): void
    {
        $this->supportRequest = $supportRequest;
    }

    /**
     * Gets description
     *
     * Ledger entry description. Also contains an id depending on the type of entry
     * (for instance payout id, settlement id, invoice orderId etc...)
     *
     * @return string|null the description
     */
    public function getDescription(): ?string
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
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * Gets BitPay invoice Id
     *
     * @return string|null the invoice id
     */
    public function getInvoiceId(): ?string
    {
        return $this->invoiceId;
    }

    /**
     * Sets BitPay invoice Id
     *
     * @param string $invoiceId the invoice id
     */
    public function setInvoiceId(string $invoiceId): void
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
    public function getBuyerFields(): Buyer
    {
        return $this->buyerFields;
    }

    /**
     * Sets buyer fields
     *
     * @param Buyer $buyerFields the buyer
     */
    public function setBuyerFields(Buyer $buyerFields): void
    {
        $this->buyerFields = $buyerFields;
    }

    /**
     * Gets Invoice price in the invoice original currency
     *
     * @return float|null the invoice amount
     */
    public function getInvoiceAmount(): ?float
    {
        return $this->invoiceAmount;
    }

    /**
     * Sets Invoice price in the invoice original currency
     *
     * @param float $invoiceAmount the invoice amount
     */
    public function setInvoiceAmount(float $invoiceAmount): void
    {
        $this->invoiceAmount = $invoiceAmount;
    }

    /**
     * Gets Currency used for invoice creation
     *
     * @return string|null the invoice currency
     */
    public function getInvoiceCurrency(): ?string
    {
        return $this->invoiceCurrency;
    }

    /**
     * Sets Currency used for invoice creation
     *
     * @param string $invoiceCurrency the invoice currency
     */
    public function setInvoiceCurrency(string $invoiceCurrency): void
    {
        $this->invoiceCurrency = $invoiceCurrency;
    }

    /**
     * Gets Cryptocurrency selected by the consumer when paying an invoice.
     *
     * @return string|null the transaction currency
     */
    public function getTransactionCurrency(): ?string
    {
        return $this->transactionCurrency;
    }

    /**
     * Sets Cryptocurrency selected by the consumer when paying an invoice.
     *
     * @param string $transactionCurrency the transaction currency
     */
    public function setTransactionCurrency(string $transactionCurrency): void
    {
        $this->transactionCurrency = $transactionCurrency;
    }

    /**
     * Gets LedgerEntry as array
     *
     * @return array LedgerEntry as array
     */
    public function toArray(): array
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
