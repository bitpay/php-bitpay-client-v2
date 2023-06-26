<?php

namespace BitPaySDK\Test\Model\Settlement;

use BitPaySDK\Model\Settlement\InvoiceData;
use BitPaySDK\Model\Settlement\RefundInfo;
use PHPUnit\Framework\TestCase;

class InvoiceDataTest extends TestCase
{
    public function testInstanceOf()
    {
        $invoiceData = $this->createClassObject();
        self::assertInstanceOf(InvoiceData::class, $invoiceData);
    }

    public function testGetOrderId()
    {
        $expectedOrderId = '1';

        $invoiceData = $this->createClassObject();
        $invoiceData->setOrderId($expectedOrderId);
        self::assertEquals($expectedOrderId, $invoiceData->getOrderId());
    }

    public function testGetDate()
    {
        $expectedDate = '2022-01-01';

        $invoiceData = $this->createClassObject();
        $invoiceData->setDate($expectedDate);
        self::assertEquals($expectedDate, $invoiceData->getDate());
    }

    public function testGetPrice()
    {
        $expectedPrice = 12.9;

        $invoiceData = $this->createClassObject();
        $invoiceData->setPrice($expectedPrice);
        self::assertEquals($expectedPrice, $invoiceData->getPrice());
    }

    public function testGetCurrency()
    {
        $expectedCurrency = 'BTC';

        $invoiceData = $this->createClassObject();
        $invoiceData->setCurrency($expectedCurrency);
        self::assertEquals($expectedCurrency, $invoiceData->getCurrency());
    }

    public function testGetTransactionCurrency()
    {
        $expectedTransactionCurrency = 'BTC';

        $invoiceData = $this->createClassObject();
        $invoiceData->setTransactionCurrency($expectedTransactionCurrency);
        self::assertEquals($expectedTransactionCurrency, $invoiceData->getTransactionCurrency());
    }

    public function testGetOverPaidAmount()
    {
        $expectedOverPaidAmount = 11.1;

        $invoiceData = $this->createClassObject();
        $invoiceData->setOverPaidAmount($expectedOverPaidAmount);
        self::assertEquals($expectedOverPaidAmount, $invoiceData->getOverPaidAmount());
    }

    public function testGetPayoutPercentage()
    {
        $expectedPayoutPercentage = 15;

        $invoiceData = $this->createClassObject();
        $invoiceData->setPayoutPercentage($expectedPayoutPercentage);
        self::assertEquals($expectedPayoutPercentage, $invoiceData->getPayoutPercentage());
    }

    public function testGetRefundInfo()
    {
        $expectedRefundInfo = $this->getMockBuilder(RefundInfo::class)->getMock();

        $invoiceData = $this->createClassObject();
        $invoiceData->setRefundInfo($expectedRefundInfo);
        self::assertEquals($expectedRefundInfo, $invoiceData->getRefundInfo());
    }

    public function testToArray()
    {
        $invoiceData = $this->createClassObject();
        $this->setSetters($invoiceData);
        $invoiceDataArray = $invoiceData->toArray();

        self::assertNotNull($invoiceDataArray);
        self::assertIsArray($invoiceDataArray);

        self::assertArrayHasKey('orderId', $invoiceDataArray);
        self::assertArrayHasKey('date', $invoiceDataArray);
        self::assertArrayHasKey('price', $invoiceDataArray);
        self::assertArrayHasKey('currency', $invoiceDataArray);
        self::assertArrayHasKey('transactionCurrency', $invoiceDataArray);
        self::assertArrayHasKey('payoutPercentage', $invoiceDataArray);
        self::assertArrayHasKey('refundInfo', $invoiceDataArray);

        self::assertEquals('1', $invoiceDataArray['orderId']);
        self::assertEquals('2022-01-01', $invoiceDataArray['date']);
        self::assertEquals(12.9, $invoiceDataArray['price']);
        self::assertEquals('BTC', $invoiceDataArray['currency']);
        self::assertEquals('BTC', $invoiceDataArray['transactionCurrency']);
        self::assertEquals(15, $invoiceDataArray['payoutPercentage']);
        self::assertEquals([], $invoiceDataArray['refundInfo']);
    }

    private function createClassObject(): InvoiceData
    {
        return new InvoiceData();
    }

    private function setSetters(InvoiceData $invoiceData)
    {
        $invoiceData->setOrderId('1');
        $invoiceData->setDate('2022-01-01');
        $invoiceData->setPrice(12.9);
        $invoiceData->setCurrency('BTC');
        $invoiceData->setTransactionCurrency('BTC');
        $invoiceData->setPayoutPercentage(15);
        $invoiceData->setRefundInfo($this->getMockBuilder(RefundInfo::class)->getMock());
    }
}
