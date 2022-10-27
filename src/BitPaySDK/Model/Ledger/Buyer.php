<?php

/**
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */

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

    /**
     * Gets name
     *
     * @return string the name
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * Sets name
     *
     * @param string $name the name
     */
    public function setName(string $name)
    {
        $this->_name = $name;
    }

    /**
     * Gets address 1
     *
     * @return string the address1
     */
    public function getAddress1()
    {
        return $this->_address1;
    }

    /**
     * Sets address1
     *
     * @param string $address1
     */
    public function setAddress1(string $address1)
    {
        $this->_address1 = $address1;
    }

    /**
     * Gets address2
     *
     * @return string the address2
     */
    public function getAddress2()
    {
        return $this->_address2;
    }

    /**
     * Sets address2
     *
     * @param string $address2 the address2
     */
    public function setAddress2(string $address2)
    {
        $this->_address2 = $address2;
    }

    /**
     * Gets city
     *
     * @return string the city
     */
    public function getCity()
    {
        return $this->_city;
    }

    /**
     * Sets city
     *
     * @param string $city the city
     */
    public function setCity(string $city)
    {
        $this->_city = $city;
    }

    /**
     * Gets state
     *
     * @return string the state
     */
    public function getState()
    {
        return $this->_state;
    }

    /**
     * Sets state
     *
     * @param string $state the state
     */
    public function setState(string $state)
    {
        $this->_state = $state;
    }

    /**
     * Gets zip
     *
     * @return string the zip
     */
    public function getZip()
    {
        return $this->_zip;
    }

    /**
     * Sets zip
     *
     * @param string $zip the zip
     */
    public function setZip(string $zip)
    {
        $this->_zip = $zip;
    }

    /**
     * Gets country
     *
     * @return string the country
     */
    public function getCountry()
    {
        return $this->_country;
    }

    /**
     * Sets country
     *
     * @param string $country the country
     */
    public function setCountry(string $country)
    {
        $this->_country = $country;
    }

    /**
     * Gets email
     *
     * @return string the email
     */
    public function getEmail()
    {
        return $this->_email;
    }

    /**
     * Sets email
     *
     * @param string $email the email
     */
    public function setEmail(string $email)
    {
        $this->_email = $email;
    }

    /**
     * Gets phone
     *
     * @return string the phone
     */
    public function getPhone()
    {
        return $this->_phone;
    }

    /**
     * Sets phone
     *
     * @param string $phone the phone
     */
    public function setPhone(string $phone)
    {
        $this->_phone = $phone;
    }

    /**
     * Gets notify
     *
     * @return bool notify
     */
    public function getNotify()
    {
        return $this->_notify;
    }

    /**
     * Sets notify
     *
     * @param bool $notify notify
     */
    public function setNotify(bool $notify)
    {
        $this->_notify = $notify;
    }

    /**
     * Gets Buyer as array
     *
     * @return array Buyer as array
     */
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
