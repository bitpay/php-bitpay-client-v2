<?php

namespace BitPaySDK\Exceptions;


use Exception;

class PayoutRecipientUpdateException extends PayoutRecipientException
{
    private $bitPayMessage = "Failed to update payout recipient";
    private $bitPayCode    = "BITPAY-PAYOUT-RECIPIENT-UPDATE";
    protected $apiCode;

    /**
     * Construct the PayoutRecipientUpdateException.
     *
     * @param string $message [optional] The Exception message to throw.
     * @param int    $code    [optional] The Exception code to throw.
     * @param string $apiCode [optional] The API Exception code to throw.
     */
    public function __construct($message = "", $code = 195, Exception $previous=NULL, $apiCode = "000000")
    {
        $message = $this->bitPayCode.": ".$this->bitPayMessage."-> ".$message;
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