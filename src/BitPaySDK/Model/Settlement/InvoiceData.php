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
 * Object containing relevant information from the paid invoice.
 * @see <a href="https://bitpay.readme.io/reference/settlements">Settlements</a>
 */
class InvoiceData
{
    protected ?string $orderId = null;
    protected ?string $date = null;
    protected ?float $price = null;
    protected ?string $currency = null;
    protected ?string $transactionCurrency = null;
    protected ?float $overPaidAmount = null;
    protected ?float $payoutPercentage = null;
    protected ?RefundInfo $refundInfo = null;

    public function __construct()
    {
    }

    /**
     * Gets Invoice orderId provided during invoice creation.
     *
     * @return string|null the order id
     */
    public function getOrderId(): ?string
    {
        return $this->orderId;
    }

    /**
     * Sets Invoice orderId provided during invoice creation.
     *
     * @param string $orderId the order id
     */
    public function setOrderId(string $orderId): void
    {
        $this->orderId = $orderId;
    }

    /**
     * Gets Date at which the invoice was created (UTC). ISO-8601 format yyyy-mm-ddThh:mm:ssZ
     *
     * @return string|null the date
     */
    public function getDate(): ?string
    {
        return $this->date;
    }

    /**
     * Sets Date at which the invoice was created (UTC). ISO-8601 format yyyy-mm-ddThh:mm:ssZ
     *
     * @param string $date the date
     */
    public function setDate(string $date): void
    {
        $this->date = $date;
    }

    /**
     * Gets Invoice price in the invoice original currency
     *
     * @return float|null the price
     */
    public function getPrice(): ?float
    {
        return $this->price;
    }

    /**
     * Sets Invoice price in the invoice original currency
     *
     * @param float $price the price
     */
    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    /**
     * Gets Invoice currency
     *
     * @return string|null the Invoice currency
     */
    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    /**
     * Sets Invoice currency
     *
     * @param string $currency the Invoice currency
     */
    public function setCurrency(string $currency): void
    {
        $this->currency = $currency;
    }

    /**
     * Gets Cryptocurrency selected by the consumer when paying the invoice.
     *
     * @return string|null the transaction currency
     */
    public function getTransactionCurrency(): ?string
    {
        return $this->transactionCurrency;
    }

    /**
     * Sets Cryptocurrency selected by the consumer when paying the invoice.
     *
     * @param string $transactionCurrency the transaction currency
     */
    public function setTransactionCurrency(string $transactionCurrency): void
    {
        $this->transactionCurrency = $transactionCurrency;
    }

    /**
     * Gets over paid amount
     *
     * @return float|null the over paid amount
     */
    public function getOverPaidAmount(): ?float
    {
        return $this->overPaidAmount;
    }

    /**
     * Sets over paid amount
     *
     * @param float $overPaidAmount the over paid amount
     */
    public function setOverPaidAmount(float $overPaidAmount): void
    {
        $this->overPaidAmount = $overPaidAmount;
    }

    /**
     * Gets The payout percentage defined by the merchant on his BitPay account settings
     *
     * @return float|null the payout percentage
     */
    public function getPayoutPercentage(): ?float
    {
        return $this->payoutPercentage;
    }

    /**
     * Sets The payout percentage defined by the merchant on his BitPay account settings
     *
     * @param float $payoutPercentage the payout percentage
     */
    public function setPayoutPercentage(float $payoutPercentage): void
    {
        $this->payoutPercentage = $payoutPercentage;
    }

    /**
     * Gets Object containing information about the refund executed for the invoice
     *
     * @return RefundInfo|null
     */
    public function getRefundInfo(): ?RefundInfo
    {
        return $this->refundInfo;
    }

    /**
     * Sets Object containing information about the refund executed for the invoice
     *
     * @param RefundInfo $refundInfo
     */
    public function setRefundInfo(RefundInfo $refundInfo): void
    {
        $this->refundInfo = $refundInfo;
    }

    /**
     * Gets InvoiceData as array
     *
     * @return array InvoiceData as array
     */
    public function toArray(): array
    {
        return [
            'orderId' => $this->getOrderId(),
            'date' => $this->getDate(),
            'price' => $this->getPrice(),
            'currency' => $this->getCurrency(),
            'transactionCurrency' => $this->getTransactionCurrency(),
            'payoutPercentage' => $this->getPayoutPercentage(),
            'refundInfo' => $this->getRefundInfo() ? $this->getRefundInfo()->toArray() : null,
        ];
    }
}
