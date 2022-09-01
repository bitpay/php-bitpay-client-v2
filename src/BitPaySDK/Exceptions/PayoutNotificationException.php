<?php

namespace BitPaySDK\Exceptions;

use Exception;

class PayoutNotificationException extends PayoutException
{
    private $bitPayMessage = "Failed to send payout notification";
    private $bitPayCode    = "BITPAY-PAYOUT-NOTIFICATION";

    /**
     * Construct the PayoutNotificationException.
     *
     * @param string $message [optional] The Exception message to throw.
     * @param int    $code    [optional] The Exception code to throw.
     * @param string $apiCode [optional] The API Exception code to throw.
     */
    public function __construct($message = "", $code = 126, Exception $previous = null, $apiCode = "000000")
    {
        $message = $this->bitPayCode . ": " . $this->bitPayMessage . "-> " . $message;
        parent::__construct($message, $code, $previous, $apiCode);
    }
}
