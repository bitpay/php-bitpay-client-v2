<?php


namespace BitPaySDK\Model\Invoice;


class Shopper
{
    protected $_user;

    public function __construct()
    {
    }

    public function getUser()
    {
        return $this->_user;
    }

    public function setUser(string $user)
    {
        $this->_user = $user;
    }

    public function toArray()
    {
        $elements = [
            'user' => $this->getUser(),
        ];

        foreach ($elements as $key => $value) {
            if (empty($value)) {
                unset($elements[$key]);
            }
        }

        return $elements;
    }
}