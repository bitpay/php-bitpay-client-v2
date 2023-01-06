<?php
declare(strict_types=1);

namespace BitPaySDK\Integration;

use BitPaySDK\Client;
use PHPUnit\Framework\TestCase;

class WalletClientTest extends TestCase
{
    protected $client;

    public function setUp(): void
    {
        $this->client = Client::createWithFile('src/BitPaySDK/config.yml');
    }

    public function testGetSupportedWallets(): void
    {
        $supportedWallets = $this->client->getSupportedWallets();

        $this->assertNotNull($supportedWallets);
        $this->assertTrue(is_array($supportedWallets));
    }
}
