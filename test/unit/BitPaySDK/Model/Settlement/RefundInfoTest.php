<?php

namespace BitPaySDK\Test\Model\Settlement;

use BitPaySDK\Model\Settlement\RefundInfo;
use PHPUnit\Framework\TestCase;

class RefundInfoTest extends TestCase
{
    public function testInstanceOf()
    {
        $refundInfo = $this->createClassObject();
        $this->assertInstanceOf(RefundInfo::class, $refundInfo);
    }

    public function testGetSupportRequest()
    {
        $expectedSupportRequest = 'Test support request';

        $refundInfo = $this->createClassObject();
        $refundInfo->setSupportRequest($expectedSupportRequest);
        $this->assertEquals($expectedSupportRequest, $refundInfo->getSupportRequest());
    }

    public function testGetCurrency()
    {
        $expectedCurrency = 'BTC';

        $refundInfo = $this->createClassObject();
        $refundInfo->setCurrency($expectedCurrency);
        $this->assertEquals($expectedCurrency, $refundInfo->getCurrency());
    }

    public function testGetAmounts()
    {
        $expectedAmounts = [25];

        $refundInfo = $this->createClassObject();
        $refundInfo->setAmounts($expectedAmounts);
        $this->assertEquals($expectedAmounts, $refundInfo->getAmounts());
    }

    public function testGetReference()
    {
        $expectedReference = 'abcd123';

        $refundInfo = $this->createClassObject();
        $refundInfo->setReference($expectedReference);
        $this->assertEquals($expectedReference, $refundInfo->getReference());
    }

    public function testToArray()
    {
        $refundInfo = $this->createClassObject();
        $this->setSetters($refundInfo);
        $refundInfoArray = $refundInfo->toArray();

        $this->assertNotNull($refundInfoArray);
        $this->assertIsArray($refundInfoArray);

        $this->assertArrayHasKey('supportRequest', $refundInfoArray);
        $this->assertArrayHasKey('currency', $refundInfoArray);
        $this->assertArrayHasKey('amounts', $refundInfoArray);

        $this->assertEquals($refundInfoArray['supportRequest'], 'Test support request');
        $this->assertEquals($refundInfoArray['currency'], 'BTC');
        $this->assertEquals($refundInfoArray['amounts'], [25]);
    }

    private function createClassObject()
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