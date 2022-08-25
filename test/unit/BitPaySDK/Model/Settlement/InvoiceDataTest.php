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
        $this->assertInstanceOf(InvoiceData::class, $invoiceData);
    }

    public function testGetOrderId()
    {
        $expectedOrderId = '1';

        $invoiceData = $this->createClassObject();
        $invoiceData->setOrderId($expectedOrderId);
        $this->assertEquals($expectedOrderId, $invoiceData->getOrderId());
    }

    public function testGetDate()
    {
        $expectedDate = '2022-01-01';

        $invoiceData = $this->createClassObject();
        $invoiceData->setDate($expectedDate);
        $this->assertEquals($expectedDate, $invoiceData->getDate());
    }

    public function testGetPrice()
    {
        $expectedPrice = 12.9;

        $invoiceData = $this->createClassObject();
        $invoiceData->setPrice($expectedPrice);
        $this->assertEquals($expectedPrice, $invoiceData->getPrice());
    }

    public function testGetCurrency()
    {
        $expectedCurrency = 'BTC';

        $invoiceData = $this->createClassObject();
        $invoiceData->setCurrency($expectedCurrency);
        $this->assertEquals($expectedCurrency, $invoiceData->getCurrency());
    }

    public function testGetTransactionCurrency()
    {
        $expectedTransactionCurrency = 'BTC';

        $invoiceData = $this->createClassObject();
        $invoiceData->setTransactionCurrency($expectedTransactionCurrency);
        $this->assertEquals($expectedTransactionCurrency, $invoiceData->getTransactionCurrency());
    }

    public function testGetOverPaidAmount()
    {
        $expectedOverPaidAmount = 11.1;

        $invoiceData = $this->createClassObject();
        $invoiceData->setOverPaidAmount($expectedOverPaidAmount);
        $this->assertEquals($expectedOverPaidAmount, $invoiceData->getOverPaidAmount());
    }

    public function testGetPayoutPercentage()
    {
        $expectedPayoutPercentage = 15;

        $invoiceData = $this->createClassObject();
        $invoiceData->setPayoutPercentage($expectedPayoutPercentage);
        $this->assertEquals($expectedPayoutPercentage, $invoiceData->getPayoutPercentage());
    }

    public function testGetBtcPrice()
    {
        $expectedBtcPrice = 50000;

        $invoiceData = $this->createClassObject();
        $invoiceData->setBtcPrice($expectedBtcPrice);
        $this->assertEquals($expectedBtcPrice, $invoiceData->getBtcPrice());
    }

    public function testGetRefundInfo()
    {
        $expectedRefundInfo = $this->getMockBuilder(RefundInfo::class)->getMock();

        $invoiceData = $this->createClassObject();
        $invoiceData->setRefundInfo($expectedRefundInfo);
        $this->assertEquals($expectedRefundInfo, $invoiceData->getRefundInfo());
    }

    public function testToArray()
    {
        $invoiceData = $this->createClassObject();
        $this->setSetters($invoiceData);
        $invoiceDataArray = $invoiceData->toArray();

        $this->assertNotNull($invoiceDataArray);
        $this->assertIsArray($invoiceDataArray);

        $this->assertArrayHasKey('orderId', $invoiceDataArray);
        $this->assertArrayHasKey('date', $invoiceDataArray);
        $this->assertArrayHasKey('price', $invoiceDataArray);
        $this->assertArrayHasKey('currency', $invoiceDataArray);
        $this->assertArrayHasKey('transactionCurrency', $invoiceDataArray);
        $this->assertArrayHasKey('payoutPercentage', $invoiceDataArray);
        $this->assertArrayHasKey('refundInfo', $invoiceDataArray);

        $this->assertEquals($invoiceDataArray['orderId'], '1');
        $this->assertEquals($invoiceDataArray['date'], '2022-01-01');
        $this->assertEquals($invoiceDataArray['price'], 12.9);
        $this->assertEquals($invoiceDataArray['currency'], 'BTC');
        $this->assertEquals($invoiceDataArray['transactionCurrency'], 'BTC');
        $this->assertEquals($invoiceDataArray['payoutPercentage'], 15);
        $this->assertEquals($invoiceDataArray['refundInfo'], null);
    }

    private function createClassObject()
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
