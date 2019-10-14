<?php

namespace BitPaySDK\Exceptions;


class SettlementException extends BitPayException
{
    private $bitPayMessage = "An unexpected error occurred while trying to manage the settlements";
    private $bitPayCode    = "BITPAY-SETTLEMENTS-GENERIC";

    /**
     * Construct the SettlementException.
     *
     * @param string $message [optional] The Exception message to throw.
     * @param int    $code    [optional] The Exception code to throw.
     */
    public function __construct($message = "", $code = 151)
    {
        if (!$message) {
            $message = $this->bitPayCode.": ".$this->bitPayMessage."-> ".$message;
        }

        parent::__construct($message, $code);
    }
}