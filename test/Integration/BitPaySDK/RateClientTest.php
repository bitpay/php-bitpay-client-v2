<?php
declare(strict_types=1);

namespace BitPaySDK\Integration;

use BitPaySDK\Client;
use BitPaySDK\Model\Rate\Rate;
use PHPUnit\Framework\TestCase;

class RateClientTest extends TestCase
{
    protected $client;

    public function setUp(): void
    {
        $this->client = Client::createWithFile('src/BitPaySDK/config.yml');
    }

    public function testGetRates(): void
    {
        $rates = $this->client->getRates();
        $ratesData = $rates->getRates();

        $this->assertCount(count($ratesData), $ratesData);
        $this->assertNotNull($rates);
        $this->assertTrue(is_array($ratesData));
    }

    public function testGetCurrencyRates()
    {
        $rates = $this->client->getCurrencyRates('BTC');
        $ratesData = $rates->getRates();

        $this->assertCount(count($ratesData), $ratesData);
        $this->assertNotNull($rates);
        $this->assertTrue(is_array($ratesData));
    }

    public function testGetCurrencyPairRate(): void
    {
        $rate = $this->client->getCurrencyPairRate('BTC', 'USD');

        $this->assertInstanceOf(Rate::class, $rate);
        $this->assertEquals('USD', $rate->getCode());
        $this->assertEquals('US Dollar', $rate->getName());
    }
}