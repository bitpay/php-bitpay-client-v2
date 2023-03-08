<?php

namespace BitPaySDK\Test\Model\Payout;

use BitPaySDK\Exceptions\BitPayException;
use BitPaySDK\Model\Currency;
use BitPaySDK\Model\Payout\Payout;
use BitPaySDK\Model\Payout\PayoutTransaction;
use PHPUnit\Framework\TestCase;

class PayoutTest extends TestCase
{
  public function testInstanceOf()
  {
    $payout = $this->createClassObject();
    $this->assertInstanceOf(Payout::class, $payout);
  }

  public function testGetToken()
  {
    $expectedToken = '6RZSTPtnzEaroAe2X4YijenRiqteRDNvzbT8NjtcHjUVd9FUFwa7dsX8RFgRDDC5SL';

    $payout = $this->createClassObject();
    $payout->setToken($expectedToken);
    $this->assertEquals($expectedToken, $payout->getToken());
  }

  public function testGetAmount()
  {
    $expectedAmount = 10.0;

    $payout = $this->createClassObject();
    $payout->setAmount($expectedAmount);
    $this->assertEquals($expectedAmount, $payout->getAmount());
  }

    /**
     * @throws BitPayException
     */
    public function testGetCurrency()
  {
    $expectedCurrency = Currency::USD;

    $payout = $this->createClassObject();
    $payout->setCurrency($expectedCurrency);
    $this->assertEquals($expectedCurrency, $payout->getCurrency());
  }

  public function testGetCurrencyException()
  {
    $expectedCurrency = 'ZZZ';

    $payout = $this->createClassObject();
    $this->expectException(BitPayException::class);
    $this->expectExceptionMessage('currency code must be a type of Model.Currency');
    $payout->setCurrency($expectedCurrency);
  }

  public function testGetEffectiveDate()
  {
    $expectedEffectiveDate = '2021-05-27T09:00:00.000Z';

    $payout = $this->createClassObject();
    $payout->setEffectiveDate($expectedEffectiveDate);
    $this->assertEquals($expectedEffectiveDate, $payout->getEffectiveDate());
  }

    /**
     * @throws BitPayException
     */
    public function testGetLedgerCurrency()
  {
    $expectedLedgerCurrency = 'GBP';

    $payout = $this->createClassObject();
    $payout->setLedgerCurrency($expectedLedgerCurrency);
    $this->assertEquals($expectedLedgerCurrency, $payout->getLedgerCurrency());
  }

  public function testGetLedgerCurrencyException()
  {
    $expectedLedgerCurrency = 'ZZZ';

    $payout = $this->createClassObject();
    $this->expectException(BitPayException::class);
    $this->expectExceptionMessage('currency code must be a type of Model.Currency');
    $payout->setLedgerCurrency($expectedLedgerCurrency);
  }

  public function testGetReference()
  {
    $expectedReference = 'payout_20210527';

    $payout = $this->createClassObject();
    $payout->setReference($expectedReference);
    $this->assertEquals($expectedReference, $payout->getReference());
  }

  public function testGetNotificationUrl()
  {
    $expectedNotificationUrl = 'https://example.com';

    $bill = $this->createClassObject();
    $bill->setNotificationUrl($expectedNotificationUrl);
    $this->assertEquals($expectedNotificationUrl, $bill->getNotificationUrl());
  }

  public function testGetNotificationEmail()
  {
    $expectedNotificationEmail = 'test@test.com';

    $payout = $this->createClassObject();
    $payout->setNotificationEmail($expectedNotificationEmail);
    $this->assertEquals($expectedNotificationEmail, $payout->getNotificationEmail());
  }

  public function testGetEmail()
  {
    $expectedEmail = 'test@test.com';

    $payout = $this->createClassObject();
    $payout->setEmail($expectedEmail);
    $this->assertEquals($expectedEmail, $payout->getEmail());
  }

  public function testGetRecipientId()
  {
    $expectedRecipientId = 'LDxRZCGq174SF8AnQpdBPB';

    $payout = $this->createClassObject();
    $payout->setRecipientId($expectedRecipientId);
    $this->assertEquals($expectedRecipientId, $payout->getRecipientId());
  }

  public function testGetShopperId()
  {
    $expectedShopperId = '7qohDf2zZnQK5Qanj8oyC2';

    $payout = $this->createClassObject();
    $payout->setShopperId($expectedShopperId);
    $this->assertEquals($expectedShopperId, $payout->getShopperId());
  }

  public function testGetLabel()
  {
    $expectedLabel = 'My label';

    $payout = $this->createClassObject();
    $payout->setLabel($expectedLabel);
    $this->assertEquals($expectedLabel, $payout->getLabel());
  }

  public function testGetMessage()
  {
    $expectedMessage = 'My message';

    $payout = $this->createClassObject();
    $payout->setMessage($expectedMessage);
    $this->assertEquals($expectedMessage, $payout->getMessage());
  }

  public function testGetId()
  {
    $expectedId = 'abcd123';

    $payout = $this->createClassObject();
    $payout->setId($expectedId);
    $this->assertEquals($expectedId, $payout->getId());
  }

  public function testGetStatus()
  {
    $expectedStatus = 'success';

    $payout = $this->createClassObject();
    $payout->setStatus($expectedStatus);
    $this->assertEquals($expectedStatus, $payout->getStatus());
  }

  public function testGetRequestDate()
  {
    $expectedRequestDate = '2021-05-27T10:47:37.834Z';

    $payout = $this->createClassObject();
    $payout->setRequestDate($expectedRequestDate);
    $this->assertEquals($expectedRequestDate, $payout->getRequestDate());
  }

  public function testGetExchangeRates()
  {
    $expectedExchangeRates = [
      'BTC' => [
        'USD' => 39390.47,
        'GBP' => 27883.962246420004
      ]
    ];

    $payout = $this->createClassObject();
    $payout->setExchangeRates($expectedExchangeRates);
    $this->assertEquals($expectedExchangeRates, $payout->getExchangeRates());
  }

  public function testGetTransactions()
  {
    $expectedTransactions = $this->getMockBuilder(PayoutTransaction::class)
        ->disableOriginalConstructor()
        ->getMock();

    $expectedTransactions->method('getTxid')->willReturn('db53d7e2bf3385a31257ce09396202d9c2823370a5ca186db315c45e24594057');
    $expectedTransactions->method('getAmount')->willReturn(0.000254);
    $expectedTransactions->method('getDate')->willReturn('2021-05-27T11:04:23.155Z');

    $payout = $this->createClassObject();
    $payout->setTransactions([$expectedTransactions]);

    $this->assertEquals([$expectedTransactions], $payout->getTransactions());
  }

  public function testFormatAmount()
  {
    $amount = 12.3456789;
    $expectedFormattedAmount = 12.35;

    $payout = $this->createClassObject();
    $payout->setAmount($amount);
    $payout->formatAmount(2);
    $this->assertEquals($expectedFormattedAmount, $payout->getAmount());
  }

    /**
     * @throws BitPayException
     */
    public function testToArray()
  {
    $payout = $this->createClassObject();
    $this->objectSetters($payout);
    $payoutArray = $payout->toArray();

    $payoutTransaction = new PayoutTransaction();
    $payoutTransaction->setTxid('db53d7e2bf3385a31257ce09396202d9c2823370a5ca186db315c45e24594057');
    $payoutTransaction->setAmount(0.000254);
    $payoutTransaction->setDate('2021-05-27T11:04:23.155Z');

    $this->assertNotNull($payoutArray);
    $this->assertIsArray($payoutArray);

    $this->assertArrayHasKey('token', $payoutArray);
    $this->assertArrayHasKey('amount', $payoutArray);
    $this->assertArrayHasKey('currency', $payoutArray);
    $this->assertArrayHasKey('effectiveDate', $payoutArray);
    $this->assertArrayHasKey('ledgerCurrency', $payoutArray);
    $this->assertArrayHasKey('reference', $payoutArray);
    $this->assertArrayHasKey('notificationURL', $payoutArray);
    $this->assertArrayHasKey('notificationEmail', $payoutArray);
    $this->assertArrayHasKey('email', $payoutArray);
    $this->assertArrayHasKey('recipientId', $payoutArray);
    $this->assertArrayHasKey('shopperId', $payoutArray);
    $this->assertArrayHasKey('label', $payoutArray);
    $this->assertArrayHasKey('message', $payoutArray);
    $this->assertArrayHasKey('id', $payoutArray);
    $this->assertArrayHasKey('status', $payoutArray);
    $this->assertArrayHasKey('requestDate', $payoutArray);
    $this->assertArrayHasKey('exchangeRates', $payoutArray);
    $this->assertArrayHasKey('transactions', $payoutArray);

    $this->assertEquals('6RZSTPtnzEaroAe2X4YijenRiqteRDNvzbT8NjtcHjUVd9FUFwa7dsX8RFgRDDC5SL', $payoutArray['token']);
    $this->assertEquals(10.0, $payoutArray['amount']);
    $this->assertEquals(Currency::USD, $payoutArray['currency']);
    $this->assertEquals('2021-05-27T09:00:00.000Z', $payoutArray['effectiveDate']);
    $this->assertEquals(Currency::GBP, $payoutArray['ledgerCurrency']);
    $this->assertEquals('payout_20210527', $payoutArray['reference']);
    $this->assertEquals('https://example.com', $payoutArray['notificationURL']);
    $this->assertEquals('test@test.com', $payoutArray['notificationEmail']);
    $this->assertEquals('test@test.com', $payoutArray['email']);
    $this->assertEquals('LDxRZCGq174SF8AnQpdBPB', $payoutArray['recipientId']);
    $this->assertEquals('7qohDf2zZnQK5Qanj8oyC2', $payoutArray['shopperId']);
    $this->assertEquals('My label', $payoutArray['label']);
    $this->assertEquals('My message', $payoutArray['message']);
    $this->assertEquals('JMwv8wQCXANoU2ZZQ9a9GH', $payoutArray['id']);
    $this->assertEquals('success', $payoutArray['status']);
    $this->assertEquals('2021-05-27T10:47:37.834Z', $payoutArray['requestDate']);
    $this->assertEquals([
      'BTC' => [
        'USD' => 39390.47,
        'GBP' => 27883.962246420004
      ]
    ], $payoutArray['exchangeRates']);

    $this->assertEquals('db53d7e2bf3385a31257ce09396202d9c2823370a5ca186db315c45e24594057', $payoutArray['transactions'][0]->getTxid());
    $this->assertEquals(0.000254, $payoutArray['transactions'][0]->getAmount());
    $this->assertEquals('2021-05-27T11:04:23.155Z', $payoutArray['transactions'][0]->getDate());
  }

    /**
     * @throws BitPayException
     */
    public function testToArrayEmptyKey()
  {
    $payout = $this->createClassObject();
    $this->objectSetters($payout);
    $payoutArray = $payout->toArray();

    $this->assertNotNull($payoutArray);
    $this->assertIsArray($payoutArray);

    $this->assertArrayNotHasKey('supportPhone', $payoutArray);
  }

  private function createClassObject(): Payout
  {
    return new Payout();
  }

    /**
     * @throws BitPayException
     */
    private function objectSetters(Payout $payout)
  {
    $payoutTransaction = new PayoutTransaction();
    $payoutTransaction->setTxid('db53d7e2bf3385a31257ce09396202d9c2823370a5ca186db315c45e24594057');
    $payoutTransaction->setAmount(0.000254);
    $payoutTransaction->setDate('2021-05-27T11:04:23.155Z');

    $transactions = [];
    $transactions[] = $payoutTransaction;
    
    $payout->setToken('6RZSTPtnzEaroAe2X4YijenRiqteRDNvzbT8NjtcHjUVd9FUFwa7dsX8RFgRDDC5SL');
    $payout->setAmount(10.0);
    $payout->setCurrency(Currency::USD);
    $payout->setEffectiveDate('2021-05-27T09:00:00.000Z');
      try {
          $payout->setLedgerCurrency(Currency::GBP);
      } catch (BitPayException) {
      }
      $payout->setReference('payout_20210527');
    $payout->setNotificationURL('https://example.com');
    $payout->setNotificationEmail('test@test.com');
    $payout->setEmail('test@test.com');
    $payout->setRecipientId('LDxRZCGq174SF8AnQpdBPB');
    $payout->setShopperId('7qohDf2zZnQK5Qanj8oyC2');
    $payout->setLabel('My label');
    $payout->setMessage('My message');
    $payout->setId('JMwv8wQCXANoU2ZZQ9a9GH');
    $payout->setStatus('success');
    $payout->setRequestDate('2021-05-27T10:47:37.834Z');
    $payout->setExchangeRates([
      'BTC' => [
        'USD' => 39390.47,
        'GBP' => 27883.962246420004
      ]
    ]);
    $payout->setTransactions($transactions);
  }
}