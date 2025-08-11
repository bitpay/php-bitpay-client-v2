<?php

/**
 * Copyright (c) 2025 BitPay
 **/

declare(strict_types=1);

namespace BitPaySDK\Model\Subscription;

use BitPaySDK\Model\Bill\Bill;

/**
 * @package BitPaySDK\Model\Subscription
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
class Subscription
{
    protected ?string $id = null;
    protected ?string $status = null;
    protected Bill $billData;
    protected ?string $merchant = null;
    protected ?string $schedule = null;
    protected ?string $nextDelivery = null;
    protected ?string $createdDate = null;
    protected ?string $token = null;

    /**
     * Constructor, create a minimal request Subscription object.
     *
     * @param Bill|null $billData Object containing the recurring billing information.
     * @param string|null $schedule Schedule of recurring billing due dates
     */
    public function __construct(?Bill $billData = null, ?string $schedule = SubscriptionSchedule::MONTHLY)
    {
        $this->billData = $billData ?: new Bill();
        $this->schedule = $schedule;
    }

    /**
     * Get subscription data as array
     *
     * @return array subscription data as array
     */
    public function toArray(): array
    {
        $elements = [
            'id' => $this->getId(),
            'status' => $this->getStatus(),
            'billData' => $this->getBillData()->toArray(),
            'merchant' => $this->getMerchant(),
            'schedule' => $this->getSchedule(),
            'nextDelivery' => $this->getNextDelivery(),
            'createdDate' => $this->getCreatedDate(),
            'token' => $this->getToken(),
        ];

        foreach ($elements as $key => $value) {
            if (empty($value)) {
                unset($elements[$key]);
            }
        }

        return $elements;
    }

    /**
     * Get Subscription id
     *
     * Subscription resource id
     *
     * @return string|null the id
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Set Subscription id
     *
     * Subscription resource id
     *
     * @param string $id Subscription resource id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * Get Subscription status
     *
     * @return string|null the status
     * @see SubscriptionStatus
     *
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * Set Subscription status
     *
     * @param string $status Subscription's status
     * @see SubscriptionStatus
     *
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * Get Subscription billData
     *
     * Object containing the recurring billing information
     *
     * @return Bill
     */
    public function getBillData(): Bill
    {
        return $this->billData;
    }

    /**
     * Set Subscription billData
     *
     * @param Bill $billData Object containing the recurring billing information.
     * @return void
     */
    public function setBillData(Bill $billData): void
    {
        $this->billData = $billData;
    }

    /**
     * Get Subscription merchant
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
     * Set Subscription merchant
     *
     * Internal identifier for BitPay, this field can be ignored by the merchants.
     *
     * @param string $merchant Internal identifier for BitPay
     */
    public function setMerchant(string $merchant): void
    {
        $this->merchant = $merchant;
    }

    /**
     * Get Subscription created date
     *
     * Date and time of Subscription creation, ISO-8601 format yyyy-mm-ddThh:mm:ssZ. (UTC)
     *
     * @return string|null the created date
     * @see Env::BITPAY_DATETIME_FORMAT
     */
    public function getCreatedDate(): ?string
    {
        return $this->createdDate;
    }

    /**
     * Set Subscription created date
     *
     * Date and time of Subscription creation, ISO-8601 format yyyy-mm-ddThh:mm:ssZ. (UTC)
     *
     * @param string $createdDate Subscription's created date
     * @see Env::BITPAY_DATETIME_FORMAT
     */
    public function setCreatedDate(string $createdDate): void
    {
        $this->createdDate = $createdDate;
    }

    /**
     * Gets token
     *
     * API token for subscription resource. This token is actually derived from the API token used to create the
     * subscription and is tied to the specific resource id created.
     *
     * @return string|null the token
     */
    public function getToken(): ?string
    {
        return $this->token;
    }

    /**
     * Set Subscription token
     *
     * API token for subscription resource. This token is actually derived from the API token used to create the
     * subscription and is tied to the specific resource id created.
     *
     * @param string $token API token for subscription resource
     */
    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    /**
     * Get Subscription schedule
     *
     * @return string|null
     * @see SubscriptionSchedule
     *
     */
    public function getSchedule(): ?string
    {
        return $this->schedule;
    }

    /**
     * Set Subscription schedule
     *
     * @param string $schedule
     * @return void
     * @see SubscriptionSchedule
     *
     */
    public function setSchedule(string $schedule): void
    {
        $this->schedule = $schedule;
    }

    /**
     * Get Subscription's next delivery date
     *
     * Default is current date & time, ISO-8601 format yyyy-mm-ddThh:mm:ssZ (UTC). Current or past date indicates that
     * the bill can be delivered immediately. BitPay may modify the hh:mm:ss values in order to distribute deliveries
     * evenly throughout the day.
     *
     * @return string|null Subscription's next delivery date
     */
    public function getNextDelivery(): ?string
    {
        return $this->nextDelivery;
    }

    /**
     * Set Subscription's next delivery date
     *
     * Default is current date & time, ISO-8601 format yyyy-mm-ddThh:mm:ssZ (UTC). Current or past date indicates that
     * the bill can be delivered immediately. BitPay may modify the hh:mm:ss values in order to distribute deliveries
     * evenly throughout the day.
     *
     * @param string $nextDelivery Subscription's next delivery date
     * @return void
     */
    public function setNextDelivery(string $nextDelivery): void
    {
        $this->nextDelivery = $nextDelivery;
    }
}
