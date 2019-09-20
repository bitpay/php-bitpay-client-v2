<?php

namespace BitPaySDK\Exceptions;


class InvoiceCreationException extends InvoiceException
{
    private $bitPayMessage = "Failed to create invoice";
    private $bitPayCode    = "BITPAY-INVOICE-CREATE";

    /**
     * Construct the InvoiceCreationException.
     *
     * @param string $message [optional] The Exception message to throw.
     * @param int    $code    [optional] The Exception code to throw.
     */
    public function __construct($message = "", $code = 102)
    {

        $message = $this->bitPayCode.": ".$this->bitPayMessage."-> ".$message;

        parent::__construct($message, $code);
    }
}