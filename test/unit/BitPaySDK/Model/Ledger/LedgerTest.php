<?php

namespace BitPaySDK\Test\Model\Ledger;

use BitPaySDK\Model\Ledger\Ledger;
use PHPUnit\Framework\TestCase;

class LedgerTest extends TestCase
{
    public function testInstanceOf()
    {
        $ledger = $this->createClassObject();
        $this->assertInstanceOf(Ledger::class, $ledger);
    }

    public function testGetCurrency()
    {
        $expectedCurrency = 'BTC';

        $ledger = $this->createClassObject();
        $ledger->setCurrency($expectedCurrency);
        $this->assertEquals($expectedCurrency, $ledger->getCurrency());
    }

    public function testGetBalance()
    {
        $expectedBalance = 1.1;

        $ledger = $this->createClassObject();
        $ledger->setBalance($expectedBalance);
        $this->assertEquals($expectedBalance, $ledger->getBalance());
    }

    public function testToArray()
    {
        $ledger = $this->createClassObject();

        $ledger->setCurrency('BTC');
        $ledger->setBalance(1.1);

        $ledgerArray = $ledger->toArray();

        $this->assertNotNull($ledgerArray);
        $this->assertIsArray($ledgerArray);

        $this->assertArrayHasKey('currency', $ledgerArray);
        $this->assertArrayHasKey('balance', $ledgerArray);

        $this->assertEquals($ledgerArray['currency'], 'BTC');
        $this->assertEquals($ledgerArray['balance'], 1.1);
    }

    private function createClassObject()
    {
        return new Ledger();
    }
}