<?php

namespace BitPaySDK\Test\Model\Ledger;

use BitPaySDK\Model\Ledger\Buyer;
use BitPaySDK\Model\Ledger\LedgerEntry;
use PHPUnit\Framework\TestCase;

class LedgerEntryTest extends TestCase
{
    public function testInstanceOf()
    {
        $ledgerEntry = $this->createClassObject();
        self::assertInstanceOf(LedgerEntry::class, $ledgerEntry);
    }

    public function testGetType()
    {
        $expectedType = 'TestType';

        $ledgerEntry = $this->createClassObject();
        $ledgerEntry->setType($expectedType);
        self::assertEquals($expectedType, $ledgerEntry->getType());
    }

    public function testGetAmount()
    {
        $expectedAmount = '1';

        $ledgerEntry = $this->createClassObject();
        $ledgerEntry->setAmount($expectedAmount);
        self::assertEquals($expectedAmount, $ledgerEntry->getAmount());
    }

    public function testGetCode()
    {
        $expectedCode = 'abc123';

        $ledgerEntry = $this->createClassObject();
        $ledgerEntry->setCode($expectedCode);
        self::assertEquals($expectedCode, $ledgerEntry->getCode());
    }

    public function testGetTimestamp()
    {
        $expectedTimestamp = '2020-01-01 18:10:10';

        $ledgerEntry = $this->createClassObject();
        $ledgerEntry->setTimestamp($expectedTimestamp);
        self::assertEquals($expectedTimestamp, $ledgerEntry->getTimestamp());
    }

    public function testGetCurrency()
    {
        $expectedCurrency = 'BTC';

        $ledgerEntry = $this->createClassObject();
        $ledgerEntry->setCurrency($expectedCurrency);
        self::assertEquals($expectedCurrency, $ledgerEntry->getCurrency());
    }

    public function testGetTxType()
    {
        $expectedTxType = 'TxType';

        $ledgerEntry = $this->createClassObject();
        $ledgerEntry->setTxType($expectedTxType);
        self::assertEquals($expectedTxType, $ledgerEntry->getTxType());
    }

    public function testGetScale()
    {
        $expectedScale = 'TestScale';

        $ledgerEntry = $this->createClassObject();
        $ledgerEntry->setScale($expectedScale);
        self::assertEquals($expectedScale, $ledgerEntry->getScale());
    }

    public function testGetId()
    {
        $expectedId = '1';

        $ledgerEntry = $this->createClassObject();
        $ledgerEntry->setId($expectedId);
        self::assertEquals($expectedId, $ledgerEntry->getId());
    }

    public function testGetSupportRequest()
    {
        $expectedSupportRequest = 'Test support request';

        $ledgerEntry = $this->createClassObject();
        $ledgerEntry->setSupportRequest($expectedSupportRequest);
        self::assertEquals($expectedSupportRequest, $ledgerEntry->getSupportRequest());
    }

    public function testGetDescription()
    {
        $expectedDescription = 'Test description';

        $ledgerEntry = $this->createClassObject();
        $ledgerEntry->setDescription($expectedDescription);
        self::assertEquals($expectedDescription, $ledgerEntry->getDescription());
    }

    public function testGetInvoiceId()
    {
        $expectedInvoiceId = '1';

        $ledgerEntry = $this->createClassObject();
        $ledgerEntry->setInvoiceId($expectedInvoiceId);
        self::assertEquals($expectedInvoiceId, $ledgerEntry->getInvoiceId());
    }

    public function testGetBuyerFields()
    {
        $expectedBuyerField = new Buyer();

        $ledgerEntry = $this->createClassObject();
        $ledgerEntry->setBuyerFields($expectedBuyerField);
        self::assertEquals($expectedBuyerField, $ledgerEntry->getBuyerFields());
    }

    public function testGetInvoiceAmount()
    {
        $expectedInvoiceAmount = 20.7;

        $ledgerEntry = $this->createClassObject();
        $ledgerEntry->setInvoiceAmount($expectedInvoiceAmount);
        self::assertEquals($expectedInvoiceAmount, $ledgerEntry->getInvoiceAmount());
    }

    public function testGetInvoiceCurrency()
    {
        $expectedInvoiceCurrency = 'BTC';

        $ledgerEntry = $this->createClassObject();
        $ledgerEntry->setInvoiceCurrency($expectedInvoiceCurrency);
        self::assertEquals($expectedInvoiceCurrency, $ledgerEntry->getInvoiceCurrency());
    }

    public function testGetTransactionCurrency()
    {
        $expectedTransactionCurrency = 'BTC';

        $ledgerEntry = $this->createClassObject();
        $ledgerEntry->setTransactionCurrency($expectedTransactionCurrency);
        self::assertEquals($expectedTransactionCurrency, $ledgerEntry->getTransactionCurrency());
    }

    public function testToArray()
    {
        $ledgerEntry = $this->createClassObject();
        $this->setSetters($ledgerEntry);
        $ledgerEntryArray = $ledgerEntry->toArray();

        self::assertNotNull($ledgerEntryArray);
        self::assertIsArray($ledgerEntryArray);

        self::assertArrayHasKey('type', $ledgerEntryArray);
        self::assertArrayHasKey('amount', $ledgerEntryArray);
        self::assertArrayHasKey('code', $ledgerEntryArray);
        self::assertArrayHasKey('timestamp', $ledgerEntryArray);
        self::assertArrayHasKey('currency', $ledgerEntryArray);
        self::assertArrayHasKey('txType', $ledgerEntryArray);
        self::assertArrayHasKey('scale', $ledgerEntryArray);
        self::assertArrayHasKey('id', $ledgerEntryArray);
        self::assertArrayHasKey('supportRequest', $ledgerEntryArray);
        self::assertArrayHasKey('description', $ledgerEntryArray);
        self::assertArrayHasKey('invoiceId', $ledgerEntryArray);
        self::assertArrayHasKey('invoiceAmount', $ledgerEntryArray);
        self::assertArrayHasKey('invoiceCurrency', $ledgerEntryArray);
        self::assertArrayHasKey('transactionCurrency', $ledgerEntryArray);

        self::assertEquals('TestType', $ledgerEntryArray['type']);
        self::assertEquals('1', $ledgerEntryArray['amount']);
        self::assertEquals('abc123', $ledgerEntryArray['code']);
        self::assertEquals('2020-01-01 18:10:10', $ledgerEntryArray['timestamp']);
        self::assertEquals('BTC', $ledgerEntryArray['currency']);
        self::assertEquals('TxType', $ledgerEntryArray['txType']);
        self::assertEquals('Test scale', $ledgerEntryArray['scale']);
        self::assertEquals('1', $ledgerEntryArray['id']);
        self::assertEquals('Test support request', $ledgerEntryArray['supportRequest']);
        self::assertEquals('Test description', $ledgerEntryArray['description']);
        self::assertEquals('1', $ledgerEntryArray['invoiceId']);
        self::assertEquals(20.7, $ledgerEntryArray['invoiceAmount']);
        self::assertEquals('BTC', $ledgerEntryArray['invoiceCurrency']);
        self::assertEquals('BTC', $ledgerEntryArray['transactionCurrency']);
    }

    private function createClassObject(): LedgerEntry
    {
        return new LedgerEntry();
    }

    private function setSetters(LedgerEntry $ledgerEntry)
    {
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
    }
}
