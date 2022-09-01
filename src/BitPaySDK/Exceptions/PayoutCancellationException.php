<?php

namespace BitPaySDK\Exceptions;

use Exception;

class PayoutCancellationException extends PayoutException
{
    private $bitPayMessage = "Failed to cancel payout";
    private $bitPayCode    = "BITPAY-PAYOUT-CANCEL";

    /**
     * Construct the PayoutCancellationException.
     *
     * @param string $message [optional] The Exception message to throw.
     * @param int    $code    [optional] The Exception code to throw.
     * @param string $apiCode [optional] The API Exception code to throw.
     */
    public function __construct($message = "", $code = 124, Exception $previous = null, $apiCode = "000000")
    {
        $message = $this->bitPayCode . ": " . $this->bitPayMessage . "-> " . $message;
        parent::__construct($message, $code, $previous, $apiCode);
    }
}
