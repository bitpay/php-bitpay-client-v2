<?php

namespace BitPaySDK\Exceptions;


class RefundException extends BitPayException
{
    private $bitPayMessage = "An unexpected error occurred while trying to manage the refund";
    private $bitPayCode    = "BITPAY-REFUND-GENERIC";

    /**
     * Construct the RefundException.
     *
     * @param string $message [optional] The Exception message to throw.
     * @param int    $code    [optional] The Exception code to throw.
     */
    public function __construct($message = "", $code = 161)
    {
        if (!$message) {
            $message = $this->bitPayCode.": ".$this->bitPayMessage."-> ".$message;
        }

        parent::__construct($message, $code);
    }
}