<?php

namespace BitPaySDK\Test\Model\Rate;

use BitPaySDK\Model\Rate\Rate;
use PHPUnit\Framework\TestCase;

class RateTest extends TestCase
{
    public function testInstanceOf()
    {
        $rate = $this->createClassObject();
        $this->assertInstanceOf(Rate::class, $rate);
    }

    public function testGetName()
    {
        $expectedName = 'Bitcoin';

        $rate = $this->createClassObject();
        $rate->setName($expectedName);
        $this->assertEquals($expectedName, $rate->getName());
    }

    public function testGetCode()
    {
        $expectedCode = 'BTC';

        $rate = $this->createClassObject();
        $rate->setCode($expectedCode);
        $this->assertEquals($expectedCode, $rate->getCode());
    }

    public function testGetRate()
    {
        $expectedRate = 1.0;

        $rate = $this->createClassObject();
        $rate->setRate($expectedRate);
        $this->assertEquals($expectedRate, $rate->getRate());
    }

    public function testToArray()
    {
        $rate = $this->createClassObject();
        $this->setSetters($rate);
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

    private function createClassObject()
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
