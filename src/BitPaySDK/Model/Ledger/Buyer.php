<?php

/**
 * Copyright (c) 2019 BitPay
 **/

declare(strict_types=1);

namespace BitPaySDK\Model\Ledger;

/**
 * @package BitPaySDK\Model\Ledger
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 * @see https://bitpay.readme.io/reference/ledgers REST API Ledgers
 */
class Buyer
{
    protected ?string $buyerName = null;
    protected ?string $buyerAddress1 = null;
    protected ?string $buyerAddress2 = null;
    protected ?string $buyerCity = null;
    protected ?string $buyerState = null;
    protected ?string $buyerZip = null;
    protected ?string $buyerCountry = null;
    protected ?string $buyerPhone = null;
    protected ?bool $buyerNotify = null;
    protected ?string $buyerEmail = null;

    public function __construct()
    {
    }

    /**
     * Gets name
     *
     * @return string|null the name
     */
    public function getBuyerName(): ?string
    {
        return $this->buyerName;
    }

    /**
     * Sets name
     *
     * @param string $name the name
     */
    public function setBuyerName(string $name): void
    {
        $this->buyerName = $name;
    }

    /**
     * Gets address 1
     *
     * @return string|null the address1
     */
    public function getBuyerAddress1(): ?string
    {
        return $this->buyerAddress1;
    }

    /**
     * Sets address1
     *
     * @param string $address1 the address1
     */
    public function setBuyerAddress1(string $address1): void
    {
        $this->buyerAddress1 = $address1;
    }

    /**
     * Gets address2
     *
     * @return string|null the address2
     */
    public function getBuyerAddress2(): ?string
    {
        return $this->buyerAddress2;
    }

    /**
     * Sets address2
     *
     * @param string $address2 the address2
     */
    public function setBuyerAddress2(string $address2): void
    {
        $this->buyerAddress2 = $address2;
    }

    /**
     * Gets city
     *
     * @return string|null the city
     */
    public function getBuyerCity(): ?string
    {
        return $this->buyerCity;
    }

    /**
     * Sets city
     *
     * @param string $city the city
     */
    public function setBuyerCity(string $city): void
    {
        $this->buyerCity = $city;
    }

    /**
     * Gets state
     *
     * @return string|null the state
     */
    public function getBuyerState(): ?string
    {
        return $this->buyerState;
    }

    /**
     * Sets state
     *
     * @param string $state the state
     */
    public function setBuyerState(string $state): void
    {
        $this->buyerState = $state;
    }

    /**
     * Gets zip
     *
     * @return string|null the zip
     */
    public function getBuyerZip(): ?string
    {
        return $this->buyerZip;
    }

    /**
     * Sets zip
     *
     * @param string $zip the zip
     */
    public function setBuyerZip(string $zip): void
    {
        $this->buyerZip = $zip;
    }

    /**
     * Gets country
     *
     * @return string|null the country
     */
    public function getBuyerCountry(): ?string
    {
        return $this->buyerCountry;
    }

    /**
     * Sets country
     *
     * @param string $country the country
     */
    public function setBuyerCountry(string $country): void
    {
        $this->buyerCountry = $country;
    }

    /**
     * Gets email
     *
     * @return string|null the email
     */
    public function getBuyerEmail(): ?string
    {
        return $this->buyerEmail;
    }

    /**
     * Sets email
     *
     * @param string $email the email
     */
    public function setBuyerEmail(string $email): void
    {
        $this->buyerEmail = $email;
    }

    /**
     * Gets phone
     *
     * @return string|null the phone
     */
    public function getBuyerPhone(): ?string
    {
        return $this->buyerPhone;
    }

    /**
     * Sets phone
     *
     * @param string $phone the phone
     */
    public function setBuyerPhone(string $phone): void
    {
        $this->buyerPhone = $phone;
    }

    /**
     * Gets notify
     *
     * @return bool|null notify
     */
    public function getBuyerNotify(): ?bool
    {
        return $this->buyerNotify;
    }

    /**
     * Sets notify
     *
     * @param bool $notify notify
     */
    public function setBuyerNotify(bool $notify): void
    {
        $this->buyerNotify = $notify;
    }

    /**
     * Gets Buyer as array
     *
     * @return array Buyer as array
     */
    public function toArray(): array
    {
        $elements = [
            'buyerName'     => $this->getBuyerName(),
            'buyerAddress1' => $this->getBuyerAddress1(),
            'buyerAddress2' => $this->getBuyerAddress2(),
            'buyerCity'     => $this->getBuyerCity(),
            'buyerState'    => $this->getBuyerState(),
            'buyerZip'      => $this->getBuyerZip(),
            'buyerCountry'  => $this->getBuyerCountry(),
            'buyerPhone'    => $this->getBuyerPhone(),
            'buyerNotify'   => $this->getBuyerNotify(),
            'buyerEmail'    => $this->getBuyerEmail(),
        ];

        foreach ($elements as $key => $value) {
            if (empty($value)) {
                unset($elements[$key]);
            }
        }

        return $elements;
    }
}
