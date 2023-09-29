<?php

declare(strict_types=1);

namespace BitPaySDK\Exceptions;

class BitPayApiException extends BitPayException
{
    private ?string $bitPayCode;

    /**
     * BitPayException constructor.
     *
     * @param string|null $message
     * @param string|null $bitPayCode
     */
    public function __construct(?string $message, ?string $bitPayCode)
    {
        if (!$message) {
            $message = "";
        }

        $this->bitPayCode = $bitPayCode;
        parent::__construct($message);
    }

    /**
     * <p>An error code consists of 6 digits. </p>
     * <p>The first two digits of an error code represent the HTTP method that was used to call it.</p>
     * <p>The next two digits refer to the resource that was impacted.</p>
     * <p>The last two digits refer to the specific error.</p>
     * <p>eg. 010103 - Missing parameters for Invoice POST request.</p>
     *
     * @return string|null
     */
    public function getBitPayCode(): ?string
    {
        return $this->bitPayCode;
    }
}
