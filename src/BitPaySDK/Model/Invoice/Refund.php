<?php


namespace BitPaySDK\Model\Invoice;


class Refund
{
    protected $_guid;
    protected $_refundEmail;
    protected $_amount;
    protected $_currency;
    protected $_token;
    protected $_id;
    protected $_requestDate;
    protected $_status;
    protected $_params;
    protected $_invoiceId;
    protected $_preview;
    protected $_immediate;
    protected $_buyerPaysRefundFee;
    protected $_refundFee;
    protected $_lastRefundNotification;
    protected $_invoice;

    public function __construct(
        string $refundEmail = "",
        float $amount = 0.0,
        string $currency = "",
        string $token = ""
    ) {
        $this->_refundEmail = $refundEmail;
        $this->_amount = $amount;
        $this->_currency = $currency;
        $this->_token = $token;
        $this->_params = new RefundParams();
    }

    // Request fields
    //

    public function getGuid()
    {
        return $this->_guid;
    }

    public function setGuid(string $guid)
    {
        $this->_guid = $guid;
    }

    public function getRefundEmail()
    {
        return $this->_refundEmail;
    }

    public function setRefundEmail(string $refundEmail)
    {
        $this->_refundEmail = $refundEmail;
    }

    public function getAmount()
    {
        return $this->_amount;
    }

    public function setAmount(float $amount)
    {
        $this->_amount = $amount;
    }

    public function getToken()
    {
        return $this->_token;
    }

    public function setToken(string $token)
    {
        $this->_token = $token;
    }

    public function getCurrency()
    {
        return $this->_currency;
    }

    public function setCurrency(string $currency)
    {
        $this->_currency = $currency;
    }

    public function getPreview()
    {
        return $this->_preview;
    }

    public function setPreview(bool $preview)
    {
        $this->_preview = $preview;
    }

    public function getInvoiceId()
    {
        return $this->_invoiceId;
    }

    public function setInvoiceId(string $invoiceId)
    {
        $this->_invoiceId = $invoiceId;
    }

    // Response fields
    //

    public function getId()
    {
        return $this->_id;
    }

    public function setId(string $id)
    {
        $this->_id = $id;
    }

    public function getRequestDate()
    {
        return $this->_requestDate;
    }

    public function setRequestDate(string $requestDate)
    {
        $this->_requestDate = $requestDate;
    }

    public function getStatus()
    {
        return $this->_status;
    }

    public function setStatus(string $status)
    {
        $this->_status = $status;
    }

    public function getParams()
    {
        return $this->_params;
    }

    public function setParams(RefundParams $params)
    {
        $this->_params = $params;
    }

    public function getImmediate()
    {
        return $this->_immediate;
    }

    public function setImmediate(bool $immediate)
    {
        $this->_immediate = $immediate;
    }

    public function getRefundFee()
    {
        return $this->_refundFee;
    }

    public function setRefundFee(float $refundFee)
    {
        $this->_refundFee = $refundFee;
    }

    public function getLastRefundNotification()
    {
        return $this->_lastRefundNotification;
    }

    public function setLastRefundNotification(string $lastRefundNotification)
    {
        $this->_lastRefundNotification = $lastRefundNotification;
    }

    public function getInvoice()
    {
        return $this->_invoice;
    }

    public function setInvoice(string $invoice)
    {
        $this->_invoice = $invoice;
    }

    public function getBuyerPaysRefundFee()
    {
        return $this->_buyerPaysRefundFee;
    }

    public function setBuyerPaysRefundFee(bool $buyerPaysRefundFee)
    {
        $this->_buyerPaysRefundFee = $buyerPaysRefundFee;
    }

    public function toArray()
    {
        $elements = [
            'guid'                     => $this->getGuid(),
            'refundEmail'              => $this->getRefundEmail(),
            'amount'                   => $this->getAmount(),
            'currency'                 => $this->getCurrency(),
            'token'                    => $this->getToken(),
            'id'                       => $this->getId(),
            'requestDate'              => $this->getRequestDate(),
            'status'                   => $this->getStatus(),
            'params'                   => $this->getParams()->toArray(),
            'invoiceId'                => $this->getInvoiceId(),
            'preview'                  => $this->getPreview(),
            'immediate'                => $this->getImmediate(),
            'refundFee'                => $this->getRefundFee(),
            'invoice'                  => $this->getInvoice(),
            'buyerPaysRefundFee'       => $this->getBuyerPaysRefundFee(),
            'lastRefundNotification'   => $this->getLastRefundNotification()
        ];

        return $elements;
    }
}