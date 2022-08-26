<?php

namespace BitPaySDK\Test;

use BitPaySDK\Model\Invoice\RefundWebhook;
use PHPUnit\Framework\TestCase;

class RefundWebhookTest extends TestCase
{
  public function testInstanceOf()
  {
    $refundWebhook = $this->createClassObject();
    $this->assertInstanceOf(RefundWebhook::class, $refundWebhook);
  }

  public function testGetId()
  {
    $expectedId = 'GZBBLcsgQamua3PN8GX92s';

    $refundWebhook = $this->createClassObject();
    $refundWebhook->setId($expectedId);
    $this->assertEquals($expectedId, $refundWebhook->getId());
  }

  public function testGetInvoice()
  {
    $expectedInvoice = 'Wp9cpGphCz7cSeFh6MSYpb';

    $refundWebhook = $this->createClassObject();
    $refundWebhook->setInvoice($expectedInvoice);
    $this->assertEquals($expectedInvoice, $refundWebhook->getInvoice());
  }

  public function testGetSupportRequest()
  {
    $expectedSupportRequest = 'XuuYtZfTw7G99Ws3z38kWZ';
    
    $refundWebhook = $this->createClassObject();
    $refundWebhook->setSupportRequest($expectedSupportRequest);
    $this->assertEquals($expectedSupportRequest, $refundWebhook->getSupportRequest());
  }

  public function testGetStatus()
  {
    $expectedStatus = 'pending';

    $refundWebhook = $this->createClassObject();
    $refundWebhook->setStatus($expectedStatus);
    $this->assertEquals($expectedStatus, $refundWebhook->getStatus());
  }

  public function testGetAmount()
  {
    $expectedAmount = 6;

    $refundWebhook = $this->createClassObject();
    $refundWebhook->setAmount($expectedAmount);
    $this->assertEquals($expectedAmount, $refundWebhook->getAmount());
  }

  public function testGetCurrency()
  {
    $expectedCurrency = 'USD';

    $refundWebhook = $this->createClassObject();
    $refundWebhook->setCurrency($expectedCurrency);
    $this->assertEquals($expectedCurrency, $refundWebhook->getCurrency());
  }

  public function testGetLastRefundNotification()
  {
    $expectedLastRefundNotification = '2022-01-11T16:58:23.967Z';

    $refundWebhook = $this->createClassObject();
    $refundWebhook->setLastRefundNotification($expectedLastRefundNotification);
    $this->assertEquals($expectedLastRefundNotification, $refundWebhook->getLastRefundNotification());
  }

  public function testGetRefundFee()
  {
    $expectedRefundFee = 2.31;

    $refundWebhook = $this->createClassObject();
    $refundWebhook->setRefundFee($expectedRefundFee);
    $this->assertEquals($expectedRefundFee, $refundWebhook->getRefundFee());
  }

  public function testImmediate()
  {
    $expectedImmediate = false;

    $refundWebhook = $this->createClassObject();
    $refundWebhook->setImmediate($expectedImmediate);
    $this->assertEquals($expectedImmediate, $refundWebhook->getImmediate());
  }

  public function testGetBuyerPaysRefundFee()
  {
    $expectedBuyerPaysRefundFee = true;

    $refundWebhook = $this->createClassObject();
    $refundWebhook->setBuyerPaysRefundFee($expectedBuyerPaysRefundFee);
    $this->assertEquals($expectedBuyerPaysRefundFee, $refundWebhook->getBuyerPaysRefundFee());
  }

  public function testGetRequestDate()
  {
    $expectedRequestDate = '2022-01-11T16:58:23.000Z';

    $refundWebhook = $this->createClassObject();
    $refundWebhook->setRequestDate($expectedRequestDate);
    $this->assertEquals($expectedRequestDate, $refundWebhook->getRequestDate());
  }

  public function testToArray()
  {
    $refundWebhook = $this->createClassObject();
    $this->objectSetters($refundWebhook);

    $refundWebhookArray = $refundWebhook->toArray();

    $this->assertNotNull($refundWebhookArray);
    $this->assertIsArray($refundWebhookArray);

    $this->assertArrayHasKey('id', $refundWebhookArray);
    $this->assertArrayHasKey('invoice', $refundWebhookArray);
    $this->assertArrayHasKey('supportRequest', $refundWebhookArray);
    $this->assertArrayHasKey('status', $refundWebhookArray);
    $this->assertArrayHasKey('amount', $refundWebhookArray);
    $this->assertArrayHasKey('currency', $refundWebhookArray);
    $this->assertArrayHasKey('lastRefundNotification', $refundWebhookArray);
    $this->assertArrayHasKey('refundFee', $refundWebhookArray);
    $this->assertArrayHasKey('immediate', $refundWebhookArray);
    $this->assertArrayHasKey('buyerPaysRefundFee', $refundWebhookArray);
    $this->assertArrayHasKey('requestDate', $refundWebhookArray);

    $this->assertEquals($refundWebhookArray['id'], 'GZBBLcsgQamua3PN8GX92s');
    $this->assertEquals($refundWebhookArray['invoice'], 'Wp9cpGphCz7cSeFh6MSYpb');
    $this->assertEquals($refundWebhookArray['supportRequest'], 'XuuYtZfTw7G99Ws3z38kWZ');
    $this->assertEquals($refundWebhookArray['status'], 'pending');
    $this->assertEquals($refundWebhookArray['amount'], 6);
    $this->assertEquals($refundWebhookArray['currency'], 'USD');
    $this->assertEquals($refundWebhookArray['lastRefundNotification'], '2022-01-11T16:58:23.967Z');
    $this->assertEquals($refundWebhookArray['refundFee'], 2.31);
    $this->assertEquals($refundWebhookArray['immediate'], false);
    $this->assertEquals($refundWebhookArray['buyerPaysRefundFee'], true);
    $this->assertEquals($refundWebhookArray['requestDate'], '2022-01-11T16:58:23.000Z');
  }

  private function createClassObject()
  {
    return new RefundWebhook();
  }

  private function objectSetters(RefundWebhook $refundWebhook): void
  {
    $refundWebhook->setId('GZBBLcsgQamua3PN8GX92s');
    $refundWebhook->setInvoice('Wp9cpGphCz7cSeFh6MSYpb');
    $refundWebhook->setSupportRequest('XuuYtZfTw7G99Ws3z38kWZ');
    $refundWebhook->setStatus('pending');
    $refundWebhook->setAmount(6);
    $refundWebhook->setCurrency('USD');
    $refundWebhook->setLastRefundNotification('2022-01-11T16:58:23.967Z');
    $refundWebhook->setRefundFee(2.31);
    $refundWebhook->setImmediate(false);
    $refundWebhook->setBuyerPaysRefundFee(true);
    $refundWebhook->setRequestDate('2022-01-11T16:58:23.000Z');
  }
}