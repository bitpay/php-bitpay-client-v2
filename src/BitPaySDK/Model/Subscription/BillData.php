<?php

/**
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace BitPaySDK\Model\Subscription;

use BitPaySDK\Exceptions\BitPayException;
use BitPaySDK\Model\Currency;

/**
 * Object containing the recurring billing information
 */
class BillData
{
    protected $emailBill;
    protected $cc;
    protected $number;
    protected $currency;
    protected $name;
    protected $address1;
    protected $address2;
    protected $city;
    protected $state;
    protected $zip;
    protected $country;
    protected $email;
    protected $phone;
    protected $dueDate;
    protected $passProcessingFee;
    protected $items;
    protected $merchant;

    /**
     * @param string $currency
     * @param string $email
     * @param string $dueDate
     * @param array $items
     */
    public function __construct(string $currency, string $email, string $dueDate, array $items)
    {
        $this->currency = $currency;
        $this->email = $email;
        $this->dueDate = $dueDate;
        $this->items = $items;
    }

    /**
     * Gets email bill
     *
     * If set the true, BitPay will automatically issue recurring bills to the email address
     * provided once the status of the subscription is set to active.
     *
     * @return bool
     */
    public function getEmailBill()
    {
        return $this->emailBill;
    }

    /**
     * Sets email bill
     *
     * If set the true, BitPay will automatically issue recurring bills to the email address
     * provided once the status of the subscription is set to active.
     *
     * @param bool $emailBill
     */
    public function setEmailBill(bool $emailBill)
    {
        $this->emailBill = $emailBill;
    }

    /**
     * Gets Email addresses to which a copy of the recurring bill must be sent
     *
     * @return array
     */
    public function getCc()
    {
        return $this->cc;
    }

    /**
     * Sets Email addresses to which a copy of the recurring bill must be sent
     *
     * @param array $cc
     */
    public function setCc(array $cc)
    {
        $this->cc = $cc;
    }

    /**
     * Gets Recurring bill identifier, specified by merchant
     *
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Sets Recurring bill identifier, specified by merchant
     *
     * @param string $number
     */
    public function setNumber(string $number)
    {
        $this->number = $number;
    }

    /**
     * Gets currency
     *
     * ISO 4217 3-character currency code. This is the currency associated with the price field
     *
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Sets currency
     *
     * ISO 4217 3-character currency code. This is the currency associated with the price field
     *
     * @param string $currency
     * @throws BitPayException
     */
    public function setCurrency(string $currency)
    {
        if (!Currency::isValid($currency)) {
            throw new BitPayException("currency code must be a type of Model.Currency");
        }

        $this->currency = $currency;
    }

    /**
     * Gets Recurring Bill recipient's name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets Recurring Bill recipient's name
     *
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * Gets Recurring Bill recipient's address
     *
     * @return string
     */
    public function getAddress1()
    {
        return $this->address1;
    }

    /**
     * Sets Recurring Bill recipient's address
     *
     * @param string $address1
     */
    public function setAddress1(string $address1)
    {
        $this->address1 = $address1;
    }

    /**
     * Gets Recurring Bill recipient's address
     *
     * @return string
     */
    public function getAddress2()
    {
        return $this->address2;
    }

    /**
     * Sets Recurring Bill recipient's address
     *
     * @param string $address2
     */
    public function setAddress2(string $address2)
    {
        $this->address2 = $address2;
    }

    /**
     * Gets Recurring Bill recipient's city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Sets Recurring Bill recipient's city
     *
     * @param string $city
     */
    public function setCity(string $city)
    {
        $this->city = $city;
    }

    /**
     * Gets Recurring Bill recipient's state or province
     *
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Sets Recurring Bill recipient's state or province
     *
     * @param string $state
     */
    public function setState(string $state)
    {
        $this->state = $state;
    }

    /**
     * Gets Recurring Bill recipient's ZIP code
     *
     * @return string
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * Sets Recurring Bill recipient's ZIP code
     *
     * @param string $zip
     */
    public function setZip(string $zip)
    {
        $this->zip = $zip;
    }

    /**
     * Gets Recurring Bill recipient's country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Sets Recurring Bill recipient's country
     *
     * @param string $country
     */
    public function setCountry(string $country)
    {
        $this->country = $country;
    }

    /**
     * Gets Recurring Bill recipient's email address
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Sets Recurring Bill recipient's email address
     *
     * @param string $email
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    /**
     * Gets Recurring Bill recipient's phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Sets Recurring Bill recipient's phone
     *
     * @param string $phone
     */
    public function setPhone(string $phone)
    {
        $this->phone = $phone;
    }

    /**
     * Gets due date.
     *
     * Date and time at which a bill is due, ISO-8601 format yyyy-mm-ddThh:mm:ssZ (UTC).
     *
     * @return string
     */
    public function getDueDate()
    {
        return $this->dueDate;
    }

    /**
     * Sets due date.
     *
     * Date and time at which a bill is due, ISO-8601 format yyyy-mm-ddThh:mm:ssZ (UTC).
     *
     * @param string $dueDate
     */
    public function setDueDate(string $dueDate)
    {
        $this->dueDate = $dueDate;
    }

    /**
     * Gets pass processing fee
     *
     * If set to true, BitPay's processing fee will be included in the amount charged on the invoice
     *
     * @return bool
     */
    public function getPassProcessingFee()
    {
        return $this->passProcessingFee;
    }

    /**
     * Sets pass processing fee
     *
     * If set to true, BitPay's processing fee will be included in the amount charged on the invoice
     *
     * @param bool $passProcessingFee
     */
    public function setPassProcessingFee(bool $passProcessingFee)
    {
        $this->passProcessingFee = $passProcessingFee;
    }

    /**
     * Gets merchant
     *
     * Internal identifier for BitPay, this field can be ignored by the merchants.
     *
     * @return string
     */
    public function getMerchant()
    {
        return $this->merchant;
    }

    /**
     * Sets merchant
     *
     * Internal identifier for BitPay, this field can be ignored by the merchants.
     *
     * @param string $merchant
     */
    public function setMerchant(string $merchant)
    {
        $this->merchant = $merchant;
    }

    /**
     * Gets List of line items
     *
     * @return array
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Gets List of line items as array
     *
     * @return array
     */
    public function getItemsAsArray()
    {
        $items = [];

        foreach ($this->items as $item) {
            if ($item instanceof Item) {
                array_push($items, $item->toArray());
            } else {
                array_push($items, $item);
            }
        }

        return $items;
    }

    /**
     * Sets List of line items
     *
     * @param array $items
     */
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
        $this->items = $itemsArray;
    }

    /**
     * Returns the BillData object as array
     *
     * @return array
     */
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
