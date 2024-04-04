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
        self::assertInstanceOf(Currency::class, $currency);
    }

    public function testIsValid()
    {
        $currencyObject = $this->createClassObject();
        $reflect = new ReflectionClass(Currency::class);
        $allCurrencies = $reflect->getConstants();

        foreach ($allCurrencies as $currency) {
            $result = $currencyObject::isValid($currency);

            self::assertTrue($result);
        }

        self::assertFalse($currencyObject::isValid('wrongValue'));
    }

    public function testToArray()
    {
        $currency = $this->createClassObject();
        $this->setSetters($currency);

        $currencyArray = $currency->toArray();

        self::assertNotNull($currencyArray);
        self::assertIsArray($currencyArray);
        self::assertArrayHasKey('code', $currencyArray);
        self::assertArrayHasKey('symbol', $currencyArray);
        self::assertArrayHasKey('precision', $currencyArray);
        self::assertArrayHasKey('currentlySettled', $currencyArray);
        self::assertArrayHasKey('name', $currencyArray);
        self::assertArrayHasKey('plural', $currencyArray);
        self::assertArrayHasKey('alts', $currencyArray);
        self::assertArrayHasKey('minimum', $currencyArray);
        self::assertArrayHasKey('sanctioned', $currencyArray);
        self::assertArrayHasKey('decimals', $currencyArray);
        self::assertEquals('BTC', $currencyArray['code']);
        self::assertEquals('Symbol', $currencyArray['symbol']);
        self::assertEquals(1, $currencyArray['precision']);
        self::assertTrue($currencyArray['currentlySettled']);
        self::assertEquals('Bitcoin', $currencyArray['name']);
        self::assertEquals('plural', $currencyArray['plural']);
        self::assertEquals('alts', $currencyArray['alts']);
        self::assertEquals('minimum', $currencyArray['minimum']);
        self::assertTrue($currencyArray['sanctioned']);
        self::assertEquals(2, $currencyArray['decimals']);
        self::assertEquals('chain', $currencyArray['chain']);
    }

    public function testGetCode()
    {
        $currency = $this->createClassObject();
        $currency->setCode('testCode');
        self::assertEquals('testCode', $currency->getCode());
    }

    public function testGetSymbol()
    {
        $currency = $this->createClassObject();
        $currency->setSymbol('testSymbol');
        self::assertEquals('testSymbol', $currency->getSymbol());
    }

    public function testGetPrecision()
    {
        $currency = $this->createClassObject();
        $currency->setPrecision(1);
        self::assertEquals(1, $currency->getPrecision());
    }

    public function testGetCurrentlySettled()
    {
        $currency = $this->createClassObject();
        $currency->setCurrentlySettled(true);
        self::assertTrue($currency->getCurrentlySettled());
    }

    public function testGetName()
    {
        $currency = $this->createClassObject();
        $currency->setName('testName');
        self::assertEquals('testName', $currency->getName());
    }

    public function testGetPlural()
    {
        $currency = $this->createClassObject();
        $currency->setPlural('testPlural');
        self::assertEquals('testPlural', $currency->getPlural());
    }

    public function testGetAlts()
    {
        $currency = $this->createClassObject();
        $currency->setAlts('testAlts');
        self::assertEquals('testAlts', $currency->getAlts());
    }

    public function testGetMinimum()
    {
        $currency = $this->createClassObject();
        $currency->setMinimum('testMinimum');
        self::assertEquals('testMinimum', $currency->getMinimum());
    }

    public function testGetSanctioned()
    {
        $currency = $this->createClassObject();
        $currency->setSanctioned(true);
        self::assertTrue($currency->getSanctioned());
    }

    public function testGetDecimals()
    {
        $currency = $this->createClassObject();
        $expected = 2;
        $currency->setDecimals($expected);
        self::assertEquals($expected, $currency->getDecimals());
    }

    public function testModifyChain(): void
    {
        $testedClass = $this->createClassObject();
        $expected = 'someValue';
        $testedClass->setChain($expected);

        self::assertEquals($expected, $testedClass->getChain());
    }

    private function createClassObject(): Currency
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
        $currency->setDecimals(2);
        $currency->setChain('chain');
    }
}
