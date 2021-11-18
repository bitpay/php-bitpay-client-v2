<?php


namespace BitPaySDK\Exceptions;


use Exception;

class PayoutRecipientCreationException extends PayoutRecipientException
{
    private $bitPayMessage = "Failed to create payout recipient";
    private $bitPayCode    = "BITPAY-PAYOUT-RECIPIENT-SUBMIT";
    protected $apiCode;

    /**
     * Construct the PayoutRecipientCreationException.
     *
     * @param string $message [optional] The Exception message to throw.
     * @param int    $code    [optional] The Exception code to throw.
     * @param string $apiCode [optional] The API Exception code to throw.
     */
    public function __construct($message = "", $code = 192, Exception $previous=NULL, $apiCode = "000000")
    {
        $message = $this->bitPayCode.": ".$this->bitPayMessage."-> ".$message;
        $this->apiCode = $apiCode;
        parent::__construct($message, $code, $previous, $apiCode);
    }

    /**
     * @return string Error code provided by the BitPay REST API
     */
    public function getApiCode()
    {
        return $this->apiCode;
    }
}