<?php

namespace BitPaySDK\Test\Model\Rate;

use BitPaySDK\Model\Rate\Rate;
use PHPUnit\Framework\TestCase;

class RateTest extends TestCase
{
    public function testInstanceOf()
    {
        $rate = $this->createClassObject();
        self::assertInstanceOf(Rate::class, $rate);
    }

    public function testGetName()
    {
        $expectedName = 'Bitcoin';

        $rate = $this->createClassObject();
        $rate->setName($expectedName);
        self::assertEquals($expectedName, $rate->getName());
    }

    public function testGetCode()
    {
        $expectedCode = 'BTC';

        $rate = $this->createClassObject();
        $rate->setCode($expectedCode);
        self::assertEquals($expectedCode, $rate->getCode());
    }

    public function testGetRate()
    {
        $expectedRate = 1.0;

        $rate = $this->createClassObject();
        $rate->setRate($expectedRate);
        self::assertEquals($expectedRate, $rate->getRate());
    }

    public function testToArray()
    {
        $rate = $this->createClassObject();
        $this->setSetters($rate);
        $rateArray = $rate->toArray();

        self::assertNotNull($rateArray);
        self::assertIsArray($rateArray);

        self::assertArrayHasKey('name', $rateArray);
        self::assertArrayHasKey('code', $rateArray);
        self::assertArrayHasKey('rate', $rateArray);

        self::assertEquals('Bitcoin', $rateArray['name']);
        self::assertEquals('BTC', $rateArray['code']);
        self::assertEquals(1.0, $rateArray['rate']);
    }

    private function createClassObject(): Rate
    {
        return new Rate();
    }

    private function setSetters(Rate $rate)
    {
        $rate->setName('Bitcoin');
        $rate->setCode('BTC');
        $rate->setRate(1.0);
    }
}
