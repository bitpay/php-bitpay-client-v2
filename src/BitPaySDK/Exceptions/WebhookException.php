<?php

namespace BitPaySDK\Exceptions;

class WebhookException extends BitPayException
{
    private $bitPayMessage = "An unexpected error occurred while trying to manage the webhook";
    private $bitPayCode = "BITPAY-WEBHOOK-GENERIC";

    /**
     * Construct the WebhookException.
     *
     * @param string $message [optional] The Exception message to throw.
     * @param int $code [optional] The Exception code to throw.
     */
    public function __construct($message = "", $code = 181)
    {
        if (!$message) {
            $message = $this->bitPayCode . ": " . $this->bitPayMessage . "-> " . $message;
        }

        parent::__construct($message, $code);
    }
}