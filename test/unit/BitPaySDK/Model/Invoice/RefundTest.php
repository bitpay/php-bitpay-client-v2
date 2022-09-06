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

    public function testGetRefundEmail()
    {
        $expectedRefundEmail = 'test@email.com';

        $refund = $this->createClassObject();
        $refund->setRefundEmail($expectedRefundEmail);
        $this->assertEquals($expectedRefundEmail, $refund->getRefundEmail());
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

    public function testGetParams()
    {
        $expectedParams = $this->getMockBuilder(RefundParams::class)->getMock();

        $refund = $this->createClassObject();
        $refund->setParams($expectedParams);
        $this->assertEquals($expectedParams, $refund->getParams());
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
        $params = $this->getMockBuilder(RefundParams::class)->getMock();
        $refund = $this->createClassObject();
        $this->setSetters($refund, $params);
        $refundArray = $refund->toArray();

        $this->assertNotNull($refundArray);
        $this->assertIsArray($refundArray);

        $this->assertArrayHasKey('guid', $refundArray);
        $this->assertArrayHasKey('refundEmail', $refundArray);
        $this->assertArrayHasKey('amount', $refundArray);
        $this->assertArrayHasKey('currency', $refundArray);
        $this->assertArrayHasKey('token', $refundArray);
        $this->assertArrayHasKey('id', $refundArray);
        $this->assertArrayHasKey('requestDate', $refundArray);
        $this->assertArrayHasKey('status', $refundArray);
        $this->assertArrayHasKey('params', $refundArray);
        $this->assertArrayHasKey('invoiceId', $refundArray);
        $this->assertArrayHasKey('preview', $refundArray);
        $this->assertArrayHasKey('immediate', $refundArray);
        $this->assertArrayHasKey('refundFee', $refundArray);
        $this->assertArrayHasKey('invoice', $refundArray);
        $this->assertArrayHasKey('buyerPaysRefundFee', $refundArray);
        $this->assertArrayHasKey('reference', $refundArray);
        $this->assertArrayHasKey('lastRefundNotification', $refundArray);

        $this->assertEquals($refundArray['guid'], 'Guid');
        $this->assertEquals($refundArray['refundEmail'], 'test@email.com');
        $this->assertEquals($refundArray['amount'], 11.1);
        $this->assertEquals($refundArray['currency'], 'BTC');
        $this->assertEquals($refundArray['token'], 'Token');
        $this->assertEquals($refundArray['id'], '1');
        $this->assertEquals($refundArray['requestDate'], '2022-01-01');
        $this->assertEquals($refundArray['status'], 'pending');
        $this->assertEquals($refundArray['invoiceId'], '11');
        $this->assertEquals($refundArray['preview'], true);
        $this->assertEquals($refundArray['immediate'], true);
        $this->assertEquals($refundArray['refundFee'], 1.0);
        $this->assertEquals($refundArray['invoice'], 'Invoice');
        $this->assertEquals($refundArray['buyerPaysRefundFee'], true);
        $this->assertEquals($refundArray['reference'], 'Reference');
        $this->assertEquals($refundArray['lastRefundNotification'], 'Last refunded notification');
    }

    private function createClassObject()
    {
        return new Refund();
    }

    private function setSetters(Refund $refund, $params)
    {
        $refund->setGuid('Guid');
        $refund->setRefundEmail('test@email.com');
        $refund->setAmount(11.1);
        $refund->setCurrency('BTC');
        $refund->setToken('Token');
        $refund->setId('1');
        $refund->setRequestDate('2022-01-01');
        $refund->setStatus('pending');
        $refund->setParams($params);
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
