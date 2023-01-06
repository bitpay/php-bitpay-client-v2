<?php
declare(strict_types=1);

namespace BitPaySDK\Integration;

use BitPaySDK\Client;
use BitPaySDK\Exceptions\LedgerQueryException;
use PHPUnit\Framework\TestCase;

class LedgerClientTest extends TestCase
{
    protected $client;

    public function setUp(): void
    {
        $this->client = Client::createWithFile('src/BitPaySDK/config.yml');
    }

    public function testGetLedger(): void
    {
        $currency = 'USD';
        $startDate = '2022-12-20T13:00:45.063Z';
        $endDate = '2023-01-01T13:00:45.063Z';

        $ledgers = $this->client->getLedger($currency, $startDate, $endDate);
        if (!empty($ledgers)) {
            $this->assertEquals($currency, $ledgers[0]->getInvoiceCurrency());
        }

        $this->assertCount(count($ledgers), $ledgers);
        $this->assertNotNull($ledgers);
        $this->assertTrue(is_array($ledgers));
    }

    public function testGetLedgers(): void
    {
        $ledgers = $this->client->getLedgers();

        $this->assertTrue(is_array($ledgers));
        $this->assertCount(count($ledgers), $ledgers);
    }

    public function testGetLedgerShouldCatchRestCliException(): void
    {
        $currency = 'USD';
        $startDate = '2020-05-12T13:00:45.063Z';
        $endDate = '2022-05-13T13:00:45.063Z';

        $this->expectException(LedgerQueryException::class);
        $this->client->getLedger($currency, $startDate, $endDate);
    }
}