<?php

namespace BitPaySDK\Test\Model\Settlement;

use BitPaySDK\Model\Settlement\WithHoldings;
use PHPUnit\Framework\TestCase;

class WithHoldingsTest extends TestCase
{
    public function testInstanceOf()
    {
        $withHoldings = $this->createClassObject();
        self::assertInstanceOf(WithHoldings::class, $withHoldings);
    }

    public function testGetAmount()
    {
        $expectedAmount = 12.5;

        $withHoldings = $this->createClassObject();
        $withHoldings->setAmount($expectedAmount);
        self::assertEquals($expectedAmount, $withHoldings->getAmount());
    }

    public function testGetCode()
    {
        $expectedCode = 'BTC';

        $withHoldings = $this->createClassObject();
        $withHoldings->setCode($expectedCode);
        self::assertEquals($expectedCode, $withHoldings->getCode());
    }

    public function testGetDescription()
    {
        $expectedDescription = 'Test description';

        $withHoldings = $this->createClassObject();
        $withHoldings->setDescription($expectedDescription);
        self::assertEquals($expectedDescription, $withHoldings->getDescription());
    }

    public function testGetNotes()
    {
        $expectedNotes = 'Test note';

        $withHoldings = $this->createClassObject();
        $withHoldings->setNotes($expectedNotes);
        self::assertEquals($expectedNotes, $withHoldings->getNotes());
    }

    public function testGetLabel()
    {
        $expectedLabel = 'Test label';

        $withHoldings = $this->createClassObject();
        $withHoldings->setLabel($expectedLabel);
        self::assertEquals($expectedLabel, $withHoldings->getLabel());
    }

    public function testGetBankCountry()
    {
        $expectedBankCountry = 'USA';

        $withHoldings = $this->createClassObject();
        $withHoldings->setBankCountry($expectedBankCountry);
        self::assertEquals($expectedBankCountry, $withHoldings->getBankCountry());
    }

    public function testToArray()
    {
        $withHoldings = $this->createClassObject();
        $this->setSetters($withHoldings);
        $withHoldingsArray = $withHoldings->toArray();

        self::assertNotNull($withHoldingsArray);
        self::assertIsArray($withHoldingsArray);

        self::assertArrayHasKey('amount', $withHoldingsArray);
        self::assertArrayHasKey('code', $withHoldingsArray);
        self::assertArrayHasKey('description', $withHoldingsArray);
        self::assertArrayHasKey('notes', $withHoldingsArray);
        self::assertArrayHasKey('label', $withHoldingsArray);
        self::assertArrayHasKey('bankCountry', $withHoldingsArray);

        self::assertEquals(10.5, $withHoldingsArray['amount']);
        self::assertEquals('BTC', $withHoldingsArray['code']);
        self::assertEquals('Description', $withHoldingsArray['description']);
        self::assertEquals('Note', $withHoldingsArray['notes']);
        self::assertEquals('Label', $withHoldingsArray['label']);
        self::assertEquals('USA', $withHoldingsArray['bankCountry']);
    }

    private function createClassObject(): WithHoldings
    {
        return new WithHoldings();
    }

    private function setSetters(WithHoldings $withHoldings)
    {
        $withHoldings->setAmount(10.5);
        $withHoldings->setCode('BTC');
        $withHoldings->setDescription('Description');
        $withHoldings->setNotes('Note');
        $withHoldings->setLabel('Label');
        $withHoldings->setBankCountry('USA');
    }
}
