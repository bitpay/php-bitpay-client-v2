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
        $this->client = Client::createWithFile(Config::INTEGRATION_TEST_PATH . DIRECTORY_SEPARATOR . Config::BITPAY_CONFIG_FILE);
    }

    public function testGetSupportedWallets(): void
    {
        $supportedWallets = $this->client->getSupportedWallets();

        $this->assertNotNull($supportedWallets);
        $this->assertTrue(is_array($supportedWallets));
    }
}
