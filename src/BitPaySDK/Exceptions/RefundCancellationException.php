<?php

namespace BitPaySDK\Exceptions;


class RefundCancellationException extends RefundException
{
    private $bitPayMessage = "Failed to cancel refund batch";
    private $bitPayCode    = "BITPAY-REFUND-CANCEL";

    /**
     * Construct the RefundCancellationException.
     *
     * @param string $message [optional] The Exception message to throw.
     * @param int    $code    [optional] The Exception code to throw.
     */
    public function __construct($message = "", $code = 164)
    {

        $message = $this->bitPayCode.": ".$this->bitPayMessage."-> ".$message;

        parent::__construct($message, $code);
    }
}