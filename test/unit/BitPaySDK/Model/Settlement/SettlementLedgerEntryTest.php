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
        $this->assertInstanceOf(SettlementLedgerEntry::class, $settlementLedgerEntry);
    }

    public function testGetCode()
    {
        $expectedCode = 583;

        $settlementLedgerEntry = $this->createClassObject();
        $settlementLedgerEntry->setCode($expectedCode);
        $this->assertEquals($expectedCode, $settlementLedgerEntry->getCode());
    }

    public function testGetInvoiceId()
    {
        $expectedInvoiceId = '1';

        $settlementLedgerEntry = $this->createClassObject();
        $settlementLedgerEntry->setInvoiceId($expectedInvoiceId);
        $this->assertEquals($expectedInvoiceId, $settlementLedgerEntry->getInvoiceId());
    }

    public function testGetAmount()
    {
        $expectedAmount = 20.3;

        $settlementLedgerEntry = $this->createClassObject();
        $settlementLedgerEntry->setAmount($expectedAmount);
        $this->assertEquals($expectedAmount, $settlementLedgerEntry->getAmount());
    }

    public function testGetTimestamp()
    {
        $expectedTimestamp = '2022-01-11 01:01:01';

        $settlementLedgerEntry = $this->createClassObject();
        $settlementLedgerEntry->setTimestamp($expectedTimestamp);
        $this->assertEquals($expectedTimestamp, $settlementLedgerEntry->getTimestamp());
    }

    public function testGetDescription()
    {
        $expectedDescription = 'Test description';

        $settlementLedgerEntry = $this->createClassObject();
        $settlementLedgerEntry->setDescription($expectedDescription);
        $this->assertEquals($expectedDescription, $settlementLedgerEntry->getDescription());
    }

    public function testGetReference()
    {
        $expectedReference = 'Test reference';

        $settlementLedgerEntry = $this->createClassObject();
        $settlementLedgerEntry->setReference($expectedReference);
        $this->assertEquals($expectedReference, $settlementLedgerEntry->getReference());
    }

    public function testGetInvoiceData()
    {
        $expectedInvoiceData = $this->getMockBuilder(InvoiceData::class)->getMock();

        $settlementLedgerEntry = $this->createClassObject();
        $settlementLedgerEntry->setInvoiceData($expectedInvoiceData);
        $this->assertEquals($expectedInvoiceData, $settlementLedgerEntry->getInvoiceData());
    }

    public function testToArray()
    {
        $settlementLedgerEntry = $this->createClassObject();
        $this->setSetters($settlementLedgerEntry);
        $settlementLedgerEntryArray = $settlementLedgerEntry->toArray();

        $this->assertNotNull($settlementLedgerEntryArray);
        $this->assertIsArray($settlementLedgerEntryArray);

        $this->assertArrayHasKey('code', $settlementLedgerEntryArray);
        $this->assertArrayHasKey('invoiceId', $settlementLedgerEntryArray);
        $this->assertArrayHasKey('amount', $settlementLedgerEntryArray);
        $this->assertArrayHasKey('timestamp', $settlementLedgerEntryArray);
        $this->assertArrayHasKey('description', $settlementLedgerEntryArray);
        $this->assertArrayHasKey('reference', $settlementLedgerEntryArray);
        $this->assertArrayHasKey('invoiceData', $settlementLedgerEntryArray);

        $this->assertEquals($settlementLedgerEntryArray['code'], 567);
        $this->assertEquals($settlementLedgerEntryArray['invoiceId'], '14');
        $this->assertEquals($settlementLedgerEntryArray['amount'], 55.5);
        $this->assertEquals($settlementLedgerEntryArray['timestamp'], '2022-01-11 01:01:01');
        $this->assertEquals($settlementLedgerEntryArray['description'], 'Description');
        $this->assertEquals($settlementLedgerEntryArray['reference'], 'Reference');
        $this->assertEquals($settlementLedgerEntryArray['invoiceData'], null);
    }

    private function createClassObject()
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
