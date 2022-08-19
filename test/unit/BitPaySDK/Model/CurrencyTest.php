<?php

namespace BitPaySDK\Test\Model;

use BitPaySDK\Model\Currency;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class CurrencyTest extends TestCase
{
    public function testInstanceOf()
    {
        $currency = $this->createClassObject();
        $this->assertInstanceOf(Currency::class, $currency);
    }

    public function testIsValid()
    {
        $currencyObject = $this->createClassObject();
        $reflect = new ReflectionClass(Currency::class);
        $allCurrencies = $reflect->getConstants();

        foreach ($allCurrencies as $currency) {
            $result = $currencyObject::isValid($currency);

            $this->assertTrue($result);
        }

        $this->assertFalse($currencyObject::isValid('wrongValue'));
    }

    public function testToArray()
    {
        $currency = $this->createClassObject();
        $this->setSetters($currency);

        $currencyArray = $currency->toArray();

        $this->assertNotNull($currencyArray);
        $this->assertIsArray($currencyArray);
        $this->assertArrayHasKey('code', $currencyArray);
        $this->assertArrayHasKey('symbol', $currencyArray);
        $this->assertArrayHasKey('precision', $currencyArray);
        $this->assertArrayHasKey('currentlySettled', $currencyArray);
        $this->assertArrayHasKey('name', $currencyArray);
        $this->assertArrayHasKey('plural', $currencyArray);
        $this->assertArrayHasKey('alts', $currencyArray);
        $this->assertArrayHasKey('minimum', $currencyArray);
        $this->assertArrayHasKey('sanctioned', $currencyArray);
        $this->assertArrayHasKey('decimals', $currencyArray);
        $this->assertArrayHasKey('payoutFields', $currencyArray);
        $this->assertArrayHasKey('settlementMinimum', $currencyArray);
        $this->assertEquals($currencyArray['code'], 'BTC');
        $this->assertEquals($currencyArray['symbol'], 'Symbol');
        $this->assertEquals($currencyArray['precision'], 1);
        $this->assertEquals($currencyArray['currentlySettled'], true);
        $this->assertEquals($currencyArray['name'], 'Bitcoin');
        $this->assertEquals($currencyArray['plural'], 'plural');
        $this->assertEquals($currencyArray['alts'], 'alts');
        $this->assertEquals($currencyArray['minimum'], 'minimum');
        $this->assertEquals($currencyArray['sanctioned'], true);
        $this->assertEquals($currencyArray['decimals'], 'decimals');
        $this->assertEquals($currencyArray['payoutFields'], ['test']);
        $this->assertEquals($currencyArray['settlementMinimum'], ['test']);
    }

    public function testGetCode()
    {
        $currency = $this->createClassObject();
        $currency->setCode('testCode');
        $this->assertEquals('testCode', $currency->getCode());
    }

    public function testGetSymbol()
    {
        $currency = $this->createClassObject();
        $currency->setSymbol('testSymbol');
        $this->assertEquals('testSymbol', $currency->getSymbol());
    }

    public function testGetPrecision()
    {
        $currency = $this->createClassObject();
        $currency->setPrecision(1);
        $this->assertEquals(1, $currency->getPrecision());
    }

    public function testGetCurrentlySettled()
    {
        $currency = $this->createClassObject();
        $currency->setCurrentlySettled(true);
        $this->assertEquals(true, $currency->getCurrentlySettled());
    }

    public function testGetName()
    {
        $currency = $this->createClassObject();
        $currency->setName('testName');
        $this->assertEquals('testName', $currency->getName());
    }

    public function testGetPlural()
    {
        $currency = $this->createClassObject();
        $currency->setPlural('testPlural');
        $this->assertEquals('testPlural', $currency->getPlural());
    }

    public function testGetAlts()
    {
        $currency = $this->createClassObject();
        $currency->setAlts('testAlts');
        $this->assertEquals('testAlts', $currency->getAlts());
    }

    public function testGetMinimum()
    {
        $currency = $this->createClassObject();
        $currency->setMinimum('testMinimum');
        $this->assertEquals('testMinimum', $currency->getMinimum());
    }

    public function testGetSanctioned()
    {
        $currency = $this->createClassObject();
        $currency->setSanctioned(true);
        $this->assertEquals(true, $currency->getSanctioned());
    }

    public function testGetDecimals()
    {
        $currency = $this->createClassObject();
        $currency->setDecimals('testDecimals');
        $this->assertEquals('testDecimals', $currency->getDecimals());
    }

    public function testGetPayoutFields()
    {
        $currency = $this->createClassObject();
        $currency->setPayoutFields(['test']);
        $this->assertEquals(['test'], $currency->getPayoutFields());
    }

    public function testGetSettlementMinimum()
    {
        $currency = $this->createClassObject();
        $currency->setSettlementMinimum(['test']);
        $this->assertEquals(['test'], $currency->getSettlementMinimum());
    }

    private function createClassObject()
    {
        return new Currency();
    }

    private function setSetters(Currency $currency)
    {
        $currency->setCode('BTC');
        $currency->setSymbol('Symbol');
        $currency->setPrecision(1);
        $currency->setCurrentlySettled(true);
        $currency->setName('Bitcoin');
        $currency->setPlural('plural');
        $currency->setAlts('alts');
        $currency->setMinimum('minimum');
        $currency->setSanctioned(true);
        $currency->setDecimals('decimals');
        $currency->setPayoutFields(['test']);
        $currency->setSettlementMinimum(['test']);
    }
}
