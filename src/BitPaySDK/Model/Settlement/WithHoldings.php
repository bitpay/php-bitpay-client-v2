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
 * Class WithHoldings
 *
 * @package BitPaySDK\Model\Settlement
 * @see <a href="https://bitpay.readme.io/reference/settlements">Settlements</a>
 */
class WithHoldings
{
    protected ?float $amount = null;
    protected ?string $code = null;
    protected ?string $description = null;
    protected ?string $notes = null;
    protected ?string $label = null;
    protected ?string $bankCountry = null;

    /**
     * WithHoldings constructor.
     */
    public function __construct()
    {
    }

    /**
     * Gets amount.
     *
     * @return float|null
     */
    public function getAmount(): ?float
    {
        return $this->amount;
    }

    /**
     * Sets amount.
     *
     * @param float $amount the amount
     */
    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * Gets code.
     *
     * @return string|null
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * Sets code.
     *
     * @param string $code the code
     */
    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    /**
     * Gets description.
     *
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Sets description.
     *
     * @param string $description the description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * Gets notes.
     *
     * @return string|null
     */
    public function getNotes(): ?string
    {
        return $this->notes;
    }

    /**
     * Sets notes.
     *
     * @param string $notes the notes
     */
    public function setNotes(string $notes): void
    {
        $this->notes = $notes;
    }

    /**
     * Gets label.
     *
     * @return string|null
     */
    public function getLabel(): ?string
    {
        return $this->label;
    }

    /**
     * Sets label.
     *
     * @param string $label the label
     */
    public function setLabel(string $label): void
    {
        $this->label = $label;
    }

    /**
     * Gets bank country.
     *
     * @return string|null
     */
    public function getBankCountry(): ?string
    {
        return $this->bankCountry;
    }

    /**
     * Sets bank country.
     *
     * @param string $bankCountry the bank country
     */
    public function setBankCountry(string $bankCountry): void
    {
        $this->bankCountry = $bankCountry;
    }

    /**
     * Return an array with class values.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'amount' => $this->getAmount(),
            'code' => $this->getCode(),
            'description' => $this->getDescription(),
            'notes' => $this->getNotes(),
            'label' => $this->getLabel(),
            'bankCountry' => $this->getBankCountry(),
        ];
    }
}
