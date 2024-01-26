<?php

/**
 * Copyright (c) 2019 BitPay
 **/

declare(strict_types=1);

namespace BitPaySDK\Model\Payout;

class PayoutWebhook
{
    protected ?string $id = null;
    protected ?string $recipientId = null;
    protected ?string $shopperId = null;
    protected ?float $price = null;
    protected ?string $currency = null;
    protected ?string $ledgerCurrency = null;
    protected ?array $exchangeRates = null;
    protected ?string $email = null;
    protected ?string $reference = null;
    protected ?string $label = null;
    protected ?string $notificationURL = null;
    protected ?string $notificationEmail = null;
    protected ?string $effectiveDate = null;
    protected ?string $requestDate = null;
    protected ?string $status = null;
    protected ?array $transactions = null;
    protected ?string $accountId = null;
    protected ?string $dateExecuted = null;
    protected ?string $groupId = null;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    public function getRecipientId(): ?string
    {
        return $this->recipientId;
    }

    public function setRecipientId(?string $recipientId): void
    {
        $this->recipientId = $recipientId;
    }

    public function getShopperId(): ?string
    {
        return $this->shopperId;
    }

    public function setShopperId(?string $shopperId): void
    {
        $this->shopperId = $shopperId;
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

    public function getLedgerCurrency(): ?string
    {
        return $this->ledgerCurrency;
    }

    public function setLedgerCurrency(?string $ledgerCurrency): void
    {
        $this->ledgerCurrency = $ledgerCurrency;
    }

    public function getExchangeRates(): ?array
    {
        return $this->exchangeRates;
    }

    public function setExchangeRates(?array $exchangeRates): void
    {
        $this->exchangeRates = $exchangeRates;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(?string $reference): void
    {
        $this->reference = $reference;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(?string $label): void
    {
        $this->label = $label;
    }

    public function getNotificationURL(): ?string
    {
        return $this->notificationURL;
    }

    public function setNotificationURL(?string $notificationURL): void
    {
        $this->notificationURL = $notificationURL;
    }

    public function getNotificationEmail(): ?string
    {
        return $this->notificationEmail;
    }

    public function setNotificationEmail(?string $notificationEmail): void
    {
        $this->notificationEmail = $notificationEmail;
    }

    public function getEffectiveDate(): ?string
    {
        return $this->effectiveDate;
    }

    public function setEffectiveDate(?string $effectiveDate): void
    {
        $this->effectiveDate = $effectiveDate;
    }

    public function getRequestDate(): ?string
    {
        return $this->requestDate;
    }

    public function setRequestDate(?string $requestDate): void
    {
        $this->requestDate = $requestDate;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): void
    {
        $this->status = $status;
    }

    public function getTransactions(): ?array
    {
        return $this->transactions;
    }

    public function setTransactions(?array $transactions): void
    {
        $this->transactions = $transactions;
    }

    /**
     * @return string|null
     */
    public function getAccountId(): ?string
    {
        return $this->accountId;
    }

    /**
     * @param string|null $accountId
     */
    public function setAccountId(?string $accountId): void
    {
        $this->accountId = $accountId;
    }

    /**
     * @return string|null
     */
    public function getDateExecuted(): ?string
    {
        return $this->dateExecuted;
    }

    public function setDateExecuted(?string $dateExecuted): void
    {
        $this->dateExecuted = $dateExecuted;
    }

    public function getGroupId(): ?string
    {
        return $this->groupId;
    }

    public function setGroupId(?string $groupId): void
    {
        $this->groupId = $groupId;
    }
}
