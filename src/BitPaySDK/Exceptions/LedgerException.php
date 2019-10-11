<?php

namespace BitPaySDK\Exceptions;


class LedgerException extends BitPayException
{
    private $bitPayMessage = "An unexpected error occurred while trying to manage the ledger";
    private $bitPayCode    = "BITPAY-LEDGER-GENERIC";

    /**
     * Construct the LedgerException.
     *
     * @param string $message [optional] The Exception message to throw.
     * @param int    $code    [optional] The Exception code to throw.
     */
    public function __construct($message = "", $code = 131)
    {
        if (!$message) {
            $message = $this->bitPayCode.": ".$this->bitPayMessage."-> ".$message;
        }

        parent::__construct($message, $code);
    }
}