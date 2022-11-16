<?php

/**
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace BitPaySDK\Model\Subscription;

/**
 * Subscription data object
 */
class Subscription
{
    protected $_id;
    protected $_status;
    /**
     * @var BillData
     */
    protected $_billData;
    protected $_schedule;
    protected $_nextDelivery;
    protected $_createdDate;
    protected $_token;

    public function __construct()
    {
        $this->_billData = new BillData('', '', '', []);
    }

    /**
     * Gets Subscription resource Id
     *
     * @return string the id
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * Sets Subscription resource Id
     *
     * @param string $id the id
     */
    public function setId(string $id)
    {
        $this->_id = $id;
    }

    /**
     * Gets Subscription object status.
     *
     * Can be draft, active or cancelled. Subscriptions in active state will create new Bills on the nextDelivery date.
     *
     * @return string the status
     */
    public function getStatus()
    {
        return $this->_status;
    }

    /**
     * Sets Subscription object status.
     *
     * Can be draft, active or cancelled. Subscriptions in active state will create new Bills on the nextDelivery date.
     *
     * @param string $status the status
     * @return void
     */
    public function setStatus(string $status)
    {
        $this->_status = $status;
    }

    /**
     * Gets Object containing the recurring billing information
     *
     * @return BillData the bill data
     */
    public function getBillData()
    {
        return $this->_billData;
    }

    /**
     * Sets Object containing the recurring billing information
     *
     * @param BillData $billData the bill data
     * @return void
     */
    public function setBillData(BillData $billData)
    {
        $this->_billData = $billData;
    }

    /**
     * Gets Schedule of repeat bill due dates.
     *
     * Can be weekly, monthly, quarterly, yearly, or a simple cron expression specifying seconds, minutes, hours,
     * day of month, month, and day of week. BitPay maintains the difference between the due date and the delivery
     * date in all subsequent, automatically-generated bills.
     *
     * @return string the schedule
     */
    public function getSchedule()
    {
        return $this->_schedule;
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
    public function setSchedule(string $schedule)
    {
        $this->_schedule = $schedule;
    }

    /**
     * Gets Default is current date & time, ISO-8601 format yyyy-mm-ddThh:mm:ssZ (UTC).
     *
     * Current or past date indicates that the bill can be delivered immediately.
     * BitPay may modify the hh:mm:ss values in order to distribute deliveries evenly throughout the day.
     *
     * @return string the next delivery
     */
    public function getNextDelivery()
    {
        return $this->_nextDelivery;
    }

    /**
     * Gets Default is current date & time, ISO-8601 format yyyy-mm-ddThh:mm:ssZ (UTC).
     *
     * Current or past date indicates that the bill can be delivered immediately.
     * BitPay may modify the hh:mm:ss values in order to distribute deliveries evenly throughout the day.
     *
     * @param string $nextDelivery the next delivery
     */
    public function setNextDelivery(string $nextDelivery)
    {
        $this->_nextDelivery = $nextDelivery;
    }

    /**
     * Gets Date and time of recurring billing creation, ISO-8601 format yyyy-mm-ddThh:mm:ssZ (UTC)
     *
     * @return string the created date
     */
    public function getCreatedDate()
    {
        return $this->_createdDate;
    }

    /**
     * Sets Date and time of recurring billing creation, ISO-8601 format yyyy-mm-ddThh:mm:ssZ (UTC)
     *
     * @param string $createdDate the created date
     */
    public function setCreatedDate(string $createdDate)
    {
        $this->_createdDate = $createdDate;
    }

    /**
     * Gets API token for subscription resource.
     *
     * This token is actually derived from the API token
     * used to create the subscription and is tied to the specific resource id created.
     *
     * @return string the token
     */
    public function getToken()
    {
        return $this->_token;
    }

    /**
     * Sets API token for subscription resource.
     *
     * This token is actually derived from the API token
     * used to create the subscription and is tied to the specific resource id created.
     *
     * @param string $token the token
     */
    public function setToken(string $token)
    {
        $this->_token = $token;
    }

    /**
     * Gets Subscription as array
     *
     * @return array Subscription as array
     */
    public function toArray()
    {
        $elements = [
            'id'           => $this->getId(),
            'status'       => $this->getStatus(),
            'billData'     => $this->getBillData()->toArray(),
            'schedule'     => $this->getSchedule(),
            'nextDelivery' => $this->getNextDelivery(),
            'createdDate'  => $this->getCreatedDate(),
            'token'        => $this->getToken(),
        ];

        foreach ($elements as $key => $value) {
            if (empty($value)) {
                unset($elements[$key]);
            }
        }

        return $elements;
    }
}
