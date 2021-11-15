<?php

namespace BitPaySDK\Exceptions;

class WebhookRequestException extends WebhookException
{
    private $bitPayMessage = "Failed to request resend of webhook";
    private $bitPayCode = "BITPAY-WEBHOOK-REQUEST";

    /**
     * Construct the WebhookRequestException.
     *
     * @param string $message [optional] The Exception message to throw.
     * @param int $code [optional] The Exception code to throw.
     */
    public function __construct($message = "", $code = 182)
    {
        if (!$message) {
            $message = $this->bitPayCode . ": " . $this->bitPayMessage . "-> " . $message;
        }

        parent::__construct($message, $code);
    }
}