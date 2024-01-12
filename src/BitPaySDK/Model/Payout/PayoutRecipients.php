<?php

/**
 * Copyright (c) 2019 BitPay
 **/

declare(strict_types=1);

/*
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace BitPaySDK\Model\Payout;

use BitPaySDK\Exceptions\BitPayExceptionProvider;
use BitPaySDK\Exceptions\BitPayValidationException;

/**
 * @package BitPaySDK\Model\Payout
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 * @see https://bitpay.readme.io/reference/payouts REST API Payouts
 */
class PayoutRecipients
{
    protected array $recipients = [];
    protected ?string $guid = null;
    protected ?string $token = null;

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
     * @return string|null
     */
    public function getGuid(): ?string
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
     * @return string|null
     */
    public function getToken(): ?string
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
     * @return PayoutRecipient[]
     */
    public function getRecipients(): array
    {
        return $this->recipients;
    }

    /**
     * Sets array with all recipients.
     *
     * @param PayoutRecipient[] $recipients
     * @throws BitPayValidationException
     */
    public function setRecipients(array $recipients): void
    {
        foreach ($recipients as $recipient) {
            if (!$recipient instanceof PayoutRecipient) {
                BitPayExceptionProvider::throwValidationException('Array should contains only PayoutRecipient objects');
            }
        }

        $this->recipients = $recipients;
    }

    /**
     * Return an array with paid and unpaid value.
     *
     * @return array
     */
    public function toArray(): array
    {
        $recipients = [];
        foreach ($this->getRecipients() as $recipient) {
            $recipients[] = $recipient->toArray();
        }

        $elements = [
            'guid' => $this->getGuid(),
            'recipients' => $recipients,
            'token' => $this->getToken(),
        ];

        foreach ($elements as $key => $value) {
            if (empty($value)) {
                unset($elements[$key]);
            }
        }

        return $elements;
    }
}
