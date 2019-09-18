<?php

namespace BitPay\Exceptions;


class InvoiceQueryException extends InvoiceException
{
    private $bitPayMessage = "Failed to retrieve invoice";
    private $bitPayCode    = "BITPAY-INVOICE-GET";

    /**
     * Construct the InvoiceQueryException.
     *
     * @param string $message [optional] The Exception message to throw.
     */
    public function __construct($message = "")
    {

        $message = $this->bitPayCode.": ".$this->bitPayMessage."-> ".$message;

        parent::__construct($message, 102);
    }
}