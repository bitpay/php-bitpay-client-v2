<?php

namespace BitPaySDK\Test\Model\Ledger;

use BitPaySDK\Model\Ledger\Ledger;
use PHPUnit\Framework\TestCase;

class LedgerTest extends TestCase
{
    public function testInstanceOf()
    {
        $ledger = $this->createClassObject();
        self::assertInstanceOf(Ledger::class, $ledger);
    }

    public function testGetCurrency()
    {
        $expectedCurrency = 'BTC';

        $ledger = $this->createClassObject();
        $ledger->setCurrency($expectedCurrency);
        self::assertEquals($expectedCurrency, $ledger->getCurrency());
    }

    public function testGetBalance()
    {
        $expectedBalance = 1.1;

        $ledger = $this->createClassObject();
        $ledger->setBalance($expectedBalance);
        self::assertEquals($expectedBalance, $ledger->getBalance());
    }

    public function testToArray()
    {
        $ledger = $this->createClassObject();

        $ledger->setCurrency('BTC');
        $ledger->setBalance(1.1);

        $ledgerArray = $ledger->toArray();

        self::assertNotNull($ledgerArray);
        self::assertIsArray($ledgerArray);

        self::assertArrayHasKey('currency', $ledgerArray);
        self::assertArrayHasKey('balance', $ledgerArray);

        self::assertEquals('BTC', $ledgerArray['currency']);
        self::assertEquals(1.1, $ledgerArray['balance']);
    }

    private function createClassObject(): Ledger
    {
        return new Ledger();
    }
}