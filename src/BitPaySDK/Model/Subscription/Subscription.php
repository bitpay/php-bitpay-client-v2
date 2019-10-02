<?php


namespace BitPaySDK\Model\Subscription;


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

    public function getId()
    {
        return $this->_id;
    }

    public function setId(string $id)
    {
        $this->_id = $id;
    }

    public function getStatus()
    {
        return $this->_status;
    }

    public function setStatus(string $status)
    {
        $this->_status = $status;
    }

    public function getBillData()
    {
        return $this->_billData;
    }

    public function setBillData(BillData $billData)
    {
        $this->_billData = $billData;
    }

    public function getSchedule()
    {
        return $this->_schedule;
    }

    public function setSchedule(string $schedule)
    {
        $this->_schedule = $schedule;
    }

    public function getNextDelivery()
    {
        return $this->_nextDelivery;
    }

    public function setNextDelivery(string $nextDelivery)
    {
        $this->_nextDelivery = $nextDelivery;
    }

    public function getCreatedDate()
    {
        return $this->_createdDate;
    }

    public function setCreatedDate(string $createdDate)
    {
        $this->_createdDate = $createdDate;
    }

    public function getToken()
    {
        return $this->_token;
    }

    public function setToken(string $token)
    {
        $this->_token = $token;
    }

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