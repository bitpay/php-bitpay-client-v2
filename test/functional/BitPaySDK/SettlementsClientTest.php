<?php
/**
 * Copyright (c) 2019 BitPay
 **/
declare(strict_types=1);

namespace BitPaySDK\Functional;

use BitPaySDK\Model\Settlement\Settlement;

class SettlementsClientTest extends AbstractClientTest
{
    public function testGetSettlements(): void
    {
        $status = 'processing';
        $dateStart = date('Y-m-d', strtotime("-50 day"));
        $dateEnd = date("Y-m-d", strtotime("+1 day"));
        $currency = 'USD';

        $settlements = $this->client->getSettlements($currency, $dateStart, $dateEnd, $status);

        self::assertNotNull($settlements);
        self::assertIsArray($settlements);
    }

    public function testGetSettlement(): void
    {
        $dateStart = date('Y-m-d', strtotime("-365 day"));
        $status = 'processing';
        $dateEnd = date("Y-m-d", strtotime("+1 day"));
        $currency = 'USD';

        $settlements = $this->client->getSettlements($currency, $dateStart, $dateEnd, $status);

        $settlement = $this->client->getSettlement($settlements[0]->getId());

        self::assertNotNull($settlement);
        self::assertInstanceOf(Settlement::class, $settlement);
        self::assertEquals($currency, $settlement->getCurrency());
        self::assertEquals($status, $settlement->getStatus());
    }

    public function testGetReconciliationReport(): void
    {
        $status = 'processing';
        $dateStart = date('Y-m-d', strtotime("-365 day"));
        $dateEnd = date("Y-m-d", strtotime("+1 day"));
        $currency = 'USD';

        $settlements = $this->client->getSettlements($currency, $dateStart, $dateEnd, $status);
        $settlement = $this->client->getSettlement($settlements[0]->getId());
        $settlement = $this->client->getSettlementReconciliationReport($settlement);

        self::assertEquals('processing', $settlement->getStatus());
        self::assertNotNull($settlement);
        self::assertEquals('USD', $settlement->getCurrency());
        self::assertEquals($status, $settlement->getStatus());
    }
}