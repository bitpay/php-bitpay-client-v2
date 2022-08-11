<?php

namespace BitPaySDK\Exceptions;

class WalletQueryException extends WalletException
{
    private $bitPayMessage = "Failed to retrieve supported wallets";
    private $bitPayCode    = "BITPAY-WALLET-GET";
    protected $apiCode;

    /**
     * Construct the WalletQueryException.
     *
     * @param string $message [optional] The Exception message to throw.
     * @param int    $code    [optional] The Exception code to throw.
     * @param string $apiCode [optional] The API Exception code to throw.
     */
    public function __construct($message = "", $code = 183, Exception $previous = null, $apiCode = "000000")
    {

        $message = $this->bitPayCode . ": " . $this->bitPayMessage . "-> " . $message;
        $this->apiCode = $apiCode;
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
