<?php

/**
 * Copyright (c) 2019 BitPay
 **/

declare(strict_types=1);

/*
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace BitPaySDK\Model\Ledger;

/**
 * Class Buyer
 * @package BitPaySDK\Model\Ledger
 * @see <a href="https://bitpay.readme.io/reference/ledgers">REST API Ledgers</a>
 */
class Buyer
{
    protected ?string $name = null;
    protected ?string $address1 = null;
    protected ?string $address2 = null;
    protected ?string $city = null;
    protected ?string $state = null;
    protected ?string $zip = null;
    protected ?string $country = null;
    protected ?string $phone = null;
    protected ?bool $notify = null;
    protected ?string $email = null;

    public function __construct()
    {
    }

    /**
     * Gets name
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
     * @param string $name the name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Gets address 1
     *
     * @return string|null the address1
     */
    public function getAddress1(): ?string
    {
        return $this->address1;
    }

    /**
     * Sets address1
     *
     * @param string $address1
     */
    public function setAddress1(string $address1): void
    {
        $this->address1 = $address1;
    }

    /**
     * Gets address2
     *
     * @return string|null the address2
     */
    public function getAddress2(): ?string
    {
        return $this->address2;
    }

    /**
     * Sets address2
     *
     * @param string $address2 the address2
     */
    public function setAddress2(string $address2): void
    {
        $this->address2 = $address2;
    }

    /**
     * Gets city
     *
     * @return string|null the city
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * Sets city
     *
     * @param string $city the city
     */
    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    /**
     * Gets state
     *
     * @return string|null the state
     */
    public function getState(): ?string
    {
        return $this->state;
    }

    /**
     * Sets state
     *
     * @param string $state the state
     */
    public function setState(string $state): void
    {
        $this->state = $state;
    }

    /**
     * Gets zip
     *
     * @return string|null the zip
     */
    public function getZip(): ?string
    {
        return $this->zip;
    }

    /**
     * Sets zip
     *
     * @param string $zip the zip
     */
    public function setZip(string $zip): void
    {
        $this->zip = $zip;
    }

    /**
     * Gets country
     *
     * @return string|null the country
     */
    public function getCountry(): ?string
    {
        return $this->country;
    }

    /**
     * Sets country
     *
     * @param string $country the country
     */
    public function setCountry(string $country): void
    {
        $this->country = $country;
    }

    /**
     * Gets email
     *
     * @return string|null the email
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Sets email
     *
     * @param string $email the email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * Gets phone
     *
     * @return string|null the phone
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * Sets phone
     *
     * @param string $phone the phone
     */
    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    /**
     * Gets notify
     *
     * @return bool|null notify
     */
    public function getNotify(): ?bool
    {
        return $this->notify;
    }

    /**
     * Sets notify
     *
     * @param bool $notify notify
     */
    public function setNotify(bool $notify): void
    {
        $this->notify = $notify;
    }

    /**
     * Gets Buyer as array
     *
     * @return array Buyer as array
     */
    public function toArray(): array
    {
        $elements = [
            'name'     => $this->getName(),
            'address1' => $this->getAddress1(),
            'address2' => $this->getAddress2(),
            'city'     => $this->getCity(),
            'state'    => $this->getState(),
            'zip'      => $this->getZip(),
            'country'  => $this->getCountry(),
            'phone'    => $this->getPhone(),
            'notify'   => $this->getNotify(),
            'email'    => $this->getEmail(),
        ];

        foreach ($elements as $key => $value) {
            if (empty($value)) {
                unset($elements[$key]);
            }
        }

        return $elements;
    }
}
