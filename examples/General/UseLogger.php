<?php

declare(strict_types=1);

namespace BitPaySDKexamples\General;

use BitPaySDK\Logger\BitPayLogger;
use BitPaySDK\Logger\LoggerProvider;
use BitPaySDKexamples\ClientProvider;

final class UseLogger
{
    /**
     * @throws \BitPaySDK\Exceptions\BitPayApiException
     * @throws \BitPaySDK\Exceptions\BitPayGenericException
     */
    public function execute(): void
    {
        LoggerProvider::setLogger(
            new class() implements BitPayLogger
            {
                public function logRequest(string $method, string $endpoint, ?string $json): void
                {
                    echo $this->getLogMessage('Request', $method, $endpoint, $json);
                    $this->newLine();
                }

                public function logResponse(string $method, string $endpoint, ?string $json): void
                {
                    echo $this->getLogMessage('Response', $method, $endpoint, $json);
                    $this->newLine();
                }

                public function logError(?string $message): void
                {
                    echo $message;
                    $this->newLine();
                }

                private function getLogMessage(string $type, string $method, string $endpoint, ?string $json): string
                {
                    $array = [
                        'type' => $type,
                        'method' => $method,
                        'endpoint' => $endpoint,
                        'json' => $json
                    ];

                    return json_encode($array, JSON_THROW_ON_ERROR | JSON_ERROR_NONE);
                }

                private function newLine(): void
                {
                    echo "\r\n";
                }
            }
        );

        // for monolog implementation you can use code from src/BitPaySDK/Logger/MonologLoggerExample.php

        $client = ClientProvider::create();

        $invoice = $client->getInvoiceByGuid("someGuid"); // requests/response will be logged
    }
}
