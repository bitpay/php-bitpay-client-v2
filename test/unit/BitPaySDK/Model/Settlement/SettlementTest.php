<?php

namespace BitPaySDK\Test\Model\Settlement;

use BitPaySDK\Model\Settlement\PayoutInfo;
use BitPaySDK\Model\Settlement\Settlement;
use BitPaySDK\Model\Settlement\SettlementLedgerEntry;
use BitPaySDK\Model\Settlement\WithHoldings;
use PHPUnit\Framework\TestCase;

class SettlementTest extends TestCase
{
    private const WITH_HOLDINGS_AMOUNT = 12.34;
    private const LEDGER_ENTRY_AMOUNT = 42.24;

    public function testInstanceOf()
    {
        $settlement = $this->createClassObject();
        self::assertInstanceOf(Settlement::class, $settlement);
    }

    public function testGetId()
    {
        $expectedId = '22';

        $settlement = $this->createClassObject();
        $settlement->setId($expectedId);
        self::assertEquals($expectedId, $settlement->getId());
    }

    public function testGetAccountId()
    {
        $expectedAccountId = '15';

        $settlement = $this->createClassObject();
        $settlement->setAccountId($expectedAccountId);
        self::assertEquals($expectedAccountId, $settlement->getAccountId());
    }

    public function testGetCurrency()
    {
        $expectedCurrency = 'BTC';

        $settlement = $this->createClassObject();
        $settlement->setCurrency($expectedCurrency);
        self::assertEquals($expectedCurrency, $settlement->getCurrency());
    }

    public function testGetPayoutInfo()
    {
        $expectedPayoutInfo = $this->getMockBuilder(PayoutInfo::class)->getMock();

        $settlement = $this->createClassObject();
        $settlement->setPayoutInfo($expectedPayoutInfo);
        self::assertEquals($expectedPayoutInfo, $settlement->getPayoutInfo());
    }

    public function testGetStatus()
    {
        $expectedStatus = 'pending';

        $settlement = $this->createClassObject();
        $settlement->setStatus($expectedStatus);
        self::assertEquals($expectedStatus, $settlement->getStatus());
    }

    public function testGetDateCreated()
    {
        $expectedDateCreated = '2022-01-01';

        $settlement = $this->createClassObject();
        $settlement->setDateCreated($expectedDateCreated);
        self::assertEquals($expectedDateCreated, $settlement->getDateCreated());
    }

    public function testGetDateExecuted()
    {
        $expectedDateExecuted = '2022-01-01';

        $settlement = $this->createClassObject();
        $settlement->setDateExecuted($expectedDateExecuted);
        self::assertEquals($expectedDateExecuted, $settlement->getDateExecuted());
    }

    public function testGetDateCompleted()
    {
        $expectedDateCompleted = '2022-01-01';

        $settlement = $this->createClassObject();
        $settlement->setDateCompleted($expectedDateCompleted);
        self::assertEquals($expectedDateCompleted, $settlement->getDateCompleted());
    }

    public function testGetOpeningDate()
    {
        $expectedDateCompleted = '2022-01-01';

        $settlement = $this->createClassObject();
        $settlement->setOpeningDate($expectedDateCompleted);
        self::assertEquals($expectedDateCompleted, $settlement->getOpeningDate());
    }

    public function testGetClosingDate()
    {
        $expectedClosingDate = '2022-01-01';

        $settlement = $this->createClassObject();
        $settlement->setClosingDate($expectedClosingDate);
        self::assertEquals($expectedClosingDate, $settlement->getClosingDate());
    }

    public function testGetOpeningBalance()
    {
        $expectedOpeningBalance = 20.0;

        $settlement = $this->createClassObject();
        $settlement->setOpeningBalance($expectedOpeningBalance);
        self::assertEquals($expectedOpeningBalance, $settlement->getOpeningBalance());
    }

    public function testGetLedgerEntriesSum()
    {
        $expectedLedgerEntriesSum = 20.0;

        $settlement = $this->createClassObject();
        $settlement->setLedgerEntriesSum($expectedLedgerEntriesSum);
        self::assertEquals($expectedLedgerEntriesSum, $settlement->getLedgerEntriesSum());
    }

    public function testGetWithHoldings()
    {
        $settlement = $this->createClassObject();
        $withHolding = new WithHoldings();

        $settlement->setWithHoldings([$withHolding]);

        self::assertSame([$withHolding], $settlement->getWithHoldings());
    }

    public function testGetWithHoldingsSum()
    {
        $expectedWithHoldingsSum = 15.2;

        $settlement = $this->createClassObject();
        $settlement->setWithHoldingsSum($expectedWithHoldingsSum);
        self::assertEquals($expectedWithHoldingsSum, $settlement->getWithHoldingsSum());
    }

    public function testGetTotalAmount()
    {
        $expectedTotalAmount = 20.0;

        $settlement = $this->createClassObject();
        $settlement->setTotalAmount($expectedTotalAmount);
        self::assertEquals($expectedTotalAmount, $settlement->getTotalAmount());
    }

    /**
     * @throws \BitPaySDK\Exceptions\SettlementException
     */
    public function testGetLedgerEntries()
    {
        $settlement = $this->createClassObject();
        $ledgerEntry = new SettlementLedgerEntry();

        $settlement->setLedgerEntries([$ledgerEntry]);

        self::assertEquals([$ledgerEntry], $settlement->getLedgerEntries());
    }

    public function testGetToken()
    {
        $expectedToken = 'she73j92nv83';

        $settlement = $this->createClassObject();
        $settlement->setToken($expectedToken);
        self::assertEquals($expectedToken, $settlement->getToken());
    }

    /**
     * @throws \BitPaySDK\Exceptions\SettlementException
     */
    public function testToArray()
    {
        $settlement = $this->createClassObject();
        $this->prepareSettlementForTests($settlement);
        $settlementArray = $settlement->toArray();

        self::assertNotNull($settlementArray);
        self::assertIsArray($settlementArray);

        self::assertArrayHasKey('id', $settlementArray);
        self::assertArrayHasKey('accountId', $settlementArray);
        self::assertArrayHasKey('currency', $settlementArray);
        self::assertArrayHasKey('payoutInfo', $settlementArray);
        self::assertArrayHasKey('status', $settlementArray);
        self::assertArrayHasKey('dateCreated', $settlementArray);
        self::assertArrayHasKey('dateExecuted', $settlementArray);
        self::assertArrayHasKey('dateCompleted', $settlementArray);
        self::assertArrayHasKey('openingDate', $settlementArray);
        self::assertArrayHasKey('closingDate', $settlementArray);
        self::assertArrayHasKey('openingBalance', $settlementArray);
        self::assertArrayHasKey('ledgerEntriesSum', $settlementArray);
        self::assertArrayHasKey('withHoldings', $settlementArray);
        self::assertArrayHasKey('withHoldingsSum', $settlementArray);
        self::assertArrayHasKey('totalAmount', $settlementArray);
        self::assertArrayHasKey('ledgerEntries', $settlementArray);
        self::assertArrayHasKey('token', $settlementArray);

        self::assertEquals('11', $settlementArray['id']);
        self::assertEquals('12', $settlementArray['accountId']);
        self::assertEquals('BTC', $settlementArray['currency']);
        self::assertEquals($settlementArray['payoutInfo'], new PayoutInfo());
        self::assertEquals('pending', $settlementArray['status']);
        self::assertEquals('2022-01-01', $settlementArray['dateCreated']);
        self::assertEquals('2022-01-01', $settlementArray['dateExecuted']);
        self::assertEquals('2022-01-01', $settlementArray['dateCompleted']);
        self::assertEquals('2022-01-01', $settlementArray['openingDate']);
        self::assertEquals('2022-01-01', $settlementArray['closingDate']);
        self::assertEquals(15.0, $settlementArray['openingBalance']);
        self::assertEquals(12.2, $settlementArray['ledgerEntriesSum']);
        self::assertEquals(self::WITH_HOLDINGS_AMOUNT, $settlementArray['withHoldings'][0]['amount']);
        self::assertEquals(15, $settlementArray['withHoldingsSum']);
        self::assertEquals(30, $settlementArray['totalAmount']);
        self::assertEquals(self::LEDGER_ENTRY_AMOUNT, $settlementArray['ledgerEntries'][0]['amount']);
        self::assertEquals('5u3cc2c7b', $settlementArray['token']);
    }

    private function createClassObject(): Settlement
    {
        return new Settlement();
    }

    /**
     * @throws \BitPaySDK\Exceptions\SettlementException
     */
    private function prepareSettlementForTests(Settlement $settlement)
    {
        $withHoldings = new WithHoldings();
        $withHoldings->setAmount(self::WITH_HOLDINGS_AMOUNT);
        $settlementLedgerEntry = new SettlementLedgerEntry();
        $settlementLedgerEntry->setAmount(self::LEDGER_ENTRY_AMOUNT);

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
        $settlement->setWithHoldings([$withHoldings]);
        $settlement->setWithHoldingsSum(15);
        $settlement->setTotalAmount(30.0);
        $settlement->setLedgerEntries([$settlementLedgerEntry]);
        $settlement->setToken('5u3cc2c7b');
    }
}
