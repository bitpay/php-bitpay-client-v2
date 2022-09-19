<?php

namespace BitPaySDK\Exceptions;

use Exception;

class BitPayException extends Exception
{
    private $bitPayMessage = "Unexpected Bitpay exeption.";
    private $bitPayCode    = "BITPAY-GENERIC";
    protected $apiCode;

    /**
     * Construct the BitPayException.
     *
     * @param string $message [optional] The Exception message to throw.
     * @param int    $code    [optional] The Exception code to throw.
     * @param string $apiCode [optional] The API Exception code to throw.
     */
    public function __construct($message = "", $code = 100, Exception $previous = null, $apiCode = null)
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
