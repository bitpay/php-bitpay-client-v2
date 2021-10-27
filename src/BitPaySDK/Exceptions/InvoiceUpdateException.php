<?php

namespace BitPaySDK\Exceptions;


class InvoiceUpdateException extends InvoiceException
{
    private $bitPayMessage = "Failed to update invoice";
    private $bitPayCode    = "BITPAY-INVOICE-UPDATE";

    /**
     * Construct the InvoiceUpdateException.
     *
     * @param string $message [optional] The Exception message to throw.
     * @param int    $code    [optional] The Exception code to throw.
     */
    public function __construct($message = "", $code = 104)
    {

        $message = $this->bitPayCode.": ".$this->bitPayMessage."-> ".$message;

        parent::__construct($message, $code);
    }
}
