<?php

namespace BitPaySDK\Test\Model\Settlement;

use BitPaySDK\Model\Settlement\PayoutInfo;
use BitPaySDK\Model\Settlement\Settlement;
use PHPUnit\Framework\TestCase;

class SettlementTest extends TestCase
{
    public function testInstanceOf()
    {
        $settlement = $this->createClassObject();
        $this->assertInstanceOf(Settlement::class, $settlement);
    }

    public function testGetId()
    {
        $expectedId = '22';

        $settlement = $this->createClassObject();
        $settlement->setId($expectedId);
        $this->assertEquals($expectedId, $settlement->getId());
    }

    public function testGetAccountId()
    {
        $expectedAccountId = '15';

        $settlement = $this->createClassObject();
        $settlement->setAccountId($expectedAccountId);
        $this->assertEquals($expectedAccountId, $settlement->getAccountId());
    }

    public function testGetCurrency()
    {
        $expectedCurrency = 'BTC';

        $settlement = $this->createClassObject();
        $settlement->setCurrency($expectedCurrency);
        $this->assertEquals($expectedCurrency, $settlement->getCurrency());
    }

    public function testGetPayoutInfo()
    {
        $expectedPayoutInfo = $this->getMockBuilder(PayoutInfo::class)->getMock();

        $settlement = $this->createClassObject();
        $settlement->setPayoutInfo($expectedPayoutInfo);
        $this->assertEquals($expectedPayoutInfo, $settlement->getPayoutInfo());
    }

    public function testGetStatus()
    {
        $expectedStatus = 'pending';

        $settlement = $this->createClassObject();
        $settlement->setStatus($expectedStatus);
        $this->assertEquals($expectedStatus, $settlement->getStatus());
    }

    public function testGetDateCreated()
    {
        $expectedDateCreated = '2022-01-01';

        $settlement = $this->createClassObject();
        $settlement->setDateCreated($expectedDateCreated);
        $this->assertEquals($expectedDateCreated, $settlement->getDateCreated());
    }

    public function testGetDateExecuted()
    {
        $expectedDateExecuted = '2022-01-01';

        $settlement = $this->createClassObject();
        $settlement->setDateExecuted($expectedDateExecuted);
        $this->assertEquals($expectedDateExecuted, $settlement->getDateExecuted());
    }

    public function testGetDateCompleted()
    {
        $expectedDateCompleted = '2022-01-01';

        $settlement = $this->createClassObject();
        $settlement->setDateCompleted($expectedDateCompleted);
        $this->assertEquals($expectedDateCompleted, $settlement->getDateCompleted());
    }

    public function testGetOpeningDate()
    {
        $expectedDateCompleted = '2022-01-01';

        $settlement = $this->createClassObject();
        $settlement->setOpeningDate($expectedDateCompleted);
        $this->assertEquals($expectedDateCompleted, $settlement->getOpeningDate());
    }

    public function testGetClosingDate()
    {
        $expectedClosingDate = '2022-01-01';

        $settlement = $this->createClassObject();
        $settlement->setClosingDate($expectedClosingDate);
        $this->assertEquals($expectedClosingDate, $settlement->getClosingDate());
    }

    public function testGetOpeningBalance()
    {
        $expectedOpeningBalance = 20.0;

        $settlement = $this->createClassObject();
        $settlement->setOpeningBalance($expectedOpeningBalance);
        $this->assertEquals($expectedOpeningBalance, $settlement->getOpeningBalance());
    }

    public function testGetLedgerEntriesSum()
    {
        $expectedLedgerEntriesSum = 20.0;

        $settlement = $this->createClassObject();
        $settlement->setLedgerEntriesSum($expectedLedgerEntriesSum);
        $this->assertEquals($expectedLedgerEntriesSum, $settlement->getLedgerEntriesSum());
    }

    public function testGetWithHoldings()
    {
        $settlement = $this->createClassObject();
        $arrayWithoutObject = ['test'];

        $settlement->setWithHoldings($arrayWithoutObject);

        $this->assertEquals($arrayWithoutObject, $settlement->getWithHoldings());
    }

    public function testGetWithHoldingsSum()
    {
        $expectedWithHoldingsSum = 15.2;

        $settlement = $this->createClassObject();
        $settlement->setWithHoldingsSum($expectedWithHoldingsSum);
        $this->assertEquals($expectedWithHoldingsSum, $settlement->getWithHoldingsSum());
    }

    public function testGetTotalAmount()
    {
        $expectedTotalAmount = 20.0;

        $settlement = $this->createClassObject();
        $settlement->setTotalAmount($expectedTotalAmount);
        $this->assertEquals($expectedTotalAmount, $settlement->getTotalAmount());
    }

    public function testGetLedgerEntries()
    {
        $settlement = $this->createClassObject();
        $arrayWithoutObject = ['test'];

        $settlement->setLedgerEntries($arrayWithoutObject);

        $this->assertEquals($arrayWithoutObject, $settlement->getLedgerEntries());
    }

    public function testGetToken()
    {
        $expectedToken = 'she73j92nv83';

        $settlement = $this->createClassObject();
        $settlement->setToken($expectedToken);
        $this->assertEquals($expectedToken, $settlement->getToken());
    }

    public function testToArray()
    {
        $settlement = $this->createClassObject();
        $this->setSetters($settlement);
        $settlementArray = $settlement->toArray();

        $this->assertNotNull($settlementArray);
        $this->assertIsArray($settlementArray);

        $this->assertArrayHasKey('id', $settlementArray);
        $this->assertArrayHasKey('accountId', $settlementArray);
        $this->assertArrayHasKey('currency', $settlementArray);
        $this->assertArrayHasKey('payoutInfo', $settlementArray);
        $this->assertArrayHasKey('status', $settlementArray);
        $this->assertArrayHasKey('dateCreated', $settlementArray);
        $this->assertArrayHasKey('dateExecuted', $settlementArray);
        $this->assertArrayHasKey('dateCompleted', $settlementArray);
        $this->assertArrayHasKey('openingDate', $settlementArray);
        $this->assertArrayHasKey('closingDate', $settlementArray);
        $this->assertArrayHasKey('openingBalance', $settlementArray);
        $this->assertArrayHasKey('ledgerEntriesSum', $settlementArray);
        $this->assertArrayHasKey('withHoldings', $settlementArray);
        $this->assertArrayHasKey('withHoldingsSum', $settlementArray);
        $this->assertArrayHasKey('totalAmount', $settlementArray);
        $this->assertArrayHasKey('ledgerEntries', $settlementArray);
        $this->assertArrayHasKey('token', $settlementArray);

        $this->assertEquals($settlementArray['id'], '11');
        $this->assertEquals($settlementArray['accountId'], '12');
        $this->assertEquals($settlementArray['currency'], 'BTC');
        $this->assertEquals($settlementArray['payoutInfo'], new PayoutInfo());
        $this->assertEquals($settlementArray['status'], 'pending');
        $this->assertEquals($settlementArray['dateCreated'], '2022-01-01');
        $this->assertEquals($settlementArray['dateExecuted'], '2022-01-01');
        $this->assertEquals($settlementArray['dateCompleted'], '2022-01-01');
        $this->assertEquals($settlementArray['openingDate'], '2022-01-01');
        $this->assertEquals($settlementArray['closingDate'], '2022-01-01');
        $this->assertEquals($settlementArray['openingBalance'], 15.0);
        $this->assertEquals($settlementArray['ledgerEntriesSum'], 12.2);
        $this->assertEquals($settlementArray['withHoldings'], ['test']);
        $this->assertEquals($settlementArray['withHoldingsSum'], 15);
        $this->assertEquals($settlementArray['totalAmount'], 30);
        $this->assertEquals($settlementArray['ledgerEntries'], ['test']);
        $this->assertEquals($settlementArray['token'], '5u3cc2c7b');
    }

    private function createClassObject()
    {
        return new Settlement();
    }

    private function setSetters(Settlement $settlement)
    {
        $settlement->setId('11');
        $settlement->setAccountId('12');
        $settlement->setCurrency('BTC');
        $settlement->setPayoutInfo(new PayoutInfo());
        $settlement->setStatus('pending');
        $settlement->setDateCreated('2022-01-01');
        $settlement->setDateExecuted('2022-01-01');
        $settlement->setDateCompleted('2022-01-01');
        $settlement->setOpeningDate('2022-01-01');
        $settlement->setClosingDate('2022-01-01');
        $settlement->setOpeningBalance(15);
        $settlement->setLedgerEntriesSum(12.2);
        $settlement->setWithHoldings(['test']);
        $settlement->setWithHoldingsSum(15);
        $settlement->setTotalAmount(30.0);
        $settlement->setLedgerEntries(['test']);
        $settlement->setToken('5u3cc2c7b');
    }
}
