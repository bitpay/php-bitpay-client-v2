<?php

namespace BitPaySDK\Exceptions;

use Exception;

class PayoutRecipientNotificationException extends PayoutRecipientException
{
    private $bitPayMessage = "Failed to send payout recipient notification";
    private $bitPayCode    = "BITPAY-PAYOUT-RECIPIENT-NOTIFICATION";

    /**
     * Construct the PayoutRecipientNotificationException.
     *
     * @param string $message [optional] The Exception message to throw.
     * @param int    $code    [optional] The Exception code to throw.
     * @param string $apiCode [optional] The API Exception code to throw.
     */
    public function __construct($message = "", $code = 196, Exception $previous = null, $apiCode = "000000")
    {
        $message = $this->bitPayCode . ": " . $this->bitPayMessage . "-> " . $message;
        parent::__construct($message, $code, $previous, $apiCode);
    }
}
