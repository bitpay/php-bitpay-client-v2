<?php

/**
 * Copyright (c) 2019 BitPay
 **/

declare(strict_types=1);

namespace BitPaySDK\Exceptions;

use Exception;

/**
 * Payout recipient update exception.
 *
 * @package BitPaySDK\Exceptions
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
class PayoutRecipientUpdateException extends PayoutRecipientException
{
    private string $bitPayMessage = "Failed to update payout recipient";
    private string $bitPayCode = "BITPAY-PAYOUT-RECIPIENT-UPDATE";

    /**
     * Construct the PayoutRecipientUpdateException.
     *
     * @param string $message [optional] The Exception message to throw.
     * @param int $code [optional] The Exception code to throw.
     * @param string|null $apiCode [optional] The API Exception code to throw.
     */
    public function __construct($message = "", $code = 195, Exception $previous = null, ?string $apiCode = "000000")
    {
        $message = $this->bitPayCode . ": " . $this->bitPayMessage . "-> " . $message;
        parent::__construct($message, $code, $previous, $apiCode);
    }
}
