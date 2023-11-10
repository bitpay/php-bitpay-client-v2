<?php

declare(strict_types=1);

namespace BitPaySDK\Exceptions;

use BitPaySDK\Logger\LoggerProvider;

class BitPayExceptionProvider
{
    public const GENERIC_API_UNMAPPED_ERROR_CODE = "000000";

    /**
     * @throws BitPayGenericException
     */
    public static function throwGenericExceptionWithMessage(?string $message): void
    {
        if ($message) {
            LoggerProvider::getLogger()->logError($message);
        }

        throw new BitPayGenericException($message);
    }

    /**
     * @throws BitPayApiException
     */
    public static function throwApiExceptionWithMessage(?string $message): void
    {
        if ($message) {
            LoggerProvider::getLogger()->logError($message);
        }

        throw new BitPayApiException($message, self::GENERIC_API_UNMAPPED_ERROR_CODE);
    }

    /**
     * @throws BitPayApiException
     */
    public static function throwApiExceptionByArrayResponse(?array $body): void
    {
        if (!$body) {
            $message = 'Missing response';
            LoggerProvider::getLogger()->logError($message);
            throw new BitPayApiException($message, self::GENERIC_API_UNMAPPED_ERROR_CODE);
        }

        $errorMessage = (!empty($body['error'])) ? $body['error'] : false;
        $errorMessage = (!empty($body['errors'])) ? $body['errors'] : $errorMessage;
        if ($errorMessage && is_array($errorMessage)) {
            if (count($errorMessage) === count($errorMessage, 1)) {
                $errorMessage = implode("\n", $errorMessage);
            } else {
                $errors = [];
                foreach ($errorMessage as $error) {
                    $errors[] = $error['param'] . ": " . $error['error'];
                }
                $errorMessage = implode(',', $errors);
            }
        }

        $code = $errorArray['code'] ?? null;
        if (is_int($code)) {
            $code = (string) $code;
        }

        self::logErrorMessage($errorMessage);

        throw new BitPayApiException($errorMessage, $code);
    }

    /**
     * @throws BitPayValidationException
     */
    public static function throwValidationException(string $message): void
    {
        self::logErrorMessage($message);

        throw new BitPayValidationException($message);
    }

    /**
     * @throws BitPayGenericException
     */
    public static function throwDeserializeException(?string $exceptionMessage): void
    {
        $message = 'Failed to deserialize BitPay server response : ' . $exceptionMessage;
        self::throwGenericExceptionWithMessage($message);
    }

    /**
     * @throws BitPayGenericException
     */
    public static function throwDeserializeResourceException(string $resource, ?string $exceptionMessage): void
    {
        $message = 'Failed to deserialize BitPay server response ( ' . $resource . ' ) : ' . $exceptionMessage;
        self::throwGenericExceptionWithMessage(sprintf($message, $resource));
    }

    private static function logErrorMessage(string $message): void
    {
        LoggerProvider::getLogger()->logError($message);
    }

    /**
     * @throws BitPayValidationException
     */
    public static function throwInvalidCurrencyException(string $currencyCode): void
    {
        $message = 'Currency code ' . $currencyCode . ' must be a type of Model.Currency';
        self::throwValidationException($message);
    }
}
