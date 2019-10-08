<?php


namespace BitPaySDK\Exceptions;


class CurrencyQueryException extends CurrencyException
{
    private $bitPayMessage = "Failed to retrieve currencies";
    private $bitPayCode    = "BITPAY-CURRENCY-GET";

    /**
     * Construct the CurrencyQueryException.
     *
     * @param string $message [optional] The Exception message to throw.
     * @param int    $code    [optional] The Exception code to throw.
     */
    public function __construct($message = "", $code = 173)
    {

        $message = $this->bitPayCode.": ".$this->bitPayMessage."-> ".$message;

        parent::__construct($message, $code);
    }
}