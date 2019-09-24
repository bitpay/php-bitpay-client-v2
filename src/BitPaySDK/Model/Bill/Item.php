<?php

namespace BitPaySDK\Model\Bill;

/**
 *
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

    public function getId()
    {
        return $this->_id;
    }

    public function setId(string $id)
    {
        $this->_id = $id;
    }

    public function getDescription()
    {
        return $this->_description;
    }

    public function setDescription(string $description)
    {
        $this->_description = $description;
    }

    public function getPrice()
    {
        return $this->_price;
    }

    public function setPrice(float $price)
    {
        $this->_price = $price;
    }

    public function getQuantity()
    {
        return $this->_quantity;
    }

    public function setQuantity(int $quantity)
    {
        $this->_quantity = $quantity;
    }

    public static function createFromArray(array $item)
    {
        $instance = new self();

        foreach ($item as $key => $value) {
            $instance->{'_'.$key} = $value;
        }

        return $instance;
    }

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
