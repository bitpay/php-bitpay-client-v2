<?php

namespace BitPaySDK\Exceptions;


use Exception;

class PayoutBatchNotificationException extends PayoutBatchException
{
    private $bitPayMessage = "Failed to send payout batch notification";
    private $bitPayCode    = "BITPAY-PAYOUT-BATCH-NOTIFICATION";
    protected $apiCode;

    /**
     * Construct the PayoutBatchNotificationException.
     *
     * @param string $message [optional] The Exception message to throw.
     * @param int    $code    [optional] The Exception code to throw.
     * @param string $apiCode [optional] The API Exception code to throw.
     */
    public function __construct($message = "", $code = 205, Exception $previous=NULL, $apiCode = "000000")
    {
        $message = $this->bitPayCode.": ".$this->bitPayMessage."-> ".$message;
        $this->apiCode = $apiCode;
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return string Error code provided by the BitPay REST API
     */
    public function getApiCode()
    {
        return $this->apiCode;
    }
}