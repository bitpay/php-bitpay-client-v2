<?php


namespace BitPaySDK\Model\Settlement;


class PayoutInfo
{
    protected $_name;
    protected $_account;
    protected $_routing;
    protected $_merchantEin;
    protected $_label;
    protected $_bankCountry;
    protected $_bank;
    protected $_swift;
    protected $_address;
    protected $_city;
    protected $_postal;
    protected $_sort;
    protected $_wire;
    protected $_bankName;
    protected $_bankAddress;
    protected $_iban;
    protected $_additionalInformation;
    protected $_accountHolderName;
    protected $_accountHolderAddress;
    protected $_accountHolderAddress2;
    protected $_accountHolderPostalCode;
    protected $_accountHolderCity;
    protected $_accountHolderCountry;

    public function __construct()
    {
    }

    public function getAccount()
    {
        return $this->_account;
    }

    public function setAccount(string $account)
    {
        $this->_account = $account;
    }

    public function getRouting()
    {
        return $this->_routing;
    }

    public function setRouting(string $routing)
    {
        $this->_routing = $routing;
    }

    public function getMerchantEin()
    {
        return $this->_merchantEin;
    }

    public function setMerchantEin(string $merchantEin)
    {
        $this->_merchantEin = $merchantEin;
    }

////////////////////////////////////////////////////////////////////////////////////////
    public function getLabel()
    {
        return $this->_label;
    }

    public function setLabel(string $label)
    {
        $this->_label = $label;
    }

    public function getBankCountry()
    {
        return $this->_bankCountry;
    }

    public function setBankCountry(string $bankCountry)
    {
        $this->_bankCountry = $bankCountry;
    }

    public function getName()
    {
        return $this->_name;
    }

    public function setName(string $name)
    {
        $this->_name = $name;
    }

    public function getBank()
    {
        return $this->_bank;
    }

    public function setBank(string $bank)
    {
        $this->_bank = $bank;
    }

    public function getSwift()
    {
        return $this->_swift;
    }

    public function setSwift(string $swift)
    {
        $this->_swift = $swift;
    }

    public function getAddress()
    {
        return $this->_address;
    }

    public function setAddress(string $address)
    {
        $this->_address = $address;
    }

    public function getCity()
    {
        return $this->_city;
    }

    public function setCity(string $city)
    {
        $this->_city = $city;
    }

    public function getPostal()
    {
        return $this->_postal;
    }

    public function setPostal(string $postal)
    {
        $this->_postal = $postal;
    }

    public function getSort()
    {
        return $this->_sort;
    }

    public function setSort(string $sort)
    {
        $this->_sort = $sort;
    }

    public function getWire()
    {
        return $this->_wire;
    }

    public function setWire(string $wire)
    {
        $this->_wire = $wire;
    }

    public function getBankName()
    {
        return $this->_bankName;
    }

    public function setBankName(string $bankName)
    {
        $this->_bankName = $bankName;
    }

    public function getBankAddress()
    {
        return $this->_bankAddress;
    }

    public function setBankAddress(string $bankAddress)
    {
        $this->_bankAddress = $bankAddress;
    }

    public function getIban()
    {
        return $this->_iban;
    }

    public function setIban(string $iban)
    {
        $this->_iban = $iban;
    }

    public function getAdditionalInformation()
    {
        return $this->_additionalInformation;
    }

    public function setAdditionalInformation(string $additionalInformation)
    {
        $this->_additionalInformation = $additionalInformation;
    }

    public function getAccountHolderName()
    {
        return $this->_accountHolderName;
    }

    public function setAccountHolderName(string $accountHolderName)
    {
        $this->_accountHolderName = $accountHolderName;
    }

    public function getAccountHolderAddress()
    {
        return $this->_accountHolderAddress;
    }

    public function setAccountHolderAddress(string $accountHolderAddress)
    {
        $this->_accountHolderAddress = $accountHolderAddress;
    }

    public function getAccountHolderAddress2()
    {
        return $this->_accountHolderAddress2;
    }

    public function setAccountHolderAddress2(string $accountHolderAddress2)
    {
        $this->_accountHolderAddress2 = $accountHolderAddress2;
    }

    public function getAccountHolderPostalCode()
    {
        return $this->_accountHolderPostalCode;
    }

    public function setAccountHolderPostalCode(string $accountHolderPostalCode)
    {
        $this->_accountHolderPostalCode = $accountHolderPostalCode;
    }

    public function getAccountHolderCity()
    {
        return $this->_accountHolderCity;
    }

    public function setAccountHolderCity(string $accountHolderCity)
    {
        $this->_accountHolderCity = $accountHolderCity;
    }

    public function getAccountHolderCountry()
    {
        return $this->_accountHolderCountry;
    }

    public function setAccountHolderCountry(string $accountHolderCountry)
    {
        $this->_accountHolderCountry = $accountHolderCountry;
    }

    public function toArray()
    {
        $elements = [
            'label'                   => $this->getLabel(),
            'bankCountry'             => $this->getBankCountry(),
            'name'                    => $this->getName(),
            'bank'                    => $this->getBank(),
            'swift'                   => $this->getSwift(),
            'address'                 => $this->getAddress(),
            'city'                    => $this->getCity(),
            'postal'                  => $this->getPostal(),
            'sort'                    => $this->getSort(),
            'wire'                    => $this->getWire(),
            'bankName'                => $this->getBankName(),
            'bankAddress'             => $this->getBankAddress(),
            'iban'                    => $this->getIban(),
            'additionalInformation'   => $this->getAdditionalInformation(),
            'accountHolderName'       => $this->getAccountHolderName(),
            'accountHolderAddress'    => $this->getAccountHolderAddress(),
            'accountHolderAddress2'   => $this->getAccountHolderAddress2(),
            'accountHolderPostalCode' => $this->getAccountHolderPostalCode(),
            'accountHolderCity'       => $this->getAccountHolderCity(),
            'accountHolderCountry'    => $this->getAccountHolderCountry(),
        ];

        return $elements;
    }
}