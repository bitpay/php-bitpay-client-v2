<?php

/**
 * Copyright (c) 2019 BitPay
 **/

declare(strict_types=1);

namespace BitPaySDK\Model\Invoice;

/**
 * Class RefundWebhook
 * @package BitPaySDK\Model\Invoice
 * @see <a href="https://bitpay.readme.io/reference/refunds-1">Webhooks refunds</a>
 */
class RefundWebhook
{
    protected string $id;
    protected string $invoice;
    protected string $supportRequest;
    protected string $status;
    protected float $amount;
    protected string $currency;
    protected string $lastRefundNotification;
    protected float $refundFee;
    protected bool $immediate;
    protected bool $buyerPaysRefundFee;
    protected string $requestDate;

    public function __construct()
    {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getInvoice(): string
    {
        return $this->invoice;
    }

    public function setInvoice(string $invoice): void
    {
        $this->invoice = $invoice;
    }

    public function getSupportRequest(): string
    {
        return $this->supportRequest;
    }

    public function setSupportRequest(string $supportRequest): void
    {
        $this->supportRequest = $supportRequest;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): void
    {
        $this->currency = $currency;
    }

    public function getLastRefundNotification(): string
    {
        return $this->lastRefundNotification;
    }

    public function setLastRefundNotification(string $lastRefundNotification): void
    {
        $this->lastRefundNotification = $lastRefundNotification;
    }

    public function getRefundFee(): float
    {
        return $this->refundFee;
    }

    public function setRefundFee(float $refundFee): void
    {
        $this->refundFee = $refundFee;
    }

    public function getImmediate(): bool
    {
        return $this->immediate;
    }

    public function setImmediate(bool $immediate): void
    {
        $this->immediate = $immediate;
    }

    public function getBuyerPaysRefundFee(): bool
    {
        return $this->buyerPaysRefundFee;
    }

    public function setBuyerPaysRefundFee(bool $buyerPaysRefundFee): void
    {
        $this->buyerPaysRefundFee = $buyerPaysRefundFee;
    }

    public function getRequestDate(): string
    {
        return $this->requestDate;
    }

    public function setRequestDate(string $requestDate): void
    {
        $this->requestDate = $requestDate;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'invoice' => $this->getInvoice(),
            'supportRequest' => $this->getSupportRequest(),
            'status' => $this->getStatus(),
            'amount' => $this->getAmount(),
            'currency' => $this->getCurrency(),
            'lastRefundNotification' => $this->getLastRefundNotification(),
            'refundFee' => $this->getRefundFee(),
            'immediate' => $this->getImmediate(),
            'buyerPaysRefundFee' => $this->getBuyerPaysRefundFee(),
            'requestDate' => $this->getRequestDate()
        ];
    }
}
