<?php

declare(strict_types=1);

/**
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace BitPaySDK\Model\Invoice;

class Refund
{
    protected ?string $guid = null;
    protected string $refundEmail;
    protected float $amount;
    protected string $currency;
    protected string $token;
    protected ?string $id = null;
    protected ?string $requestDate = null;
    protected ?string $status = null;
    protected ?RefundParams $params = null;
    protected ?string $invoiceId = null;
    protected ?bool $preview = null;
    protected ?bool $immediate = null;
    protected ?bool $buyerPaysRefundFee = null;
    protected ?float $refundFee = null;
    protected ?string $reference = null;
    protected ?string $lastRefundNotification = null;
    protected ?string $invoice = null;

    /**
     * Constructor, create Refund object
     *
     * @param string $refundEmail
     * @param float $amount
     * @param string $currency
     * @param string $token
     */
    public function __construct(
        string $refundEmail = "",
        float $amount = 0.0,
        string $currency = "",
        string $token = ""
    ) {
        $this->refundEmail = $refundEmail;
        $this->amount = $amount;
        $this->currency = $currency;
        $this->token = $token;
        $this->params = new RefundParams();
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
     * Gets refund email
     *
     * @return string
     */
    public function getRefundEmail(): string
    {
        return $this->refundEmail;
    }

    /**
     * Sets refund email
     *
     * @param string $refundEmail
     */
    public function setRefundEmail(string $refundEmail): void
    {
        $this->refundEmail = $refundEmail;
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
     * Gets object containing the refund request parameters
     *
     * @return RefundParams|null
     */
    public function getParams(): ?RefundParams
    {
        return $this->params;
    }

    /**
     * Sets refund params object
     *
     * @param RefundParams $params
     */
    public function setParams(RefundParams $params): void
    {
        $this->params = $params;
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
     * Return Refund values as array
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'guid' => $this->getGuid(),
            'refundEmail' => $this->getRefundEmail(),
            'amount' => $this->getAmount(),
            'currency' => $this->getCurrency(),
            'token' => $this->getToken(),
            'id' => $this->getId(),
            'requestDate' => $this->getRequestDate(),
            'status' => $this->getStatus(),
            'params' => $this->getParams()->toArray(),
            'invoiceId' => $this->getInvoiceId(),
            'preview' => $this->getPreview(),
            'immediate' => $this->getImmediate(),
            'refundFee' => $this->getRefundFee(),
            'invoice' => $this->getInvoice(),
            'buyerPaysRefundFee' => $this->getBuyerPaysRefundFee(),
            'reference' => $this->getReference(),
            'lastRefundNotification' => $this->getLastRefundNotification()
        ];
    }
}
