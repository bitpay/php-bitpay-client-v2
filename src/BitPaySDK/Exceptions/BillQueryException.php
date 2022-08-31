<?php

namespace BitPaySDK\Exceptions;

use Exception;

class BillQueryException extends BillException
{
    private $bitPayMessage = "Failed to retrieve bill";
    private $bitPayCode    = "BITPAY-BILL-GET";

    /**
     * Construct the BillQueryException.
     *
     * @param string $message [optional] The Exception message to throw.
     * @param int    $code    [optional] The Exception code to throw.
     * @param string $apiCode [optional] The API Exception code to throw.
     */
    public function __construct($message = "", $code = 113, Exception $previous = null, $apiCode = "000000")
    {
        $message = $this->bitPayCode . ": " . $this->bitPayMessage . "-> " . $message;
        parent::__construct($message, $code, $previous, $apiCode);
    }
}
