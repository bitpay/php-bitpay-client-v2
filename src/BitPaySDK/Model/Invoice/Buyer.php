<?php

/**
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace BitPaySDK\Model\Invoice;

/**
 * @package Bitpay
 *
 * Allows merchant to pass buyer related information in the invoice object
 */
class Buyer
{
    protected $name;
    protected $address1;
    protected $address2;
    protected $locality;
    protected $region;
    protected $postalCode;
    protected $country;
    protected $email;
    protected $phone;
    protected $notify;

    public function __construct()
    {
    }

    /**
     * Gets Buyer's name
     *
     * @return string Buyer's name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets Buyer's name
     *
     * @param string $name Buyer's name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * Gets Buyer's address
     *
     * @return string Buyer's address
     */
    public function getAddress1()
    {
        return $this->address1;
    }

    /**
     * Sets Buyer's address
     *
     * @param string $address1 Buyer's address
     */
    public function setAddress1(string $address1)
    {
        $this->address1 = $address1;
    }

    /**
     * Gets Buyer's appartment or suite number
     *
     * @return string Buyer's appartment or suite number
     */
    public function getAddress2()
    {
        return $this->address2;
    }

    /**
     * Sets Buyer's appartment or suite number
     *
     * @param string $address2 Buyer's appartment or suite number
     */
    public function setAddress2(string $address2)
    {
        $this->address2 = $address2;
    }

    /**
     * Gets Buyer's city or locality
     *
     * @return string Buyer's city or locality
     */
    public function getLocality()
    {
        return $this->locality;
    }

    /**
     * Sets Buyer's city or locality
     *
     * @param string $locality Buyer's city or locality
     */
    public function setLocality(string $locality)
    {
        $this->locality = $locality;
    }

    /**
     * Buyer's state or province
     *
     * @return string Buyer's state or province
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Sets Buyer's state or province
     *
     * @param string $region Buyer's state or province
     */
    public function setRegion(string $region)
    {
        $this->region = $region;
    }

    /**
     * Gets Buyer's Zip or Postal Code
     *
     * @return string Buyer's Zip or Postal Code
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * Sets Buyer's Zip or Postal Code
     *
     * @param string $postalCode Buyer's Zip or Postal Code
     */
    public function setPostalCode(string $postalCode)
    {
        $this->postalCode = $postalCode;
    }

    /**
     * Gets Buyer's Country code
     *
     * Format ISO 3166-1 alpha-2
     *
     * @return string Buyer's Country code
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Sets Buyer's Country code
     *
     * @param string $country Buyer's Country code
     */
    public function setCountry(string $country)
    {
        $this->country = $country;
    }

    /**
     * Gets Buyer's email address.
     *
     * If provided during invoice creation, this will bypass the email prompt for the consumer when opening the invoice.
     *
     * @return string Buyer's email address
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Sets Buyer's email address
     *
     * If provided during invoice creation, this will bypass the email prompt for the consumer when opening the invoice.
     *
     * @param string $email Buyer's email address
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    /**
     * Gets Buyer's phone number
     *
     * @return string Buyer's phone number
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Sets Buyer's phone number
     *
     * @param string $phone Buyer's phone number
     */
    public function setPhone(string $phone)
    {
        $this->phone = $phone;
    }

    /**
     * Gets Buyer's notify
     *
     * Indicates whether a BitPay email confirmation should be sent to the buyer once he has paid the invoice
     *
     * @return bool Buyer's notify
     */
    public function getNotify()
    {
        return $this->notify;
    }

    /**
     * Sets Buyer's notify
     *
     * Indicates whether a BitPay email confirmation should be sent to the buyer once he has paid the invoice
     *
     * @param bool $notify  Buyer's notify
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
            'name'       => $this->getName(),
            'address1'   => $this->getAddress1(),
            'address2'   => $this->getAddress2(),
            'locality'   => $this->getLocality(),
            'region'     => $this->getRegion(),
            'postalCode' => $this->getPostalCode(),
            'country'    => $this->getCountry(),
            'email'      => $this->getEmail(),
            'phone'      => $this->getPhone(),
            'notify'     => $this->getNotify(),
        ];

        foreach ($elements as $key => $value) {
            if (empty($value)) {
                unset($elements[$key]);
            }
        }

        return $elements;
    }
}
