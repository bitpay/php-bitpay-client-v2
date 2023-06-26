<?php
/**
 * Copyright (c) 2019 BitPay
 **/
declare(strict_types=1);

namespace BitPaySDK\Functional;

use BitPaySDK\Model\Rate\Rate;

class RateClientTest extends AbstractClientTest
{
    public function testGetRates(): void
    {
        $rates = $this->client->getRates();
        $ratesData = $rates->getRates();

        self::assertCount(count($ratesData), $ratesData);
        self::assertNotNull($rates);
        self::assertIsArray($ratesData);
    }

    public function testGetCurrencyRates()
    {
        $rates = $this->client->getCurrencyRates('BTC');
        $ratesData = $rates->getRates();

        self::assertCount(count($ratesData), $ratesData);
        self::assertNotNull($rates);
        self::assertIsArray($ratesData);
    }

    public function testGetCurrencyPairRate(): void
    {
        $rate = $this->client->getCurrencyPairRate('BTC', 'USD');

        self::assertInstanceOf(Rate::class, $rate);
        self::assertEquals('USD', $rate->getCode());
        self::assertEquals('US Dollar', $rate->getName());
    }
}