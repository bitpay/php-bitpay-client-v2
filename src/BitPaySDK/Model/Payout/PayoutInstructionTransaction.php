<?php

declare(strict_types=1);

/*
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace BitPaySDK\Model\Payout;

class PayoutInstructionTransaction
{
    protected ?string $txid = null;
    protected ?float $amount = null;
    protected ?string $date = null;

    public function __construct()
    {
    }

    /**
     * Gets Cryptocurrency transaction hash for the executed payout.
     *
     * @return string|null the taxid
     */
    public function getTxid(): ?string
    {
        return $this->txid;
    }

    /**
     * Sets Cryptocurrency transaction hash for the executed payout.
     *
     * @param string $txid the taxid
     */
    public function setTxid(string $txid): void
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
     * @param float $amount the amount
     */
    public function setAmount(float $amount): void
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
     * @param string $date the date
     */
    public function setDate(string $date): void
    {
        $this->date = $date;
    }

    /**
     * Gets PayoutInstructionTransaction as array
     *
     * @return array PayoutInstructionTransaction as array
     */
    public function toArray(): array
    {
        return [
            'txid' => $this->getTxid(),
            'amount' => $this->getAmount(),
            'date' => $this->getDate(),
        ];
    }
}
