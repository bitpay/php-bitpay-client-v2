<?php

namespace BitPaySDK\Exceptions;


class LedgerQueryException extends LedgerException
{
    private $bitPayMessage = "Failed to retrieve ledger";
    private $bitPayCode    = "BITPAY-LEDGER-GET";

    /**
     * Construct the LedgerQueryException.
     *
     * @param string $message [optional] The Exception message to throw.
     * @param int    $code    [optional] The Exception code to throw.
     */
    public function __construct($message = "", $code = 132)
    {

        $message = $this->bitPayCode.": ".$this->bitPayMessage."-> ".$message;

        parent::__construct($message, $code);
    }
}