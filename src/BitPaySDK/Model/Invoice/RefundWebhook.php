<?php


namespace BitPaySDK\Model\Invoice;


class RefundWebhook
{
    protected $_id;
    protected $_invoice;
    protected $_supportRequest;
    protected $_status;
    protected $_amount;
    protected $_currency;
    protected $_lastRefundNotification;
    protected $_refundFee;
    protected $_immediate;
    protected $_buyerPaysRefundFee;
    protected $_requestDate;

    public function __construct() {
    }

    // Request fields
    //

    public function getId()
    {
        return $this->_id;
    }

    public function setId(string $id)
    {
        $this->_id = $id;
    }

    public function getInvoice()
    {
        return $this->_invoice;
    }

    public function setInvoice(string $invoice)
    {
        $this->_invoice = $invoice;
    }

    public function getSupportRequest()
    {
        return $this->_supportRequest;
    }

    public function setSupportRequest(string $supportRequest)
    {
        $this->_supportRequest = $supportRequest;
    }

    public function getStatus()
    {
        return $this->_status;
    }

    public function setStatus(string $status)
    {
        $this->_status = $status;
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

    public function getLastRefundNotification()
    {
        return $this->_lastRefundNotification;
    }

    public function setLastRefundNotification(string $lastRefundNotification)
    {
        $this->_lastRefundNotification = $lastRefundNotification;
    }

    public function getRefundFee()
    {
        return $this->_refundFee;
    }

    public function setRefundFee(float $refundFee)
    {
        $this->_refundFee = $refundFee;
    }

    // Response fields
    //

    public function getImmediate()
    {
        return $this->_immediate;
    }

    public function setImmediate(bool $immediate)
    {
        $this->_immediate = $immediate;
    }

    public function getbuyerPaysRefundFee()
    {
        return $this->_buyerPaysRefundFee;
    }

    public function setbuyerPaysRefundFee(bool $buyerPaysRefundFee)
    {
        $this->_buyerPaysRefundFee = $buyerPaysRefundFee;
    }

    public function getRequestDate()
    {
        return $this->_requestDate;
    }

    public function setRequestDate(string $requestDate)
    {
        $this->_requestDate = $requestDate;
    }

    public function toArray()
    {
        $elements = [
            'id'                       => $this->getId(),
            'invoice'                  => $this->getInvoice(),
            'supportRequest'           => $this->getSupportRequest(),
            'status'                   => $this->getStatus(),
            'amount'                   => $this->getAmount(),
            'currency'                 => $this->getCurrency(),
            'lastRefundNotification'   => $this->getLastRefundNotification(),
            'refundFee'                => $this->getRefundFee(),
            'immediate'                => $this->getImmediate(),
            'buyerPaysRefundFee'       => $this->getBuyerPaysRefundFee(),
            'requestDate'              => $this->getRequestDate()
        ];

        return $elements;
    }
}
