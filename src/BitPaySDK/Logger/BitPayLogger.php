<?php

/**
 * Copyright (c) 2019 BitPay
 **/

declare(strict_types=1);

namespace BitPaySDK\Logger;

interface BitPayLogger
{
    public function logRequest(
        string $method,
        string $endpoint,
        ?string $json
    ): void;

    public function logResponse(
        string $method,
        string $endpoint,
        ?string $json
    ): void;

    public function logError(?string $message): void;
}
