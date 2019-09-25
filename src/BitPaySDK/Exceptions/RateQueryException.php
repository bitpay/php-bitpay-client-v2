<?php

namespace BitPaySDK\Exceptions;


class RateQueryException extends RateException
{
    private $bitPayMessage = "Failed to retrieve rates";
    private $bitPayCode    = "BITPAY-RATES-GET";

    /**
     * Construct the RateQueryException.
     *
     * @param string $message [optional] The Exception message to throw.
     * @param int    $code    [optional] The Exception code to throw.
     */
    public function __construct($message = "", $code = 142)
    {

        $message = $this->bitPayCode.": ".$this->bitPayMessage."-> ".$message;

        parent::__construct($message, $code);
    }
}