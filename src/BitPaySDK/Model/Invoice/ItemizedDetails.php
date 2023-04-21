<?php

/**
 * Copyright (c) 2019 BitPay
 **/

declare(strict_types=1);

/*
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace BitPaySDK\Model\Invoice;

/**
 * Class ItemizedDetails
 * @package BitPaySDK\Model\Invoice
 * @see <a href="https://bitpay.readme.io/reference/invoices">REST API Invoices</a>
 */
class ItemizedDetails
{
    protected ?float $amount = null;
    protected ?string $description = null;
    protected ?bool $isFee = null;

    public function __construct()
    {
    }

    /**
     * Gets The amount of currency.
     *
     * @return float|null the amount
     */
    public function getAmount(): ?float
    {
        return $this->amount;
    }

    /**
     * Sets The amount of currency.
     *
     * @param float|null $amount the amount
     */
    public function setAmount(?float $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * Gets description
     *
     * Display string for the item.
     *
     * @return string|null the description
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Sets string for the item.
     *
     * @param string|null $description the description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * Gets is fee
     *
     * Indicates whether or not the item is considered a fee/tax or part of the main purchase.
     *
     * @return bool|null is fee
     */
    public function getIsFee(): ?bool
    {
        return $this->isFee;
    }

    /**
     * Sets is fee
     *
     * Gets Indicates whether or not the item is considered a fee/tax or part of the main purchase.
     *
     * @param bool|null $isFee is fee
     */
    public function setIsFee(?bool $isFee): void
    {
        $this->isFee = $isFee;
    }

    /**
     * Gets Item details data as array
     *
     * @return array item details data as array
     */
    public function toArray(): array
    {
        $elements = [
            'amount'        => $this->getAmount(),
            'description'   => $this->getDescription(),
            'isFee'         => $this->getIsFee()
        ];

        foreach ($elements as $key => $value) {
            if (empty($value)) {
                unset($elements[$key]);
            }
        }

        return $elements;
    }
}
