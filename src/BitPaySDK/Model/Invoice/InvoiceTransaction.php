<?php

declare(strict_types=1);

namespace BitPaySDK\Model\Invoice;

class InvoiceTransaction
{
    protected string $amount;
    protected int $confirmations;
    protected string $time;
    protected string $receivedTime;
    protected string $txid ;
    protected array $exRates;
    protected int $outputIndex;

    /**
     * @return string
     */
    public function getAmount(): string
    {
        return $this->amount;
    }

    /**
     * @param string $amount
     */
    public function setAmount(string $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @return int
     */
    public function getConfirmations(): int
    {
        return $this->confirmations;
    }

    /**
     * @param int $confirmations
     */
    public function setConfirmations(int $confirmations): void
    {
        $this->confirmations = $confirmations;
    }

    /**
     * @return string
     */
    public function getTime(): string
    {
        return $this->time;
    }

    /**
     * @param string $time
     */
    public function setTime(string $time): void
    {
        $this->time = $time;
    }

    /**
     * @return string
     */
    public function getReceivedTime(): string
    {
        return $this->receivedTime;
    }

    /**
     * @param string $receivedTime
     */
    public function setReceivedTime(string $receivedTime): void
    {
        $this->receivedTime = $receivedTime;
    }

    /**
     * @return string
     */
    public function getTxid(): string
    {
        return $this->txid;
    }

    /**
     * @param string $txid
     */
    public function setTxid(string $txid): void
    {
        $this->txid = $txid;
    }

    /**
     * @return array [string => float]
     */
    public function getExRates(): array
    {
        return $this->exRates;
    }

    /**
     * @param array $exRates [string => float]
     */
    public function setExRates(array $exRates): void
    {
        $this->exRates = $exRates;
    }

    /**
     * @return int
     */
    public function getOutputIndex(): int
    {
        return $this->outputIndex;
    }

    /**
     * @param int $outputIndex
     */
    public function setOutputIndex(int $outputIndex): void
    {
        $this->outputIndex = $outputIndex;
    }
}
