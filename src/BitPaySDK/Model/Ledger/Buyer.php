<?php

namespace BitPaySDK\Model\Ledger;


class Buyer
{
    protected $_name;
    protected $_address1;
    protected $_address2;
    protected $_city;
    protected $_state;
    protected $_zip;
    protected $_country;
    protected $_phone;
    protected $_notify;
    protected $_email;

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

    public function getAddress1()
    {
        return $this->_address1;
    }

    public function setAddress1(string $address1)
    {
        $this->_address1 = $address1;
    }

    public function getAddress2()
    {
        return $this->_address2;
    }

    public function setAddress2(string $address2)
    {
        $this->_address2 = $address2;
    }

    public function getCity()
    {
        return $this->_city;
    }

    public function setCity(string $city)
    {
        $this->_city = $city;
    }

    public function getState()
    {
        return $this->_state;
    }

    public function setState(string $state)
    {
        $this->_state = $state;
    }

    public function getZip()
    {
        return $this->_zip;
    }

    public function setZip(string $zip)
    {
        $this->_zip = $zip;
    }

    public function getCountry()
    {
        return $this->_country;
    }

    public function setCountry(string $country)
    {
        $this->_country = $country;
    }

    public function getEmail()
    {
        return $this->_email;
    }

    public function setEmail(string $email)
    {
        $this->_email = $email;
    }

    public function getPhone()
    {
        return $this->_phone;
    }

    public function setPhone(string $phone)
    {
        $this->_phone = $phone;
    }

    public function getNotify()
    {
        return $this->_notify;
    }

    public function setNotify(bool $notify)
    {
        $this->_notify = $notify;
    }

    public function toArray()
    {
        $elements = [
            'name'     => $this->getName(),
            'address1' => $this->getAddress1(),
            'address2' => $this->getAddress2(),
            'city'     => $this->getCity(),
            'state'    => $this->getState(),
            'zip'      => $this->getZip(),
            'country'  => $this->getCountry(),
            'phone'    => $this->getPhone(),
            'notify'   => $this->getNotify(),
            'email'    => $this->getEmail(),
        ];

        foreach ($elements as $key => $value) {
            if (empty($value)) {
                unset($elements[$key]);
            }
        }

        return $elements;
    }
}
