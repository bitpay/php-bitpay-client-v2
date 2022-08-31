<?php

namespace BitPaySDK\Exceptions;

use Exception;

class InvoicePaymentException extends InvoiceException
{
    private $bitPayMessage = "Failed to pay invoice";
    private $bitPayCode    = "BITPAY-INVOICE-PAY-UPDATE";

    /**
     * Construct the InvoicePaymentException.
     *
     * @param string $message [optional] The Exception message to throw.
     * @param int    $code    [optional] The Exception code to throw.
     * @param string $apiCode [optional] The API Exception code to throw.
     */
    public function __construct($message = "", $code = 107, Exception $previous = null, $apiCode = "000000")
    {
        $message = $this->bitPayCode . ": " . $this->bitPayMessage . "-> " . $message;
        $this->apiCode = $apiCode;
        parent::__construct($message, $code, $previous, $apiCode);
    }
}
