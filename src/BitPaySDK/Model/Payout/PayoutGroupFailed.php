<?php

/**
 * Copyright (c) 2019 BitPay
 **/

declare(strict_types=1);

namespace BitPaySDK\Model\Payout;

class PayoutGroupFailed
{
    private string $errMessage = '';
    private ?string $payoutId;
    private ?string $payee;

    /**
     * @return string
     */
    public function getErrorMessage(): string
    {
        return $this->errMessage;
    }

    /**
     * @param string $errMessage
     */
    public function setErrorMessage(string $errMessage): void
    {
        $this->errMessage = $errMessage;
    }

    /**
     * @return string|null
     */
    public function getPayoutId(): ?string
    {
        return $this->payoutId;
    }

    /**
     * @param string|null $payoutId
     */
    public function setPayoutId(?string $payoutId): void
    {
        $this->payoutId = $payoutId;
    }

    /**
     * @return string|null
     */
    public function getPayee(): ?string
    {
        return $this->payee;
    }

    /**
     * @param string|null $payee
     */
    public function setPayee(?string $payee): void
    {
        $this->payee = $payee;
    }
}
