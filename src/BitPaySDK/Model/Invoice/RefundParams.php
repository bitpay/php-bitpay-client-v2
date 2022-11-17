<?php

/**
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace BitPaySDK\Model\Invoice;

/**
 * Object containing the refund request parameters.
 */
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

    /**
     * Gets Requester type
     *
     * Set to "purchaser"
     *
     * @return string requester type
     */
    public function getRequesterType()
    {
        return $this->_requesterType;
    }

    /**
     * Sets requester type
     *
     * Set to "purchaser"
     *
     * @param string $requesterType the requester type
     * @return void
     */
    public function setRequesterType(string $requesterType)
    {
        $this->_requesterType = $requesterType;
    }

    /**
     * Gets Purchaser's email address stored on the invoice
     *
     * @return string purchaser's email address stored on the invoice
     */
    public function getRequesterEmail()
    {
        return $this->_requesterEmail;
    }

    /**
     * Sets Purchaser's email address stored on the invoice
     *
     * @param string $requesterEmail purchaser's email address stored on the invoice
     */
    public function setRequesterEmail(string $requesterEmail)
    {
        $this->_requesterEmail = $requesterEmail;
    }

    /**
     * Gets Amount to be refunded in the currency indicated in the refund object.
     *
     * @return float the amounts
     */
    public function getAmount()
    {
        return $this->_amount;
    }

    /**
     * Sets Amount to be refunded in the currency indicated in the refund object.
     *
     * @param float $amount the amount
     */
    public function setAmount(float $amount)
    {
        $this->_amount = $amount;
    }

    /**
     * Get currency
     *
     * Reference currency used for the refund, usually the same as the currency used to create the invoice.
     *
     * @return string the currency
     */
    public function getCurrency()
    {
        return $this->_currency;
    }

    /**
     * Sets currency
     *
     * Reference currency used for the refund, usually the same as the currency used to create the invoice.
     *
     * @param string $currency the currency
     */
    public function setCurrency(string $currency)
    {
        $this->_currency = $currency;
    }

    /**
     * Gets Purchaser's email address stored on the invoice
     *
     * @return string purchaser's email address stored on the invoice
     */
    public function getEmail()
    {
        return $this->_email;
    }

    /**
     * Sets Purchaser's email address stored on the invoice
     *
     * @param string $email purchaser's email address stored on the invoice
     */
    public function setEmail(string $email)
    {
        $this->_email = $email;
    }

    /**
     * Gets purchaser notify email.
     *
     * Email address to which the refund link was sent.
     * This is equal to the refundEmail used when submitting the refund request.
     *
     * @return string the purchaser notify email
     */
    public function getPurchaserNotifyEmail()
    {
        return $this->_purchaserNotifyEmail;
    }

    /**
     * Sets purchaser notify email.
     *
     * Email address to which the refund link was sent.
     * This is equal to the refundEmail used when submitting the refund request.
     *
     * @param string $purchaserNotifyEmail the purchaser notify email
     */
    public function setPurchaserNotifyEmail(string $purchaserNotifyEmail)
    {
        $this->_purchaserNotifyEmail = $purchaserNotifyEmail;
    }

    /**
     * Gets refund address.
     *
     * Contains the cryptocurrency address provided by the customer via the refund link which was emailed to him.
     *
     * @return string the refund address
     */
    public function getRefundAddress()
    {
        return $this->_refundAddress;
    }

    /**
     * Sets refund address.
     *
     * Contains the cryptocurrency address provided by the customer via the refund link which was emailed to him.
     *
     * @param string $refundAddress the refund address
     */
    public function setRefundAddress(string $refundAddress)
    {
        $this->_refundAddress = $refundAddress;
    }

    /**
     * Gets support request eid.
     *
     * Contains the refund requestId.
     *
     * @return string the support request eid
     */
    public function getSupportRequestEid()
    {
        return $this->_supportRequestEid;
    }

    /**
     * Sets support request eid.
     *
     * Contains the refund requestId.
     *
     * @param string $supportRequestEid the support request eid
     */
    public function setSupportRequestEid(string $supportRequestEid)
    {
        $this->_supportRequestEid = $supportRequestEid;
    }

    /**
     * Gets RefundParams as array
     *
     * @return array RefundParams as array
     */
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
