<?php

namespace BitPaySDK\Exceptions;


class InvoiceException extends BitPayException
{
    private $bitPayMessage = "An unexpected error occurred while trying to manage the invoice";
    private $bitPayCode    = "BITPAY-INVOICE-GENERIC";

    /**
     * Construct the InvoiceException.
     *
     * @param string $message [optional] The Exception message to throw.
     * @param int    $code    [optional] The Exception code to throw.
     */
    public function __construct($message = "", $code = 101)
    {
        if (!$message) {
            $message = $this->bitPayCode.": ".$this->bitPayMessage."-> ".$message;
        }

        parent::__construct($message, $code);
    }
}