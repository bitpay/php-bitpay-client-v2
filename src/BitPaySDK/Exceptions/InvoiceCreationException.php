<?php

/**
 * Copyright (c) 2019 BitPay
 **/

declare(strict_types=1);

namespace BitPaySDK\Exceptions;

use Exception;

class InvoiceCreationException extends InvoiceException
{
    private string $bitPayMessage = "Failed to create invoice";
    private string $bitPayCode = "BITPAY-INVOICE-CREATE";

    /**
     * Construct the InvoiceCreationException.
     *
     * @param string $message [optional] The Exception message to throw.
     * @param int $code [optional] The Exception code to throw.
     * @param string|null $apiCode [optional] The API Exception code to throw.
     */
    public function __construct($message = "", $code = 102, Exception $previous = null, ?string $apiCode = "000000")
    {
        $message = $this->bitPayCode . ": " . $this->bitPayMessage . "-> " . $message;
        parent::__construct($message, $code, $previous, $apiCode);
    }
}
