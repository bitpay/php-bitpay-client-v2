<?php

/**
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace BitPaySDK\Model\Bill;

/**
 * @package Bitpay
 */
class Item
{
    protected $id;
    protected $description;
    protected $price;
    protected $quantity;

    public function __construct()
    {
    }

    /**
     * Gets id.
     *
     * @return string the id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets id.
     *
     * @param string $id the id
     */
    public function setId(string $id)
    {
        $this->id = $id;
    }

    /**
     * Gets Line item description
     *
     * @return string the description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets Line item description
     *
     * @param string $description the description
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    /**
     * Gets Line item unit price for the corresponding currency
     *
     * @return float the price
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Sets Line item unit price for the corresponding currency
     *
     * @param float $price the price
     */
    public function setPrice(float $price)
    {
        $this->price = $price;
    }

    /**
     * Gets Line item number of units
     *
     * @return int the quantity
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Sets Line item number of units
     *
     * @param int $quantity the quantity
     */
    public function setQuantity(int $quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * @param array $item List of line items
     * @return Item
     */
    public static function createFromArray(array $item)
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
    public function toArray()
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
