<?php

/**
 * Copyright (c) 2019 BitPay
 **/

declare(strict_types=1);

namespace BitPaySDK\Exceptions;

use Exception;

class PayoutRecipientCreationException extends PayoutRecipientException
{
    private string $bitPayMessage = "Failed to create payout recipient";
    private string $bitPayCode = "BITPAY-PAYOUT-RECIPIENT-SUBMIT";

    /**
     * Construct the PayoutRecipientCreationException.
     *
     * @param string $message [optional] The Exception message to throw.
     * @param int $code [optional] The Exception code to throw.
     * @param string|null $apiCode [optional] The API Exception code to throw.
     */
    public function __construct($message = "", $code = 192, Exception $previous = null, ?string $apiCode = "000000")
    {
        $message = $this->bitPayCode . ": " . $this->bitPayMessage . "-> " . $message;
        parent::__construct($message, $code, $previous, $apiCode);
    }
}
