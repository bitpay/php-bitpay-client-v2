<?php

/**
 * Copyright (c) 2019 BitPay
 **/

declare(strict_types=1);

namespace BitPaySDK\Model\Invoice;

/**
 * Class RefundWebhook
 *
 * @package BitPaySDK\Model\Invoice
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 * @see https://bitpay.readme.io/reference/refunds-1 Webhooks refunds
 */
class RefundWebhook
{
    protected ?string $id = null;
    protected ?string $invoice = null;
    protected ?string $supportRequest = null;
    protected ?string $status = null;
    protected ?float $amount = null;
    protected ?string $currency = null;
    protected ?string $lastRefundNotification = null;
    protected ?float $refundFee = null;
    protected ?bool $immediate = null;
    protected ?bool $buyerPaysRefundFee = null;
    protected ?string $requestDate = null;
    protected ?string $reference;
    protected ?string $guid;
    protected ?string $refundAddress;
    protected ?string $type;
    protected ?string $txid;
    protected ?string $transactionCurrency;
    protected ?float $transactionAmount;
    protected ?float $transactionRefundFee;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    public function getInvoice(): ?string
    {
        return $this->invoice;
    }

    public function setInvoice(?string $invoice): void
    {
        $this->invoice = $invoice;
    }

    public function getSupportRequest(): ?string
    {
        return $this->supportRequest;
    }

    public function setSupportRequest(?string $supportRequest): void
    {
        $this->supportRequest = $supportRequest;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): void
    {
        $this->status = $status;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(?float $amount): void
    {
        $this->amount = $amount;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(?string $currency): void
    {
        $this->currency = $currency;
    }

    public function getLastRefundNotification(): ?string
    {
        return $this->lastRefundNotification;
    }

    public function setLastRefundNotification(?string $lastRefundNotification): void
    {
        $this->lastRefundNotification = $lastRefundNotification;
    }

    public function getRefundFee(): ?float
    {
        return $this->refundFee;
    }

    public function setRefundFee(?float $refundFee): void
    {
        $this->refundFee = $refundFee;
    }

    public function getImmediate(): ?bool
    {
        return $this->immediate;
    }

    public function setImmediate(?bool $immediate): void
    {
        $this->immediate = $immediate;
    }

    public function getBuyerPaysRefundFee(): ?bool
    {
        return $this->buyerPaysRefundFee;
    }

    public function setBuyerPaysRefundFee(?bool $buyerPaysRefundFee): void
    {
        $this->buyerPaysRefundFee = $buyerPaysRefundFee;
    }

    public function getRequestDate(): ?string
    {
        return $this->requestDate;
    }

    public function setRequestDate(?string $requestDate): void
    {
        $this->requestDate = $requestDate;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(?string $reference): void
    {
        $this->reference = $reference;
    }

    public function getGuid(): ?string
    {
        return $this->guid;
    }

    public function setGuid(?string $guid): void
    {
        $this->guid = $guid;
    }

    public function getRefundAddress(): ?string
    {
        return $this->refundAddress;
    }

    public function setRefundAddress(?string $refundAddress): void
    {
        $this->refundAddress = $refundAddress;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): void
    {
        $this->type = $type;
    }

    public function getTxid(): ?string
    {
        return $this->txid;
    }

    public function setTxid(?string $txid): void
    {
        $this->txid = $txid;
    }

    public function getTransactionCurrency(): ?string
    {
        return $this->transactionCurrency;
    }

    public function setTransactionCurrency(?string $transactionCurrency): void
    {
        $this->transactionCurrency = $transactionCurrency;
    }

    public function getTransactionAmount(): ?float
    {
        return $this->transactionAmount;
    }

    public function setTransactionAmount(?float $transactionAmount): void
    {
        $this->transactionAmount = $transactionAmount;
    }

    public function getTransactionRefundFee(): ?float
    {
        return $this->transactionRefundFee;
    }

    public function setTransactionRefundFee(?float $transactionRefundFee): void
    {
        $this->transactionRefundFee = $transactionRefundFee;
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
            'requestDate' => $this->getRequestDate(),
            'reference' => $this->getReference(),
            'guid' => $this->getGuid(),
            'refundAddress' => $this->getRefundAddress(),
            'type' => $this->getType(),
            'txid' => $this->getTxid(),
            'transactionCurrency' => $this->getTransactionCurrency(),
            'transactionAmount' => $this->getTransactionAmount(),
            'transactionRefundFee' => $this->getTransactionRefundFee(),
        ];
    }
}
