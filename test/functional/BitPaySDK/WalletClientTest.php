<?php
/**
 * Copyright (c) 2019 BitPay
 **/
declare(strict_types=1);

namespace BitPaySDK\Functional;

class WalletClientTest extends AbstractClientTest
{
    public function testGetSupportedWallets(): void
    {
        $supportedWallets = $this->client->getSupportedWallets();

        self::assertNotNull($supportedWallets);
        self::assertIsArray($supportedWallets);
    }
}
