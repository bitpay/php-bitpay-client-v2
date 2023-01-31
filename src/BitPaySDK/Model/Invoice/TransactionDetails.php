<?php
declare(strict_types=1);

namespace BitPaySDK\Model\Invoice;

class TransactionDetails
{
    protected ?float $amount;
    protected ?string $description;
    protected ?bool $isFee;

    /**
     * Constructs a TransactionDetails object.
     *
     * @param float|null $amount The amount of the transaction.
     * @param string|null $description The three digit currency string.
     * @param bool $isFee Designates if the amount is a fee.
     */
    public function __construct(?float $amount = null, ?string $description = null, ?bool $isFee = null)
    {
        $this->amount = $amount;
        $this->description = $description;
        $this->isFee = $isFee;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount)
    {
        $this->amount = $amount;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    public function getIsFee(): ?bool
    {
        return $this->isFee;
    }

    public function setIsFee(bool $isFee)
    {
        $this->isFee = $isFee;
    }

    public function toArray(): array
    {
        return [
            'amount'        => $this->getAmount(),
            'description'   => $this->getDescription(),
            'isFee'         => $this->getIsFee()
        ];
    }
}
