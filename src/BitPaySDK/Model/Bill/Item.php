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
    protected $_id;
    protected $_description;
    protected $_price;
    protected $_quantity;

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
        return $this->_id;
    }

    /**
     * Sets id.
     *
     * @param string $id the id
     */
    public function setId(string $id)
    {
        $this->_id = $id;
    }

    /**
     * Gets Line item description
     *
     * @return string the description
     */
    public function getDescription()
    {
        return $this->_description;
    }

    /**
     * Sets Line item description
     *
     * @param string $description the description
     */
    public function setDescription(string $description)
    {
        $this->_description = $description;
    }

    /**
     * Gets Line item unit price for the corresponding currency
     *
     * @return float the price
     */
    public function getPrice()
    {
        return $this->_price;
    }

    /**
     * Sets Line item unit price for the corresponding currency
     *
     * @param float $price the price
     */
    public function setPrice(float $price)
    {
        $this->_price = $price;
    }

    /**
     * Gets Line item number of units
     *
     * @return int the quantity
     */
    public function getQuantity()
    {
        return $this->_quantity;
    }

    /**
     * Sets Line item number of units
     *
     * @param int $quantity the quantity
     */
    public function setQuantity(int $quantity)
    {
        $this->_quantity = $quantity;
    }

    /**
     * @param array $item List of line items
     * @return Item
     */
    public static function createFromArray(array $item)
    {
        $instance = new self();

        foreach ($item as $key => $value) {
            $instance->{'_' . $key} = $value;
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
