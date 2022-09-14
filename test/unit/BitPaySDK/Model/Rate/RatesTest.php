<?php

namespace BitPaySDK\Test\Model\Rate;

use BitPaySDK\Client;
use BitPaySDK\Exceptions\BitPayException;
use BitPaySDK\Model\Rate\Rate;
use BitPaySDK\Model\Rate\Rates;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class RatesTest extends TestCase
{
    public function testInstanceOf()
    {
        $rates = $this->createClassObject();
        $this->assertInstanceOf(Rates::class, $rates);
    }

    public function testGetRates()
    {
        $rates = $this->createClassObject();

        $ratesArray = $rates->getRates();
        $this->assertIsArray($ratesArray);
    }

    public function testUpdate()
    {
        $rates = [new Rate(), 'test' => 'test'];
        $bp = $this->getMockBuilder(Client::class)->getMock();
        $bp->method('getRates')->willReturn(new Rates($rates, $bp));

        $rates = new Rates($rates, $bp);

        $reflection = new ReflectionClass(Rates::class);
        $rates->update();

        $reflectionTest = $reflection->getProperty('_rates')->setAccessible(true);

        $this->assertEquals(null, $reflectionTest);
    }

    public function testGetRateException()
    {
        $rates = $this->createClassObject();
        $this->expectException(BitPayException::class);
        $this->expectExceptionMessage('currency code must be a type of Model.Currency');
        $rates->getRate('ELO');
    }

    public function testGetRate()
    {
        $expectedValue = 12;

        $rateMock = $this->getMockBuilder(Rate::class)->disableOriginalConstructor()->getMock();
        $rateMock->method('getCode')->willReturn('BTC');
        $rateMock->method('getRate')->willReturn(12);

        $rates = [$rateMock];
        $bp = $this->getMockBuilder(Client::class)->getMock();
        $rates = new Rates($rates, $bp);

        $this->assertEquals($expectedValue, $rates->getRate('BTC'));
    }

    public function testToArray()
    {
        $rates = $this->createClassObject();
        $ratesEmpty = new Rates([], $this->getMockBuilder(Client::class)->getMock());
        $ratesArray = $rates->toArray();

        $ratesEmptyArray = $ratesEmpty->toArray();

        $this->assertIsArray($ratesArray);
        $this->assertArrayNotHasKey('rates', $ratesEmptyArray);
    }

    private function createClassObject()
    {
        $rates = [new Rate(), 'test' => 'test'];
        $bp = $this->getMockBuilder(Client::class)->getMock();

        return new Rates($rates, $bp);
    }
}