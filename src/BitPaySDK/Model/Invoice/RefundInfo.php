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
 * For a refunded invoice, this object will contain the details of executed refunds for the corresponding invoice.
 * @see <a href="https://bitpay.readme.io/reference/invoices">REST API Invoices</a>
 */
class RefundInfo
{
    protected ?string $supportRequest = null;
    protected ?string $currency = null;
    protected ?array $amounts = null;

    public function __construct()
    {
    }

    /**
     * Gets support request
     *
     * For a refunded invoice, this field will contain the refund requestId once executed.
     *
     * @return string|null the support request
     */
    public function getSupportRequest(): ?string
    {
        return $this->supportRequest;
    }

    /**
     * Sets support request
     *
     * For a refunded invoice, this field will contain the refund requestId once executed.
     *
     * @param string $supportRequest the support request
     */
    public function setSupportRequest(string $supportRequest): void
    {
        $this->supportRequest = $supportRequest;
    }

    /**
     * Gets currency
     *
     * For a refunded invoice, this field will contain the base currency selected for the refund.
     * Typically the same as the invoice currency.
     *
     * @return string|null the currency
     */
    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    /**
     * Sets currency
     *
     * For a refunded invoice, this field will contain the base currency selected for the refund.
     * Typically the same as the invoice currency.
     *
     * @param string $currency the currency
     */
    public function setCurrency(string $currency): void
    {
        $this->currency = $currency;
    }

    /**
     * Gets amounts
     *
     * For a refunded invoice, this object will contain the crypto currency amount
     * refunded by BitPay to the consumer (in the selected transactionCurrency)
     * and the equivalent refunded amount from the invoice in the given currency
     * (thus linked to the amount debited from the merchant account to cover the refund)
     *
     * @return array|null the amounts
     */
    public function getAmounts(): ?array
    {
        return $this->amounts;
    }

    /**
     * Set amounts
     *
     * For a refunded invoice, this object will contain the crypto currency amount
     * refunded by BitPay to the consumer (in the selected transactionCurrency)
     * and the equivalent refunded amount from the invoice in the given currency
     * (thus linked to the amount debited from the merchant account to cover the refund)
     *
     * @param array $amounts the amounts
     */
    public function setAmounts(array $amounts): void
    {
        $this->amounts = $amounts;
    }

    /**
     * Gets Refund info as array
     *
     * @return array refund info as array
     */
    public function toArray(): array
    {
        $elements = [
            'supportRequest' => $this->getSupportRequest(),
            'currency'       => $this->getCurrency(),
            'amounts'        => $this->getAmounts(),
        ];

        foreach ($elements as $key => $value) {
            if (empty($value)) {
                unset($elements[$key]);
            }
        }

        return $elements;
    }
}
