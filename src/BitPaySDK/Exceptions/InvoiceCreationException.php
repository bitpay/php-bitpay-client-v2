<?php

namespace BitPaySDK\Exceptions;

use Exception;

class InvoiceCreationException extends InvoiceException
{
    private $bitPayMessage = "Failed to create invoice";
    private $bitPayCode    = "BITPAY-INVOICE-CREATE";

    /**
     * Construct the InvoiceCreationException.
     *
     * @param string $message [optional] The Exception message to throw.
     * @param int    $code    [optional] The Exception code to throw.
     * @param string $apiCode [optional] The API Exception code to throw.
     */
    public function __construct($message = "", $code = 102, Exception $previous = null, $apiCode = "000000")
    {
        $message = $this->bitPayCode . ": " . $this->bitPayMessage . "-> " . $message;
        parent::__construct($message, $code, $previous, $apiCode);
    }
}
