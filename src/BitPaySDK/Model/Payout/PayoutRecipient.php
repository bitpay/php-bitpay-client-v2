<?php

namespace BitPaySDK\Model\Payout;

/**
 *
 * @package Bitpay
 */
class PayoutRecipient
{
    protected $_email;
    protected $_guid;
    protected $_label;
    protected $_reference;
    protected $_notificationURL;

    protected $_account;
    protected $_status;
    protected $_id;
    protected $_shopperId;
    protected $_token;
    protected $_supportPhone;

    /**
     * Constructor, create a minimal Recipient object.
     *
     * @param $email           string Recipient email address to which the invite shall be sent.
     * @param $label           string Recipient nickname assigned by the merchant (Optional).
     * @param $notificationURL string URL to which BitPay sends webhook notifications to inform the merchant about the
     *                         status of a given recipient. HTTPS is mandatory (Optional).
     */
    public function __construct(string $email = null, string $label = null, string $notificationURL = null)
    {
        $this->_email = $email;
        $this->_label = $label;
        $this->_notificationURL = $notificationURL;
    }

    // Required fields
    //

    public function getEmail()
    {
        return $this->_email;
    }

    public function setEmail(?string $email)
    {
        $this->_email = $email;
    }

    // Optional fields
    //

    public function getGuid()
    {
        return $this->_guid;
    }

    public function setGuid(string $guid)
    {
        $this->_guid = $guid;
    }

    public function getLabel()
    {
        return $this->_label;
    }

    public function setLabel(?string $label)
    {
        $this->_label = $label;
    }

    public function getReference()
    {
        return $this->_reference;
    }

    public function setReference(string $reference)
    {
        $this->_reference = $reference;
    }

    public function getNotificationURL()
    {
        return $this->_notificationURL;
    }

    public function setNotificationURL(?string $notificationURL)
    {
        $this->_notificationURL = $notificationURL;
    }

    // Response fields
    //

    public function getAccount()
    {
        return $this->account;
    }

    public function setAccount(string $account)
    {
        $this->_account = $account;
    }

    public function getStatus()
    {
        return $this->_status;
    }

    public function setStatus(string $status)
    {
        $this->_status = $status;
    }

    public function getId()
    {
        return $this->_id;
    }

    public function setId(?string $id)
    {
        $this->_id = $id;
    }

    public function getShopperId()
    {
        return $this->_shopperId;
    }

    public function setShopperId(?string $shopperId)
    {
        $this->_shopperId = $shopperId;
    }

    public function getToken()
    {
        return $this->_token;
    }

    public function setToken(string $token)
    {
        $this->_token = $token;
    }

    public function getSupportPhone()
    {
        return $this->_supportPhone;
    }

    public function setSupportPhone(string $supportPhone)
    {
        $this->_supportPhone = $supportPhone;
    }

    public function toArray()
    {
        $elements = [
            'email'           => $this->getEmail(),
            'guid'            => $this->getGuid(),
            'label'           => $this->getLabel(),
            'reference'       => $this->getReference(),
            'notificationURL' => $this->getNotificationURL(),
            'account'         => $this->getAccount(),
            'status'          => $this->getStatus(),
            'id'              => $this->getId(),
            'shopperId'       => $this->getShopperId(),
            'token'           => $this->getToken(),
            'supportPhone'    => $this->getSupportPhone()
        ];

        foreach ($elements as $key => $value) {
            if (empty($value)) {
                unset($elements[$key]);
            }
        }

        return $elements;
    }
}
