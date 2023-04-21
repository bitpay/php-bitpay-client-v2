<?php

/**
 * Copyright (c) 2019 BitPay
 **/

declare(strict_types=1);

namespace BitPaySDK\Exceptions;

use Exception;

class InvoicePaymentException extends InvoiceException
{
    private string $bitPayMessage = "Failed to pay invoice";
    private string $bitPayCode = "BITPAY-INVOICE-PAY-UPDATE";

    /**
     * Construct the InvoicePaymentException.
     *
     * @param string $message [optional] The Exception message to throw.
     * @param int $code [optional] The Exception code to throw.
     * @param string|null $apiCode [optional] The API Exception code to throw.
     */
    public function __construct($message = "", $code = 107, Exception $previous = null, ?string $apiCode = "000000")
    {
        $message = $this->bitPayCode . ": " . $this->bitPayMessage . "-> " . $message;
        $this->apiCode = $apiCode;
        parent::__construct($message, $code, $previous, $apiCode);
    }
}
