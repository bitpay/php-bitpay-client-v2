<?php


namespace BitPaySDK\Model\Payout;


use BitPaySDK;

/**
 *
 * @package Bitpay
 */
class PayoutRecipients
{
    protected $_guid  = "";
    protected $_recipients = [];
    protected $_token      = "";

    /**
     * Constructor, create an recipient-full request PayoutBatch object.
     *
     * @param $recipients array array of JSON objects, with containing the following parameters.
     */
    public function __construct(array $recipients = [])
    {
        $this->_recipients = $recipients;
    }

    // API fields
    //

    public function getGuid()
    {
        return $this->_guid;
    }

    public function setGuid(string $guid)
    {
        $this->_guid = $guid;
    }

    public function getToken()
    {
        return $this->_token;
    }

    public function setToken(string $token)
    {
        $this->_token = $token;
    }

    // Required fields
    //

    public function getRecipients()
    {
        $recipients = [];

        foreach ($this->_recipients as $recipient) {
            if ($recipient instanceof PayoutRecipient) {
                array_push($recipients, $recipient->toArray());
            } else {
                array_push($recipients, $recipient);
            }
        }

        return $recipients;
    }

    public function setRecipients(array $recipients)
    {
        $this->_recipients = $recipients;
    }

    public function toArray()
    {
        $elements = [
            'recipients' => $this->getRecipients(),
            'token'      => $this->getToken(),
        ];

        foreach ($elements as $key => $value) {
            if (empty($value)) {
                unset($elements[$key]);
            }
        }

        return $elements;
    }
}
