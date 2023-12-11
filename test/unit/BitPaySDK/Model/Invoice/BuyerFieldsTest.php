<?php

declare(strict_types=1);

namespace BitPaySDK\Test\Model\Invoice;

use BitPaySDK\Model\Invoice\BuyerFields;
use PHPUnit\Framework\TestCase;

class BuyerFieldsTest extends TestCase
{
    public function testManipulateBuyerAddress1(): void
    {
        $testedClass = $this->getTestedClass();
        $expected = 'someValue';
        $testedClass->setBuyerAddress1($expected);

        self::assertEquals($expected, $testedClass->getBuyerAddress1());
    }

    public function testManipulateBuyerAddress2(): void
    {
        $testedClass = $this->getTestedClass();
        $expected = 'someValue';
        $testedClass->setBuyerAddress2($expected);

        self::assertEquals($expected, $testedClass->getBuyerAddress2());
    }

    public function testManipulateBuyerCity(): void
    {
        $testedClass = $this->getTestedClass();
        $expected = 'someValue';
        $testedClass->setBuyerCity($expected);

        self::assertEquals($expected, $testedClass->getBuyerCity());
    }

    public function testManipulateBuyerCountry(): void
    {
        $testedClass = $this->getTestedClass();
        $expected = 'someValue';
        $testedClass->setBuyerCountry($expected);

        self::assertEquals($expected, $testedClass->getBuyerCountry());
    }

    public function testManipulateBuyerEmail(): void
    {
        $testedClass = $this->getTestedClass();
        $expected = 'someValue';
        $testedClass->setBuyerEmail($expected);

        self::assertEquals($expected, $testedClass->getBuyerEmail());
    }

    public function testManipulateBuyerName(): void
    {
        $testedClass = $this->getTestedClass();
        $expected = 'someValue';
        $testedClass->setBuyerName($expected);

        self::assertEquals($expected, $testedClass->getBuyerName());
    }

    public function testManipulateBuyerNotify(): void
    {
        $testedClass = $this->getTestedClass();
        $expected = true;
        $testedClass->setBuyerNotify($expected);

        self::assertEquals($expected, $testedClass->getBuyerNotify());
    }

    public function testManipulateBuyerPhone(): void
    {
        $testedClass = $this->getTestedClass();
        $expected = 'someValue';
        $testedClass->setBuyerPhone($expected);

        self::assertEquals($expected, $testedClass->getBuyerPhone());
    }

    public function testManipulateBuyerState(): void
    {
        $testedClass = $this->getTestedClass();
        $expected = 'someValue';
        $testedClass->setBuyerState($expected);

        self::assertEquals($expected, $testedClass->getBuyerState());
    }

    public function testManipulateBuyerZip(): void
    {
        $testedClass = $this->getTestedClass();
        $expected = 'someValue';
        $testedClass->setBuyerZip($expected);

        self::assertEquals($expected, $testedClass->getBuyerZip());
    }

    private function getTestedClass(): BuyerFields
    {
        return new BuyerFields();
    }
}
