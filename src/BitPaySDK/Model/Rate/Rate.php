<?php


namespace BitPaySDK\Model\Rate;


class Rate
{
    protected $_name;
    protected $_code;
    protected $_rate;

    public function __construct()
    {
    }

    public function getName()
    {
        return $this->_name;
    }

    public function setName(string $name)
    {
        $this->_name = $name;
    }

    public function getCode()
    {
        return $this->_code;
    }

    public function setCode(string $code)
    {
        $this->_code = $code;
    }

    public function getRate()
    {
        return $this->_rate;
    }

    public function setRate(float $rate)
    {
        $this->_rate = $rate;
    }

    public function toArray()
    {
        $elements = [
            'name' => $this->getName(),
            'code' => $this->getCode(),
            'rate' => $this->getRate(),
        ];

        foreach ($elements as $key => $value) {
            if (empty($value)) {
                unset($elements[$key]);
            }
        }

        return $elements;
    }
}