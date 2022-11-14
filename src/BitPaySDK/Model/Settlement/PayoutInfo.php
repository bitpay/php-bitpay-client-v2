<?php

/**
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace BitPaySDK\Model\Settlement;

/**
 * Object containing the settlement info provided by the Merchant in his BitPay account settings
 */
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
    protected $_bankAddress2;
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

    /**
     * Gets Bank account number of the merchant
     *
     * @return string the bank account number
     */
    public function getAccount()
    {
        return $this->_account;
    }

    /**
     * Sets Bank account number of the merchant
     *
     * @param string $account the bank account number
     */
    public function setAccount(string $account)
    {
        $this->_account = $account;
    }

    /**
     * Gets routing
     *
     * for merchants receiving USD settlements via local ACH, this field contains the ABA provided by the merchant
     *
     * @return string the routing
     */
    public function getRouting()
    {
        return $this->_routing;
    }

    /**
     * Sets routing
     *
     * @param string $routing the routing
     */
    public function setRouting(string $routing)
    {
        $this->_routing = $routing;
    }

    /**
     * Gets merchant ein
     *
     * for merchants receiving USD settlements via local ACH, this field contains the merchant's EIN
     *
     * @return string the merchant ein
     */
    public function getMerchantEin()
    {
        return $this->_merchantEin;
    }

    /**
     * Sets merchant ein
     *
     * @param string $merchantEin the merchant ein
     */
    public function setMerchantEin(string $merchantEin)
    {
        $this->_merchantEin = $merchantEin;
    }

    /**
     * Gets label
     *
     * As indicated by the merchant in his settlement settings
     *
     * @return string the label
     */
    public function getLabel()
    {
        return $this->_label;
    }

    /**
     * Sets label
     *
     * @param string $label the label
     */
    public function setLabel(string $label)
    {
        $this->_label = $label;
    }

    /**
     * Gets Country where the merchant's bank account is located
     *
     * @return string the bank country
     */
    public function getBankCountry()
    {
        return $this->_bankCountry;
    }

    /**
     * Sets Country where the merchant's bank account is located
     *
     * @param string $bankCountry the bank country
     */
    public function setBankCountry(string $bankCountry)
    {
        $this->_bankCountry = $bankCountry;
    }

    /**
     * Gets account holder name
     *
     * @return string the name
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * Sets account holder name
     *
     * @param string $name the name
     */
    public function setName(string $name)
    {
        $this->_name = $name;
    }

    /**
     * Gets Name of the bank used by the merchant
     *
     * @return string the bank
     */
    public function getBank()
    {
        return $this->_bank;
    }

    /**
     * Sets Name of the bank used by the merchant
     *
     * @param string $bank the bank
     */
    public function setBank(string $bank)
    {
        $this->_bank = $bank;
    }

    /**
     * Gets SWIFT/BIC code of the merchant's bank.
     *
     * @return string the swift
     */
    public function getSwift()
    {
        return $this->_swift;
    }

    /**
     * Sets SWIFT/BIC code of the merchant's bank.
     *
     * @param string $swift the swift
     */
    public function setSwift(string $swift)
    {
        $this->_swift = $swift;
    }

    /**
     * Gets address
     *
     * This field is used to indicate the wallet address used for the settlement,
     * if the settlement currency selected by the merchant is one of the supported crypto currency:
     * Bitcoin (BTC), Bitcoin Cash (BCH), Dogecoin (DOGE), Ether (ETH), Gemini US Dollar (GUSD),
     * Circle USD Coin (USDC), Paxos Standard USD (PAX), Binance USD (BUSD), Dai (DAI), Wrapped Bitcoin (WBTC),
     * and Ripple (XRP). If the settlement currency used is AUD, GBP, NZD, MXN, ZAR -
     * this field is used to indicate the address of the merchant's bank
     *
     * @return string the address
     */
    public function getAddress()
    {
        return $this->_address;
    }

    /**
     * Sets address
     *
     * @param string $address the address
     */
    public function setAddress(string $address)
    {
        $this->_address = $address;
    }

    /**
     * Gets City of the merchant bank, field return if the settlement currency is
     *
     * @return string the city
     */
    public function getCity()
    {
        return $this->_city;
    }

    /**
     * Sets city of the merchant bank
     *
     * @param string $city the city
     */
    public function setCity(string $city)
    {
        $this->_city = $city;
    }

    /**
     * Gets Postal code of the merchant bank, field return if the settlement currency is
     *
     * @return string the postal
     */
    public function getPostal()
    {
        return $this->_postal;
    }

    /**
     * Sets Postal code of the merchant bank
     *
     * @param string $postal the postal
     */
    public function setPostal(string $postal)
    {
        $this->_postal = $postal;
    }

    /**
     * Gets sort
     *
     * used to pass country specific bank fields: BSB for AUD
     *
     * @return string
     */
    public function getSort()
    {
        return $this->_sort;
    }

    /**
     * Sets sort
     *
     * @param string $sort the sort
     */
    public function setSort(string $sort)
    {
        $this->_sort = $sort;
    }

    /**
     * Gets wire
     *
     * If set to true, this means BitPay will be settling the account using an international transfer via the SWIFT
     * network instead of local settlement methods like ACH(United States) or SEPA (European Economic Area)
     *
     * @return string the wire
     */
    public function getWire()
    {
        return $this->_wire;
    }

    /**
     * Sets wire
     *
     * @param string $wire the wire
     */
    public function setWire(string $wire)
    {
        $this->_wire = $wire;
    }

    /**
     * Gets bank name
     *
     * Name of the bank used by the merchant. Field returned if "wire": true in the "payoutInfo" object
     *
     * @return string the bank name
     */
    public function getBankName()
    {
        return $this->_bankName;
    }

    /**
     * Sets bank name
     *
     * @param string $bankName the bank name
     */
    public function setBankName(string $bankName)
    {
        $this->_bankName = $bankName;
    }

    /**
     * Gets bank address
     *
     * Address of the merchant's bank. Field returned if "wire": true in the "payoutInfo" object
     *
     * @return string the bank address
     */
    public function getBankAddress()
    {
        return $this->_bankAddress;
    }

    /**
     * Sets bank address
     *
     * @param string $bankAddress the bank address
     */
    public function setBankAddress(string $bankAddress)
    {
        $this->_bankAddress = $bankAddress;
    }

    /**
     * Gets bank address 2
     *
     * Address of the merchant's bank. Field returned if "wire": true in the "payoutInfo" object
     *
     * @return string the bank address2
     */
    public function getBankAddress2()
    {
        return $this->_bankAddress2;
    }

    /**
     * Sets bank address2
     *
     * @param string $bankAddress2 the bank address2
     */
    public function setBankAddress2(string $bankAddress2)
    {
        $this->_bankAddress2 = $bankAddress2;
    }

    /**
     * Gets iban
     *
     * The merchant's bank account number, in the IBAN (International Bank Account Number) format.
     * Field returned if "wire": true in the "payoutInfo" object
     *
     * @return string the iban
     */
    public function getIban()
    {
        return $this->_iban;
    }

    /**
     * Sets iban
     *
     * @param string $iban the iban
     * @return void
     */
    public function setIban(string $iban)
    {
        $this->_iban = $iban;
    }

    /**
     * Gets additional information
     *
     * When providing the settlement info via the dashboard, this field can be used by the merchant to provide
     * additional information about the receiving bank. Field returned if "wire": true in the "payoutInfo" object
     *
     * @return string the additional information
     */
    public function getAdditionalInformation()
    {
        return $this->_additionalInformation;
    }

    /**
     * Sets additional information
     *
     * @param string $additionalInformation the additional information
     */
    public function setAdditionalInformation(string $additionalInformation)
    {
        $this->_additionalInformation = $additionalInformation;
    }

    /**
     * Gets Bank account holder name
     *
     * @return string the bank account holder name
     */
    public function getAccountHolderName()
    {
        return $this->_accountHolderName;
    }

    /**
     * Sets Bank account holder name
     *
     * @param string $accountHolderName the bank account holder name
     */
    public function setAccountHolderName(string $accountHolderName)
    {
        $this->_accountHolderName = $accountHolderName;
    }

    /**
     * Gets Bank account holder address
     *
     * @return string the bank account holder address
     */
    public function getAccountHolderAddress()
    {
        return $this->_accountHolderAddress;
    }

    /**
     * Sets Bank account holder address2
     *
     * @param string $accountHolderAddress the bank account holder address
     */
    public function setAccountHolderAddress(string $accountHolderAddress)
    {
        $this->_accountHolderAddress = $accountHolderAddress;
    }

    /**
     * Gets Bank account holder address2
     *
     * @return string the bank account holder address2
     */
    public function getAccountHolderAddress2()
    {
        return $this->_accountHolderAddress2;
    }

    /**
     * Sets Bank account holder address2
     *
     * @param string $accountHolderAddress2 the bank account holder address2
     */
    public function setAccountHolderAddress2(string $accountHolderAddress2)
    {
        $this->_accountHolderAddress2 = $accountHolderAddress2;
    }

    /**
     * Gets Bank account holder postal code
     *
     * @return string the bank account holder postal code
     */
    public function getAccountHolderPostalCode()
    {
        return $this->_accountHolderPostalCode;
    }

    /**
     * Sets Bank account holder postal code
     *
     * @param string $accountHolderPostalCode the bank account holder postal code
     */
    public function setAccountHolderPostalCode(string $accountHolderPostalCode)
    {
        $this->_accountHolderPostalCode = $accountHolderPostalCode;
    }

    /**
     * Gets Bank account holder city
     *
     * @return string the bank account holder city
     */
    public function getAccountHolderCity()
    {
        return $this->_accountHolderCity;
    }

    /**
     * Sets Bank account holder city
     *
     * @param string $accountHolderCity the bank account holder city
     */
    public function setAccountHolderCity(string $accountHolderCity)
    {
        $this->_accountHolderCity = $accountHolderCity;
    }

    /**
     * Gets Bank account holder country
     *
     * @return string the bank account holder country
     */
    public function getAccountHolderCountry()
    {
        return $this->_accountHolderCountry;
    }

    /**
     * Sets Bank account holder country
     *
     * @param string $accountHolderCountry the bank account holder country
     */
    public function setAccountHolderCountry(string $accountHolderCountry)
    {
        $this->_accountHolderCountry = $accountHolderCountry;
    }

    /**
     * Gets PayoutInfo as array
     *
     * @return array PayoutInfo as array
     */
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
