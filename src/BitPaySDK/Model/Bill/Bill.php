<?php


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
     * @param $items    array The list of itens to add to this bill.
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

    // API fields
    //

    public function getToken()
    {
        return $this->_token;
    }

    public function setToken(string $token)
    {
        $this->_token = $token;
    }

    // Required fields
    //

    public function getCurrency()
    {
        return $this->_currency;
    }

    public function setCurrency(string $currency)
    {
        if (!Currency::isValid($currency)) {
            throw new BitPayException("currency code must be a type of Model.Currency");
        }

        $this->_currency = $currency;
    }

    public function getEmail()
    {
        return $this->_email;
    }

    public function setEmail(string $email)
    {
        $this->_email = $email;
    }

    public function getItems()
    {
        return $this->_items;
    }

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

    // Optional fields
    //

    public function getNumber()
    {
        return $this->_number;
    }

    public function setNumber(string $number)
    {
        $this->_number = $number;
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

    public function getCc()
    {
        return $this->_cc;
    }

    public function setCc(array $cc)
    {
        $this->_cc = $cc;
    }

    public function getPhone()
    {
        return $this->_phone;
    }

    public function setPhone(string $phone)
    {
        $this->_phone = $phone;
    }

    public function getDueDate()
    {
        return $this->_dueDate;
    }

    public function setDueDate(string $dueDate)
    {
        $this->_dueDate = $dueDate;
    }

    public function getPassProcessingFee()
    {
        return $this->_passProcessingFee;
    }

    public function setPassProcessingFee(bool $passProcessingFee)
    {
        $this->_passProcessingFee = $passProcessingFee;
    }

    // Response fields
    //

    public function getStatus()
    {
        return $this->_status;
    }

    public function setStatus(string $status)
    {
        $this->_status = $status;
    }

    public function getUrl()
    {
        return $this->_url;
    }

    public function setUrl(string $url)
    {
        $this->_url = $url;
    }

    public function getCreateDate()
    {
        return $this->_createDate;
    }

    public function setCreateDate(string $createDate)
    {
        $this->_createDate = $createDate;
    }

    public function getId()
    {
        return $this->_id;
    }

    public function setId(string $id)
    {
        $this->_id = $id;
    }

    public function getMerchant()
    {
        return $this->_merchant;
    }

    public function setMerchant(string $merchant)
    {
        $this->_merchant = $merchant;
    }

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
