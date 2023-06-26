<?php

/**
 * Copyright (c) 2019 BitPay
 **/

declare(strict_types=1);

namespace BitPaySDK\Exceptions;

use Exception;

class RefundException extends BitPayException
{
    private string $bitPayMessage = "An unexpected error occurred while trying to manage the refund";
    private string $bitPayCode = "BITPAY-REFUND-GENERIC";

    /**
     * Construct the RefundException.
     *
     * @param string $message [optional] The Exception message to throw.
     * @param int $code [optional] The Exception code to throw.
     * @param string|null $apiCode [optional] The API Exception code to throw.
     */
    public function __construct($message = "", $code = 161, Exception $previous = null, ?string $apiCode = "000000")
    {
        if (!$message) {
            $message = $this->bitPayCode . ": " . $this->bitPayMessage . "-> " . $message;
        }
        parent::__construct($message, $code, $previous, $apiCode);
    }
}
