<?php

/**
 * Copyright (c) 2019 BitPay
 **/

declare(strict_types=1);

/*
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace BitPaySDK\Model\Invoice;

/**
 * Information collected from the buyer during the process of paying an invoice. Initially this object is empty.
 * @see <a href="https://bitpay.readme.io/reference/invoices">REST API Invoices</a>
 */
class BuyerProvidedInfo
{
    protected ?string $name = null;
    protected ?string $phoneNumber = null;
    protected ?string $selectedWallet = null;
    protected ?string $emailAddress = null;
    protected ?string $selectedTransactionCurrency = null;
    protected ?string $sms = null;
    protected ?bool $smsVerified = null;

    public function __construct()
    {
    }

    /**
     * Gets name
     *
     * Populated with the buyer's name address if passed in the buyer object by the merchant
     *
     * @return string|null the name
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Sets name
     *
     * Populated with the buyer's name address if passed in the buyer object by the merchant
     *
     * @param string $name the name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Gets phone number
     *
     * Populated with the buyer's phone number if passed in the buyer object by the merchant
     *
     * @return string|null the phone number
     */
    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    /**
     * Sets phone number
     *
     * Populated with the buyer's phone number if passed in the buyer object by the merchant
     *
     * @param string $phoneNumber the phone number
     */
    public function setPhoneNumber(string $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * Gets selected wallet
     *
     * This field contains the name of the cryptocurrency wallet selected by the shopper to complete the payment.
     *
     * @return string|null the selected wallet
     */
    public function getSelectedWallet(): ?string
    {
        return $this->selectedWallet;
    }

    /**
     * Sets selected wallet
     *
     * This field contains the name of the cryptocurrency wallet selected by the shopper to complete the payment.
     *
     * @param string|null $selectedWallet the selected wallet
     */
    public function setSelectedWallet(?string $selectedWallet): void
    {
        $this->selectedWallet = $selectedWallet;
    }

    /**
     * Gets email address
     *
     * Populated with the buyer's email address if passed in the buyer object,
     * otherwise this field is not returned in the response.
     *
     * @return string|null the email address
     */
    public function getEmailAddress(): ?string
    {
        return $this->emailAddress;
    }

    /**
     * Sets email address
     *
     * Populated with the buyer's email address if passed in the buyer object,
     * otherwise this field is not returned in the response.
     *
     * @param string $emailAddress the email address
     */
    public function setEmailAddress(string $emailAddress): void
    {
        $this->emailAddress = $emailAddress;
    }

    /**
     * Gets selected transaction currency
     *
     * This field will be populated with the cryptocurrency selected to pay the BitPay invoice,
     * current supported values are "BTC", "BCH", "ETH", "GUSD", "PAX", "BUSD", "USDC", "XRP", "DOGE", "DAI" and "WBTC".
     * If not yet selected, this field will not be returned.
     *
     * @return string|null the selected transaction currency
     */
    public function getSelectedTransactionCurrency(): ?string
    {
        return $this->selectedTransactionCurrency;
    }

    /**
     * Sets selected transaction currency
     *
     * This field will be populated with the cryptocurrency selected to pay the BitPay invoice,
     * current supported values are "BTC", "BCH", "ETH", "GUSD", "PAX", "BUSD", "USDC", "XRP", "DOGE", "DAI" and "WBTC".
     * If not yet selected, this field will not be returned.
     *
     * @param string $selectedTransactionCurrency the selected transaction currency
     */
    public function setSelectedTransactionCurrency(string $selectedTransactionCurrency): void
    {
        $this->selectedTransactionCurrency = $selectedTransactionCurrency;
    }

    /**
     * Gets sms
     *
     * SMS provided by user for communications. This is only used for instances where a buyers email
     * (primary form of buyer communication) is can not be gathered.
     *
     * @return string|null the sms
     */
    public function getSms(): ?string
    {
        return $this->sms;
    }

    /**
     * Sets sms
     *
     * SMS provided by user for communications. This is only used for instances where a buyers email
     * (primary form of buyer communication) is can not be gathered.
     *
     * @param string $sms the sms
     */
    public function setSms(string $sms): void
    {
        $this->sms = $sms;
    }

    /**
     * Gets verification status of SMS (ie. have they passed the challenge).
     *
     * @return bool|null the sms verified
     */
    public function getSmsVerified(): ?bool
    {
        return $this->smsVerified;
    }

    /**
     * Sets verification status of SMS (ie. have they passed the challenge).
     *
     * @param bool $smsVerified the sms verified
     */
    public function setSmsVerified(bool $smsVerified): void
    {
        $this->smsVerified = $smsVerified;
    }

    /**
     * Gets BuyerProvidedInfo as array
     *
     * @return array BuyerProvidedInfo as array
     */
    public function toArray(): array
    {
        $elements = [
            'name'                        => $this->getName(),
            'phoneNumber'                 => $this->getPhoneNumber(),
            'selectedWallet'              => $this->getSelectedWallet(),
            'emailAddress'                => $this->getEmailAddress(),
            'selectedTransactionCurrency' => $this->getSelectedTransactionCurrency(),
            'sms'                         => $this->getSms(),
            'smsVerified'                 => $this->getSmsVerified(),
        ];

        foreach ($elements as $key => $value) {
            if (empty($value)) {
                unset($elements[$key]);
            }
        }

        return $elements;
    }
}
