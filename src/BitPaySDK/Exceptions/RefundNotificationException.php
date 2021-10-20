<?php

namespace BitPaySDK\Exceptions;


class RefundNotificationException extends RefundException
{
    private $bitPayMessage = "Failed to send refund notification";
    private $bitPayCode    = "BITPAY-REFUND-NOTIFICATION";

    /**
     * Construct the RefundNotificationException.
     *
     * @param string $message [optional] The Exception message to throw.
     * @param int    $code    [optional] The Exception code to throw.
     */
    public function __construct($message = "", $code = 166)
    {

        $message = $this->bitPayCode.": ".$this->bitPayMessage."-> ".$message;

        parent::__construct($message, $code);
    }
}
