<?php

namespace BitPaySDK\Exceptions;


class BillCreationException extends BillException
{
    private $bitPayMessage = "Failed to create bill";
    private $bitPayCode    = "BITPAY-BILL-CREATE";

    /**
     * Construct the BillCreationException.
     *
     * @param string $message [optional] The Exception message to throw.
     * @param int    $code    [optional] The Exception code to throw.
     */
    public function __construct($message = "", $code = 112)
    {

        $message = $this->bitPayCode.": ".$this->bitPayMessage."-> ".$message;

        parent::__construct($message, $code);
    }
}