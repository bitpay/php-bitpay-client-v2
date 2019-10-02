<?php


namespace BitPaySDK\Model\Payout;

/**
 *
 * @package Bitpay
 */
class PayoutReceivedInfo
{
    protected $_name;
    protected $_email;

    /**
     * @var PayoutReceivedInfoAddress
     * */
    protected $_address;

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

    public function getEmail()
    {
        return $this->_email;
    }

    public function setEmail(string $email)
    {
        $this->_email = $email;
    }

    public function getAddress()
    {
        return $this->_address;
    }

    public function setAddress(PayoutReceivedInfoAddress $address)
    {
        $this->_address = $address;
    }

    public function toArray()
    {
        $elements = [
            'name'    => $this->getName(),
            'email'   => $this->getEmail(),
            'address' => $this->getAddress()->toArray(),
        ];

        foreach ($elements as $key => $value) {
            if (empty($value)) {
                unset($elements[$key]);
            }
        }

        return $elements;
    }
}
