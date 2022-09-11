<?php

namespace BitPaySDK\Test\Model\Payout;

use BitPaySDK\Exceptions\BitPayException;
use BitPaySDK\Model\Currency;
use BitPaySDK\Model\Payout\PayoutBatch;
use BitPaySDK\Model\Payout\PayoutInstruction;
use BitPaySDK\Model\Payout\RecipientReferenceMethod;
use PHPUnit\Framework\TestCase;

class PayoutBatchTest extends TestCase
{
  public function testInstanceOf()
  {
    $payout = $this->createClassObject();
    $this->assertInstanceOf(PayoutBatch::class, $payout);
  }

  public function testGetToken()
  {
    $expectedToken = '6RZSTPtnzEaroAe2X4YijenRiqteRDNvzbT8NjtcHjUVd9FUFwa7dsX8RFgRDDC5SL';

    $payoutBatch = $this->createClassObject();
    $payoutBatch->setToken($expectedToken);
    $this->assertEquals($expectedToken, $payoutBatch->getToken());
  }

  public function testGetAmount()
  {
    $expectedAmount = 10.0;

    $payoutBatch = $this->createClassObject();
    $payoutBatch->setAmount($expectedAmount);
    $this->assertEquals($expectedAmount, $payoutBatch->getAmount());
  }

  public function testFormatAmount()
  {
    $amount = 12.3456789;
    $expectedFormattedAmount = 12.35;

    $payoutBatch = $this->createClassObject();
    $payoutBatch->setAmount($amount);
    $payoutBatch->formatAmount(2);
    $this->assertEquals($expectedFormattedAmount, $payoutBatch->getAmount());
  }

  public function testGetCurrency()
  {
    $expectedCurrency = Currency::USD;

    $payoutBatch = $this->createClassObject();
    $payoutBatch->setCurrency($expectedCurrency);
    $this->assertEquals($expectedCurrency, $payoutBatch->getCurrency());
  }

  public function testGetCurrencyException()
  {
    $this->expectException(BitPayException::class);

    $payoutBatch = $this->createClassObject();
    $payoutBatch->setCurrency('ZZZ');
  }

  public function testGetEffectiveDate()
  {
    $expectedEffectiveDate = '2021-05-27T09:00:00.000Z';

    $payoutBatch = $this->createClassObject();
    $payoutBatch->setEffectiveDate($expectedEffectiveDate);
    $this->assertEquals($expectedEffectiveDate, $payoutBatch->getEffectiveDate());
  }

  public function testGetInstructionsObject()
  {
    $expectedInstructions = [
      new PayoutInstruction(10.0, RecipientReferenceMethod::EMAIL, 'john@doe.com')
    ];
    
    $payoutBatch = new PayoutBatch(Currency::USD, $expectedInstructions, Currency::BTC);
    $payoutBatch->setInstructions($expectedInstructions);
    $this->assertEquals($expectedInstructions[0]->toArray(), $payoutBatch->getInstructions()[0]);
  }

  public function testGetInstructionsArray()
  {

    $expectedInstructions = [
      [
        'amount' => 10.0,
        'email' => 'john@doe.com'
      ]
    ];
    
    $payoutBatch = new PayoutBatch(Currency::USD, [], Currency::BTC);
    $payoutBatch->setInstructions($expectedInstructions);
    $this->assertEquals($expectedInstructions, $payoutBatch->getInstructions());
  }

  public function testGetLedgerCurrency() {
    $expectedLedgerCurrency = Currency::BTC;

    $payoutBatch = $this->createClassObject();
    $payoutBatch->setLedgerCurrency($expectedLedgerCurrency);
    $this->assertEquals($expectedLedgerCurrency, $payoutBatch->getLedgerCurrency());
  }

  public function testGetLedgerCurrencyException() {
    $this->expectException(BitPayException::class);
    
    $payoutBatch = $this->createClassObject();
    $payoutBatch->setLedgerCurrency('ZZZ');
  }

  public function testGetReference()
  {
    $expectedReference = 'payout_20210527';

    $payoutBatch = $this->createClassObject();
    $payoutBatch->setReference($expectedReference);
    $this->assertEquals($expectedReference, $payoutBatch->getReference());
  }

  public function testGetNotificationUrl()
  {
    $expectedNotificationUrl = 'http://example.com';

    $payoutBatch = $this->createClassObject();
    $payoutBatch->setNotificationUrl($expectedNotificationUrl);
    $this->assertEquals($expectedNotificationUrl, $payoutBatch->getNotificationUrl());
  }

  public function testGetNotificationEmail()
  {
    $expectedNotificationEmail = 'test@test.com';

    $payoutBatch = $this->createClassObject();
    $payoutBatch->setNotificationEmail($expectedNotificationEmail);
    $this->assertEquals($expectedNotificationEmail, $payoutBatch->getNotificationEmail());
  }

  public function testGetEmail()
  {
    $expectedEmail = 'test@test.com';

    $payoutBatch = $this->createClassObject();
    $payoutBatch->setEmail($expectedEmail);
    $this->assertEquals($expectedEmail, $payoutBatch->getEmail());
  }

  public function testGetRecipientId()
  {
    $expectedRecipientId = 'LDxRZCGq174SF8AnQpdBPB';

    $payoutBatch = $this->createClassObject();
    $payoutBatch->setRecipientId($expectedRecipientId);
    $this->assertEquals($expectedRecipientId, $payoutBatch->getRecipientId());
  }

  public function testGetShopperId()
  {
    $expectedShopperId = '7qohDf2zZnQK5Qanj8oyC2';

    $payoutBatch = $this->createClassObject();
    $payoutBatch->setShopperId($expectedShopperId);
    $this->assertEquals($expectedShopperId, $payoutBatch->getShopperId());
  }

  public function testGetLabel()
  {
    $expectedLabel = 'My label';

    $payoutBatch = $this->createClassObject();
    $payoutBatch->setLabel($expectedLabel);
    $this->assertEquals($expectedLabel, $payoutBatch->getLabel());
  }

  public function testGetMessage()
  {
    $expectedMessage = 'My message';

    $payoutBatch = $this->createClassObject();
    $payoutBatch->setMessage($expectedMessage);
    $this->assertEquals($expectedMessage, $payoutBatch->getMessage());
  }

  public function testGetId()
  {
    $expectedId = 'abcd123';

    $payoutBatch = $this->createClassObject();
    $payoutBatch->setId($expectedId);
    $this->assertEquals($expectedId, $payoutBatch->getId());
  }

  public function testGetAccount()
  {
      $expectedAccount = 'Test account';

      $payoutBatch = $this->createClassObject();
      $payoutBatch->setAccount($expectedAccount);
      $this->assertEquals($expectedAccount, $payoutBatch->getAccount());
  }

  public function testGetStatus()
  {
    $expectedStatus = 'success';

    $payoutBatch = $this->createClassObject();
    $payoutBatch->setStatus($expectedStatus);
    $this->assertEquals($expectedStatus, $payoutBatch->getStatus());
  }

  public function testGetPercentFee()
  {
    $expectedPercentFee = 1.0;

    $payoutBatch = $this->createClassObject();
    $payoutBatch->setPercentFee($expectedPercentFee);
    $this->assertEquals($expectedPercentFee, $payoutBatch->getPercentFee());
  }

  public function testGetFee()
  {
    $expectedFee = 1.0;

    $payoutBatch = $this->createClassObject();
    $payoutBatch->setFee($expectedFee);
    $this->assertEquals($expectedFee, $payoutBatch->getFee());
  }

  public function testDepositTotal()
  {
    $expectedDepositTotal = 1.0;

    $payoutBatch = $this->createClassObject();
    $payoutBatch->setDepositTotal($expectedDepositTotal);
    $this->assertEquals($expectedDepositTotal, $payoutBatch->getDepositTotal());
  }

  public function testGetBtc()
  {
      $expectedBtc = 1;

      $payoutBatch = $this->createClassObject();
      $payoutBatch->setBtc($expectedBtc);
      $this->assertEquals($expectedBtc, $payoutBatch->getBtc());
  }

  public function testGetRate()
  {
    $expectedRate = 1.0;

    $payoutBatch = $this->createClassObject();
    $payoutBatch->setRate($expectedRate);
    $this->assertEquals($expectedRate, $payoutBatch->getRate());
  }

  public function testGetRequestDate()
  {
    $expectedRequestDate = '2021-05-27T10:47:37.834Z';

    $payoutBatch = $this->createClassObject();
    $payoutBatch->setRequestDate($expectedRequestDate);
    $this->assertEquals($expectedRequestDate, $payoutBatch->getRequestDate());
  }

  public function testGetDateExecuted()
  {
    $expectedDateExecuted = '2022-01-01T10:47:37.834Z';

    $payoutBatch = $this->createClassObject();
    $payoutBatch->setDateExecuted($expectedDateExecuted);
    $this->assertEquals($expectedDateExecuted, $payoutBatch->getDateExecuted());
  }

  public function testGetExchangeRates()
  {
    $expectedExchangeRates = [
      'BTC' => [
        'USD' => 39390.47,
        'GBP' => 27883.962246420004
      ]
    ];

    $payoutBatch = $this->createClassObject();
    $payoutBatch->setExchangeRates($expectedExchangeRates);
    $this->assertEquals($expectedExchangeRates, $payoutBatch->getExchangeRates());
  }

  public function testToArray()
  {
    $payoutBatch = $this->createClassObject();
    $this->objectSetters($payoutBatch);
    $payoutBatchArray = $payoutBatch->toArray();

    $this->assertNotNull($payoutBatchArray);
    $this->assertIsArray($payoutBatchArray);

    $this->assertArrayHasKey('currency', $payoutBatchArray);
    $this->assertArrayHasKey('instructions', $payoutBatchArray);
    $this->assertArrayHasKey('ledgerCurrency', $payoutBatchArray);
    $this->assertArrayHasKey('token', $payoutBatchArray);
    $this->assertArrayHasKey('amount', $payoutBatchArray);
    $this->assertArrayHasKey('effectiveDate', $payoutBatchArray);
    $this->assertArrayHasKey('reference', $payoutBatchArray);
    $this->assertArrayHasKey('notificationURL', $payoutBatchArray);
    $this->assertArrayHasKey('notificationEmail', $payoutBatchArray);
    $this->assertArrayHasKey('email', $payoutBatchArray);
    $this->assertArrayHasKey('recipientId', $payoutBatchArray);
    $this->assertArrayHasKey('shopperId', $payoutBatchArray);
    $this->assertArrayHasKey('label', $payoutBatchArray);
    $this->assertArrayHasKey('message', $payoutBatchArray);
    $this->assertArrayHasKey('id', $payoutBatchArray);
    $this->assertArrayHasKey('account', $payoutBatchArray);
    $this->assertArrayHasKey('supportPhone', $payoutBatchArray);
    $this->assertArrayHasKey('status', $payoutBatchArray);
    $this->assertArrayHasKey('percentFee', $payoutBatchArray);
    $this->assertArrayHasKey('fee', $payoutBatchArray);
    $this->assertArrayHasKey('depositTotal', $payoutBatchArray);
    $this->assertArrayHasKey('btc', $payoutBatchArray);
    $this->assertArrayHasKey('rate', $payoutBatchArray);
    $this->assertArrayHasKey('requestDate', $payoutBatchArray);
    $this->assertArrayHasKey('dateExecuted', $payoutBatchArray);
    $this->assertArrayHasKey('exchangeRates', $payoutBatchArray);

    $this->assertEquals($payoutBatchArray['currency'], Currency::USD);
    $this->assertEquals($payoutBatchArray['instructions'][0]['amount'], 10.0);
    $this->assertEquals($payoutBatchArray['instructions'][0]['email'], 'john@doe.com');
    $this->assertEquals($payoutBatchArray['ledgerCurrency'], Currency::BTC);
    $this->assertEquals($payoutBatchArray['token'], '6RZSTPtnzEaroAe2X4YijenRiqteRDNvzbT8NjtcHjUVd9FUFwa7dsX8RFgRDDC5SL');
    $this->assertEquals($payoutBatchArray['amount'], 10.0);
    $this->assertEquals($payoutBatchArray['effectiveDate'], '2021-05-27T09:00:00.000Z');
    $this->assertEquals($payoutBatchArray['reference'], 'payout_20210527');
    $this->assertEquals($payoutBatchArray['notificationURL'], 'http://example.com');
    $this->assertEquals($payoutBatchArray['notificationEmail'], 'test@test.com');
    $this->assertEquals($payoutBatchArray['email'], 'test@test.com');
    $this->assertEquals($payoutBatchArray['recipientId'], 'LDxRZCGq174SF8AnQpdBPB');
    $this->assertEquals($payoutBatchArray['shopperId'], '7qohDf2zZnQK5Qanj8oyC2');
    $this->assertEquals($payoutBatchArray['label'], 'My label');
    $this->assertEquals($payoutBatchArray['message'], 'My message');
    $this->assertEquals($payoutBatchArray['id'], 'abcd123');
    $this->assertEquals($payoutBatchArray['account'], 'Test account');
    $this->assertEquals($payoutBatchArray['supportPhone'], '2155551212');
    $this->assertEquals($payoutBatchArray['status'], 'success');
    $this->assertEquals($payoutBatchArray['percentFee'], 1.0);
    $this->assertEquals($payoutBatchArray['fee'], 1.0);
    $this->assertEquals($payoutBatchArray['depositTotal'], 1.0);
    $this->assertEquals($payoutBatchArray['btc'], 1);
    $this->assertEquals($payoutBatchArray['rate'], 1);
    $this->assertEquals($payoutBatchArray['requestDate'], '2021-05-27T10:47:37.834Z');
    $this->assertEquals($payoutBatchArray['dateExecuted'], '2022-01-01T10:47:37.834Z');
    $this->assertEquals($payoutBatchArray['exchangeRates']['BTC']['USD'], 39390.47);
    $this->assertEquals($payoutBatchArray['exchangeRates']['BTC']['GBP'], 27883.962246420004);
  }

  public function testToArrayEmptyKey()
  {
    $instructions = [
      new PayoutInstruction(10.0, RecipientReferenceMethod::EMAIL, 'john@doe.com')
    ];

    $payoutBatch = new PayoutBatch(Currency::USD, $instructions, Currency::BTC);
    $payoutBatchArray = $payoutBatch->toArray();

    $this->assertNotNull($payoutBatchArray);
    $this->assertIsArray($payoutBatchArray);

    $this->assertArrayNotHasKey('token', $payoutBatchArray);
  }

  private function createClassObject()
  {
    return new PayoutBatch();
  }

  private function objectSetters(PayoutBatch $payoutBatch)
  {
    $instructions = [
      new PayoutInstruction(10.0, RecipientReferenceMethod::EMAIL, 'john@doe.com')
    ];

    $payoutBatch->setCurrency(Currency::USD);
    $payoutBatch->setInstructions($instructions);
    $payoutBatch->setLedgerCurrency(Currency::BTC);
    $payoutBatch->setToken('6RZSTPtnzEaroAe2X4YijenRiqteRDNvzbT8NjtcHjUVd9FUFwa7dsX8RFgRDDC5SL');
    $payoutBatch->setAmount(10.0);
    $payoutBatch->setEffectiveDate('2021-05-27T09:00:00.000Z');
    $payoutBatch->setReference('payout_20210527');
    $payoutBatch->setNotificationURL('http://example.com');
    $payoutBatch->setNotificationEmail('test@test.com');
    $payoutBatch->setEmail('test@test.com');
    $payoutBatch->setRecipientId('LDxRZCGq174SF8AnQpdBPB');
    $payoutBatch->setShopperId('7qohDf2zZnQK5Qanj8oyC2');
    $payoutBatch->setLabel('My label');
    $payoutBatch->setMessage('My message');
    $payoutBatch->setId('abcd123');
    $payoutBatch->setAccount('Test account');
    $payoutBatch->setSupportPhone('2155551212');
    $payoutBatch->setStatus('success');
    $payoutBatch->setPercentFee(1.0);
    $payoutBatch->setFee(1.0);
    $payoutBatch->setDepositTotal(1.0);
    $payoutBatch->setBtc(1);
    $payoutBatch->setRate(1.0);
    $payoutBatch->setRequestDate('2021-05-27T10:47:37.834Z');
    $payoutBatch->setDateExecuted('2022-01-01T10:47:37.834Z');
    $payoutBatch->setExchangeRates([
      'BTC' => [
        'USD' => 39390.47,
        'GBP' => 27883.962246420004
      ]
    ]);
  }
}