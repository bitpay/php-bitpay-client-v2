<?php

namespace BitPaySDK\Exceptions;


use Exception;

class RefundCreationException extends RefundException
{
    private $bitPayMessage = "Failed to create refund";
    private $bitPayCode    = "BITPAY-REFUND-CREATE";
    protected $apiCode;

    /**
     * Construct the RefundCreationException.
     *
     * @param string $message [optional] The Exception message to throw.
     * @param int    $code    [optional] The Exception code to throw.
     * @param string $apiCode [optional] The API Exception code to throw.
     */
    public function __construct($message = "", $code = 162, Exception $previous=NULL, $apiCode = "000000")
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