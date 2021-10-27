<?php

namespace BitPaySDK\Exceptions;


class InvoiceCancellationException extends InvoiceException
{
    private $bitPayMessage = "Failed to cancel invoice object";
    private $bitPayCode    = "BITPAY-INVOICE-CANCEL";

    /**
     * Construct the InvoiceCancellationException.
     *
     * @param string $message [optional] The Exception message to throw.
     * @param int    $code    [optional] The Exception code to throw.
     */
    public function __construct($message = "", $code = 105)
    {

        $message = $this->bitPayCode.": ".$this->bitPayMessage."-> ".$message;

        parent::__construct($message, $code);
    }
}
