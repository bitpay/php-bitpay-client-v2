<?php

namespace BitPaySDK\Exceptions;


use Exception;

class SubscriptionException extends BitPayException
{
    private $bitPayMessage = "An unexpected error occurred while trying to manage the subscription";
    private $bitPayCode    = "BITPAY-SUBSCRIPTION-GENERIC";
    protected $apiCode;

    /**
     * Construct the SubscriptionException.
     *
     * @param string $message [optional] The Exception message to throw.
     * @param int    $code    [optional] The Exception code to throw.
     * @param string $apiCode [optional] The API Exception code to throw.
     */
    public function __construct($message = "", $code = 171, Exception $previous=NULL, $apiCode = "000000")
    {
        if (!$message) {
            $message = $this->bitPayCode.": ".$this->bitPayMessage."-> ".$message;
        }
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