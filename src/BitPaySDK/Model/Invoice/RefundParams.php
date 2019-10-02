<?php


namespace BitPaySDK\Model\Invoice;


class RefundParams
{
    protected $_requesterType        = "";
    protected $_requesterEmail       = "";
    protected $_amount               = 0.0;
    protected $_currency             = "";
    protected $_email                = "";
    protected $_purchaserNotifyEmail = "";
    protected $_refundAddress        = "";
    protected $_supportRequestEid    = "";

    public function __construct()
    {
    }

    public function getRequesterType()
    {
        return $this->_requesterType;
    }

    public function setRequesterType(string $requesterType)
    {
        $this->_requesterType = $requesterType;
    }

    public function getRequesterEmail()
    {
        return $this->_requesterEmail;
    }

    public function setRequesterEmail(string $requesterEmail)
    {
        $this->_requesterEmail = $requesterEmail;
    }

    public function getAmount()
    {
        return $this->_amount;
    }

    public function setAmount(float $amount)
    {
        $this->_amount = $amount;
    }

    public function getCurrency()
    {
        return $this->_currency;
    }

    public function setCurrency(string $currency)
    {
        $this->_currency = $currency;
    }

    public function getEmail()
    {
        return $this->_email;
    }

    public function setEmail(string $email)
    {
        $this->_email = $email;
    }

    public function getPurchaserNotifyEmail()
    {
        return $this->_purchaserNotifyEmail;
    }

    public function setPurchaserNotifyEmail(string $purchaserNotifyEmail)
    {
        $this->_purchaserNotifyEmail = $purchaserNotifyEmail;
    }

    public function getRefundAddress()
    {
        return $this->_refundAddress;
    }

    public function setRefundAddress(string $refundAddress)
    {
        $this->_refundAddress = $refundAddress;
    }

    public function getSupportRequestEid()
    {
        return $this->_supportRequestEid;
    }

    public function setSupportRequestEid(string $supportRequestEid)
    {
        $this->_supportRequestEid = $supportRequestEid;
    }

    public function toArray()
    {
        $elements = [
            'requesterType'        => $this->getRequesterType(),
            'requesterEmail'       => $this->getRequesterEmail(),
            'amount'               => $this->getAmount(),
            'currency'             => $this->getCurrency(),
            'email'                => $this->getEmail(),
            'purchaserNotifyEmail' => $this->getPurchaserNotifyEmail(),
            'refundAddress'        => $this->getRefundAddress(),
        ];

        return $elements;
    }
}