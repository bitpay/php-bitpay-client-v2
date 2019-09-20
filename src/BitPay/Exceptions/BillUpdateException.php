<?php

namespace BitPay\Exceptions;


class BillDeliverException extends BillException
{
    private $bitPayMessage = "Failed to deliver bill";
    private $bitPayCode    = "BITPAY-BILL-DELIVER";

    /**
     * Construct the BillDeliverException.
     *
     * @param string $message [optional] The Exception message to throw.
     * @param int $code [optional] The Exception code to throw.
     */
    public function __construct($message = "", $code = 115)
    {

        $message = $this->bitPayCode.": ".$this->bitPayMessage."-> ".$message;

        parent::__construct($message, $code);
    }
}