<?php

namespace BitPaySDK\Test\Model\Invoice;

use BitPaySDK\Model\Invoice\Refund;
use BitPaySDK\Model\Invoice\RefundParams;
use PHPUnit\Framework\TestCase;

class RefundTest extends TestCase
{
    public function testInstanceOf()
    {
        $refund = $this->createClassObject();
        $this->assertInstanceOf(Refund::class, $refund);
    }

    public function testGetGuid()
    {
        $expectedGuid = 'Test guid';

        $refund = $this->createClassObject();
        $refund->setGuid($expectedGuid);
        $this->assertEquals($expectedGuid, $refund->getGuid());
    }

    public function testGetReference()
    {
        $expectedReference = 'Test reference';

        $refund = $this->createClassObject();
        $refund->setReference($expectedReference);
        $this->assertEquals($expectedReference, $refund->getReference());
    }

    public function testGetAmount()
    {
        $expectedAmount = 15.0;

        $refund = $this->createClassObject();
        $refund->setAmount($expectedAmount);
        $this->assertEquals($expectedAmount, $refund->getAmount());
    }

    public function testGetToken()
    {
        $expectedToken = 'Test token';

        $refund = $this->createClassObject();
        $refund->setToken($expectedToken);
        $this->assertEquals($expectedToken, $refund->getToken());
    }

    public function testGetCurrency()
    {
        $expectedCurrency = 'BTC';

        $refund = $this->createClassObject();
        $refund->setCurrency($expectedCurrency);
        $this->assertEquals($expectedCurrency, $refund->getCurrency());
    }

    public function testGetPreview()
    {
        $refund = $this->createClassObject();
        $refund->setPreview(true);
        $this->assertTrue($refund->getPreview());
    }

    public function testGetInvoiceId()
    {
        $expectedInvoiceId = '15';

        $refund = $this->createClassObject();
        $refund->setInvoiceId($expectedInvoiceId);
        $this->assertEquals($expectedInvoiceId, $refund->getInvoiceId());
    }

    public function testGetId()
    {
        $expectedId = '10';

        $refund = $this->createClassObject();
        $refund->setId($expectedId);
        $this->assertEquals($expectedId, $refund->getId());
    }

    public function testGetRequestDate()
    {
        $expectedRequestDate = '2022-01-01';

        $refund = $this->createClassObject();
        $refund->setRequestDate($expectedRequestDate);
        $this->assertEquals($expectedRequestDate, $refund->getRequestDate());
    }

    public function testGetStatus()
    {
        $expectedStatus = 'pending';

        $refund = $this->createClassObject();
        $refund->setStatus($expectedStatus);
        $this->assertEquals($expectedStatus, $refund->getStatus());
    }

    public function testGetImmediate()
    {
        $refund = $this->createClassObject();
        $refund->setImmediate(true);
        $this->assertTrue($refund->getImmediate());
    }

    public function testGetRefundFee()
    {
        $expectedRefundFee = 1.0;

        $refund = $this->createClassObject();
        $refund->setRefundFee($expectedRefundFee);
        $this->assertEquals($expectedRefundFee, $refund->getRefundFee());
    }

    public function testGetLastRefundNotification()
    {
        $expectedLastRefundNotification = 'Test last refund notification';

        $refund = $this->createClassObject();
        $refund->setLastRefundNotification($expectedLastRefundNotification);
        $this->assertEquals($expectedLastRefundNotification, $refund->getLastRefundNotification());
    }

    public function testGetInvoice()
    {
        $expectedInvoice = 'Test invoice';

        $refund = $this->createClassObject();
        $refund->setInvoice($expectedInvoice);
        $this->assertEquals($expectedInvoice, $refund->getInvoice());
    }

    public function testGetBuyerPaysRefundFee()
    {
        $refund = $this->createClassObject();
        $refund->setBuyerPaysRefundFee(true);
        $this->assertTrue($refund->getBuyerPaysRefundFee());
    }

    public function testToArray()
    {
        $refund = $this->createClassObject();
        $this->prepareRefund($refund);
        $refundArray = $refund->toArray();

        $this->assertNotNull($refundArray);
        $this->assertIsArray($refundArray);

        $this->assertArrayHasKey('guid', $refundArray);
        $this->assertArrayHasKey('amount', $refundArray);
        $this->assertArrayHasKey('currency', $refundArray);
        $this->assertArrayHasKey('token', $refundArray);
        $this->assertArrayHasKey('id', $refundArray);
        $this->assertArrayHasKey('requestDate', $refundArray);
        $this->assertArrayHasKey('status', $refundArray);
        $this->assertArrayHasKey('invoiceId', $refundArray);
        $this->assertArrayHasKey('preview', $refundArray);
        $this->assertArrayHasKey('immediate', $refundArray);
        $this->assertArrayHasKey('refundFee', $refundArray);
        $this->assertArrayHasKey('invoice', $refundArray);
        $this->assertArrayHasKey('buyerPaysRefundFee', $refundArray);
        $this->assertArrayHasKey('reference', $refundArray);
        $this->assertArrayHasKey('lastRefundNotification', $refundArray);

        $this->assertEquals('Guid', $refundArray['guid']);
        $this->assertEquals(11.1, $refundArray['amount']);
        $this->assertEquals('BTC', $refundArray['currency']);
        $this->assertEquals('Token', $refundArray['token']);
        $this->assertEquals('1', $refundArray['id']);
        $this->assertEquals('2022-01-01', $refundArray['requestDate']);
        $this->assertEquals('pending', $refundArray['status']);
        $this->assertEquals('11', $refundArray['invoiceId']);
        $this->assertEquals(true, $refundArray['preview']);
        $this->assertEquals(true, $refundArray['immediate']);
        $this->assertEquals(1.0, $refundArray['refundFee']);
        $this->assertEquals('Invoice', $refundArray['invoice']);
        $this->assertEquals(true, $refundArray['buyerPaysRefundFee']);
        $this->assertEquals('Reference', $refundArray['reference']);
        $this->assertEquals('Last refunded notification', $refundArray['lastRefundNotification']);
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
