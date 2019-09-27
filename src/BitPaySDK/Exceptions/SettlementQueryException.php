<?php

namespace BitPaySDK\Exceptions;


class SettlementQueryException extends SettlementException
{
    private $bitPayMessage = "Failed to retrieve settlements";
    private $bitPayCode    = "BITPAY-SETTLEMENTS-GET";

    /**
     * Construct the SettlementQueryException.
     *
     * @param string $message [optional] The Exception message to throw.
     * @param int    $code    [optional] The Exception code to throw.
     */
    public function __construct($message = "", $code = 152)
    {

        $message = $this->bitPayCode.": ".$this->bitPayMessage."-> ".$message;

        parent::__construct($message, $code);
    }
}