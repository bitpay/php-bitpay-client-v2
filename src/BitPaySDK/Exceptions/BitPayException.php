<?php

/**
 * Copyright (c) 2019 BitPay
 **/

declare(strict_types=1);

namespace BitPaySDK\Exceptions;

use Exception;

class BitPayException extends Exception
{
    private string $bitPayMessage = "Unexpected Bitpay exeption.";
    private string $bitPayCode = "BITPAY-GENERIC";
    protected ?string $apiCode;

    /**
     * Construct the BitPayException.
     *
     * @param string $message [optional] The Exception message to throw.
     * @param int $code [optional] The Exception code to throw.
     * @param string|null $apiCode [optional] The API Exception code to throw.
     */
    public function __construct($message = "", $code = 100, Exception $previous = null, ?string $apiCode = null)
    {
        if (!$message) {
            $message = $this->bitPayCode . ": " . $this->bitPayMessage . "-> " . $message;
        }
        $this->apiCode = $apiCode;
        $code = $code ?? 100;
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return string Error code provided by the BitPay REST API
     */
    public function getApiCode()
    {
        return $this->apiCode;
    }
}
