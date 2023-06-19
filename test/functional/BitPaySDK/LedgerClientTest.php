<?php
/**
 * Copyright (c) 2019 BitPay
 **/
declare(strict_types=1);

namespace BitPaySDK\Functional;

use BitPaySDK\Exceptions\LedgerQueryException;

class LedgerClientTest extends AbstractClientTest
{
    public function testGetLedger(): void
    {
        $currency = 'USD';
        $startDate = '2022-12-20T13:00:45.063Z';
        $endDate = '2023-01-01T13:00:45.063Z';

        $ledgers = $this->client->getLedgerEntries($currency, $startDate, $endDate);
        if (!empty($ledgers)) {
            self::assertEquals($currency, $ledgers[0]->getInvoiceCurrency());
        }

        self::assertCount(count($ledgers), $ledgers);
        self::assertNotNull($ledgers);
        self::assertIsArray($ledgers);
    }

    public function testGetLedgers(): void
    {
        $ledgers = $this->client->getLedgers();

        self::assertIsArray($ledgers);
        self::assertCount(count($ledgers), $ledgers);
    }

    public function testGetLedgerShouldCatchRestCliException(): void
    {
        $currency = 'USD';
        $startDate = '2020-05-12T13:00:45.063Z';
        $endDate = '2022-05-13T13:00:45.063Z';

        $this->expectException(LedgerQueryException::class);
        $this->client->getLedgerEntries($currency, $startDate, $endDate);
    }
}