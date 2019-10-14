<?php

namespace BitPaySDK\Exceptions;


class RateException extends BitPayException
{
    private $bitPayMessage = "An unexpected error occurred while trying to manage the rates";
    private $bitPayCode    = "BITPAY-RATES-GENERIC";

    /**
     * Construct the RateException.
     *
     * @param string $message [optional] The Exception message to throw.
     * @param int    $code    [optional] The Exception code to throw.
     */
    public function __construct($message = "", $code = 141)
    {
        if (!$message) {
            $message = $this->bitPayCode.": ".$this->bitPayMessage."-> ".$message;
        }

        parent::__construct($message, $code);
    }
}