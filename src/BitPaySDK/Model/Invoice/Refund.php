<?php

/**
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */

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
    protected $_reference;
    protected $_lastRefundNotification;
    protected $_invoice;

    /**
     * Constructor, create Refund object
     *
     * @param string $refundEmail
     * @param float $amount
     * @param string $currency
     * @param string $token
     */
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

    /**
     * Gets a passthru variable provided by the merchant and designed to be used by the merchant to correlate
     * the invoice with an order ID in their system
     *
     * @return string
     */
    public function getGuid()
    {
        return $this->_guid;
    }

    /**
     * Sets guid
     *
     * @param string $guid
     */
    public function setGuid(string $guid)
    {
        $this->_guid = $guid;
    }

    /**
     * Present only if specified in the request to create the refund. This is your reference label for this refund.
     * It will be passed-through on each response for you to identify the refund in your system.
     * Maximum string length is 100 characters
     *
     * @return string
     */
    public function getReference()
    {
        return $this->_reference;
    }

    /**
     * Sets reference label for refund
     *
     * @param string $reference
     */
    public function setReference(string $reference)
    {
        $this->_reference = $reference;
    }

    /**
     * Gets refund email
     *
     * @return string
     */
    public function getRefundEmail()
    {
        return $this->_refundEmail;
    }

    /**
     * Sets refund email
     *
     * @param string $refundEmail
     */
    public function setRefundEmail(string $refundEmail)
    {
        $this->_refundEmail = $refundEmail;
    }

    /**
     * Gets amount to be refunded in the invoice currency
     *
     * @return float
     */
    public function getAmount()
    {
        return $this->_amount;
    }

    /**
     * Sets amount to be refunded
     *
     * @param float $amount
     */
    public function setAmount(float $amount)
    {
        $this->_amount = $amount;
    }

    /**
     * Gets API token
     *
     * @return string
     */
    public function getToken()
    {
        return $this->_token;
    }

    /**
     * Sets API token
     *
     * @param string $token
     */
    public function setToken(string $token)
    {
        $this->_token = $token;
    }

    /**
     * Gets reference currency used for the refund, the same as the currency used to create the invoice
     *
     * @return string
     */
    public function getCurrency()
    {
        return $this->_currency;
    }

    /**
     * Sets currency used for the refund
     *
     * @param string $currency
     */
    public function setCurrency(string $currency)
    {
        $this->_currency = $currency;
    }

    /**
     * Whether to create the refund request as a preview
     *
     * @return bool
     */
    public function getPreview()
    {
        return $this->_preview;
    }

    /**
     * Sets preview
     *
     * @param bool $preview
     */
    public function setPreview(bool $preview)
    {
        $this->_preview = $preview;
    }

    /**
     * Gets the ID of the invoice to refund
     *
     * @return string
     */
    public function getInvoiceId()
    {
        return $this->_invoiceId;
    }

    /**
     * Sets invoice id
     *
     * @param string $invoiceId
     */
    public function setInvoiceId(string $invoiceId)
    {
        $this->_invoiceId = $invoiceId;
    }

    // Response fields
    //

    /**
     * Gets the ID of the refund
     *
     * @return string
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * Sets id of the refund
     *
     * @param string $id
     */
    public function setId(string $id)
    {
        $this->_id = $id;
    }

    /**
     * Gets the date the refund was requested
     *
     * @return string
     */
    public function getRequestDate()
    {
        return $this->_requestDate;
    }

    /**
     * Sets request date
     *
     * @param string $requestDate
     */
    public function setRequestDate(string $requestDate)
    {
        $this->_requestDate = $requestDate;
    }

    /**
     * Gets the refund lifecycle status of the request
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->_status;
    }

    /**
     * Sets refund status
     *
     * @param string $status
     */
    public function setStatus(string $status)
    {
        $this->_status = $status;
    }

    /**
     * Gets object containing the refund request parameters
     *
     * @return RefundParams
     */
    public function getParams()
    {
        return $this->_params;
    }

    /**
     * Sets refund params object
     *
     * @param RefundParams $params
     */
    public function setParams(RefundParams $params)
    {
        $this->_params = $params;
    }

    /**
     * Gets whether the funds should be removed from merchant ledger immediately
     * on submission or at the time of processing
     *
     * @return bool
     */
    public function getImmediate()
    {
        return $this->_immediate;
    }

    /**
     * Sets immediate value
     *
     * @param bool $immediate
     */
    public function setImmediate(bool $immediate)
    {
        $this->_immediate = $immediate;
    }

    /**
     * Gets the amount of refund fee expressed in terms of pricing currency
     *
     * @return float
     */
    public function getRefundFee()
    {
        return $this->_refundFee;
    }

    /**
     * Sets amount of the refund fee
     *
     * @param float $refundFee
     */
    public function setRefundFee(float $refundFee)
    {
        $this->_refundFee = $refundFee;
    }

    /**
     * Gets the last time notification of buyer was attempted
     *
     * @return string
     */
    public function getLastRefundNotification()
    {
        return $this->_lastRefundNotification;
    }

    /**
     * Sets last refund notification
     *
     * @param string $lastRefundNotification
     */
    public function setLastRefundNotification(string $lastRefundNotification)
    {
        $this->_lastRefundNotification = $lastRefundNotification;
    }

    /**
     * Gets the ID of the invoice being refunded
     *
     * @return string
     */
    public function getInvoice()
    {
        return $this->_invoice;
    }

    /**
     * Sets the id of the invoice being refunded
     *
     * @param string $invoice
     */
    public function setInvoice(string $invoice)
    {
        $this->_invoice = $invoice;
    }

    /**
     * Gets whether the buyer should pay the refund fee rather
     * than the merchant
     *
     * @return bool
     */
    public function getBuyerPaysRefundFee()
    {
        return $this->_buyerPaysRefundFee;
    }

    /**
     * Sets whether the buyer should pay the refund fee rather
     *
     * @param bool $buyerPaysRefundFee
     */
    public function setBuyerPaysRefundFee(bool $buyerPaysRefundFee)
    {
        $this->_buyerPaysRefundFee = $buyerPaysRefundFee;
    }

    /**
     * Return Refund values as array
     *
     * @return array
     */
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
            'reference'                => $this->getReference(),
            'lastRefundNotification'   => $this->getLastRefundNotification()
        ];

        return $elements;
    }
}
