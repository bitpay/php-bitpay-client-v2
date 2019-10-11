<?php

namespace BitPaySDK\Exceptions;


class PayoutException extends BitPayException
{
    private $bitPayMessage = "An unexpected error occurred while trying to manage the payout batch";
    private $bitPayCode    = "BITPAY-PAYOUT-GENERIC";

    /**
     * Construct the PayoutException.
     *
     * @param string $message [optional] The Exception message to throw.
     * @param int    $code    [optional] The Exception code to throw.
     */
    public function __construct($message = "", $code = 121)
    {
        if (!$message) {
            $message = $this->bitPayCode.": ".$this->bitPayMessage."-> ".$message;
        }

        parent::__construct($message, $code);
    }
}