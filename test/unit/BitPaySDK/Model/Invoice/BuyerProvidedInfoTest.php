<?php

namespace BitPaySDK\Test\Model\Invoice;

use BitPaySDK\Model\Invoice\BuyerProvidedInfo;
use PHPUnit\Framework\TestCase;

class BuyerProvidedInfoTest extends TestCase
{
    public function testInstanceOf()
    {
        $buyerProvidedInfo = $this->createClassObject();
        $this->assertInstanceOf(BuyerProvidedInfo::class, $buyerProvidedInfo);
    }

    public function testGetName()
    {
        $expectedName = 'Test User';

        $buyerProvidedInfo = $this->createClassObject();
        $buyerProvidedInfo->setName($expectedName);
        $this->assertEquals($expectedName, $buyerProvidedInfo->getName());
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

        $this->assertNull($buyerProvidedInfo->getSelectedWallet());
    }

    public function testGetPhoneNumber()
    {
        $expectedPhoneNumber = '1112223333';

        $buyerProvidedInfo = $this->createClassObject();
        $buyerProvidedInfo->setPhoneNumber($expectedPhoneNumber);
        $this->assertEquals($expectedPhoneNumber, $buyerProvidedInfo->getPhoneNumber());
    }

    public function testGetSelectedWallet()
    {
        $expectedSelectedWallet = 'bitpay';

        $buyerProvidedInfo = $this->createClassObject();
        $buyerProvidedInfo->setSelectedWallet($expectedSelectedWallet);
        $this->assertEquals($expectedSelectedWallet, $buyerProvidedInfo->getSelectedWallet());
    }

    public function testGetEmailAddress()
    {
        $expectedEmailAddress = 'example@bitpay.com';

        $buyerProvidedInfo = $this->createClassObject();
        $buyerProvidedInfo->setEmailAddress($expectedEmailAddress);
        $this->assertEquals($expectedEmailAddress, $buyerProvidedInfo->getEmailAddress());
    }

    public function testGetSelectedTransactionCurrency()
    {
        $expectedSelectedTransactionCurrency = 'BTC';

        $buyerProvidedInfo = $this->createClassObject();
        $buyerProvidedInfo->setSelectedTransactionCurrency($expectedSelectedTransactionCurrency);
        $this->assertEquals($expectedSelectedTransactionCurrency, $buyerProvidedInfo->getSelectedTransactionCurrency());
    }

    public function testGetSms()
    {
        $expectedSms = '4445556666';

        $buyerProvidedInfo = $this->createClassObject();
        $buyerProvidedInfo->setSms($expectedSms);
        $this->assertEquals($expectedSms, $buyerProvidedInfo->getSms());
    }

    public function testGetSmsVerified()
    {
        $buyerProvidedInfo = $this->createClassObject();
        $buyerProvidedInfo->setSmsVerified(true);
        $this->assertTrue($buyerProvidedInfo->getSmsVerified());
    }

    public function testToArray()
    {
        $buyerProvidedInfo = $this->createClassObject();
        $this->objectSetters($buyerProvidedInfo);

        $buyerProvidedInfoArray = $buyerProvidedInfo->toArray();

        $this->assertNotNull($buyerProvidedInfoArray);
        $this->assertIsArray($buyerProvidedInfoArray);

        $this->assertArrayHasKey('name', $buyerProvidedInfoArray);
        $this->assertArrayHasKey('phoneNumber', $buyerProvidedInfoArray);
        $this->assertArrayHasKey('selectedWallet', $buyerProvidedInfoArray);
        $this->assertArrayHasKey('emailAddress', $buyerProvidedInfoArray);
        $this->assertArrayHasKey('selectedTransactionCurrency', $buyerProvidedInfoArray);
        $this->assertArrayHasKey('sms', $buyerProvidedInfoArray);
        $this->assertArrayHasKey('smsVerified', $buyerProvidedInfoArray);

        $this->assertEquals('Test User', $buyerProvidedInfoArray['name']);
        $this->assertEquals('1112223333', $buyerProvidedInfoArray['phoneNumber']);
        $this->assertEquals('bitpay', $buyerProvidedInfoArray['selectedWallet']);
        $this->assertEquals('example@bitpay.com', $buyerProvidedInfoArray['emailAddress']);
        $this->assertEquals('BTC', $buyerProvidedInfoArray['selectedTransactionCurrency']);
        $this->assertEquals('4445556666', $buyerProvidedInfoArray['sms']);
        $this->assertEquals(true, $buyerProvidedInfoArray['smsVerified']);
    }

    public function testToArrayEmptyKey()
    {
        $buyerProvidedInfo = $this->createClassObject();

        $buyerProvidedInfoArray = $buyerProvidedInfo->toArray();

        $this->assertNotNull($buyerProvidedInfoArray);
        $this->assertIsArray($buyerProvidedInfoArray);

        $this->assertArrayNotHasKey('name', $buyerProvidedInfoArray);
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