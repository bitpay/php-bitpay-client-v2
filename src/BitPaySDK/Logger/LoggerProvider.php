<?php

/**
 * Copyright (c) 2019 BitPay
 **/

declare(strict_types=1);

namespace BitPaySDK\Logger;

class LoggerProvider
{
    private static ?BitPayLogger $logger = null;

    private function __construct()
    {
    }

    public static function getLogger(): BitPayLogger
    {
        if (!self::$logger) {
            self::$logger = new EmptyLogger();
        }

        return self::$logger;
    }

    public static function setLogger(BitPayLogger $logger): void
    {
        self::$logger = $logger;
    }
}
