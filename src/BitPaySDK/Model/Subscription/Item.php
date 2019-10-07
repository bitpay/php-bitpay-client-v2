<?php


namespace BitPaySDK\Model\Subscription;


class Item
{
    protected $_description;
    protected $_price;
    protected $_quantity;

    public function __construct(float $price = 0.0, int $quantity = 0, string $description = "")
    {
        $this->_price = $price;
        $this->_quantity = $quantity;
        $this->_description = $description;
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