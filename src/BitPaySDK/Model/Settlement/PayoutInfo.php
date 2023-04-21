<?php

/**
 * Copyright (c) 2019 BitPay
 **/

declare(strict_types=1);

/*
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace BitPaySDK\Model\Settlement;

/**
 * Object containing the settlement info provided by the Merchant in his BitPay account settings.
 * @see <a href="https://bitpay.readme.io/reference/settlements">Settlements</a>
 */
class PayoutInfo
{
    protected ?string $name = null;
    protected ?string $account = null;
    protected ?string $routing = null;
    protected ?string $merchantEin = null;
    protected ?string $label = null;
    protected ?string $bankCountry = null;
    protected ?string $bank = null;
    protected ?string $swift = null;
    protected ?string $address = null;
    protected ?string $city = null;
    protected ?string $postal = null;
    protected ?string $sort = null;
    protected ?string $wire = null;
    protected ?string $bankName = null;
    protected ?string $bankAddress = null;
    protected ?string $bankAddress2 = null;
    protected ?string $iban = null;
    protected ?string $additionalInformation = null;
    protected ?string $accountHolderName = null;
    protected ?string $accountHolderAddress = null;
    protected ?string $accountHolderAddress2 = null;
    protected ?string $accountHolderPostalCode = null;
    protected ?string $accountHolderCity = null;
    protected ?string $accountHolderCountry = null;

    public function __construct()
    {
    }

    /**
     * Gets Bank account number of the merchant
     *
     * @return string|null the bank account number
     */
    public function getAccount(): ?string
    {
        return $this->account;
    }

    /**
     * Sets Bank account number of the merchant
     *
     * @param string $account the bank account number
     */
    public function setAccount(string $account): void
    {
        $this->account = $account;
    }

    /**
     * Gets routing
     *
     * for merchants receiving USD settlements via local ACH, this field contains the ABA provided by the merchant
     *
     * @return string|null the routing
     */
    public function getRouting(): ?string
    {
        return $this->routing;
    }

    /**
     * Sets routing
     *
     * @param string $routing the routing
     */
    public function setRouting(string $routing): void
    {
        $this->routing = $routing;
    }

    /**
     * Gets merchant ein
     *
     * for merchants receiving USD settlements via local ACH, this field contains the merchant's EIN
     *
     * @return string|null the merchant ein
     */
    public function getMerchantEin(): ?string
    {
        return $this->merchantEin;
    }

    /**
     * Sets merchant ein
     *
     * @param string $merchantEin the merchant ein
     */
    public function setMerchantEin(string $merchantEin): void
    {
        $this->merchantEin = $merchantEin;
    }

    /**
     * Gets label
     *
     * As indicated by the merchant in his settlement settings
     *
     * @return string|null the label
     */
    public function getLabel(): ?string
    {
        return $this->label;
    }

    /**
     * Sets label
     *
     * @param string $label the label
     */
    public function setLabel(string $label): void
    {
        $this->label = $label;
    }

    /**
     * Gets Country where the merchant's bank account is located
     *
     * @return string|null the bank country
     */
    public function getBankCountry(): ?string
    {
        return $this->bankCountry;
    }

    /**
     * Sets Country where the merchant's bank account is located
     *
     * @param string $bankCountry the bank country
     */
    public function setBankCountry(string $bankCountry): void
    {
        $this->bankCountry = $bankCountry;
    }

    /**
     * Gets account holder name
     *
     * @return string|null the name
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Sets account holder name
     *
     * @param string $name the name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Gets Name of the bank used by the merchant
     *
     * @return string|null the bank
     */
    public function getBank(): ?string
    {
        return $this->bank;
    }

    /**
     * Sets Name of the bank used by the merchant
     *
     * @param string $bank the bank
     */
    public function setBank(string $bank): void
    {
        $this->bank = $bank;
    }

    /**
     * Gets SWIFT/BIC code of the merchant's bank.
     *
     * @return string|null the swift
     */
    public function getSwift(): ?string
    {
        return $this->swift;
    }

    /**
     * Sets SWIFT/BIC code of the merchant's bank.
     *
     * @param string $swift the swift
     */
    public function setSwift(string $swift): void
    {
        $this->swift = $swift;
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
     * @return string|null the address
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * Sets address
     *
     * @param string $address the address
     */
    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    /**
     * Gets City of the merchant bank, field return if the settlement currency is
     *
     * @return string|null the city
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * Sets city of the merchant bank
     *
     * @param string $city the city
     */
    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    /**
     * Gets Postal code of the merchant bank, field return if the settlement currency is
     *
     * @return string|null the postal
     */
    public function getPostal(): ?string
    {
        return $this->postal;
    }

    /**
     * Sets Postal code of the merchant bank
     *
     * @param string $postal the postal
     */
    public function setPostal(string $postal): void
    {
        $this->postal = $postal;
    }

    /**
     * Gets sort
     *
     * used to pass country specific bank fields: BSB for AUD
     *
     * @return string|null
     */
    public function getSort(): ?string
    {
        return $this->sort;
    }

    /**
     * Sets sort
     *
     * @param string $sort the sort
     */
    public function setSort(string $sort): void
    {
        $this->sort = $sort;
    }

    /**
     * Gets wire
     *
     * If set to true, this means BitPay will be settling the account using an international transfer via the SWIFT
     * network instead of local settlement methods like ACH(United States) or SEPA (European Economic Area)
     *
     * @return string|null the wire
     */
    public function getWire(): ?string
    {
        return $this->wire;
    }

    /**
     * Sets wire
     *
     * @param string $wire the wire
     */
    public function setWire(string $wire): void
    {
        $this->wire = $wire;
    }

    /**
     * Gets bank name
     *
     * Name of the bank used by the merchant. Field returned if "wire": true in the "payoutInfo" object
     *
     * @return string|null the bank name
     */
    public function getBankName(): ?string
    {
        return $this->bankName;
    }

    /**
     * Sets bank name
     *
     * @param string $bankName the bank name
     */
    public function setBankName(string $bankName): void
    {
        $this->bankName = $bankName;
    }

    /**
     * Gets bank address
     *
     * Address of the merchant's bank. Field returned if "wire": true in the "payoutInfo" object
     *
     * @return string|null the bank address
     */
    public function getBankAddress(): ?string
    {
        return $this->bankAddress;
    }

    /**
     * Sets bank address
     *
     * @param string $bankAddress the bank address
     */
    public function setBankAddress(string $bankAddress): void
    {
        $this->bankAddress = $bankAddress;
    }

    /**
     * Gets bank address 2
     *
     * Address of the merchant's bank. Field returned if "wire": true in the "payoutInfo" object
     *
     * @return string|null the bank address2
     */
    public function getBankAddress2(): ?string
    {
        return $this->bankAddress2;
    }

    /**
     * Sets bank address2
     *
     * @param string $bankAddress2 the bank address2
     */
    public function setBankAddress2(string $bankAddress2): void
    {
        $this->bankAddress2 = $bankAddress2;
    }

    /**
     * Gets iban
     *
     * The merchant's bank account number, in the IBAN (International Bank Account Number) format.
     * Field returned if "wire": true in the "payoutInfo" object
     *
     * @return string|null the iban
     */
    public function getIban(): ?string
    {
        return $this->iban;
    }

    /**
     * Sets iban
     *
     * @param string $iban the iban
     * @return void
     */
    public function setIban(string $iban): void
    {
        $this->iban = $iban;
    }

    /**
     * Gets additional information
     *
     * When providing the settlement info via the dashboard, this field can be used by the merchant to provide
     * additional information about the receiving bank. Field returned if "wire": true in the "payoutInfo" object
     *
     * @return string|null the additional information
     */
    public function getAdditionalInformation(): ?string
    {
        return $this->additionalInformation;
    }

    /**
     * Sets additional information
     *
     * @param string $additionalInformation the additional information
     */
    public function setAdditionalInformation(string $additionalInformation): void
    {
        $this->additionalInformation = $additionalInformation;
    }

    /**
     * Gets Bank account holder name
     *
     * @return string|null the bank account holder name
     */
    public function getAccountHolderName(): ?string
    {
        return $this->accountHolderName;
    }

    /**
     * Sets Bank account holder name
     *
     * @param string $accountHolderName the bank account holder name
     */
    public function setAccountHolderName(string $accountHolderName): void
    {
        $this->accountHolderName = $accountHolderName;
    }

    /**
     * Gets Bank account holder address
     *
     * @return string|null the bank account holder address
     */
    public function getAccountHolderAddress(): ?string
    {
        return $this->accountHolderAddress;
    }

    /**
     * Sets Bank account holder address2
     *
     * @param string $accountHolderAddress the bank account holder address
     */
    public function setAccountHolderAddress(string $accountHolderAddress): void
    {
        $this->accountHolderAddress = $accountHolderAddress;
    }

    /**
     * Gets Bank account holder address2
     *
     * @return string|null the bank account holder address2
     */
    public function getAccountHolderAddress2(): ?string
    {
        return $this->accountHolderAddress2;
    }

    /**
     * Sets Bank account holder address2
     *
     * @param string $accountHolderAddress2 the bank account holder address2
     */
    public function setAccountHolderAddress2(string $accountHolderAddress2): void
    {
        $this->accountHolderAddress2 = $accountHolderAddress2;
    }

    /**
     * Gets Bank account holder postal code
     *
     * @return string|null the bank account holder postal code
     */
    public function getAccountHolderPostalCode(): ?string
    {
        return $this->accountHolderPostalCode;
    }

    /**
     * Sets Bank account holder postal code
     *
     * @param string $accountHolderPostalCode the bank account holder postal code
     */
    public function setAccountHolderPostalCode(string $accountHolderPostalCode): void
    {
        $this->accountHolderPostalCode = $accountHolderPostalCode;
    }

    /**
     * Gets Bank account holder city
     *
     * @return string|null the bank account holder city
     */
    public function getAccountHolderCity(): ?string
    {
        return $this->accountHolderCity;
    }

    /**
     * Sets Bank account holder city
     *
     * @param string $accountHolderCity the bank account holder city
     */
    public function setAccountHolderCity(string $accountHolderCity): void
    {
        $this->accountHolderCity = $accountHolderCity;
    }

    /**
     * Gets Bank account holder country
     *
     * @return string|null the bank account holder country
     */
    public function getAccountHolderCountry(): ?string
    {
        return $this->accountHolderCountry;
    }

    /**
     * Sets Bank account holder country
     *
     * @param string $accountHolderCountry the bank account holder country
     */
    public function setAccountHolderCountry(string $accountHolderCountry): void
    {
        $this->accountHolderCountry = $accountHolderCountry;
    }

    /**
     * Gets PayoutInfo as array
     *
     * @return array PayoutInfo as array
     */
    public function toArray(): array
    {
        return [
            'label' => $this->getLabel(),
            'bankCountry' => $this->getBankCountry(),
            'name' => $this->getName(),
            'bank' => $this->getBank(),
            'swift' => $this->getSwift(),
            'address' => $this->getAddress(),
            'city' => $this->getCity(),
            'postal' => $this->getPostal(),
            'sort' => $this->getSort(),
            'wire' => $this->getWire(),
            'bankName' => $this->getBankName(),
            'bankAddress' => $this->getBankAddress(),
            'iban' => $this->getIban(),
            'additionalInformation' => $this->getAdditionalInformation(),
            'accountHolderName' => $this->getAccountHolderName(),
            'accountHolderAddress' => $this->getAccountHolderAddress(),
            'accountHolderAddress2' => $this->getAccountHolderAddress2(),
            'accountHolderPostalCode' => $this->getAccountHolderPostalCode(),
            'accountHolderCity' => $this->getAccountHolderCity(),
            'accountHolderCountry' => $this->getAccountHolderCountry(),
        ];
    }
}
