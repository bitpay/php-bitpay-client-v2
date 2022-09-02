<?php

namespace BitPaySDK\Exceptions;

use Exception;

class RefundCreationException extends RefundException
{
    private $bitPayMessage = "Failed to create refund";
    private $bitPayCode    = "BITPAY-REFUND-CREATE";

    /**
     * Construct the RefundCreationException.
     *
     * @param string $message [optional] The Exception message to throw.
     * @param int    $code    [optional] The Exception code to throw.
     * @param string $apiCode [optional] The API Exception code to throw.
     */
    public function __construct($message = "", $code = 162, Exception $previous = null, $apiCode = "000000")
    {
        $message = $this->bitPayCode . ": " . $this->bitPayMessage . "-> " . $message;
        parent::__construct($message, $code, $previous, $apiCode);
    }
}
