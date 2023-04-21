<?php

namespace BitPaySDK\Test\Model\Invoice;

use BitPaySDK\Model\Invoice\Refund;
use PHPUnit\Framework\TestCase;

class RefundTest extends TestCase
{
    public function testInstanceOf()
    {
        $refund = $this->createClassObject();
        self::assertInstanceOf(Refund::class, $refund);
    }

    public function testGetGuid()
    {
        $expectedGuid = 'Test guid';

        $refund = $this->createClassObject();
        $refund->setGuid($expectedGuid);
        self::assertEquals($expectedGuid, $refund->getGuid());
    }

    public function testGetReference()
    {
        $expectedReference = 'Test reference';

        $refund = $this->createClassObject();
        $refund->setReference($expectedReference);
        self::assertEquals($expectedReference, $refund->getReference());
    }

    public function testGetAmount()
    {
        $expectedAmount = 15.0;

        $refund = $this->createClassObject();
        $refund->setAmount($expectedAmount);
        self::assertEquals($expectedAmount, $refund->getAmount());
    }

    public function testGetToken()
    {
        $expectedToken = 'Test token';

        $refund = $this->createClassObject();
        $refund->setToken($expectedToken);
        self::assertEquals($expectedToken, $refund->getToken());
    }

    public function testGetCurrency()
    {
        $expectedCurrency = 'BTC';

        $refund = $this->createClassObject();
        $refund->setCurrency($expectedCurrency);
        self::assertEquals($expectedCurrency, $refund->getCurrency());
    }

    public function testGetPreview()
    {
        $refund = $this->createClassObject();
        $refund->setPreview(true);
        self::assertTrue($refund->getPreview());
    }

    public function testGetInvoiceId()
    {
        $expectedInvoiceId = '15';

        $refund = $this->createClassObject();
        $refund->setInvoiceId($expectedInvoiceId);
        self::assertEquals($expectedInvoiceId, $refund->getInvoiceId());
    }

    public function testGetId()
    {
        $expectedId = '10';

        $refund = $this->createClassObject();
        $refund->setId($expectedId);
        self::assertEquals($expectedId, $refund->getId());
    }

    public function testGetRequestDate()
    {
        $expectedRequestDate = '2022-01-01';

        $refund = $this->createClassObject();
        $refund->setRequestDate($expectedRequestDate);
        self::assertEquals($expectedRequestDate, $refund->getRequestDate());
    }

    public function testGetStatus()
    {
        $expectedStatus = 'pending';

        $refund = $this->createClassObject();
        $refund->setStatus($expectedStatus);
        self::assertEquals($expectedStatus, $refund->getStatus());
    }

    public function testGetImmediate()
    {
        $refund = $this->createClassObject();
        $refund->setImmediate(true);
        self::assertTrue($refund->getImmediate());
    }

    public function testGetRefundFee()
    {
        $expectedRefundFee = 1.0;

        $refund = $this->createClassObject();
        $refund->setRefundFee($expectedRefundFee);
        self::assertEquals($expectedRefundFee, $refund->getRefundFee());
    }

    public function testGetLastRefundNotification()
    {
        $expectedLastRefundNotification = 'Test last refund notification';

        $refund = $this->createClassObject();
        $refund->setLastRefundNotification($expectedLastRefundNotification);
        self::assertEquals($expectedLastRefundNotification, $refund->getLastRefundNotification());
    }

    public function testGetInvoice()
    {
        $expectedInvoice = 'Test invoice';

        $refund = $this->createClassObject();
        $refund->setInvoice($expectedInvoice);
        self::assertEquals($expectedInvoice, $refund->getInvoice());
    }

    public function testGetBuyerPaysRefundFee()
    {
        $refund = $this->createClassObject();
        $refund->setBuyerPaysRefundFee(true);
        self::assertTrue($refund->getBuyerPaysRefundFee());
    }

    public function testToArray()
    {
        $refund = $this->createClassObject();
        $this->prepareRefund($refund);
        $refundArray = $refund->toArray();

        self::assertNotNull($refundArray);
        self::assertIsArray($refundArray);

        self::assertArrayHasKey('guid', $refundArray);
        self::assertArrayHasKey('amount', $refundArray);
        self::assertArrayHasKey('currency', $refundArray);
        self::assertArrayHasKey('token', $refundArray);
        self::assertArrayHasKey('id', $refundArray);
        self::assertArrayHasKey('requestDate', $refundArray);
        self::assertArrayHasKey('status', $refundArray);
        self::assertArrayHasKey('invoiceId', $refundArray);
        self::assertArrayHasKey('preview', $refundArray);
        self::assertArrayHasKey('immediate', $refundArray);
        self::assertArrayHasKey('refundFee', $refundArray);
        self::assertArrayHasKey('invoice', $refundArray);
        self::assertArrayHasKey('buyerPaysRefundFee', $refundArray);
        self::assertArrayHasKey('reference', $refundArray);
        self::assertArrayHasKey('lastRefundNotification', $refundArray);

        self::assertEquals('Guid', $refundArray['guid']);
        self::assertEquals(11.1, $refundArray['amount']);
        self::assertEquals('BTC', $refundArray['currency']);
        self::assertEquals('Token', $refundArray['token']);
        self::assertEquals('1', $refundArray['id']);
        self::assertEquals('2022-01-01', $refundArray['requestDate']);
        self::assertEquals('pending', $refundArray['status']);
        self::assertEquals('11', $refundArray['invoiceId']);
        self::assertEquals(true, $refundArray['preview']);
        self::assertEquals(true, $refundArray['immediate']);
        self::assertEquals(1.0, $refundArray['refundFee']);
        self::assertEquals('Invoice', $refundArray['invoice']);
        self::assertEquals(true, $refundArray['buyerPaysRefundFee']);
        self::assertEquals('Reference', $refundArray['reference']);
        self::assertEquals('Last refunded notification', $refundArray['lastRefundNotification']);
    }

    private function createClassObject(): Refund
    {
        return new Refund();
    }

    private function prepareRefund(Refund $refund): void
    {
        $refund->setGuid('Guid');
        $refund->setAmount(11.1);
        $refund->setCurrency('BTC');
        $refund->setToken('Token');
        $refund->setId('1');
        $refund->setRequestDate('2022-01-01');
        $refund->setStatus('pending');
        $refund->setInvoiceId('11');
        $refund->setPreview(true);
        $refund->setImmediate(true);
        $refund->setRefundFee(1.0);
        $refund->setInvoice('Invoice');
        $refund->setBuyerPaysRefundFee(true);
        $refund->setReference('Reference');
        $refund->setLastRefundNotification('Last refunded notification');
    }
}
