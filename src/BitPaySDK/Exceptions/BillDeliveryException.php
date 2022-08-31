<?php

namespace BitPaySDK\Exceptions;

use Exception;

class BillDeliveryException extends BillException
{
    private $bitPayMessage = "Failed to deliver bill";
    private $bitPayCode    = "BITPAY-BILL-DELIVERY";

    /**
     * Construct the BillDeliveryException.
     *
     * @param string $message [optional] The Exception message to throw.
     * @param int    $code    [optional] The Exception code to throw.
     * @param string $apiCode [optional] The API Exception code to throw.
     */
    public function __construct($message = "", $code = 115, Exception $previous = null, $apiCode = "000000")
    {
        $message = $this->bitPayCode . ": " . $this->bitPayMessage . "-> " . $message;
        parent::__construct($message, $code, $previous, $apiCode);
    }
}
