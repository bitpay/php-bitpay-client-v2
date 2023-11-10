<?php

declare(strict_types=1);

namespace unit\Logger;

use BitPaySDK\Logger\BitPayLogger;
use BitPaySDK\Logger\EmptyLogger;
use BitPaySDK\Logger\LoggerProvider;
use PHPUnit\Framework\TestCase;

class LoggerTest extends TestCase
{
    public function testGetEmptyLoggerAsDefault(): void
    {
        self::assertInstanceOf(EmptyLogger::class, LoggerProvider::getLogger());
    }

    public function testChangeDefaultLogger(): void
    {
        $customLogger = new class() implements BitPayLogger {
            public function logRequest(string $method, string $endpoint, ?string $json): void
            {
            }

            public function logResponse(string $method, string $endpoint, ?string $json): void
            {
            }

            public function logError(?string $message): void
            {
            }
        };

        LoggerProvider::setLogger($customLogger);
        self::assertSame($customLogger, LoggerProvider::getLogger());
    }
}
