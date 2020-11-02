<?php


namespace BitPaySDK\Model\Payout;


use BitPaySDK;

/**
 *
 * @package Bitpay
 */
class PayoutRecipient
{
    protected $_email;
    protected $_label;
    protected $_notificationURL;

    protected $_status;
    protected $_id;
    protected $_shopperId;
    protected $_token;

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

    public function getLabel()
    {
        return $this->_label;
    }

    public function setLabel(?string $label)
    {
        $this->_label = $label;
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

    public function toArray()
    {
        $elements = [
            'email'           => $this->getEmail(),
            'label'           => $this->getLabel(),
            'notificationURL' => $this->getNotificationURL(),
            'status'          => $this->getStatus(),
            'id'              => $this->getId(),
            'shopperId'       => $this->getShopperId(),
            'token'           => $this->getToken(),
        ];

        foreach ($elements as $key => $value) {
            if (empty($value)) {
                unset($elements[$key]);
            }
        }

        return $elements;
    }
}
