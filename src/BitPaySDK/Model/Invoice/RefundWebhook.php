<?php

declare(strict_types=1);

namespace BitPaySDK\Model\Invoice;

class RefundWebhook
{
    protected $_id;
    protected $_invoice;
    protected $_supportRequest;
    protected $_status;
    protected $_amount;
    protected $_currency;
    protected $_lastRefundNotification;
    protected $_refundFee;
    protected $_immediate;
    protected $_buyerPaysRefundFee;
    protected $_requestDate;

    public function __construct()
    {
    }

    public function getId(): string
    {
        return $this->_id;
    }

    public function setId(string $id): void
    {
        $this->_id = $id;
    }

    public function getInvoice(): string
    {
        return $this->_invoice;
    }

    public function setInvoice(string $invoice): void
    {
        $this->_invoice = $invoice;
    }

    public function getSupportRequest(): string
    {
        return $this->_supportRequest;
    }

    public function setSupportRequest(string $supportRequest): void
    {
        $this->_supportRequest = $supportRequest;
    }

    public function getStatus(): string
    {
        return $this->_status;
    }

    public function setStatus(string $status): void
    {
        $this->_status = $status;
    }

    public function getAmount(): float
    {
        return $this->_amount;
    }

    public function setAmount(float $amount): void
    {
        $this->_amount = $amount;
    }

    public function getCurrency(): string
    {
        return $this->_currency;
    }

    public function setCurrency(string $currency): void
    {
        $this->_currency = $currency;
    }

    public function getLastRefundNotification(): string
    {
        return $this->_lastRefundNotification;
    }

    public function setLastRefundNotification(string $lastRefundNotification): void
    {
        $this->_lastRefundNotification = $lastRefundNotification;
    }

    public function getRefundFee(): float
    {
        return $this->_refundFee;
    }

    public function setRefundFee(float $refundFee): void
    {
        $this->_refundFee = $refundFee;
    }

    public function getImmediate(): bool
    {
        return $this->_immediate;
    }

    public function setImmediate(bool $immediate): void
    {
        $this->_immediate = $immediate;
    }

    public function getBuyerPaysRefundFee(): bool
    {
        return $this->_buyerPaysRefundFee;
    }

    public function setBuyerPaysRefundFee(bool $buyerPaysRefundFee): void
    {
        $this->_buyerPaysRefundFee = $buyerPaysRefundFee;
    }

    public function getRequestDate(): string
    {
        return $this->_requestDate;
    }

    public function setRequestDate(string $requestDate): void
    {
        $this->_requestDate = $requestDate;
    }

    public function toArray(): array
    {
        $elements = [
            'id'                     => $this->getId(),
            'invoice'                => $this->getInvoice(),
            'supportRequest'         => $this->getSupportRequest(),
            'status'                 => $this->getStatus(),
            'amount'                 => $this->getAmount(),
            'currency'               => $this->getCurrency(),
            'lastRefundNotification' => $this->getLastRefundNotification(),
            'refundFee'              => $this->getRefundFee(),
            'immediate'              => $this->getImmediate(),
            'buyerPaysRefundFee'     => $this->getBuyerPaysRefundFee(),
            'requestDate'            => $this->getRequestDate()
        ];

        return $elements;
    }
}
