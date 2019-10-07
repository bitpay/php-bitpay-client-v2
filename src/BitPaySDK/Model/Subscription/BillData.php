<?php


namespace BitPaySDK\Model\Subscription;


use BitPaySDK\Exceptions\BitPayException;
use BitPaySDK\Model\Currency;

class BillData
{
    protected $_emailBill;
    protected $_cc;
    protected $_number;
    protected $_currency;
    protected $_name;
    protected $_address1;
    protected $_address2;
    protected $_city;
    protected $_state;
    protected $_zip;
    protected $_country;
    protected $_email;
    protected $_phone;
    protected $_dueDate;
    protected $_passProcessingFee;
    protected $_items;
    protected $_merchant;

    public function __construct(string $currency, string $email, string $dueDate, array $items)
    {
        $this->_currency = $currency;
        $this->_email = $email;
        $this->_dueDate = $dueDate;
        $this->_items = $items;
    }

    public function getEmailBill()
    {
        return $this->_emailBill;
    }

    public function setEmailBill(bool $emailBill)
    {
        $this->_emailBill = $emailBill;
    }

    public function getCc()
    {
        return $this->_cc;
    }

    public function setCc(array $cc)
    {
        $this->_cc = $cc;
    }

    public function getNumber()
    {
        return $this->_number;
    }

    public function setNumber(string $number)
    {
        $this->_number = $number;
    }

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

    public function getMerchant()
    {
        return $this->_merchant;
    }

    public function setMerchant(string $merchant)
    {
        $this->_merchant = $merchant;
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

    public function toArray()
    {
        $elements = [
            'emailBill'         => $this->getEmailBill(),
            'cc'                => $this->getCc(),
            'number'            => $this->getNumber(),
            'currency'          => $this->getCurrency(),
            'name'              => $this->getName(),
            'address1'          => $this->getAddress1(),
            'address2'          => $this->getAddress2(),
            'city'              => $this->getCity(),
            'state'             => $this->getState(),
            'zip'               => $this->getZip(),
            'country'           => $this->getCountry(),
            'email'             => $this->getEmail(),
            'phone'             => $this->getPhone(),
            'dueDate'           => $this->getDueDate(),
            'passProcessingFee' => $this->getPassProcessingFee(),
            'items'             => $this->getItemsAsArray(),
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