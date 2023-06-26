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
 * Object containing information about the refund.
 * @see <a href="https://bitpay.readme.io/reference/settlements">Settlements</a>
 */
class RefundInfo
{
    protected ?string $supportRequest = null;
    protected ?string $currency = null;
    protected ?array $amounts = null;
    protected ?string $refundRequestEid = null;

    public function __construct()
    {
    }

    /**
     * Gets support request.
     *
     * BitPay support request ID associated to the refund
     *
     * @return string|null the support request
     */
    public function getSupportRequest(): ?string
    {
        return $this->supportRequest;
    }

    /**
     * Sets support request.
     *
     * BitPay support request ID associated to the refund
     *
     * @param string $supportRequest the support request
     */
    public function setSupportRequest(string $supportRequest): void
    {
        $this->supportRequest = $supportRequest;
    }

    /**
     * Gets currency.
     *
     * ISO 4217 3-character currency code. This is the currency associated with the settlement.
     * Supported settlement currencies are listed on <a href="https://bitpay.com/docs/settlement">Settlement Docs</a>
     *
     * @return string|null
     */
    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    /**
     * Sets currency.
     *
     * ISO 4217 3-character currency code. This is the currency associated with the settlement.
     * Supported settlement currencies are listed on <a href="https://bitpay.com/docs/settlement">Settlement Docs</a>
     *
     * @param string $currency the currency
     */
    public function setCurrency(string $currency): void
    {
        $this->currency = $currency;
    }

    /**
     * Gets amounts.
     *
     * This object will contain the crypto currency amount refunded by BitPay to the consumer
     *
     * @return array|null
     */
    public function getAmounts(): ?array
    {
        return $this->amounts;
    }

    /**
     * Sets amounts.
     *
     * @param array $amounts
     */
    public function setAmounts(array $amounts): void
    {
        $this->amounts = $amounts;
    }

    /**
     * Gets Refund Request Eid.
     *
     * @return string Request Eid
     */
    public function getRefundRequestEid(): ?string
    {
        return $this->refundRequestEid;
    }

    /**
     * Sets Refund Request Eid.
     *
     * @param string|null Refund Request Eid
     */
    public function setRefundRequestEid(?string $refundRequestEid): void
    {
        $this->refundRequestEid = $refundRequestEid;
    }

    /**
     * Gets Refund info as array
     *
     * @return array refund info as array
     */
    public function toArray(): array
    {
        return [
            'supportRequest' => $this->getSupportRequest(),
            'currency' => $this->getCurrency(),
            'amounts' => $this->getAmounts(),
            'refundRequestEid' => $this->getRefundRequestEid()
        ];
    }
}
