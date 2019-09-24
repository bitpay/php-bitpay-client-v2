<?php

namespace BitPaySDK\Exceptions;


class PayoutCancellationException extends PayoutException
{
    private $bitPayMessage = "Failed to cancel payout batch";
    private $bitPayCode    = "BITPAY-PAYOUT-BATCH-CANCEL";

    /**
     * Construct the PayoutCancellationException.
     *
     * @param string $message [optional] The Exception message to throw.
     * @param int    $code    [optional] The Exception code to throw.
     */
    public function __construct($message = "", $code = 124)
    {

        $message = $this->bitPayCode.": ".$this->bitPayMessage."-> ".$message;

        parent::__construct($message, $code);
    }
}