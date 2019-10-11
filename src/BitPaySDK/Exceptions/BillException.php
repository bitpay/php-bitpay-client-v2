<?php

namespace BitPaySDK\Exceptions;


class BillException extends BitPayException
{
    private $bitPayMessage = "An unexpected error occurred while trying to manage the bill";
    private $bitPayCode    = "BITPAY-BILL-GENERIC";

    /**
     * Construct the BillException.
     *
     * @param string $message [optional] The Exception message to throw.
     * @param int    $code    [optional] The Exception code to throw.
     */
    public function __construct($message = "", $code = 111)
    {
        if (!$message) {
            $message = $this->bitPayCode.": ".$this->bitPayMessage."-> ".$message;
        }

        parent::__construct($message, $code);
    }
}