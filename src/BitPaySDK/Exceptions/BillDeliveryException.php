<?php

namespace BitPaySDK\Exceptions;


class BillDeliveryException extends BillException
{
    private $bitPayMessage = "Failed to deliver bill";
    private $bitPayCode    = "BITPAY-BILL-DELIVERY";

    /**
     * Construct the BillDeliveryException.
     *
     * @param string $message [optional] The Exception message to throw.
     * @param int    $code    [optional] The Exception code to throw.
     */
    public function __construct($message = "", $code = 115)
    {

        $message = $this->bitPayCode.": ".$this->bitPayMessage."-> ".$message;

        parent::__construct($message, $code);
    }
}