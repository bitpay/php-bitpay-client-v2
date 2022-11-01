<?php

/**
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace BitPaySDK\Model\Payout;

/**
 *
 * @package Bitpay
 */
class PayoutRecipients
{
    protected $_guid  = '';
    protected $_recipients = [];
    protected $_token      = '';

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

    /**
     * Gets guid.
     *
     * @return string
     */
    public function getGuid()
    {
        return $this->_guid;
    }

    /**
     * Sets guid.
     *
     * @param string $guid
     */
    public function setGuid(string $guid)
    {
        $this->_guid = $guid;
    }

    /**
     * Gets token.
     *
     * @return string
     */
    public function getToken()
    {
        return $this->_token;
    }

    /**
     * Sets token.
     *
     * @param string $token
     */
    public function setToken(string $token)
    {
        $this->_token = $token;
    }

    // Required fields
    //

    /**
     * Gets an array with all recipients.
     *
     * @return array
     */
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

    /**
     * Sets array with all recipients.
     *
     * @param array $recipients
     */
    public function setRecipients(array $recipients)
    {
        $this->_recipients = $recipients;
    }

    /**
     * Return an array with paid and unpaid value.
     *
     * @return array
     */
    public function toArray()
    {
        $elements = [
            'guid'       => $this->getGuid(),
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
