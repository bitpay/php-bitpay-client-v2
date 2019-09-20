<?php


namespace BitPaySDK\Exceptions;


class BillUpdateException extends BillException
{
    private $bitPayMessage = "Failed to update bill";
    private $bitPayCode    = "BITPAY-BILL-UPDATE";

    /**
     * Construct the BillUpdateException.
     *
     * @param string $message [optional] The Exception message to throw.
     * @param int    $code    [optional] The Exception code to throw.
     */
    public function __construct($message = "", $code = 114)
    {

        $message = $this->bitPayCode.": ".$this->bitPayMessage."-> ".$message;

        parent::__construct($message, $code);
    }
}