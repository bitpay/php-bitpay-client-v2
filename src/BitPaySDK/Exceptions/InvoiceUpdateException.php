<?php

namespace BitPaySDK\Exceptions;

use Exception;

class InvoiceUpdateException extends InvoiceException
{
    private $bitPayMessage = "Failed to update invoice";
    private $bitPayCode    = "BITPAY-INVOICE-UPDATE";

    /**
     * Construct the InvoiceUpdateException.
     *
     * @param string $message [optional] The Exception message to throw.
     * @param int    $code    [optional] The Exception code to throw.
     * @param string $apiCode [optional] The API Exception code to throw.
     */
    public function __construct($message = "", $code = 104, Exception $previous = null, $apiCode = "000000")
    {
        $message = $this->bitPayCode . ": " . $this->bitPayMessage . "-> " . $message;
        parent::__construct($message, $code, $previous, $apiCode);
    }
}
