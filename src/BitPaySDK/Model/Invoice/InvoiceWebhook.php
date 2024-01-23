<?php

/**
 * Copyright (c) 2019 BitPay
 **/

declare(strict_types=1);

namespace BitPaySDK\Model\Invoice;

/**
 * @package BitPaySDK\Model\Invoice
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 * @see https://developer.bitpay.com/reference/notifications-invoices Notifications Invoices
 */
class InvoiceWebhook
{
    protected ?string $id;
    protected ?string $url;
    protected ?string $posData;
    protected ?string $status;
    protected ?float $price;
    protected ?string $currency;
    protected ?string $invoiceTime;
    protected ?string $currencyTime;
    protected ?string $exceptionStatus;
    protected ?BuyerFields $buyerFields;
    protected ?array $paymentSubtotals;
    protected ?array $paymentTotals;
    protected ?array $exchangeRates;
    protected ?float $amountPaid;
    protected ?string $orderId;
    protected ?string $transactionCurrency;
    protected ?string $inInvoiceId;
    protected ?string $inPaymentRequest;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): void
    {
        $this->url = $url;
    }

    public function getPosData(): ?string
    {
        return $this->posData;
    }

    public function setPosData(?string $posData): void
    {
        $this->posData = $posData;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): void
    {
        $this->status = $status;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): void
    {
        $this->price = $price;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(?string $currency): void
    {
        $this->currency = $currency;
    }

    public function getInvoiceTime(): ?string
    {
        return $this->invoiceTime;
    }

    public function setInvoiceTime(?string $invoiceTime): void
    {
        $this->invoiceTime = $invoiceTime;
    }

    public function getCurrencyTime(): ?string
    {
        return $this->currencyTime;
    }

    public function setCurrencyTime(?string $currencyTime): void
    {
        $this->currencyTime = $currencyTime;
    }

    public function getExceptionStatus(): ?string
    {
        return $this->exceptionStatus;
    }

    public function setExceptionStatus(?string $exceptionStatus): void
    {
        $this->exceptionStatus = $exceptionStatus;
    }

    public function getBuyerFields(): ?BuyerFields
    {
        return $this->buyerFields;
    }

    public function setBuyerFields(?BuyerFields $buyerFields): void
    {
        $this->buyerFields = $buyerFields;
    }

    public function getPaymentSubtotals(): ?array
    {
        return $this->paymentSubtotals;
    }

    public function setPaymentSubtotals(?array $paymentSubtotals): void
    {
        $this->paymentSubtotals = $paymentSubtotals;
    }

    public function getPaymentTotals(): ?array
    {
        return $this->paymentTotals;
    }

    public function setPaymentTotals(?array $paymentTotals): void
    {
        $this->paymentTotals = $paymentTotals;
    }

    public function getExchangeRates(): ?array
    {
        return $this->exchangeRates;
    }

    public function setExchangeRates(?array $exchangeRates): void
    {
        $this->exchangeRates = $exchangeRates;
    }

    public function getAmountPaid(): ?float
    {
        return $this->amountPaid;
    }

    public function setAmountPaid(?float $amountPaid): void
    {
        $this->amountPaid = $amountPaid;
    }

    public function getOrderId(): ?string
    {
        return $this->orderId;
    }

    public function setOrderId(?string $orderId): void
    {
        $this->orderId = $orderId;
    }

    public function getTransactionCurrency(): ?string
    {
        return $this->transactionCurrency;
    }

    public function setTransactionCurrency(?string $transactionCurrency): void
    {
        $this->transactionCurrency = $transactionCurrency;
    }

    /**
     * @return string|null
     */
    public function getInInvoiceId(): ?string
    {
        return $this->inInvoiceId;
    }

    public function setInInvoiceId(?string $inInvoiceId): void
    {
        $this->inInvoiceId = $inInvoiceId;
    }

    public function getInPaymentRequest(): ?string
    {
        return $this->inPaymentRequest;
    }

    public function setInPaymentRequest(?string $inPaymentRequest): void
    {
        $this->inPaymentRequest = $inPaymentRequest;
    }
}
