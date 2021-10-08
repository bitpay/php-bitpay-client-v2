<?php

namespace BitPaySDK\Exceptions;


class WalletQueryException extends RefundException
{
    
    /**
     * Construct the WalletQueryException.
     *
     * @param $message String [optional] The Exception message to throw.
    */
    private $bitPayMessage = "Failed to retrieve supported wallets";
    private $bitPayCode = "BITPAY-WALLET-GET";

    public function __construct($message = "")
    {
        if (!$message) {
            $message = $this->bitPayMessage."-> ".$message;
        }
        parent::__construct($message);
    }
}
