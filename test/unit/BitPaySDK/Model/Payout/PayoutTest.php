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
        self::assertInstanceOf(Payout::class, $payout);
    }

    public function testGetToken()
    {
        $expectedToken = '6RZSTPtnzEaroAe2X4YijenRiqteRDNvzbT8NjtcHjUVd9FUFwa7dsX8RFgRDDC5SL';

        $payout = $this->createClassObject();
        $payout->setToken($expectedToken);
        self::assertEquals($expectedToken, $payout->getToken());
    }

    public function testGetAmount()
    {
        $expectedAmount = 10.0;

        $payout = $this->createClassObject();
        $payout->setAmount($expectedAmount);
        self::assertEquals($expectedAmount, $payout->getAmount());
    }

    /**
     * @throws BitPayException
     */
    public function testGetCurrency()
    {
        $expectedCurrency = Currency::USD;

        $payout = $this->createClassObject();
        $payout->setCurrency($expectedCurrency);
        self::assertEquals($expectedCurrency, $payout->getCurrency());
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
        self::assertEquals($expectedEffectiveDate, $payout->getEffectiveDate());
    }

    /**
     * @throws BitPayException
     */
    public function testGetLedgerCurrency()
    {
        $expectedLedgerCurrency = 'GBP';

        $payout = $this->createClassObject();
        $payout->setLedgerCurrency($expectedLedgerCurrency);
        self::assertEquals($expectedLedgerCurrency, $payout->getLedgerCurrency());
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
        self::assertEquals($expectedReference, $payout->getReference());
    }

    public function testGetNotificationUrl()
    {
        $expectedNotificationUrl = 'https://example.com';

        $bill = $this->createClassObject();
        $bill->setNotificationUrl($expectedNotificationUrl);
        self::assertEquals($expectedNotificationUrl, $bill->getNotificationUrl());
    }

    public function testGetNotificationEmail()
    {
        $expectedNotificationEmail = 'test@test.com';

        $payout = $this->createClassObject();
        $payout->setNotificationEmail($expectedNotificationEmail);
        self::assertEquals($expectedNotificationEmail, $payout->getNotificationEmail());
    }

    public function testGetEmail()
    {
        $expectedEmail = 'test@test.com';

        $payout = $this->createClassObject();
        $payout->setEmail($expectedEmail);
        self::assertEquals($expectedEmail, $payout->getEmail());
    }

    public function testGetRecipientId()
    {
        $expectedRecipientId = 'LDxRZCGq174SF8AnQpdBPB';

        $payout = $this->createClassObject();
        $payout->setRecipientId($expectedRecipientId);
        self::assertEquals($expectedRecipientId, $payout->getRecipientId());
    }

    public function testGetShopperId()
    {
        $expectedShopperId = '7qohDf2zZnQK5Qanj8oyC2';

        $payout = $this->createClassObject();
        $payout->setShopperId($expectedShopperId);
        self::assertEquals($expectedShopperId, $payout->getShopperId());
    }

    public function testGetLabel()
    {
        $expectedLabel = 'My label';

        $payout = $this->createClassObject();
        $payout->setLabel($expectedLabel);
        self::assertEquals($expectedLabel, $payout->getLabel());
    }

    public function testGetMessage()
    {
        $expectedMessage = 'My message';

        $payout = $this->createClassObject();
        $payout->setMessage($expectedMessage);
        self::assertEquals($expectedMessage, $payout->getMessage());
    }

    public function testGetId()
    {
        $expectedId = 'abcd123';

        $payout = $this->createClassObject();
        $payout->setId($expectedId);
        self::assertEquals($expectedId, $payout->getId());
    }

    public function testGetStatus()
    {
        $expectedStatus = 'success';

        $payout = $this->createClassObject();
        $payout->setStatus($expectedStatus);
        self::assertEquals($expectedStatus, $payout->getStatus());
    }

    public function testGetRequestDate()
    {
        $expectedRequestDate = '2021-05-27T10:47:37.834Z';

        $payout = $this->createClassObject();
        $payout->setRequestDate($expectedRequestDate);
        self::assertEquals($expectedRequestDate, $payout->getRequestDate());
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
        self::assertEquals($expectedExchangeRates, $payout->getExchangeRates());
    }

    public function testGetTransactions()
    {
        $expectedTransaction = new PayoutTransaction();
        $expectedTransaction->setTxid('db53d7e2bf3385a31257ce09396202d9c2823370a5ca186db315c45e24594057');
        $expectedTransaction->setAmount(0.000254);
        $expectedTransaction->setDate('2021-05-27T11:04:23.155Z');

        $expectedItemizedDetails = $this->getMockBuilder(PayoutTransaction::class)
            ->disableOriginalConstructor()
            ->getMock();
        $expectedItemizedDetails->method('toArray')->willReturn([$expectedTransaction]);

        $payout = $this->createClassObject();
        $payout->setTransactions([$expectedTransaction]);
        self::assertIsArray($payout->getTransactions());
        self::assertNotNull($payout->getTransactions());
        self::assertInstanceOf(PayoutTransaction::class, $payout->getTransactions()[0]);
    }

    public function testFormatAmount()
    {
        $amount = 12.3456789;
        $expectedFormattedAmount = 12.35;

        $payout = $this->createClassObject();
        $payout->setAmount($amount);
        $payout->formatAmount(2);
        self::assertEquals($expectedFormattedAmount, $payout->getAmount());
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

        self::assertNotNull($payoutArray);
        self::assertIsArray($payoutArray);

        self::assertArrayHasKey('token', $payoutArray);
        self::assertArrayHasKey('amount', $payoutArray);
        self::assertArrayHasKey('currency', $payoutArray);
        self::assertArrayHasKey('effectiveDate', $payoutArray);
        self::assertArrayHasKey('ledgerCurrency', $payoutArray);
        self::assertArrayHasKey('reference', $payoutArray);
        self::assertArrayHasKey('notificationURL', $payoutArray);
        self::assertArrayHasKey('notificationEmail', $payoutArray);
        self::assertArrayHasKey('email', $payoutArray);
        self::assertArrayHasKey('recipientId', $payoutArray);
        self::assertArrayHasKey('shopperId', $payoutArray);
        self::assertArrayHasKey('label', $payoutArray);
        self::assertArrayHasKey('message', $payoutArray);
        self::assertArrayHasKey('id', $payoutArray);
        self::assertArrayHasKey('status', $payoutArray);
        self::assertArrayHasKey('requestDate', $payoutArray);
        self::assertArrayHasKey('exchangeRates', $payoutArray);
        self::assertArrayHasKey('transactions', $payoutArray);

        self::assertEquals(
            '6RZSTPtnzEaroAe2X4YijenRiqteRDNvzbT8NjtcHjUVd9FUFwa7dsX8RFgRDDC5SL',
            $payoutArray['token']
        );
        self::assertEquals(10.0, $payoutArray['amount']);
        self::assertEquals(Currency::USD, $payoutArray['currency']);
        self::assertEquals('2021-05-27T09:00:00.000Z', $payoutArray['effectiveDate']);
        self::assertEquals(Currency::GBP, $payoutArray['ledgerCurrency']);
        self::assertEquals('payout_20210527', $payoutArray['reference']);
        self::assertEquals('https://example.com', $payoutArray['notificationURL']);
        self::assertEquals('test@test.com', $payoutArray['notificationEmail']);
        self::assertEquals('test@test.com', $payoutArray['email']);
        self::assertEquals('LDxRZCGq174SF8AnQpdBPB', $payoutArray['recipientId']);
        self::assertEquals('7qohDf2zZnQK5Qanj8oyC2', $payoutArray['shopperId']);
        self::assertEquals('My label', $payoutArray['label']);
        self::assertEquals('My message', $payoutArray['message']);
        self::assertEquals('JMwv8wQCXANoU2ZZQ9a9GH', $payoutArray['id']);
        self::assertEquals('success', $payoutArray['status']);
        self::assertEquals('2021-05-27T10:47:37.834Z', $payoutArray['requestDate']);
        self::assertEquals([
            'BTC' => [
                'USD' => 39390.47,
                'GBP' => 27883.962246420004
            ]
        ], $payoutArray['exchangeRates']);
        self::assertInstanceOf(PayoutTransaction::class, $payoutArray['transactions'][0]);
    }

    /**
     * @throws BitPayException
     */
    public function testToArrayEmptyKey()
    {
        $payout = $this->createClassObject();
        $this->objectSetters($payout);
        $payoutArray = $payout->toArray();

        self::assertNotNull($payoutArray);
        self::assertIsArray($payoutArray);

        self::assertArrayNotHasKey('supportPhone', $payoutArray);
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