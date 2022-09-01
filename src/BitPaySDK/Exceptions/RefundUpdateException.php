<?php

namespace BitPaySDK\Exceptions;

use Exception;

class RefundUpdateException extends RefundException
{
    private $bitPayMessage = "Failed to update refund";
    private $bitPayCode    = "BITPAY-REFUND-UPDATE";

    /**
     * Construct the RefundUpdateException.
     *
     * @param string $message [optional] The Exception message to throw.
     * @param int    $code    [optional] The Exception code to throw.
     * @param string $apiCode [optional] The API Exception code to throw.
     */
    public function __construct($message = "", $code = 164, Exception $previous = null, $apiCode = "000000")
    {

        $message = $this->bitPayCode . ": " . $this->bitPayMessage . "-> " . $message;
        parent::__construct($message, $code, $previous, $apiCode);
    }
}
