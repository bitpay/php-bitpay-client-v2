<?php


namespace BitPay\Exceptions;


use Throwable;

class BitPayException extends \Exception
{
    private $bitPayMessage = "Unexpected Bitpay exeption. ";
    private $bitPayCode = "BITPAY-GENERIC: ";

    /**
     * Construct the BitPayException.
     *
     * @param string $message [optional] The Exception message to throw.
     * @param int $code [optional] The Exception code.
     * @param Throwable $previous [optional] The previous throwable used for the exception chaining.
     */
    public function __construct($message = "") {

        $message = $this->bitPayCode . $this->bitPayMessage . $message;

        parent::__construct($message, 101);
    }
}