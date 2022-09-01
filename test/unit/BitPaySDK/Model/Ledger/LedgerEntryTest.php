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
        $this->assertInstanceOf(LedgerEntry::class, $ledgerEntry);
    }

    public function testGetType()
    {
        $expectedType = 'TestType';

        $ledgerEntry = $this->createClassObject();
        $ledgerEntry->setType($expectedType);
        $this->assertEquals($expectedType, $ledgerEntry->getType());
    }

    public function testGetAmount()
    {
        $expectedAmount = '1';

        $ledgerEntry = $this->createClassObject();
        $ledgerEntry->setAmount($expectedAmount);
        $this->assertEquals($expectedAmount, $ledgerEntry->getAmount());
    }

    public function testGetCode()
    {
        $expectedCode = 'abc123';

        $ledgerEntry = $this->createClassObject();
        $ledgerEntry->setCode($expectedCode);
        $this->assertEquals($expectedCode, $ledgerEntry->getCode());
    }

    public function testGetTimestamp()
    {
        $expectedTimestamp = '2020-01-01 18:10:10';

        $ledgerEntry = $this->createClassObject();
        $ledgerEntry->setTimestamp($expectedTimestamp);
        $this->assertEquals($expectedTimestamp, $ledgerEntry->getTimestamp());
    }

    public function testGetCurrency()
    {
        $expectedCurrency = 'BTC';

        $ledgerEntry = $this->createClassObject();
        $ledgerEntry->setCurrency($expectedCurrency);
        $this->assertEquals($expectedCurrency, $ledgerEntry->getCurrency());
    }

    public function testGetTxType()
    {
        $expectedTxType = 'TxType';

        $ledgerEntry = $this->createClassObject();
        $ledgerEntry->setTxType($expectedTxType);
        $this->assertEquals($expectedTxType, $ledgerEntry->getTxType());
    }

    public function testGetScale()
    {
        $expectedScale = 'TestScale';

        $ledgerEntry = $this->createClassObject();
        $ledgerEntry->setScale($expectedScale);
        $this->assertEquals($expectedScale, $ledgerEntry->getScale());
    }

    public function testGetId()
    {
        $expectedId = '1';

        $ledgerEntry = $this->createClassObject();
        $ledgerEntry->setId($expectedId);
        $this->assertEquals($expectedId, $ledgerEntry->getId());
    }

    public function testGetSupportRequest()
    {
        $expectedSupportRequest = 'Test support request';

        $ledgerEntry = $this->createClassObject();
        $ledgerEntry->setSupportRequest($expectedSupportRequest);
        $this->assertEquals($expectedSupportRequest, $ledgerEntry->getSupportRequest());
    }

    public function testGetDescription()
    {
        $expectedDescription = 'Test description';

        $ledgerEntry = $this->createClassObject();
        $ledgerEntry->setDescription($expectedDescription);
        $this->assertEquals($expectedDescription, $ledgerEntry->getDescription());
    }

    public function testGetInvoiceId()
    {
        $expectedInvoiceId = '1';

        $ledgerEntry = $this->createClassObject();
        $ledgerEntry->setInvoiceId($expectedInvoiceId);
        $this->assertEquals($expectedInvoiceId, $ledgerEntry->getInvoiceId());
    }

    public function testGetBuyerFields()
    {
        $expectedBuyerField = new Buyer();

        $ledgerEntry = $this->createClassObject();
        $ledgerEntry->setBuyerFields($expectedBuyerField);
        $this->assertEquals($expectedBuyerField, $ledgerEntry->getBuyerFields());
    }

    public function testGetInvoiceAmount()
    {
        $expectedInvoiceAmount = 20.7;

        $ledgerEntry = $this->createClassObject();
        $ledgerEntry->setInvoiceAmount($expectedInvoiceAmount);
        $this->assertEquals($expectedInvoiceAmount, $ledgerEntry->getInvoiceAmount());
    }

    public function testGetInvoiceCurrency()
    {
        $expectedInvoiceCurrency = 'BTC';

        $ledgerEntry = $this->createClassObject();
        $ledgerEntry->setInvoiceCurrency($expectedInvoiceCurrency);
        $this->assertEquals($expectedInvoiceCurrency, $ledgerEntry->getInvoiceCurrency());
    }

    public function testGetTransactionCurrency()
    {
        $expectedTransactionCurrency = 'BTC';

        $ledgerEntry = $this->createClassObject();
        $ledgerEntry->setTransactionCurrency($expectedTransactionCurrency);
        $this->assertEquals($expectedTransactionCurrency, $ledgerEntry->getTransactionCurrency());
    }

    public function testToArray()
    {
        $ledgerEntry = $this->createClassObject();
        $this->setSetters($ledgerEntry);
        $ledgerEntryArray = $ledgerEntry->toArray();

        $this->assertNotNull($ledgerEntryArray);
        $this->assertIsArray($ledgerEntryArray);

        $this->assertArrayHasKey('type', $ledgerEntryArray);
        $this->assertArrayHasKey('amount', $ledgerEntryArray);
        $this->assertArrayHasKey('code', $ledgerEntryArray);
        $this->assertArrayHasKey('timestamp', $ledgerEntryArray);
        $this->assertArrayHasKey('currency', $ledgerEntryArray);
        $this->assertArrayHasKey('txType', $ledgerEntryArray);
        $this->assertArrayHasKey('scale', $ledgerEntryArray);
        $this->assertArrayHasKey('id', $ledgerEntryArray);
        $this->assertArrayHasKey('supportRequest', $ledgerEntryArray);
        $this->assertArrayHasKey('description', $ledgerEntryArray);
        $this->assertArrayHasKey('invoiceId', $ledgerEntryArray);
        $this->assertArrayHasKey('invoiceAmount', $ledgerEntryArray);
        $this->assertArrayHasKey('invoiceCurrency', $ledgerEntryArray);
        $this->assertArrayHasKey('transactionCurrency', $ledgerEntryArray);

        $this->assertEquals($ledgerEntryArray['type'], 'TestType');
        $this->assertEquals($ledgerEntryArray['amount'], '1');
        $this->assertEquals($ledgerEntryArray['code'], 'abc123');
        $this->assertEquals($ledgerEntryArray['timestamp'], '2020-01-01 18:10:10');
        $this->assertEquals($ledgerEntryArray['currency'], 'BTC');
        $this->assertEquals($ledgerEntryArray['txType'], 'TxType');
        $this->assertEquals($ledgerEntryArray['scale'], 'Test scale');
        $this->assertEquals($ledgerEntryArray['id'], '1');
        $this->assertEquals($ledgerEntryArray['supportRequest'], 'Test support request');
        $this->assertEquals($ledgerEntryArray['description'], 'Test description');
        $this->assertEquals($ledgerEntryArray['invoiceId'], '1');
        $this->assertEquals($ledgerEntryArray['invoiceAmount'], 20.7);
        $this->assertEquals($ledgerEntryArray['invoiceCurrency'], 'BTC');
        $this->assertEquals($ledgerEntryArray['transactionCurrency'], 'BTC');
    }

    private function createClassObject()
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
