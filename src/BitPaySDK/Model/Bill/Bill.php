<?php

/**
 * Copyright (c) 2019 BitPay
 **/

declare(strict_types=1);

/*
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace BitPaySDK\Model\Bill;

use BitPaySDK\Exceptions\BitPayException;
use BitPaySDK\Model\Currency;

/**
 * @package Bitpay
 * @see <a href="https://developer.bitpay.com/reference/bills">REST API Bills</a>
 */
class Bill
{
    protected ?string $currency = null;
    protected ?string $token = null;
    protected ?string $email = null;
    protected array $items = [];
    protected ?string $number = null;
    protected ?string $name = null;
    protected ?string $address1 = null;
    protected ?string $address2 = null;
    protected ?string $city = null;
    protected ?string $state = null;
    protected ?string $zip = null;
    protected ?string $country = null;
    protected ?array $cc = null;
    protected ?string $phone = null;
    protected ?string $dueDate = null;
    protected ?bool $passProcessingFee = null;
    protected ?string $status = null;
    protected ?string $url = null;
    protected ?string $createDate = null;
    protected ?string $id = null;
    protected ?string $merchant = null;

    /**
     * Constructor, create a minimal request Bill object.
     *
     * @param string|null $number string A string for tracking purposes.
     * @param string|null $currency string The three digit currency type used to compute the bill's amount.
     * @param string|null $email string The email address of the receiver for this bill.
     * @param array|null $items array The list of items to add to this bill.
     */
    public function __construct(
        string $number = null,
        string $currency = null,
        string $email = null,
        array $items = null
    ) {
        $this->number = $number;
        $this->currency = $currency;
        $this->email = $email;

        if (!$items) {
            $items = [];
        }
        $this->setItems($items);
    }

    /**
     * Gets token
     *
     * API token for bill resource. This token is actually derived from the API token used to
     * create the bill and is tied to the specific resource id created.
     *
     * @return string|null the token
     */
    public function getToken(): ?string
    {
        return $this->token;
    }

    /**
     * Sets Bill's token
     *
     * API token for bill resource. This token is actually derived from the API token used to
     * create the bill and is tied to the specific resource id created.
     *
     * @param string $token the token
     */
    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    /**
     * Gets bill currency
     *
     * ISO 4217 3-character currency code. This is the currency associated with the price field
     *
     * @return string|null the bill currency
     */
    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    /**
     * Sets Bill's currency
     *
     * ISO 4217 3-character currency code. This is the currency associated with the price field
     *
     * @param string $currency the currency
     * @throws BitPayException
     */
    public function setCurrency(string $currency): void
    {
        if (!Currency::isValid($currency)) {
            throw new BitPayException("currency code must be a type of Model.Currency");
        }

        $this->currency = $currency;
    }

    /**
     * Gets bill email
     *
     * @return string|null the email
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Sets Bill's email
     *
     * @param string $email the email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * Gets items from bill
     *
     * @return array Item[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * Gets items as array from bill
     *
     * @return array|null items as array from bill
     */
    public function getItemsAsArray(): ?array
    {
        $items = [];

        foreach ($this->items as $item) {
            $items[] = $item->toArray();
        }

        return $items;
    }

    /**
     * Sets Bill's items
     *
     * @param array $items Item[]
     */
    public function setItems(array $items): void
    {
        $itemsArray = [];

        foreach ($items as $item) {
            if ($item instanceof Item) {
                $itemsArray[] = $item;
            } else {
                $itemsArray[] = Item::createFromArray((array)$item);
            }
        }

        $this->items = $itemsArray;
    }

    /**
     * Gets bill number
     *
     * Bill identifier, specified by merchant
     *
     * @return string|null the number
     */
    public function getNumber(): ?string
    {
        return $this->number;
    }

    /**
     * Sets Bill's number
     *
     * Bill identifier, specified by merchant
     *
     * @param string $number the number
     */
    public function setNumber(string $number): void
    {
        $this->number = $number;
    }

    /**
     * Gets Bill recipient's name
     *
     * @return string|null the name
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Sets Bill recipient's name
     *
     * @param string $name the name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Gets Bill recipient's address
     *
     * @return string|null the address1
     */
    public function getAddress1(): ?string
    {
        return $this->address1;
    }

    /**
     * Sets Bill recipient's address
     *
     * @param string $address1
     */
    public function setAddress1(string $address1): void
    {
        $this->address1 = $address1;
    }

    /**
     * Gets Bill recipient's address
     *
     * @return string|null the address2
     */
    public function getAddress2(): ?string
    {
        return $this->address2;
    }

    /**
     * Sets Bill recipient's address
     *
     * @param string $address2
     */
    public function setAddress2(string $address2): void
    {
        $this->address2 = $address2;
    }

    /**
     * Gets Bill recipient's city
     *
     * @return string|null the city
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * Sets Bill recipient's city
     *
     * @param string $city
     */
    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    /**
     * Gets Bill recipient's state or province
     *
     * @return string|null the state
     */
    public function getState(): ?string
    {
        return $this->state;
    }

    /**
     * Sets Bill recipient's state or province
     *
     * @param string $state
     */
    public function setState(string $state): void
    {
        $this->state = $state;
    }

    /**
     * Gets Bill recipient's ZIP code
     *
     * @return string|null the zip
     */
    public function getZip(): ?string
    {
        return $this->zip;
    }

    /**
     * Sets Bill recipient's ZIP code
     *
     * @param string $zip
     */
    public function setZip(string $zip): void
    {
        $this->zip = $zip;
    }

    /**
     * Gets Bill recipient's country
     *
     * @return string|null the country
     */
    public function getCountry(): ?string
    {
        return $this->country;
    }

    /**
     * Sets Bill recipient's country
     *
     * @param string $country
     */
    public function setCountry(string $country): void
    {
        $this->country = $country;
    }

    /**
     * Gets Bill cc
     *
     * Email addresses to which a copy of the bill must be sent
     *
     * @return array|null the cc
     */
    public function getCc(): ?array
    {
        return $this->cc;
    }

    /**
     * Sets Bill's cc
     *
     * Email addresses to which a copy of the bill must be sent
     *
     * @param array $cc
     */
    public function setCc(array $cc): void
    {
        $this->cc = $cc;
    }

    /**
     * Gets Bill recipient's phone number
     *
     * @return string|null the phone
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * Sets Bill recipient's phone number
     *
     * @param string $phone
     */
    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    /**
     * Gets Bill due date
     *
     * Date and time at which a bill is due, ISO-8601 format yyyy-mm-ddThh:mm:ssZ. (UTC)
     *
     * @return string|null the number
     */
    public function getDueDate(): ?string
    {
        return $this->dueDate;
    }

    /**
     * Sets Bill's due date
     *
     * Date and time at which a bill is due, ISO-8601 format yyyy-mm-ddThh:mm:ssZ. (UTC)
     *
     * @param string $dueDate
     */
    public function setDueDate(string $dueDate): void
    {
        $this->dueDate = $dueDate;
    }

    /**
     * Gets bill pass processing fee
     *
     * @return bool|null the pass processing fee
     */
    public function getPassProcessingFee(): ?bool
    {
        return $this->passProcessingFee;
    }

    /**
     * Sets Bill's pass processing fee
     *
     * If set to true, BitPay's processing fee will be included in the amount charged on the invoice
     *
     * @param bool $passProcessingFee
     */
    public function setPassProcessingFee(bool $passProcessingFee): void
    {
        $this->passProcessingFee = $passProcessingFee;
    }

    /**
     * Gets bill status
     *
     * Can "draft", "sent", "new", "paid", or "complete"
     *
     * @return string|null the status
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * Sets Bill's status
     *
     * Can "draft", "sent", "new", "paid", or "complete"
     *
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * Gets bill url
     *
     * Web address of bill
     *
     * @return string|null the url
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * Sets Bill's url
     *
     * Web address of bill
     *
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    /**
     * Gets bill create date
     *
     * Date and time of Bill creation, ISO-8601 format yyyy-mm-ddThh:mm:ssZ. (UTC)
     *
     * @return string|null the creation date
     */
    public function getCreateDate(): ?string
    {
        return $this->createDate;
    }

    /**
     * Sets Bill's create date
     *
     * Date and time of Bill creation, ISO-8601 format yyyy-mm-ddThh:mm:ssZ. (UTC)
     *
     * @param string $createDate
     */
    public function setCreateDate(string $createDate): void
    {
        $this->createDate = $createDate;
    }

    /**
     * Gets bill id
     *
     * Bill resource id
     *
     * @return string|null the id
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Sets Bill's id
     *
     * Bill resource id
     *
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * Gets bill merchant
     *
     * Internal identifier for BitPay, this field can be ignored by the merchants.
     *
     * @return string|null the merchant
     */
    public function getMerchant(): ?string
    {
        return $this->merchant;
    }

    /**
     * Sets Bill's merchant
     *
     * Internal identifier for BitPay, this field can be ignored by the merchants.
     *
     * @param string $merchant
     */
    public function setMerchant(string $merchant): void
    {
        $this->merchant = $merchant;
    }

    /**
     * Get bill data as array
     *
     * @return array bill data as array
     */
    public function toArray(): array
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
