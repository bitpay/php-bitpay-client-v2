<?php

namespace BitPay\Exceptions;


class InvoiceCreationException extends InvoiceException
{
    private $bitPayMessage = "Failed to create invoice";
    private $bitPayCode    = "BITPAY-INVOICE-CREATE";

    /**
     * Construct the InvoiceCreationException.
     *
     * @param string $message [optional] The Exception message to throw.
     */
    public function __construct($message = "")
    {

        $message = $this->bitPayCode.": ".$this->bitPayMessage."-> ".$message;

        parent::__construct($message, 101);
    }
}