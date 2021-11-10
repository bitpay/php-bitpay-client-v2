<?php


namespace BitPaySDK\Exceptions;


class PayoutCreationException extends BitPayException
{
    private $bitPayMessage = "Failed to create payout";
    private $bitPayCode    = "BITPAY-PAYOUT-SUBMIT";

    /**
     * Construct the PayoutCreationException.
     *
     * @param string $message [optional] The Exception message to throw.
     * @param int    $code    [optional] The Exception code to throw.
     */
    public function __construct($message = "", $code = 122)
    {

        $message = $this->bitPayCode.": ".$this->bitPayMessage."-> ".$message;

        parent::__construct($message, $code);
    }
}