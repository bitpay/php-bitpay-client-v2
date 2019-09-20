<?php

namespace BitPaySDK\Exceptions;


class InvoiceQueryException extends InvoiceException
{
    private $bitPayMessage = "Failed to retrieve invoice";
    private $bitPayCode    = "BITPAY-INVOICE-GET";

    /**
     * Construct the InvoiceQueryException.
     *
     * @param string $message [optional] The Exception message to throw.
     * @param int    $code    [optional] The Exception code to throw.
     */
    public function __construct($message = "", $code = 103)
    {

        $message = $this->bitPayCode.": ".$this->bitPayMessage."-> ".$message;

        parent::__construct($message, $code);
    }
}