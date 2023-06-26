<?php

namespace BitPaySDK\Test\Model\Invoice;

use BitPaySDK\Model\Invoice\UniversalCodes;
use PHPUnit\Framework\TestCase;

class UniversalCodesTest extends TestCase
{
    public function testInstanceOf()
    {
        $universalCodes = $this->createClassObject();
        self::assertInstanceOf(UniversalCodes::class, $universalCodes);
    }

    public function testGetPaymentString()
    {
        $expectedPaymentString = 'Test payment string';

        $universalCodes = $this->createClassObject();
        $universalCodes->setPaymentString($expectedPaymentString);
        self::assertEquals($expectedPaymentString, $universalCodes->getPaymentString());
    }

    public function testGetVerificationLink()
    {
        $expectedVerificationLink = 'http://test.com';

        $universalCodes = $this->createClassObject();
        $universalCodes->setVerificationLink($expectedVerificationLink);
        self::assertEquals($expectedVerificationLink, $universalCodes->getVerificationLink());
    }

    public function testToArray()
    {
        $universalCodes = $this->createClassObject();
        $this->setSetters($universalCodes);
        $universalCodesArray = $universalCodes->toArray();

        self::assertNotNull($universalCodesArray);
        self::assertIsArray($universalCodesArray);

        self::assertArrayHasKey('paymentString', $universalCodesArray);
        self::assertArrayHasKey('verificationLink', $universalCodesArray);

        self::assertEquals('Test payment string', $universalCodesArray['paymentString']);
        self::assertEquals('http://test.com', $universalCodesArray['verificationLink']);
    }

    private function createClassObject(): UniversalCodes
    {
        return new UniversalCodes();
    }

    private function setSetters(UniversalCodes $universalCodes)
    {
        $universalCodes->setPaymentString('Test payment string');
        $universalCodes->setVerificationLink('http://test.com');
    }
}
