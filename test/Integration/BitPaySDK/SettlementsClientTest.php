<?php
declare(strict_types=1);

namespace BitPaySDK\Integration;

use BitPaySDK\Client;
use BitPaySDK\Model\Settlement\Settlement;
use PHPUnit\Framework\TestCase;

class SettlementsClientTest extends TestCase
{
    protected $client;

    public function setUp(): void
    {
        $this->client = Client::createWithFile(Config::INTEGRATION_TEST_PATH . DIRECTORY_SEPARATOR . Config::BITPAY_CONFIG_FILE);
    }

    public function testGetSettlements(): void
    {
        $status = 'processing';
        $dateStart = date('Y-m-d', strtotime("-50 day"));
        $dateEnd = date("Y-m-d", strtotime("+1 day"));
        $currency = 'USD';

        $settlements = $this->client->getSettlements($currency, $dateStart, $dateEnd, $status);

        $this->assertNotNull($settlements);
        $this->assertTrue(is_array($settlements));
    }

    public function testGetSettlement(): void
    {
        $dateStart = date('Y-m-d', strtotime("-365 day"));
        $status = 'processing';
        $dateEnd = date("Y-m-d", strtotime("+1 day"));
        $currency = 'USD';

        $settlements = $this->client->getSettlements($currency, $dateStart, $dateEnd, $status);

        $settlement = $this->client->getSettlement($settlements[0]->getId());

        $this->assertNotNull($settlement);
        $this->assertInstanceOf(Settlement::class, $settlement);
        $this->assertEquals($currency, $settlement->getCurrency());
        $this->assertEquals($status, $settlement->getStatus());
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

        $this->assertEquals('processing', $settlement->getStatus());
        $this->assertNotNull($settlement);
        $this->assertEquals('USD', $settlement->getCurrency());
        $this->assertEquals($status, $settlement->getStatus());
    }
}