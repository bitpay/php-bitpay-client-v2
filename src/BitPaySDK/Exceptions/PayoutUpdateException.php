<?php

namespace BitPaySDK\Exceptions;


class PayoutUpdateException extends PayoutException
{
    private $bitPayMessage = "Failed to update payout batch";
    private $bitPayCode    = "BITPAY-PAYOUT-BATCH-UPDATE";

    /**
     * Construct the PayoutUpdateException.
     *
     * @param string $message [optional] The Exception message to throw.
     * @param int    $code    [optional] The Exception code to throw.
     */
    public function __construct($message = "", $code = 125)
    {

        $message = $this->bitPayCode.": ".$this->bitPayMessage."-> ".$message;

        parent::__construct($message, $code);
    }
}