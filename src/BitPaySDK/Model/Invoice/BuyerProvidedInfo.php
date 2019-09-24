<?php


namespace BitPaySDK\Model\Invoice;


class BuyerProvidedInfo
{
    protected $_name;
    protected $_phoneNumber;
    protected $_emailAddress;
    protected $_selectedTransactionCurrency;

    public function __construct()
    {
    }

    public function getName()
    {
        return $this->_name;
    }

    public function setName($name)
    {
        $this->_name = $name;
    }

    public function getPhoneNumber()
    {
        return $this->_phoneNumber;
    }

    public function setPhoneNumber($phoneNumber)
    {
        $this->_phoneNumber = $phoneNumber;
    }

    public function getEmailAddress()
    {
        return $this->_emailAddress;
    }

    public function setEmailAddress($emailAddress)
    {
        $this->_emailAddress = $emailAddress;
    }

    public function getSelectedTransactionCurrency()
    {
        return $this->_selectedTransactionCurrency;
    }

    public function setSelectedTransactionCurrency($selectedTransactionCurrency)
    {
        $this->_selectedTransactionCurrency = $selectedTransactionCurrency;
    }

    public function toArray()
    {
        $elements = [
            'name'                        => $this->getName(),
            'phoneNumber'                 => $this->getPhoneNumber(),
            'emailAddress'                => $this->getEmailAddress(),
            'selectedTransactionCurrency' => $this->getSelectedTransactionCurrency(),
        ];

        foreach ($elements as $key => $value) {
            if (empty($value)) {
                unset($elements[$key]);
            }
        }

        return $elements;
    }
}