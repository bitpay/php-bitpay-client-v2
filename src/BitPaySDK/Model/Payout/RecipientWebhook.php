<?php

/**
 * Copyright (c) 2019 BitPay
 **/

declare(strict_types=1);

namespace BitPaySDK\Model\Payout;

class RecipientWebhook
{
    protected ?string $email = null;
    protected ?string $label = null;
    protected ?string $status = null;
    protected ?string $id = null;
    protected ?string $shopperId = null;

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(?string $label): void
    {
        $this->label = $label;
    }

    /**
     * @return string|null RecipientStatus value
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @param string|null $status RecipientStatus value
     * @return void
     */
    public function setStatus(?string $status): void
    {
        $this->status = $status;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    public function getShopperId(): ?string
    {
        return $this->shopperId;
    }

    public function setShopperId(?string $shopperId): void
    {
        $this->shopperId = $shopperId;
    }
}
