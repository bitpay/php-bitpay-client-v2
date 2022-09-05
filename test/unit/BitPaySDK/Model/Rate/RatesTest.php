<?php

namespace BitPaySDK\Test\Model\Rate;

use BitPaySDK\Client;
use BitPaySDK\Exceptions\BitPayException;
use BitPaySDK\Model\Rate\Rate;
use BitPaySDK\Model\Rate\Rates;
use PHPUnit\Framework\TestCase;

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

    public function testGetRateException()
    {
        $rates = $this->createClassObject();
        $this->expectException(BitPayException::class);
        $this->expectExceptionMessage('currency code must be a type of Model.Currency');
        $rates->getRate('ELO');
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