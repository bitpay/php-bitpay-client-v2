<?php


namespace BitPaySDK\Model\Invoice;


class BuyerProvidedInfo
{
    protected $_name;
    protected $_phoneNumber;
    protected $_selectedWallet;
    protected $_emailAddress;
    protected $_selectedTransactionCurrency;
    protected $_sms;
    protected $_smsVerified;

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

    public function getSelectedWallet()
    {
        return $this->_selectedWallet;
    }

    public function setSelectedWallet(string $selectedWallet)
    {
        $this->_selectedWallet = $selectedWallet;
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

    public function setSelectedTransactionCurrency(string $selectedTransactionCurrency)
    {
        $this->_selectedTransactionCurrency = $selectedTransactionCurrency;
    }

    public function getSms()
    {
        return $this->_sms;
    }

    public function setSms(string $sms)
    {
        $this->_sms = $sms;
    }

    public function getSmsVerified()
    {
        return $this->_smsVerified;
    }

    public function setSmsVerified(bool $smsVerified)
    {
        $this->_smsVerified = $smsVerified;
    }

    public function toArray()
    {
        $elements = [
            'name'                        => $this->getName(),
            'phoneNumber'                 => $this->getPhoneNumber(),
            'selectedWallet'              => $this->getSelectedWallet(),
            'emailAddress'                => $this->getEmailAddress(),
            'selectedTransactionCurrency' => $this->getSelectedTransactionCurrency(),
            'sms'                         => $this->getSms(),
            'smsVerified'                 => $this->getSmsVerified()
        ];

        foreach ($elements as $key => $value) {
            if (empty($value)) {
                unset($elements[$key]);
            }
        }

        return $elements;
    }
}