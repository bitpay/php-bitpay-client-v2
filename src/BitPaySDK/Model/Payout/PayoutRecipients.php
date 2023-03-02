<?php

declare(strict_types=1);

/*
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
    protected array $recipients = [];
    protected string $guid  = '';
    protected string $token      = '';

    /**
     * Constructor, create an recipient-full request PayoutBatch object.
     *
     * @param $recipients array array of JSON objects, with containing the following parameters.
     */
    public function __construct(array $recipients = [])
    {
        $this->recipients = $recipients;
    }

    // API fields
    //

    /**
     * Gets guid.
     *
     * @return string
     */
    public function getGuid(): string
    {
        return $this->guid;
    }

    /**
     * Sets guid.
     *
     * @param string $guid
     */
    public function setGuid(string $guid): void
    {
        $this->guid = $guid;
    }

    /**
     * Gets token.
     *
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * Sets token.
     *
     * @param string $token
     */
    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    // Required fields
    //

    /**
     * Gets an array with all recipients.
     *
     * @return array
     */
    public function getRecipients(): array
    {
        $recipients = [];

        foreach ($this->recipients as $recipient) {
            if ($recipient instanceof PayoutRecipient) {
                $recipients[] = $recipient->toArray();
            } else {
                $recipients[] = $recipient;
            }
        }

        return $recipients;
    }

    /**
     * Sets array with all recipients.
     *
     * @param array $recipients
     */
    public function setRecipients(array $recipients): void
    {
        $this->recipients = $recipients;
    }

    /**
     * Return an array with paid and unpaid value.
     *
     * @return array
     */
    public function toArray(): array
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
