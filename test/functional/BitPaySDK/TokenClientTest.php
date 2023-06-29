<?php

/**
 * Copyright (c) 2019 BitPay
 **/

declare(strict_types=1);

namespace BitPaySDK\Functional;

class TokenClientTest extends AbstractClientTestCase
{
    public function testGetTokens(): void
    {
        $tokens = $this->client->getTokens();

        self::assertNotEmpty($tokens);
    }
}
