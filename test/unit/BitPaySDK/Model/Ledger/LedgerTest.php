<?php

namespace BitPaySDK\Test\Model\Ledger;

use BitPaySDK\Model\Ledger\Buyer;
use BitPaySDK\Model\Ledger\Ledger;
use BitPaySDK\Model\Ledger\LedgerEntry;
use PHPUnit\Framework\TestCase;

class LedgerTest extends TestCase
{
    public function testInstanceOf()
    {
        $ledger = $this->createClassObject();
        $this->assertInstanceOf(Ledger::class, $ledger);
    }

    public function testGetEntries()
    {
        $expectedLedgerEntries = [];
        array_push($expectedLedgerEntries, $this->createLedgerEntry()->toArray());

        $ledger = $this->createClassObject();
        $ledger->setEntries($expectedLedgerEntries);
        $this->assertEquals($expectedLedgerEntries, $ledger->getEntries());

        $expectedLedgerEntries = [];
        array_push($expectedLedgerEntries, $this->createLedgerEntry());
        
        $ledger = $this->createClassObject();
        $ledger->setEntries($expectedLedgerEntries);
        $this->assertEquals($expectedLedgerEntries[0]->toArray(), $ledger->getEntries()[0]);
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
        $expectedLedgerEntries = [];
        array_push($expectedLedgerEntries, $this->createLedgerEntry()->toArray());

        $ledger = $this->createClassObject();

        $ledger->setEntries($expectedLedgerEntries);
        $ledger->setCurrency('BTC');
        $ledger->setBalance(1.1);

        $ledgerArray = $ledger->toArray();

        $this->assertNotNull($ledgerArray);
        $this->assertIsArray($ledgerArray);

        $this->assertArrayHasKey('entries', $ledgerArray);
        $this->assertArrayHasKey('currency', $ledgerArray);
        $this->assertArrayHasKey('balance', $ledgerArray);

        $this->assertEquals($ledgerArray['entries'], $expectedLedgerEntries);
        $this->assertEquals($ledgerArray['currency'], 'BTC');
        $this->assertEquals($ledgerArray['balance'], 1.1);
    }

    private function createClassObject()
    {
        return new Ledger();
    }

    private function createLedgerEntry()
    {
        $ledgerEntry = new LedgerEntry;
        $ledgerEntry->setType('TestType');
        $ledgerEntry->setAmount('1');
        $ledgerEntry->setCode('abc123');
        $ledgerEntry->setTimestamp('2020-01-01 18:10:10');
        $ledgerEntry->setCurrency('BTC');
        $ledgerEntry->setTxType('TxType');
        $ledgerEntry->setScale('Test scale');
        $ledgerEntry->setId('1');
        $ledgerEntry->setSupportRequest('Test support request');
        $ledgerEntry->setDescription('Test description');
        $ledgerEntry->setInvoiceId('1');
        $ledgerEntry->setBuyerFields(new Buyer());
        $ledgerEntry->setInvoiceAmount(20.7);
        $ledgerEntry->setInvoiceCurrency('BTC');
        $ledgerEntry->setTransactionCurrency('BTC');

        return $ledgerEntry;
    }
}