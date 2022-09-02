<?php

namespace BitPaySDK\Exceptions;

use Exception;

class PayoutRecipientUpdateException extends PayoutRecipientException
{
    private $bitPayMessage = "Failed to update payout recipient";
    private $bitPayCode    = "BITPAY-PAYOUT-RECIPIENT-UPDATE";

    /**
     * Construct the PayoutRecipientUpdateException.
     *
     * @param string $message [optional] The Exception message to throw.
     * @param int    $code    [optional] The Exception code to throw.
     * @param string $apiCode [optional] The API Exception code to throw.
     */
    public function __construct($message = "", $code = 195, Exception $previous = null, $apiCode = "000000")
    {
        $message = $this->bitPayCode . ": " . $this->bitPayMessage . "-> " . $message;
        parent::__construct($message, $code, $previous, $apiCode);
    }
}
