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
class BuyerFields
{
    protected ?string $buyerName = null;
    protected ?string $buyerAddress1 = null;
    protected ?string $buyerAddress2 = null;
    protected ?string $buyerCity = null;
    protected ?string $buyerState = null;
    protected ?string $buyerZip = null;
    protected ?string $buyerCountry = null;
    protected ?string $buyerPhone = null;
    protected ?bool $buyerNotify = null;
    protected ?string $buyerEmail = null;

    public function getBuyerName(): ?string
    {
        return $this->buyerName;
    }

    public function setBuyerName(?string $buyerName): void
    {
        $this->buyerName = $buyerName;
    }

    public function getBuyerAddress1(): ?string
    {
        return $this->buyerAddress1;
    }

    public function setBuyerAddress1(?string $buyerAddress1): void
    {
        $this->buyerAddress1 = $buyerAddress1;
    }

    public function getBuyerAddress2(): ?string
    {
        return $this->buyerAddress2;
    }

    public function setBuyerAddress2(?string $buyerAddress2): void
    {
        $this->buyerAddress2 = $buyerAddress2;
    }

    public function getBuyerCity(): ?string
    {
        return $this->buyerCity;
    }

    public function setBuyerCity(?string $buyerCity): void
    {
        $this->buyerCity = $buyerCity;
    }

    public function getBuyerState(): ?string
    {
        return $this->buyerState;
    }

    public function setBuyerState(?string $buyerState): void
    {
        $this->buyerState = $buyerState;
    }

    public function getBuyerZip(): ?string
    {
        return $this->buyerZip;
    }

    public function setBuyerZip(?string $buyerZip): void
    {
        $this->buyerZip = $buyerZip;
    }

    public function getBuyerCountry(): ?string
    {
        return $this->buyerCountry;
    }

    public function setBuyerCountry(?string $buyerCountry): void
    {
        $this->buyerCountry = $buyerCountry;
    }

    public function getBuyerPhone(): ?string
    {
        return $this->buyerPhone;
    }

    public function setBuyerPhone(?string $buyerPhone): void
    {
        $this->buyerPhone = $buyerPhone;
    }

    public function getBuyerNotify(): ?bool
    {
        return $this->buyerNotify;
    }

    public function setBuyerNotify(?bool $buyerNotify): void
    {
        $this->buyerNotify = $buyerNotify;
    }

    public function getBuyerEmail(): ?string
    {
        return $this->buyerEmail;
    }

    public function setBuyerEmail(?string $buyerEmail): void
    {
        $this->buyerEmail = $buyerEmail;
    }
}
