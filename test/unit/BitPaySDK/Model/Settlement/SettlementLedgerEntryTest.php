<?php

namespace BitPaySDK\Test\Model\Settlement;

use BitPaySDK\Model\Settlement\InvoiceData;
use BitPaySDK\Model\Settlement\SettlementLedgerEntry;
use PHPUnit\Framework\TestCase;

class SettlementLedgerEntryTest extends TestCase
{
    public function testInstanceOf()
    {
        $settlementLedgerEntry = $this->createClassObject();
        self::assertInstanceOf(SettlementLedgerEntry::class, $settlementLedgerEntry);
    }

    public function testGetCode()
    {
        $expectedCode = 583;

        $settlementLedgerEntry = $this->createClassObject();
        $settlementLedgerEntry->setCode($expectedCode);
        self::assertEquals($expectedCode, $settlementLedgerEntry->getCode());
    }

    public function testGetInvoiceId()
    {
        $expectedInvoiceId = '1';

        $settlementLedgerEntry = $this->createClassObject();
        $settlementLedgerEntry->setInvoiceId($expectedInvoiceId);
        self::assertEquals($expectedInvoiceId, $settlementLedgerEntry->getInvoiceId());
    }

    public function testGetAmount()
    {
        $expectedAmount = 20.3;

        $settlementLedgerEntry = $this->createClassObject();
        $settlementLedgerEntry->setAmount($expectedAmount);
        self::assertEquals($expectedAmount, $settlementLedgerEntry->getAmount());
    }

    public function testGetTimestamp()
    {
        $expectedTimestamp = '2022-01-11 01:01:01';

        $settlementLedgerEntry = $this->createClassObject();
        $settlementLedgerEntry->setTimestamp($expectedTimestamp);
        self::assertEquals($expectedTimestamp, $settlementLedgerEntry->getTimestamp());
    }

    public function testGetDescription()
    {
        $expectedDescription = 'Test description';

        $settlementLedgerEntry = $this->createClassObject();
        $settlementLedgerEntry->setDescription($expectedDescription);
        self::assertEquals($expectedDescription, $settlementLedgerEntry->getDescription());
    }

    public function testGetReference()
    {
        $expectedReference = 'Test reference';

        $settlementLedgerEntry = $this->createClassObject();
        $settlementLedgerEntry->setReference($expectedReference);
        self::assertEquals($expectedReference, $settlementLedgerEntry->getReference());
    }

    public function testGetInvoiceData()
    {
        $expectedInvoiceData = $this->getMockBuilder(InvoiceData::class)->getMock();

        $settlementLedgerEntry = $this->createClassObject();
        $settlementLedgerEntry->setInvoiceData($expectedInvoiceData);
        self::assertEquals($expectedInvoiceData, $settlementLedgerEntry->getInvoiceData());
    }

    public function testToArray()
    {
        $settlementLedgerEntry = $this->createClassObject();
        $this->setSetters($settlementLedgerEntry);
        $settlementLedgerEntryArray = $settlementLedgerEntry->toArray();

        self::assertNotNull($settlementLedgerEntryArray);
        self::assertIsArray($settlementLedgerEntryArray);

        self::assertArrayHasKey('code', $settlementLedgerEntryArray);
        self::assertArrayHasKey('invoiceId', $settlementLedgerEntryArray);
        self::assertArrayHasKey('amount', $settlementLedgerEntryArray);
        self::assertArrayHasKey('timestamp', $settlementLedgerEntryArray);
        self::assertArrayHasKey('description', $settlementLedgerEntryArray);
        self::assertArrayHasKey('reference', $settlementLedgerEntryArray);
        self::assertArrayHasKey('invoiceData', $settlementLedgerEntryArray);

        self::assertEquals(567, $settlementLedgerEntryArray['code']);
        self::assertEquals('14', $settlementLedgerEntryArray['invoiceId']);
        self::assertEquals(55.5, $settlementLedgerEntryArray['amount']);
        self::assertEquals('2022-01-11 01:01:01', $settlementLedgerEntryArray['timestamp']);
        self::assertEquals('Description', $settlementLedgerEntryArray['description']);
        self::assertEquals('Reference', $settlementLedgerEntryArray['reference']);
    }

    private function createClassObject(): SettlementLedgerEntry
    {
        return new SettlementLedgerEntry();
    }

    private function setSetters(SettlementLedgerEntry $settlementLedgerEntry)
    {
        $settlementLedgerEntry->setCode(567);
        $settlementLedgerEntry->setInvoiceId('14');
        $settlementLedgerEntry->setAmount(55.5);
        $settlementLedgerEntry->setTimestamp('2022-01-11 01:01:01');
        $settlementLedgerEntry->setDescription('Description');
        $settlementLedgerEntry->setReference('Reference');
        $settlementLedgerEntry->setInvoiceData($this->getMockBuilder(InvoiceData::class)->getMock());
    }
}
