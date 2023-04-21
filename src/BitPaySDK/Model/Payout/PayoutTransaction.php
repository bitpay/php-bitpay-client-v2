<?php

/**
 * Copyright (c) 2019 BitPay
 **/

declare(strict_types=1);

/*
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace BitPaySDK\Model\Payout;

/**
 * Contains the cryptocurrency transaction details for the executed payout.
 * @see <a href="https://bitpay.readme.io/reference/payouts">REST API Payouts</a>
 */
class PayoutTransaction
{
    protected ?string $txid = null;
    protected ?float $amount = null;
    protected ?string $date = null;
    protected ?string $confirmations = null;

    public function __construct()
    {
    }

    /**
     * Gets Cryptocurrency transaction hash for the executed payout.
     *
     * @return string|null the tax id
     */
    public function getTxid(): ?string
    {
        return $this->txid;
    }

    /**
     * Sets Cryptocurrency transaction hash for the executed payout.
     *
     * @param string|null $txid the tax id
     */
    public function setTxid(?string $txid): void
    {
        $this->txid = $txid;
    }

    /**
     * Gets Amount of cryptocurrency sent to the requested address.
     *
     * @return float|null the amount
     */
    public function getAmount(): ?float
    {
        return $this->amount;
    }

    /**
     * Sets Amount of cryptocurrency sent to the requested address.
     *
     * @param float|null $amount the amount
     */
    public function setAmount(?float $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * Gets Date and time (UTC) when the cryptocurrency transaction is broadcasted.
     * ISO-8601 format yyyy-mm-ddThh:mm:ssZ.
     *
     * @return string|null the date
     */
    public function getDate(): ?string
    {
        return $this->date;
    }

    /**
     * Sets Date and time (UTC) when the cryptocurrency transaction is broadcasted.
     * ISO-8601 format yyyy-mm-ddThh:mm:ssZ.
     *
     * @param string|null $date the date
     */
    public function setDate(?string $date): void
    {
        $this->date = $date;
    }

    /**
     * Gets the number of confirmations the transaction has received.
     *
     * @return string|null
     */
    public function getConfirmations(): ?string
    {
        return $this->confirmations;
    }

    /**
     * Sets the number of confirmations the transaction has received.
     *
     * @param string|null $confirmations
     */
    public function setConfirmations(?string $confirmations): void
    {
        $this->confirmations = $confirmations;
    }

    /**
     * Gets PayoutTransaction as array
     *
     * @return array PayoutTransaction as array
     */
    public function toArray(): array
    {
        return [
            'txid' => $this->getTxid(),
            'amount' => $this->getAmount(),
            'date' => $this->getDate(),
            'confirmations' => $this->getConfirmations()
        ];
    }
}
