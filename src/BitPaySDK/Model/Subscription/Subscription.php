<?php

declare(strict_types=1);

/*
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace BitPaySDK\Model\Subscription;

/**
 * Subscription data object
 */
class Subscription
{
    protected ?string $id = null;
    protected ?string $status = null;
    protected BillData $billData;
    protected ?string $schedule = null;
    protected ?string $nextDelivery = null;
    protected ?string $createdDate = null;
    protected ?string $token = null;

    public function __construct()
    {
        $this->billData = new BillData('', '', '', []);
    }

    /**
     * Gets Subscription resource Id
     *
     * @return string|null the id
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Sets Subscription resource Id
     *
     * @param string $id the id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * Gets Subscription object status.
     *
     * Can be draft, active or cancelled. Subscriptions in active state will create new Bills on the nextDelivery date.
     *
     * @return string|null the status
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * Sets Subscription object status.
     *
     * Can be draft, active or cancelled. Subscriptions in active state will create new Bills on the nextDelivery date.
     *
     * @param string $status the status
     * @return void
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * Gets Object containing the recurring billing information
     *
     * @return BillData the bill data
     */
    public function getBillData(): BillData
    {
        return $this->billData;
    }

    /**
     * Sets Object containing the recurring billing information
     *
     * @param BillData $billData the bill data
     * @return void
     */
    public function setBillData(BillData $billData): void
    {
        $this->billData = $billData;
    }

    /**
     * Gets Schedule of repeat bill due dates.
     *
     * Can be weekly, monthly, quarterly, yearly, or a simple cron expression specifying seconds, minutes, hours,
     * day of month, month, and day of week. BitPay maintains the difference between the due date and the delivery
     * date in all subsequent, automatically-generated bills.
     *
     * @return string|null the schedule
     */
    public function getSchedule(): ?string
    {
        return $this->schedule;
    }

    /**
     * Sets Schedule of repeat bill due dates.
     *
     * Can be weekly, monthly, quarterly, yearly, or a simple cron expression specifying seconds, minutes, hours,
     * day of month, month, and day of week. BitPay maintains the difference between the due date and the delivery
     * date in all subsequent, automatically-generated bills.
     *
     * @param string $schedule the schedule
     */
    public function setSchedule(string $schedule): void
    {
        $this->schedule = $schedule;
    }

    /**
     * Gets Default is current date & time, ISO-8601 format yyyy-mm-ddThh:mm:ssZ (UTC).
     *
     * Current or past date indicates that the bill can be delivered immediately.
     * BitPay may modify the hh:mm:ss values in order to distribute deliveries evenly throughout the day.
     *
     * @return string|null the next delivery
     */
    public function getNextDelivery(): ?string
    {
        return $this->nextDelivery;
    }

    /**
     * Gets Default is current date & time, ISO-8601 format yyyy-mm-ddThh:mm:ssZ (UTC).
     *
     * Current or past date indicates that the bill can be delivered immediately.
     * BitPay may modify the hh:mm:ss values in order to distribute deliveries evenly throughout the day.
     *
     * @param string $nextDelivery the next delivery
     */
    public function setNextDelivery(string $nextDelivery): void
    {
        $this->nextDelivery = $nextDelivery;
    }

    /**
     * Gets Date and time of recurring billing creation, ISO-8601 format yyyy-mm-ddThh:mm:ssZ (UTC)
     *
     * @return string|null the created date
     */
    public function getCreatedDate(): ?string
    {
        return $this->createdDate;
    }

    /**
     * Sets Date and time of recurring billing creation, ISO-8601 format yyyy-mm-ddThh:mm:ssZ (UTC)
     *
     * @param string $createdDate the created date
     */
    public function setCreatedDate(string $createdDate): void
    {
        $this->createdDate = $createdDate;
    }

    /**
     * Gets API token for subscription resource.
     *
     * This token is actually derived from the API token
     * used to create the subscription and is tied to the specific resource id created.
     *
     * @return string|null the token
     */
    public function getToken(): ?string
    {
        return $this->token;
    }

    /**
     * Sets API token for subscription resource.
     *
     * This token is actually derived from the API token
     * used to create the subscription and is tied to the specific resource id created.
     *
     * @param string $token the token
     */
    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    /**
     * Gets Subscription as array
     *
     * @return array Subscription as array
     */
    public function toArray(): array
    {
        $elements = [
            'id' => $this->getId(),
            'status' => $this->getStatus(),
            'billData' => $this->getBillData()->toArray(),
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
}
