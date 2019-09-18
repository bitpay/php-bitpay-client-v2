<?php

namespace BitPay\Exceptions;


class InvoiceException extends BitPayException
{
    private $bitPayMessage = "An unexpected error occured while trying to manage the invoice";
    private $bitPayCode    = "BITPAY-INVOICE-GENERIC";

    /**
     * Construct the InvoiceException.
     *
     * @param string $message [optional] The Exception message to throw.
     */
    public function __construct($message = "", $code = 102)
    {

        $message = $this->bitPayCode.": ".$this->bitPayMessage."-> ".$message;

        parent::__construct($message, $code);
    }
}