<?php

declare(strict_types=1);

/**
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace BitPaySDK\Model\Subscription;

class Item
{
    protected string $description;
    protected float $price;
    protected int $quantity;

    public function __construct(float $price = 0.0, int $quantity = 0, string $description = "")
    {
        $this->price = $price;
        $this->quantity = $quantity;
        $this->description = $description;
    }

    /**
     * Gets Line item description
     *
     * @return string the Line item description
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Sets Line item description
     *
     * @param string $description the Line item description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * Gets Line item unit price for the corresponding currency
     *
     * @return float the price
     */
    public function getPrice(): float
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
     * @return int the quantity
     */
    public function getQuantity(): int
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
     * Gets Item as array
     *
     * @return array Item as array
     */
    public function toArray(): array
    {
        $elements = [
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
