<?php


namespace BitPaySDK\Exceptions;


class BillQueryException extends BillException
{
    private $bitPayMessage = "Failed to retrieve bill";
    private $bitPayCode    = "BITPAY-BILL-GET";

    /**
     * Construct the BillQueryException.
     *
     * @param string $message [optional] The Exception message to throw.
     * @param int    $code    [optional] The Exception code to throw.
     */
    public function __construct($message = "", $code = 113)
    {

        $message = $this->bitPayCode.": ".$this->bitPayMessage."-> ".$message;

        parent::__construct($message, $code);
    }
}