<?php

namespace BitPaySDK\Test\Model\Rate;

use BitPaySDK\Client;
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

    private function createClassObject()
    {
        $rates = [new Rate(), 'test' => 'test'];
        $bp = $this->getMockBuilder(Client::class)->getMock();

        return new Rates($rates, $bp);
    }
}