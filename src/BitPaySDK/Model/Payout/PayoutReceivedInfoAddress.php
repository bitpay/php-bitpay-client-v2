<?php


namespace BitPaySDK\Model\Payout;

/**
 *
 * @package Bitpay
 */
class PayoutReceivedInfoAddress
{
    protected $_address1;
    protected $_address2;
    protected $_locality;
    protected $_region;
    protected $_postalCode;
    protected $_country;

    public function __construct()
    {
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

    public function getLocality()
    {
        return $this->_locality;
    }

    public function setLocality(string $locality)
    {
        $this->_locality = $locality;
    }

    public function getRegion()
    {
        return $this->_region;
    }

    public function setRegion(string $region)
    {
        $this->_region = $region;
    }

    public function getPostalCode()
    {
        return $this->_postalCode;
    }

    public function setPostalCode(string $postalCode)
    {
        $this->_postalCode = $postalCode;
    }

    public function getCountry()
    {
        return $this->_country;
    }

    public function setCountry(string $country)
    {
        $this->_country = $country;
    }

    public function toArray()
    {
        $elements = [
            'address1'   => $this->getAddress1(),
            'address2'   => $this->getAddress2(),
            'locality'   => $this->getLocality(),
            'region'     => $this->getRegion(),
            'postalCode' => $this->getPostalCode(),
            'country'    => $this->getCountry(),
        ];

        foreach ($elements as $key => $value) {
            if (empty($value)) {
                unset($elements[$key]);
            }
        }

        return $elements;
    }
}
