<?php

namespace BitPay\Exceptions;


class BitPayException extends \Exception
{
    private $bitPayMessage = "Unexpected Bitpay exeption. ";
    private $bitPayCode    = "BITPAY-GENERIC: ";

    /**
     * Construct the BitPayException.
     *
     * @param string $message [optional] The Exception message to throw.
     */
    public function __construct($message = "")
    {

        $message = $this->bitPayCode.$this->bitPayMessage.$message;

        parent::__construct($message, 101);
    }
}