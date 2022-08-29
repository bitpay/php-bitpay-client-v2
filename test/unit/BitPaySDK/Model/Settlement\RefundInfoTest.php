<?php

namespace BitPaySDK\Test;

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
    $expectedSupportRequest = 'SYyrnbRCJ78V1DknHakKPo';

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
    $expectedAmounts = [
      "USD" => 1010.1,
      "BTC" => 0.145439
    ];

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
    $this->objectSetters($refundInfo);

    $refundInfoArray = $refundInfo->toArray();

    $this->assertNotNull($refundInfoArray);
    $this->assertIsArray($refundInfoArray);

    $this->assertArrayHasKey('supportRequest', $refundInfoArray);
    $this->assertArrayHasKey('currency', $refundInfoArray);
    $this->assertArrayHasKey('amounts', $refundInfoArray);
    $this->assertArrayHasKey('reference', $refundInfoArray);

    $this->assertEquals($refundInfoArray['supportRequest'], 'SYyrnbRCJ78V1DknHakKPo');
    $this->assertEquals($refundInfoArray['currency'], 'BTC');
    $this->assertEquals($refundInfoArray['amounts'], [
      "USD" => 1010.1,
      "BTC" => 0.145439
    ]);
    $this->assertEquals($refundInfoArray['reference'], 'abcd123');
  }

  private function createClassObject()
  {
    return new RefundInfo();
  }

  private function objectSetters(RefundInfo $refundInfo): void
  {
    $refundInfo->setSupportRequest('SYyrnbRCJ78V1DknHakKPo');
    $refundInfo->setCurrency('BTC');
    $refundInfo->setAmounts([
      "USD" => 1010.1,
      "BTC" => 0.145439
    ]);
    $refundInfo->setReference('abcd123');
  }
}