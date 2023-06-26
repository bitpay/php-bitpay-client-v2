<?php

/**
 * Copyright (c) 2019 BitPay
 **/

declare(strict_types=1);

/*
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace BitPaySDK\Model\Bill;

/**
 * @see <a href="https://developer.bitpay.com/reference/bills">REST API Bills</a>
 *
 * @package Bitpay
 */

#[\AllowDynamicProperties]
class Item
{
    protected ?string $id = null;
    protected ?string $description = null;
    protected ?float $price = null;
    protected ?int $quantity = null;

    public function __construct()
    {
    }

    /**
     * Gets id.
     *
     * @return string|null the id
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Sets id.
     *
     * @param string $id the id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * Gets Line item description
     *
     * @return string|null the description
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Sets Line item description
     *
     * @param string $description the description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * Gets Line item unit price for the corresponding currency
     *
     * @return float|null the price
     */
    public function getPrice(): ?float
    {
        return $this->price;
    }

    /**
     * Sets Line item unit price for the corresponding currency
     *
     * @param float $price the price
     */
    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    /**
     * Gets Line item number of units
     *
     * @return int|null the quantity
     */
    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    /**
     * Sets Line item number of units
     *
     * @param int $quantity the quantity
     */
    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    /**
     * @param array $item List of line items
     * @return Item
     */
    public static function createFromArray(array $item): Item
    {
        $instance = new self();

        foreach ($item as $key => $value) {
            $instance->{$key} = $value;
        }

        return $instance;
    }

    /**
     * Gets Item data as array
     *
     * @return array item data as array
     */
    public function toArray(): array
    {
        $elements = [
            'id'          => $this->getId(),
            'description' => $this->getDescription(),
            'price'       => $this->getPrice(),
            'quantity'    => $this->getQuantity(),
        ];

        foreach ($elements as $key => $value) {
            if (empty($value)) {
                unset($elements[$key]);
            }
        }

        return $elements;
    }
}
