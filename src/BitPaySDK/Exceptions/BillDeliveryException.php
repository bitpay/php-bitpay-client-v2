<?php

namespace BitPaySDK\Exceptions;


use Exception;

class BillDeliveryException extends BillException
{
    private $bitPayMessage = "Failed to deliver bill";
    private $bitPayCode    = "BITPAY-BILL-DELIVERY";
    protected $apiCode;

    /**
     * Construct the BillDeliveryException.
     *
     * @param string $message [optional] The Exception message to throw.
     * @param int    $code    [optional] The Exception code to throw.
     * @param string $apiCode [optional] The API Exception code to throw.
     */
    public function __construct($message = "", $code = 115, Exception $previous=NULL, $apiCode = "000000")
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