<?php

namespace BitPaySDK\Exceptions;


class WalletQueryException extends WalletException
{
    private $bitPayMessage = "Failed to retrieve supported wallets";
    private $bitPayCode    = "BITPAY-WALLET-GET";

    /**
     * Construct the WalletQueryException.
     *
     * @param string $message [optional] The Exception message to throw.
     * @param int    $code    [optional] The Exception code to throw.
     */
    public function __construct($message = "", $code = 167)
    {

        $message = $this->bitPayCode.": ".$this->bitPayMessage."-> ".$message;

        parent::__construct($message, $code);
    }
}
