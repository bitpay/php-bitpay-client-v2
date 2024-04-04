<?php

namespace BitPaySDK\Test\Model\Invoice;

use BitPaySDK\Model\Invoice\RefundWebhook;
use PHPUnit\Framework\TestCase;

class RefundWebhookTest extends TestCase
{
  public function testInstanceOf()
  {
    $refundWebhook = $this->createClassObject();
    self::assertInstanceOf(RefundWebhook::class, $refundWebhook);
  }

  public function testGetId()
  {
    $expectedId = 'GZBBLcsgQamua3PN8GX92s';

    $refundWebhook = $this->createClassObject();
    $refundWebhook->setId($expectedId);
    self::assertEquals($expectedId, $refundWebhook->getId());
  }

  public function testGetInvoice()
  {
    $expectedInvoice = 'Wp9cpGphCz7cSeFh6MSYpb';

    $refundWebhook = $this->createClassObject();
    $refundWebhook->setInvoice($expectedInvoice);
    self::assertEquals($expectedInvoice, $refundWebhook->getInvoice());
  }

  public function testGetSupportRequest()
  {
    $expectedSupportRequest = 'XuuYtZfTw7G99Ws3z38kWZ';
    
    $refundWebhook = $this->createClassObject();
    $refundWebhook->setSupportRequest($expectedSupportRequest);
    self::assertEquals($expectedSupportRequest, $refundWebhook->getSupportRequest());
  }

  public function testGetStatus()
  {
    $expectedStatus = 'pending';

    $refundWebhook = $this->createClassObject();
    $refundWebhook->setStatus($expectedStatus);
    self::assertEquals($expectedStatus, $refundWebhook->getStatus());
  }

  public function testGetAmount()
  {
    $expectedAmount = 6;

    $refundWebhook = $this->createClassObject();
    $refundWebhook->setAmount($expectedAmount);
    self::assertEquals($expectedAmount, $refundWebhook->getAmount());
  }

  public function testGetCurrency()
  {
    $expectedCurrency = 'USD';

    $refundWebhook = $this->createClassObject();
    $refundWebhook->setCurrency($expectedCurrency);
    self::assertEquals($expectedCurrency, $refundWebhook->getCurrency());
  }

  public function testGetLastRefundNotification()
  {
    $expectedLastRefundNotification = '2022-01-11T16:58:23.967Z';

    $refundWebhook = $this->createClassObject();
    $refundWebhook->setLastRefundNotification($expectedLastRefundNotification);
    self::assertEquals($expectedLastRefundNotification, $refundWebhook->getLastRefundNotification());
  }

  public function testGetRefundFee()
  {
    $expectedRefundFee = 2.31;

    $refundWebhook = $this->createClassObject();
    $refundWebhook->setRefundFee($expectedRefundFee);
    self::assertEquals($expectedRefundFee, $refundWebhook->getRefundFee());
  }

  public function testImmediate()
  {
    $refundWebhook = $this->createClassObject();
    $refundWebhook->setImmediate(false);
    self::assertFalse($refundWebhook->getImmediate());
  }

  public function testGetBuyerPaysRefundFee()
  {
    $refundWebhook = $this->createClassObject();
    $refundWebhook->setBuyerPaysRefundFee(true);
    self::assertTrue($refundWebhook->getBuyerPaysRefundFee());
  }

  public function testGetRequestDate()
  {
    $expectedRequestDate = '2022-01-11T16:58:23.000Z';

    $refundWebhook = $this->createClassObject();
    $refundWebhook->setRequestDate($expectedRequestDate);
    self::assertEquals($expectedRequestDate, $refundWebhook->getRequestDate());
  }

  public function testToArray()
  {
    $refundWebhook = $this->createClassObject();
    $this->objectSetters($refundWebhook);

    $refundWebhookArray = $refundWebhook->toArray();

    self::assertNotNull($refundWebhookArray);
    self::assertIsArray($refundWebhookArray);

    self::assertArrayHasKey('id', $refundWebhookArray);
    self::assertArrayHasKey('invoice', $refundWebhookArray);
    self::assertArrayHasKey('supportRequest', $refundWebhookArray);
    self::assertArrayHasKey('status', $refundWebhookArray);
    self::assertArrayHasKey('amount', $refundWebhookArray);
    self::assertArrayHasKey('currency', $refundWebhookArray);
    self::assertArrayHasKey('lastRefundNotification', $refundWebhookArray);
    self::assertArrayHasKey('refundFee', $refundWebhookArray);
    self::assertArrayHasKey('immediate', $refundWebhookArray);
    self::assertArrayHasKey('buyerPaysRefundFee', $refundWebhookArray);
    self::assertArrayHasKey('requestDate', $refundWebhookArray);
    self::assertArrayHasKey('reference', $refundWebhookArray);
    self::assertArrayHasKey('guid', $refundWebhookArray);
    self::assertArrayHasKey('refundAddress', $refundWebhookArray);
    self::assertArrayHasKey('type', $refundWebhookArray);
    self::assertArrayHasKey('txid', $refundWebhookArray);
    self::assertArrayHasKey('transactionCurrency', $refundWebhookArray);
    self::assertArrayHasKey('transactionAmount', $refundWebhookArray);
    self::assertArrayHasKey('transactionRefundFee', $refundWebhookArray);

    self::assertEquals('GZBBLcsgQamua3PN8GX92s', $refundWebhookArray['id']);
    self::assertEquals('Wp9cpGphCz7cSeFh6MSYpb', $refundWebhookArray['invoice']);
    self::assertEquals('XuuYtZfTw7G99Ws3z38kWZ', $refundWebhookArray['supportRequest']);
    self::assertEquals('pending', $refundWebhookArray['status']);
    self::assertEquals(6, $refundWebhookArray['amount']);
    self::assertEquals('USD', $refundWebhookArray['currency']);
    self::assertEquals('2022-01-11T16:58:23.967Z', $refundWebhookArray['lastRefundNotification']);
    self::assertEquals(2.31, $refundWebhookArray['refundFee']);
    self::assertFalse($refundWebhookArray['immediate']);
    self::assertTrue($refundWebhookArray['buyerPaysRefundFee']);
    self::assertEquals('2022-01-11T16:58:23.000Z', $refundWebhookArray['requestDate']);
    self::assertEquals('someReference', $refundWebhookArray['reference']);
    self::assertEquals('someGuid', $refundWebhookArray['guid']);
    self::assertEquals('someRefundAddress', $refundWebhookArray['refundAddress']);
    self::assertEquals('someType', $refundWebhookArray['type']);
    self::assertEquals('someTxid', $refundWebhookArray['txid']);
    self::assertEquals('someTransactionCurrency', $refundWebhookArray['transactionCurrency']);
    self::assertEquals(12.34, $refundWebhookArray['transactionAmount']);
    self::assertEquals(12.11, $refundWebhookArray['transactionRefundFee']);
  }

  private function createClassObject(): RefundWebhook
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
    $refundWebhook->setReference('someReference');
    $refundWebhook->setGuid('someGuid');
    $refundWebhook->setRefundAddress('someRefundAddress');
    $refundWebhook->setType('someType');
    $refundWebhook->setTxid('someTxid');
    $refundWebhook->setTransactionCurrency('someTransactionCurrency');
    $refundWebhook->setTransactionAmount(12.34);
    $refundWebhook->setTransactionRefundFee(12.11);
  }
}