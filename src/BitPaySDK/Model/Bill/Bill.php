<?php

/**
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace BitPaySDK\Model\Bill;

use BitPaySDK\Exceptions\BitPayException;
use BitPaySDK\Model\Currency;

/**
 *
 * @package Bitpay
 */
class Bill
{
    protected $_currency;
    protected $_token = "";
    protected $_email;
    protected $_items;
    protected $_number;
    protected $_name;
    protected $_address1;
    protected $_address2;
    protected $_city;
    protected $_state;
    protected $_zip;
    protected $_country;
    protected $_cc;
    protected $_phone;
    protected $_dueDate;
    protected $_passProcessingFee;
    protected $_status;
    protected $_url;
    protected $_createDate;
    protected $_id;
    protected $_merchant;

    /**
     * Constructor, create a minimal request Bill object.
     *
     * @param $number   string A string for tracking purposes.
     * @param $currency string The three digit currency type used to compute the bill's amount.
     * @param $email    string The email address of the receiver for this bill.
     * @param $items    array The list of items to add to this bill.
     */
    public function __construct(
        string $number = null,
        string $currency = null,
        string $email = null,
        array $items = null
    ) {
        $this->_number = $number;
        $this->_currency = $currency;
        $this->_email = $email;
        $this->_items = $items;
    }

    /**
     * Gets token
     *
     * API token for bill resource. This token is actually derived from the API token used to
     * create the bill and is tied to the specific resource id created.
     *
     * @return string the token
     */
    public function getToken()
    {
        return $this->_token;
    }

    /**
     * Sets Bill's token
     *
     * API token for bill resource. This token is actually derived from the API token used to
     * create the bill and is tied to the specific resource id created.
     *
     * @param string $token the token
     */
    public function setToken(string $token)
    {
        $this->_token = $token;
    }

    /**
     * Gets bill currency
     *
     * ISO 4217 3-character currency code. This is the currency associated with the price field
     *
     * @return string the bill currency
     */
    public function getCurrency()
    {
        return $this->_currency;
    }

    /**
     * Sets Bill's currency
     *
     * ISO 4217 3-character currency code. This is the currency associated with the price field
     *
     * @param string $currency the currency
     * @throws BitPayException
     */
    public function setCurrency(string $currency)
    {
        if (!Currency::isValid($currency)) {
            throw new BitPayException("currency code must be a type of Model.Currency");
        }

        $this->_currency = $currency;
    }

    /**
     * Gets bill email
     *
     * @return string the email
     */
    public function getEmail()
    {
        return $this->_email;
    }

    /**
     * Sets Bill's email
     *
     * @param string $email the email
     */
    public function setEmail(string $email)
    {
        $this->_email = $email;
    }

    /**
     * Gets items from bill
     *
     * @return array items object from bill
     */
    public function getItems()
    {
        return $this->_items;
    }

    /**
     * Gets items as array from bill
     *
     * @return array items as array from bill
     */
    public function getItemsAsArray()
    {
        $items = [];

        foreach ($this->_items as $item) {
            if ($item instanceof Item) {
                array_push($items, $item->toArray());
            } else {
                array_push($items, $item);
            }
        }

        return $items;
    }

    /**
     * Sets Bill's items
     *
     * @param array $items items in bill
     */
    public function setItems(array $items)
    {
        $itemsArray = [];

        foreach ($items as $item) {
            if ($item instanceof Item) {
                array_push($itemsArray, $item);
            } else {
                array_push($itemsArray, Item::createFromArray((array)$item));
            }
        }
        $this->_items = $itemsArray;
    }

    /**
     * Gets bill number
     *
     * Bill identifier, specified by merchant
     *
     * @return string the number
     */
    public function getNumber()
    {
        return $this->_number;
    }

    /**
     * Sets Bill's number
     *
     * Bill identifier, specified by merchant
     *
     * @param string $number the number
     */
    public function setNumber(string $number)
    {
        $this->_number = $number;
    }

    /**
     * Gets Bill recipient's name
     *
     * @return string the name
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * Sets Bill recipient's name
     *
     * @param string $name the name
     */
    public function setName(string $name)
    {
        $this->_name = $name;
    }

    /**
     * Gets Bill recipient's address
     *
     * @return string the address1
     */
    public function getAddress1()
    {
        return $this->_address1;
    }

    /**
     * Sets Bill recipient's address
     *
     * @param string $address1
     */
    public function setAddress1(string $address1)
    {
        $this->_address1 = $address1;
    }

    /**
     * Gets Bill recipient's address
     *
     * @return string the address2
     */
    public function getAddress2()
    {
        return $this->_address2;
    }

    /**
     * Sets Bill recipient's address
     *
     * @param string $address2
     */
    public function setAddress2(string $address2)
    {
        $this->_address2 = $address2;
    }

    /**
     * Gets Bill recipient's city
     *
     * @return string the city
     */
    public function getCity()
    {
        return $this->_city;
    }

    /**
     * Sets Bill recipient's city
     *
     * @param string $city
     */
    public function setCity(string $city)
    {
        $this->_city = $city;
    }

    /**
     * Gets Bill recipient's state or province
     *
     * @return string the state
     */
    public function getState()
    {
        return $this->_state;
    }

    /**
     * Sets Bill recipient's state or province
     *
     * @param string $state
     */
    public function setState(string $state)
    {
        $this->_state = $state;
    }

    /**
     * Gets Bill recipient's ZIP code
     *
     * @return string the zip
     */
    public function getZip()
    {
        return $this->_zip;
    }

    /**
     * Sets Bill recipient's ZIP code
     *
     * @param string $zip
     */
    public function setZip(string $zip)
    {
        $this->_zip = $zip;
    }

    /**
     * Gets Bill recipient's country
     *
     * @return string the country
     */
    public function getCountry()
    {
        return $this->_country;
    }

    /**
     * Sets Bill recipient's country
     *
     * @param string $country
     */
    public function setCountry(string $country)
    {
        $this->_country = $country;
    }

    /**
     * Gets Bill cc
     *
     * Email addresses to which a copy of the bill must be sent
     *
     * @return array the cc
     */
    public function getCc()
    {
        return $this->_cc;
    }

    /**
     * Sets Bill's cc
     *
     * Email addresses to which a copy of the bill must be sent
     *
     * @param array $cc
     */
    public function setCc(array $cc)
    {
        $this->_cc = $cc;
    }

    /**
     * Gets Bill recipient's phone number
     *
     * @return string the phone
     */
    public function getPhone()
    {
        return $this->_phone;
    }

    /**
     * Sets Bill recipient's phone number
     *
     * @param string $phone
     */
    public function setPhone(string $phone)
    {
        $this->_phone = $phone;
    }

    /**
     * Gets Bill due date
     *
     * Date and time at which a bill is due, ISO-8601 format yyyy-mm-ddThh:mm:ssZ. (UTC)
     *
     * @return string the number
     */
    public function getDueDate()
    {
        return $this->_dueDate;
    }

    /**
     * Sets Bill's due date
     *
     * Date and time at which a bill is due, ISO-8601 format yyyy-mm-ddThh:mm:ssZ. (UTC)
     *
     * @param string $dueDate
     */
    public function setDueDate(string $dueDate)
    {
        $this->_dueDate = $dueDate;
    }

    /**
     * Gets bill pass processing fee
     *
     * @return bool the pass processing fee
     */
    public function getPassProcessingFee()
    {
        return $this->_passProcessingFee;
    }

    /**
     * Sets Bill's pass processing fee
     *
     * If set to true, BitPay's processing fee will be included in the amount charged on the invoice
     *
     * @param bool $passProcessingFee
     */
    public function setPassProcessingFee(bool $passProcessingFee)
    {
        $this->_passProcessingFee = $passProcessingFee;
    }

    /**
     * Gets bill status
     *
     * Can "draft", "sent", "new", "paid", or "complete"
     *
     * @return string the status
     */
    public function getStatus()
    {
        return $this->_status;
    }

    /**
     * Sets Bill's status
     *
     * Can "draft", "sent", "new", "paid", or "complete"
     *
     * @param string $status
     */
    public function setStatus(string $status)
    {
        $this->_status = $status;
    }

    /**
     * Gets bill url
     *
     * Web address of bill
     *
     * @return string the url
     */
    public function getUrl()
    {
        return $this->_url;
    }

    /**
     * Sets Bill's url
     *
     * Web address of bill
     *
     * @param string $url
     */
    public function setUrl(string $url)
    {
        $this->_url = $url;
    }

    /**
     * Gets bill create date
     *
     * Date and time of Bill creation, ISO-8601 format yyyy-mm-ddThh:mm:ssZ. (UTC)
     *
     * @return string the create date
     */
    public function getCreateDate()
    {
        return $this->_createDate;
    }

    /**
     * Sets Bill's create date
     *
     * Date and time of Bill creation, ISO-8601 format yyyy-mm-ddThh:mm:ssZ. (UTC)
     *
     * @param string $createDate
     */
    public function setCreateDate(string $createDate)
    {
        $this->_createDate = $createDate;
    }

    /**
     * Gets bill id
     *
     * Bill resource id
     *
     * @return string the id
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * Sets Bill's id
     *
     * Bill resource id
     *
     * @param string $id
     */
    public function setId(string $id)
    {
        $this->_id = $id;
    }

    /**
     * Gets bill merchant
     *
     * Internal identifier for BitPay, this field can be ignored by the merchants.
     *
     * @return string the merchant
     */
    public function getMerchant()
    {
        return $this->_merchant;
    }

    /**
     * Sets Bill's merchant
     *
     * Internal identifier for BitPay, this field can be ignored by the merchants.
     *
     * @param string $merchant
     */
    public function setMerchant(string $merchant)
    {
        $this->_merchant = $merchant;
    }

    /**
     * Get bill data as array
     *
     * @return array bill data as array
     */
    public function toArray()
    {
        $elements = [
            'currency'          => $this->getCurrency(),
            'token'             => $this->getToken(),
            'email'             => $this->getEmail(),
            'items'             => $this->getItemsAsArray(),
            'number'            => $this->getNumber(),
            'name'              => $this->getName(),
            'address1'          => $this->getAddress1(),
            'address2'          => $this->getAddress2(),
            'city'              => $this->getCity(),
            'state'             => $this->getState(),
            'zip'               => $this->getZip(),
            'country'           => $this->getCountry(),
            'cc'                => $this->getCc(),
            'phone'             => $this->getPhone(),
            'dueDate'           => $this->getDueDate(),
            'passProcessingFee' => $this->getPassProcessingFee(),
            'status'            => $this->getStatus(),
            'url'               => $this->getUrl(),
            'createDate'        => $this->getCreateDate(),
            'id'                => $this->getId(),
            'merchant'          => $this->getMerchant(),
        ];

        foreach ($elements as $key => $value) {
            if (empty($value)) {
                unset($elements[$key]);
            }
        }

        return $elements;
    }
}
