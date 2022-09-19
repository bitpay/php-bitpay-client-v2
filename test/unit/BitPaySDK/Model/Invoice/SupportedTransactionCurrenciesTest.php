<?php

namespace BitPaySDK\Test\Model\Invoice;

use BitPaySDK\Model\Invoice\SupportedTransactionCurrencies;
use BitPaySDK\Model\Invoice\SupportedTransactionCurrency;
use PHPUnit\Framework\TestCase;

class SupportedTransactionCurrenciesTest extends TestCase
{
    public function testInstanceOf()
    {
        $supportedTransactionCurrencies = $this->createClassObject();
        $this->assertInstanceOf(SupportedTransactionCurrencies::class, $supportedTransactionCurrencies);
    }

    public function testGetBTC()
    {
        $expectedSupportedTransactionCurrency = $this->getMockBuilder(SupportedTransactionCurrency::class)->getMock();
        $supportedTransactionCurrencies = $this->createClassObject();
        $supportedTransactionCurrencies->setBTC($expectedSupportedTransactionCurrency);
        $this->assertEquals($expectedSupportedTransactionCurrency, $supportedTransactionCurrencies->getBTC());
    }

    public function testGetBCH()
    {
        $expectedSupportedTransactionCurrency = $this->getMockBuilder(SupportedTransactionCurrency::class)->getMock();
        $supportedTransactionCurrencies = $this->createClassObject();
        $supportedTransactionCurrencies->setBCH($expectedSupportedTransactionCurrency);
        $this->assertEquals($expectedSupportedTransactionCurrency, $supportedTransactionCurrencies->getBCH());
    }

    public function testGetETH()
    {
        $expectedSupportedTransactionCurrency = $this->getMockBuilder(SupportedTransactionCurrency::class)->getMock();
        $supportedTransactionCurrencies = $this->createClassObject();
        $supportedTransactionCurrencies->setETH($expectedSupportedTransactionCurrency);
        $this->assertEquals($expectedSupportedTransactionCurrency, $supportedTransactionCurrencies->getETH());
    }

    public function testGetUSDC()
    {
        $expectedSupportedTransactionCurrency = $this->getMockBuilder(SupportedTransactionCurrency::class)->getMock();
        $supportedTransactionCurrencies = $this->createClassObject();
        $supportedTransactionCurrencies->setUSDC($expectedSupportedTransactionCurrency);
        $this->assertEquals($expectedSupportedTransactionCurrency, $supportedTransactionCurrencies->getUSDC());
    }

    public function testGetGUSD()
    {
        $expectedSupportedTransactionCurrency = $this->getMockBuilder(SupportedTransactionCurrency::class)->getMock();
        $supportedTransactionCurrencies = $this->createClassObject();
        $supportedTransactionCurrencies->setGUSD($expectedSupportedTransactionCurrency);
        $this->assertEquals($expectedSupportedTransactionCurrency, $supportedTransactionCurrencies->getGUSD());
    }

    public function testGetPAX()
    {
        $expectedSupportedTransactionCurrency = $this->getMockBuilder(SupportedTransactionCurrency::class)->getMock();
        $supportedTransactionCurrencies = $this->createClassObject();
        $supportedTransactionCurrencies->setPAX($expectedSupportedTransactionCurrency);
        $this->assertEquals($expectedSupportedTransactionCurrency, $supportedTransactionCurrencies->getPAX());
    }

    public function testGetXRP()
    {
        $expectedSupportedTransactionCurrency = $this->getMockBuilder(SupportedTransactionCurrency::class)->getMock();
        $supportedTransactionCurrencies = $this->createClassObject();
        $supportedTransactionCurrencies->setXRP($expectedSupportedTransactionCurrency);
        $this->assertEquals($expectedSupportedTransactionCurrency, $supportedTransactionCurrencies->getXRP());
    }

    public function testToArray()
    {
        $expectedSupportedTransactionCurrency = $this->getMockBuilder(SupportedTransactionCurrency::class)->getMock();
        $expectedSupportedTransactionCurrency->expects($this->once())->method('toArray')->willReturn(['enabled' => true, 'reason' => 'test']);
        $supportedTransactionCurrencies = $this->createClassObject();
        $supportedTransactionCurrencies->setBTC($expectedSupportedTransactionCurrency);
        $supportedTransactionCurrenciesArray = $supportedTransactionCurrencies->toArray();

        $this->assertNotNull($supportedTransactionCurrenciesArray);
        $this->assertIsArray($supportedTransactionCurrenciesArray);

        $this->assertArrayHasKey('btc', $supportedTransactionCurrenciesArray);
        $this->assertArrayNotHasKey('bch', $supportedTransactionCurrenciesArray);
        $this->assertEquals(['btc' => ['enabled' => true,  'reason' => 'test']], $supportedTransactionCurrenciesArray);
    }

    public function testToArrayEmptyKey()
    {
        $supportedTransactionCurrencies = $this->createClassObject();
        $supportedTransactionCurrenciesArray = $supportedTransactionCurrencies->toArray();

        $this->assertNotNull($supportedTransactionCurrenciesArray);
        $this->assertIsArray($supportedTransactionCurrenciesArray);

        $this->assertArrayNotHasKey('btc', $supportedTransactionCurrenciesArray);
    }

    private function createClassObject()
    {
        return new SupportedTransactionCurrencies();
    }
}