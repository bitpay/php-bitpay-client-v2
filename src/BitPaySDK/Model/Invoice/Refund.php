<?php

/**
 * Copyright (c) 2019 BitPay
 **/

declare(strict_types=1);

/*
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace BitPaySDK\Model\Invoice;

/**
 * Class Refund
 * @package BitPaySDK\Model\Invoice
 * @see <a href="https://bitpay.readme.io/reference/invoices">REST API Invoices</a>
 */
class Refund
{
    protected ?string $guid = null;
    protected float $amount;
    protected string $currency;
    protected string $token;
    protected ?string $id = null;
    protected ?string $requestDate = null;
    protected ?string $status = null;
    protected ?string $invoiceId = null;
    protected ?bool $preview = null;
    protected ?bool $immediate = null;
    protected ?bool $buyerPaysRefundFee = null;
    protected ?float $refundFee = null;
    protected ?string $reference = null;
    protected ?string $lastRefundNotification = null;
    protected ?string $invoice = null;
    protected ?string $notificationURL = null;
    protected ?string $refundAddress = null;
    protected ?string $supportRequest = null;
    protected ?float $transactionAmount = null;
    protected ?string $transactionCurrency = null;
    protected ?float $transactionRefundFee = null;
    protected ?string $txid = null;
    protected ?string $type = null;

    /**
     * Constructor, create Refund object
     *
     * @param float $amount
     * @param string $currency
     * @param string $token
     */
    public function __construct(
        float $amount = 0.0,
        string $currency = "",
        string $token = ""
    ) {
        $this->amount = $amount;
        $this->currency = $currency;
        $this->token = $token;
    }

    // Request fields
    //

    /**
     * Gets a passthru variable provided by the merchant and designed to be used by the merchant to correlate
     * the invoice with an order ID in their system
     *
     * @return string|null
     */
    public function getGuid(): ?string
    {
        return $this->guid;
    }

    /**
     * Sets guid
     *
     * @param string $guid
     */
    public function setGuid(string $guid): void
    {
        $this->guid = $guid;
    }

    /**
     * Present only if specified in the request to create the refund. This is your reference label for this refund.
     * It will be passed-through on each response for you to identify the refund in your system.
     * Maximum string length is 100 characters
     *
     * @return string|null
     */
    public function getReference(): ?string
    {
        return $this->reference;
    }

    /**
     * Sets reference label for refund
     *
     * @param string $reference: void
     */
    public function setReference(string $reference): void
    {
        $this->reference = $reference;
    }

    /**
     * Gets amount to be refunded in the invoice currency
     *
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * Sets amount to be refunded
     *
     * @param float $amount
     */
    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * Gets API token
     *
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * Sets API token
     *
     * @param string $token
     */
    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    /**
     * Gets reference currency used for the refund, the same as the currency used to create the invoice
     *
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * Sets currency used for the refund
     *
     * @param string $currency
     */
    public function setCurrency(string $currency): void
    {
        $this->currency = $currency;
    }

    /**
     * Whether to create the refund request as a preview
     *
     * @return bool|null
     */
    public function getPreview(): ?bool
    {
        return $this->preview;
    }

    /**
     * Sets preview
     *
     * @param bool $preview
     */
    public function setPreview(bool $preview): void
    {
        $this->preview = $preview;
    }

    /**
     * Gets the ID of the invoice to refund
     *
     * @return string|null
     */
    public function getInvoiceId(): ?string
    {
        return $this->invoiceId;
    }

    /**
     * Sets invoice id
     *
     * @param string $invoiceId
     */
    public function setInvoiceId(string $invoiceId): void
    {
        $this->invoiceId = $invoiceId;
    }

    // Response fields
    //

    /**
     * Gets the ID of the refund
     *
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Sets id of the refund
     *
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * Gets the date the refund was requested
     *
     * @return string|null
     */
    public function getRequestDate(): ?string
    {
        return $this->requestDate;
    }

    /**
     * Sets request date
     *
     * @param string $requestDate
     */
    public function setRequestDate(string $requestDate): void
    {
        $this->requestDate = $requestDate;
    }

    /**
     * Gets the refund lifecycle status of the request
     *
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * Sets refund status
     *
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * Gets whether the funds should be removed from merchant ledger immediately
     * on submission or at the time of processing
     *
     * @return bool|null
     */
    public function getImmediate(): ?bool
    {
        return $this->immediate;
    }

    /**
     * Sets immediate value
     *
     * @param bool $immediate
     */
    public function setImmediate(bool $immediate): void
    {
        $this->immediate = $immediate;
    }

    /**
     * Gets the amount of refund fee expressed in terms of pricing currency
     *
     * @return float|null
     */
    public function getRefundFee(): ?float
    {
        return $this->refundFee;
    }

    /**
     * Sets amount of the refund fee
     *
     * @param float $refundFee
     */
    public function setRefundFee(float $refundFee): void
    {
        $this->refundFee = $refundFee;
    }

    /**
     * Gets the last time notification of buyer was attempted
     *
     * @return string|null
     */
    public function getLastRefundNotification(): ?string
    {
        return $this->lastRefundNotification;
    }

    /**
     * Sets last refund notification
     *
     * @param string $lastRefundNotification
     */
    public function setLastRefundNotification(string $lastRefundNotification): void
    {
        $this->lastRefundNotification = $lastRefundNotification;
    }

    /**
     * Gets the ID of the invoice being refunded
     *
     * @return string|null
     */
    public function getInvoice(): ?string
    {
        return $this->invoice;
    }

    /**
     * Sets the id of the invoice being refunded
     *
     * @param string $invoice
     */
    public function setInvoice(string $invoice): void
    {
        $this->invoice = $invoice;
    }

    /**
     * Gets whether the buyer should pay the refund fee rather
     * than the merchant
     *
     * @return bool|null
     */
    public function getBuyerPaysRefundFee(): ?bool
    {
        return $this->buyerPaysRefundFee;
    }

    /**
     * Sets whether the buyer should pay the refund fee rather
     *
     * @param bool $buyerPaysRefundFee
     */
    public function setBuyerPaysRefundFee(bool $buyerPaysRefundFee): void
    {
        $this->buyerPaysRefundFee = $buyerPaysRefundFee;
    }

    /**
     * Gets URL to which BitPay sends webhook notifications. HTTPS is mandatory.
     *
     * @return string|null
     */
    public function getNotificationURL(): ?string
    {
        return $this->notificationURL;
    }

    /**
     * Sets URL to which BitPay sends webhook notifications. HTTPS is mandatory.
     *
     * @param string|null $notificationURL
     */
    public function setNotificationURL(?string $notificationURL): void
    {
        $this->notificationURL = $notificationURL;
    }

    /**
     * Gets the wallet address that the refund will return the funds to, added by the customer.
     *
     * @return string|null
     */
    public function getRefundAddress(): ?string
    {
        return $this->refundAddress;
    }

    /**
     * Sets the wallet address that the refund will return the funds to, added by the customer.
     *
     * @param string|null $refundAddress
     */
    public function setRefundAddress(?string $refundAddress): void
    {
        $this->refundAddress = $refundAddress;
    }

    /**
     * Gets the ID of the associated support request for the refund.
     *
     * @return string|null
     */
    public function getSupportRequest(): ?string
    {
        return $this->supportRequest;
    }

    /**
     * Sets the ID of the associated support request for the refund.
     *
     * @param string|null $supportRequest
     */
    public function setSupportRequest(?string $supportRequest): void
    {
        $this->supportRequest = $supportRequest;
    }

    /**
     * Gets amount to be refunded in terms of the transaction currency.
     *
     * @return float|null
     */
    public function getTransactionAmount(): ?float
    {
        return $this->transactionAmount;
    }

    /**
     * Sets amount to be refunded in terms of the transaction currency.
     *
     * @param float|null $transactionAmount
     */
    public function setTransactionAmount(?float $transactionAmount): void
    {
        $this->transactionAmount = $transactionAmount;
    }

    /**
     * Gets the currency used for the invoice transaction.
     *
     * @return string|null
     */
    public function getTransactionCurrency(): ?string
    {
        return $this->transactionCurrency;
    }

    /**
     * Sets the currency used for the invoice transaction.
     *
     * @param string|null $transactionCurrency
     */
    public function setTransactionCurrency(?string $transactionCurrency): void
    {
        $this->transactionCurrency = $transactionCurrency;
    }

    /**
     * Gets the refund fee expressed in terms of transaction currency.
     *
     * @return float|null
     */
    public function getTransactionRefundFee(): ?float
    {
        return $this->transactionRefundFee;
    }

    /**
     * Sets the refund fee expressed in terms of transaction currency.
     *
     * @param float|null $transactionRefundFee
     */
    public function setTransactionRefundFee(?float $transactionRefundFee): void
    {
        $this->transactionRefundFee = $transactionRefundFee;
    }

    /**
     * Gets the transaction ID of the refund once executed.
     *
     * @return string|null
     */
    public function getTxid(): ?string
    {
        return $this->txid;
    }

    /**
     * Sets the transaction ID of the refund once executed.
     *
     * @param string|null $txid
     */
    public function setTxid(?string $txid): void
    {
        $this->txid = $txid;
    }

    /**
     * <p>Gets the type of refund.</p>
     * <ul>
     *    <li>full (current rate): A full refund of the amount paid at the current rate.</li>
     *    <li>full (fixed rate): A full refund of the amount paid at the fixed rate.
     *    Note: deprecated refund implementation only.</li>
     *    <li>partial: Part of the invoice is being refunded, rather than the full invoie amount.</li>
     *    <li>underpayment: The payment was underpaid, a refund in the amount paid will be executed.</li>
     *    <li>overpayment: The payment was overpaid, a refund in the amount that was overpaid from the invoice price
     *    will be executed.</li>
     *    <li>declined: The payment was declined, a refund in the full amount paid will be excuted.</li>
     * </ul>
     *
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * <p>Sets the type of refund.</p>
     * <ul>
     *    <li>full (current rate): A full refund of the amount paid at the current rate.</li>
     *    <li>full (fixed rate): A full refund of the amount paid at the fixed rate.
     *    Note: deprecated refund implementation only.</li>
     *    <li>partial: Part of the invoice is being refunded, rather than the full invoie amount.</li>
     *    <li>underpayment: The payment was underpaid, a refund in the amount paid will be executed.</li>
     *    <li>overpayment: The payment was overpaid, a refund in the amount that was overpaid from the invoice price
     *    will be executed.</li>
     *    <li>declined: The payment was declined, a refund in the full amount paid will be excuted.</li>
     * </ul>
     *
     * @param string|null $type
     */
    public function setType(?string $type): void
    {
        $this->type = $type;
    }

    /**
     * Return Refund values as array
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'guid' => $this->getGuid(),
            'amount' => $this->getAmount(),
            'currency' => $this->getCurrency(),
            'token' => $this->getToken(),
            'id' => $this->getId(),
            'requestDate' => $this->getRequestDate(),
            'status' => $this->getStatus(),
            'invoiceId' => $this->getInvoiceId(),
            'preview' => $this->getPreview(),
            'immediate' => $this->getImmediate(),
            'refundFee' => $this->getRefundFee(),
            'invoice' => $this->getInvoice(),
            'buyerPaysRefundFee' => $this->getBuyerPaysRefundFee(),
            'reference' => $this->getReference(),
            'lastRefundNotification' => $this->getLastRefundNotification(),
            'notificationURL' => $this->getNotificationURL(),
            'refundAddress' => $this->getRefundAddress(),
            'supportRequest' => $this->getSupportRequest(),
            'transactionAmount' => $this->getTransactionAmount(),
            'transactionCurrency' => $this->getTransactionCurrency(),
            'transactionRefundFee' => $this->getTransactionRefundFee(),
            'txid' => $this->getTxid(),
            'type' => $this->getType()
        ];
    }
}
