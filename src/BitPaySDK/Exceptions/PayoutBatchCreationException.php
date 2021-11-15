<?php


namespace BitPaySDK\Exceptions;


class PayoutBatchCreationException extends BitPayException
{
    private $bitPayMessage = "Failed to create payout batch";
    private $bitPayCode    = "BITPAY-PAYOUT-BATCH-SUBMIT";

    /**
     * Construct the PayoutBatchCreationException.
     *
     * @param string $message [optional] The Exception message to throw.
     * @param int    $code    [optional] The Exception code to throw.
     */
    public function __construct($message = "", $code = 126)
    {

        $message = $this->bitPayCode.": ".$this->bitPayMessage."-> ".$message;

        parent::__construct($message, $code);
    }
}