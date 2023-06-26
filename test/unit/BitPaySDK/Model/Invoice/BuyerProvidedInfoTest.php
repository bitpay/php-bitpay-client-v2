<?php

namespace BitPaySDK\Test\Model\Invoice;

use BitPaySDK\Model\Invoice\BuyerProvidedInfo;
use PHPUnit\Framework\TestCase;

class BuyerProvidedInfoTest extends TestCase
{
    public function testInstanceOf()
    {
        $buyerProvidedInfo = $this->createClassObject();
        self::assertInstanceOf(BuyerProvidedInfo::class, $buyerProvidedInfo);
    }

    public function testGetName()
    {
        $expectedName = 'Test User';

        $buyerProvidedInfo = $this->createClassObject();
        $buyerProvidedInfo->setName($expectedName);
        self::assertEquals($expectedName, $buyerProvidedInfo->getName());
    }

    /**
     * https://github.com/bitpay/php-bitpay-client-v2/issues/212
     *
     * @return void
     */
    public function testGetSelectedWalletAsNull()
    {
        $expectedSelectedWallet = null;

        $buyerProvidedInfo = $this->createClassObject();
        $buyerProvidedInfo->setSelectedWallet($expectedSelectedWallet);

        self::assertNull($buyerProvidedInfo->getSelectedWallet());
    }

    public function testGetPhoneNumber()
    {
        $expectedPhoneNumber = '1112223333';

        $buyerProvidedInfo = $this->createClassObject();
        $buyerProvidedInfo->setPhoneNumber($expectedPhoneNumber);
        self::assertEquals($expectedPhoneNumber, $buyerProvidedInfo->getPhoneNumber());
    }

    public function testGetSelectedWallet()
    {
        $expectedSelectedWallet = 'bitpay';

        $buyerProvidedInfo = $this->createClassObject();
        $buyerProvidedInfo->setSelectedWallet($expectedSelectedWallet);
        self::assertEquals($expectedSelectedWallet, $buyerProvidedInfo->getSelectedWallet());
    }

    public function testGetEmailAddress()
    {
        $expectedEmailAddress = 'example@bitpay.com';

        $buyerProvidedInfo = $this->createClassObject();
        $buyerProvidedInfo->setEmailAddress($expectedEmailAddress);
        self::assertEquals($expectedEmailAddress, $buyerProvidedInfo->getEmailAddress());
    }

    public function testGetSelectedTransactionCurrency()
    {
        $expectedSelectedTransactionCurrency = 'BTC';

        $buyerProvidedInfo = $this->createClassObject();
        $buyerProvidedInfo->setSelectedTransactionCurrency($expectedSelectedTransactionCurrency);
        self::assertEquals($expectedSelectedTransactionCurrency, $buyerProvidedInfo->getSelectedTransactionCurrency());
    }

    public function testGetSms()
    {
        $expectedSms = '4445556666';

        $buyerProvidedInfo = $this->createClassObject();
        $buyerProvidedInfo->setSms($expectedSms);
        self::assertEquals($expectedSms, $buyerProvidedInfo->getSms());
    }

    public function testGetSmsVerified()
    {
        $buyerProvidedInfo = $this->createClassObject();
        $buyerProvidedInfo->setSmsVerified(true);
        self::assertTrue($buyerProvidedInfo->getSmsVerified());
    }

    public function testToArray()
    {
        $buyerProvidedInfo = $this->createClassObject();
        $this->objectSetters($buyerProvidedInfo);

        $buyerProvidedInfoArray = $buyerProvidedInfo->toArray();

        self::assertNotNull($buyerProvidedInfoArray);
        self::assertIsArray($buyerProvidedInfoArray);

        self::assertArrayHasKey('name', $buyerProvidedInfoArray);
        self::assertArrayHasKey('phoneNumber', $buyerProvidedInfoArray);
        self::assertArrayHasKey('selectedWallet', $buyerProvidedInfoArray);
        self::assertArrayHasKey('emailAddress', $buyerProvidedInfoArray);
        self::assertArrayHasKey('selectedTransactionCurrency', $buyerProvidedInfoArray);
        self::assertArrayHasKey('sms', $buyerProvidedInfoArray);
        self::assertArrayHasKey('smsVerified', $buyerProvidedInfoArray);

        self::assertEquals('Test User', $buyerProvidedInfoArray['name']);
        self::assertEquals('1112223333', $buyerProvidedInfoArray['phoneNumber']);
        self::assertEquals('bitpay', $buyerProvidedInfoArray['selectedWallet']);
        self::assertEquals('example@bitpay.com', $buyerProvidedInfoArray['emailAddress']);
        self::assertEquals('BTC', $buyerProvidedInfoArray['selectedTransactionCurrency']);
        self::assertEquals('4445556666', $buyerProvidedInfoArray['sms']);
        self::assertEquals(true, $buyerProvidedInfoArray['smsVerified']);
    }

    public function testToArrayEmptyKey()
    {
        $buyerProvidedInfo = $this->createClassObject();

        $buyerProvidedInfoArray = $buyerProvidedInfo->toArray();

        self::assertNotNull($buyerProvidedInfoArray);
        self::assertIsArray($buyerProvidedInfoArray);

        self::assertArrayNotHasKey('name', $buyerProvidedInfoArray);
    }

    private function createClassObject(): BuyerProvidedInfo
    {
        return new BuyerProvidedInfo();
    }

    private function objectSetters(BuyerProvidedInfo $buyerProvidedInfo)
    {
        $buyerProvidedInfo->setName('Test User');
        $buyerProvidedInfo->setPhoneNumber('1112223333');
        $buyerProvidedInfo->setSelectedWallet('bitpay');
        $buyerProvidedInfo->setEmailAddress('example@bitpay.com');
        $buyerProvidedInfo->setSelectedTransactionCurrency('BTC');
        $buyerProvidedInfo->setSms('4445556666');
        $buyerProvidedInfo->setSmsVerified(true);
    }
}