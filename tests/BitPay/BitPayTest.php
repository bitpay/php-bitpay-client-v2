<?php

namespace BitPay\Test;


use BitPayKeyUtils\KeyHelper\PrivateKey;
use PHPUnit\Framework\TestCase;
use Bitpay;

class BitPayTest extends TestCase
{
    protected $client;
    protected $clientMock;

    protected function setUp(): void
    {
        $this->clientMock = $this->createMock(Bitpay\Client::class);
        $this->clientMock->withData(
            Bitpay\Env::Test,
            __DIR__ . "/../../bitpay_private_test.key",
            new Bitpay\Tokens("2smKkjA1ACPKWUGN7wUEEqdWi3rhXYhDX6AKgG4njKvj"),
            "YourMasterPassword"
        );

        $this->client = Bitpay\Client::create()->withData(
            Bitpay\Env::Test,
            __DIR__ . "/../../bitpay_private_test.key",
            new Bitpay\Tokens("2smKkjA1ACPKWUGN7wUEEqdWi3rhXYhDX6AKgG4njKvj"),
            "YourMasterPassword");
        $this->assertNotNull($this->client);
    }

    public function testGetIdentity()
    {
        $this->clientMock->method('getIdentity')->willReturn(null);
        $identity = $this->clientMock->getIdentity();
        $this->assertNotNull($identity);
    }
}
