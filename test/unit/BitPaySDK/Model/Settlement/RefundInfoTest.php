<?php

namespace BitPaySDK\Test\Model\Settlement;

use BitPaySDK\Model\Settlement\RefundInfo;
use PHPUnit\Framework\TestCase;

class RefundInfoTest extends TestCase
{
    public function testInstanceOf()
    {
        $refundInfo = $this->createClassObject();
        self::assertInstanceOf(RefundInfo::class, $refundInfo);
    }

    public function testGetSupportRequest()
    {
        $expectedSupportRequest = 'Test support request';

        $refundInfo = $this->createClassObject();
        $refundInfo->setSupportRequest($expectedSupportRequest);
        self::assertEquals($expectedSupportRequest, $refundInfo->getSupportRequest());
    }

    public function testGetCurrency()
    {
        $expectedCurrency = 'BTC';

        $refundInfo = $this->createClassObject();
        $refundInfo->setCurrency($expectedCurrency);
        self::assertEquals($expectedCurrency, $refundInfo->getCurrency());
    }

    public function testGetAmounts()
    {
        $expectedAmounts = [25];

        $refundInfo = $this->createClassObject();
        $refundInfo->setAmounts($expectedAmounts);
        self::assertEquals($expectedAmounts, $refundInfo->getAmounts());
    }

    public function testToArray()
    {
        $refundInfo = $this->createClassObject();
        $this->setSetters($refundInfo);
        $refundInfoArray = $refundInfo->toArray();

        self::assertNotNull($refundInfoArray);
        self::assertIsArray($refundInfoArray);

        self::assertArrayHasKey('supportRequest', $refundInfoArray);
        self::assertArrayHasKey('currency', $refundInfoArray);
        self::assertArrayHasKey('amounts', $refundInfoArray);

        self::assertEquals('Test support request', $refundInfoArray['supportRequest']);
        self::assertEquals('BTC', $refundInfoArray['currency']);
        self::assertEquals([25], $refundInfoArray['amounts']);
    }

    private function createClassObject(): RefundInfo
    {
        return new RefundInfo();
    }

    private function setSetters(RefundInfo $refundInfo)
    {
        $refundInfo->setSupportRequest('Test support request');
        $refundInfo->setCurrency('BTC');
        $refundInfo->setAmounts([25]);
    }
}