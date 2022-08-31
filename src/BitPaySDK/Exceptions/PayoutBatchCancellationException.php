<?php

namespace BitPaySDK\Exceptions;

use Exception;

class PayoutBatchCancellationException extends PayoutBatchException
{
    private $bitPayMessage = "Failed to cancel payout batch";
    private $bitPayCode    = "BITPAY-PAYOUT-BATCH-CANCEL";

    /**
     * Construct the PayoutBatchCancellationException.
     *
     * @param string $message [optional] The Exception message to throw.
     * @param int    $code    [optional] The Exception code to throw.
     * @param string $apiCode [optional] The API Exception code to throw.
     */
    public function __construct($message = "", $code = 204, Exception $previous = null, $apiCode = "000000")
    {
        $message = $this->bitPayCode . ": " . $this->bitPayMessage . "-> " . $message;
        parent::__construct($message, $code, $previous, $apiCode);
    }
}
