<?php

/**
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace BitPaySDK\Model\Ledger;

class Buyer
{
    protected $name;
    protected $address1;
    protected $address2;
    protected $city;
    protected $state;
    protected $zip;
    protected $country;
    protected $phone;
    protected $notify;
    protected $email;

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
        return $this->name;
    }

    /**
     * Sets name
     *
     * @param string $name the name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * Gets address 1
     *
     * @return string the address1
     */
    public function getAddress1()
    {
        return $this->address1;
    }

    /**
     * Sets address1
     *
     * @param string $address1
     */
    public function setAddress1(string $address1)
    {
        $this->address1 = $address1;
    }

    /**
     * Gets address2
     *
     * @return string the address2
     */
    public function getAddress2()
    {
        return $this->address2;
    }

    /**
     * Sets address2
     *
     * @param string $address2 the address2
     */
    public function setAddress2(string $address2)
    {
        $this->address2 = $address2;
    }

    /**
     * Gets city
     *
     * @return string the city
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Sets city
     *
     * @param string $city the city
     */
    public function setCity(string $city)
    {
        $this->city = $city;
    }

    /**
     * Gets state
     *
     * @return string the state
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Sets state
     *
     * @param string $state the state
     */
    public function setState(string $state)
    {
        $this->state = $state;
    }

    /**
     * Gets zip
     *
     * @return string the zip
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * Sets zip
     *
     * @param string $zip the zip
     */
    public function setZip(string $zip)
    {
        $this->zip = $zip;
    }

    /**
     * Gets country
     *
     * @return string the country
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Sets country
     *
     * @param string $country the country
     */
    public function setCountry(string $country)
    {
        $this->country = $country;
    }

    /**
     * Gets email
     *
     * @return string the email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Sets email
     *
     * @param string $email the email
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    /**
     * Gets phone
     *
     * @return string the phone
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Sets phone
     *
     * @param string $phone the phone
     */
    public function setPhone(string $phone)
    {
        $this->phone = $phone;
    }

    /**
     * Gets notify
     *
     * @return bool notify
     */
    public function getNotify()
    {
        return $this->notify;
    }

    /**
     * Sets notify
     *
     * @param bool $notify notify
     */
    public function setNotify(bool $notify)
    {
        $this->notify = $notify;
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
