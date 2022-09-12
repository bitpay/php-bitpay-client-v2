<?php

namespace BitPaySDK\Test\Model\Invoice;

use BitPaySDK\Model\Invoice\RefundInfo;
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
        $expectedAmount = ['test amount'];

        $refundInfo = $this->createClassObject();
        $refundInfo->setAmounts($expectedAmount);
        $this->assertEquals($expectedAmount, $refundInfo->getAmounts());
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
        $this->assertArrayNotHasKey('amounts', $refundInfoArray);

        $this->assertEquals($refundInfoArray['supportRequest'], 'Test support request');
        $this->assertEquals($refundInfoArray['currency'], 'BTC');
    }

    private function createClassObject()
    {
        return new RefundInfo();
    }

    private function setSetters(RefundInfo $refundInfo)
    {
        $refundInfo->setSupportRequest('Test support request');
        $refundInfo->setCurrency('BTC');
        $refundInfo->setAmounts([]);
    }
}
