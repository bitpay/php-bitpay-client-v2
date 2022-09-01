<?php

namespace BitPaySDK\Exceptions;

use Exception;

class SubscriptionException extends BitPayException
{
    private $bitPayMessage = "An unexpected error occurred while trying to manage the subscription";
    private $bitPayCode    = "BITPAY-SUBSCRIPTION-GENERIC";

    /**
     * Construct the SubscriptionException.
     *
     * @param string $message [optional] The Exception message to throw.
     * @param int    $code    [optional] The Exception code to throw.
     * @param string $apiCode [optional] The API Exception code to throw.
     */
    public function __construct($message = "", $code = 171, Exception $previous = null, $apiCode = "000000")
    {
        if (!$message) {
            $message = $this->bitPayCode . ": " . $this->bitPayMessage . "-> " . $message;
        }
        parent::__construct($message, $code, $previous, $apiCode);
    }
}
