<?php

namespace BitPaySDK\Test;

use BitPaySDK\Model\Rate\Rate;
use PHPUnit\Framework\TestCase;

class RateTest extends TestCase
{
  public function testToArray()
  {
    $rate = new Rate;
    $rate->setName('Bitcoin');
    $rate->setCode('BTC');
    $rate->setRate(1.0);

    $rateArray = $rate->toArray();

    $this->assertNotNull($rateArray);
    $this->assertIsArray($rateArray);
    $this->assertArrayHasKey('name', $rateArray);
    $this->assertArrayHasKey('code', $rateArray);
    $this->assertArrayHasKey('rate', $rateArray);
    $this->assertEquals($rateArray['name'], 'Bitcoin');
    $this->assertEquals($rateArray['code'], 'BTC');
    $this->assertEquals($rateArray['rate'], 1.0);
  }
}