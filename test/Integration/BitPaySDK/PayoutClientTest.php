<?php
declare(strict_types=1);

namespace BitPaySDK\Integration;

use BitPaySDK\Client;
use BitPaySDK\Exceptions\PayoutCreationException;
use BitPaySDK\Exceptions\PayoutQueryException;
use BitPaySDK\Model\Payout\Payout;
use BitPaySDK\Model\Currency;
use PHPUnit\Framework\TestCase;

class PayoutClientTest extends TestCase
{
    protected $client;

    public function setUp(): void
    {
        $this->client = Client::createWithFile('src/BitPaySDK/config.yml');
    }

    public function testSubmitPayoutShouldCatchRestCliException(): void
    {
        $currency = Currency::USD;
        $ledgerCurrency = Currency::USD;
        $payout = new Payout(10, $currency, $ledgerCurrency);
        $payout->setEmail('w.kogut@sumoheavy.com');

        $this->expectException(PayoutCreationException::class);
        $this->client->submitPayout($payout);
    }

    public function testGetPayoutShouldCatchRestCliException(): void
    {
        $this->expectException(PayoutQueryException::class);
        $this->client->getPayout('test');
    }

    public function testGetPayouts(): void
    {
        $startDate = '2022-10-20T13:00:45.063Z';
        $endDate = '2023-01-01T13:00:45.063Z';

        $payouts = $this->client->getPayouts($startDate, $endDate);
        $this->assertTrue(is_array($payouts));
        $this->assertCount(count($payouts), $payouts);
    }
}