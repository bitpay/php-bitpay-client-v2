<?php

namespace BitPaySDK\Test\Model\Settlement;

use BitPaySDK\Model\Settlement\WithHoldings;
use PHPUnit\Framework\TestCase;

class WithHoldingsTest extends TestCase
{
    public function testInstanceOf()
    {
        $withHoldings = $this->createClassObject();
        $this->assertInstanceOf(WithHoldings::class, $withHoldings);
    }

    public function testGetAmount()
    {
        $expectedAmount = 12.5;

        $withHoldings = $this->createClassObject();
        $withHoldings->setAmount($expectedAmount);
        $this->assertEquals($expectedAmount, $withHoldings->getAmount());
    }

    public function testGetCode()
    {
        $expectedCode = 'BTC';

        $withHoldings = $this->createClassObject();
        $withHoldings->setCode($expectedCode);
        $this->assertEquals($expectedCode, $withHoldings->getCode());
    }

    public function testGetDescription()
    {
        $expectedDescription = 'Test description';

        $withHoldings = $this->createClassObject();
        $withHoldings->setDescription($expectedDescription);
        $this->assertEquals($expectedDescription, $withHoldings->getDescription());
    }

    public function testGetNotes()
    {
        $expectedNotes = 'Test note';

        $withHoldings = $this->createClassObject();
        $withHoldings->setNotes($expectedNotes);
        $this->assertEquals($expectedNotes, $withHoldings->getNotes());
    }

    public function testGetLabel()
    {
        $expectedLabel = 'Test label';

        $withHoldings = $this->createClassObject();
        $withHoldings->setLabel($expectedLabel);
        $this->assertEquals($expectedLabel, $withHoldings->getLabel());
    }

    public function testGetBankCountry()
    {
        $expectedBankCountry = 'USA';

        $withHoldings = $this->createClassObject();
        $withHoldings->setBankCountry($expectedBankCountry);
        $this->assertEquals($expectedBankCountry, $withHoldings->getBankCountry());
    }

    public function testToArray()
    {
        $withHoldings = $this->createClassObject();
        $this->setSetters($withHoldings);
        $withHoldingsArray = $withHoldings->toArray();

        $this->assertNotNull($withHoldingsArray);
        $this->assertIsArray($withHoldingsArray);

        $this->assertArrayHasKey('amount', $withHoldingsArray);
        $this->assertArrayHasKey('code', $withHoldingsArray);
        $this->assertArrayHasKey('description', $withHoldingsArray);
        $this->assertArrayHasKey('notes', $withHoldingsArray);
        $this->assertArrayHasKey('label', $withHoldingsArray);
        $this->assertArrayHasKey('bankCountry', $withHoldingsArray);

        $this->assertEquals($withHoldingsArray['amount'], 10.5);
        $this->assertEquals($withHoldingsArray['code'], 'BTC');
        $this->assertEquals($withHoldingsArray['description'], 'Description');
        $this->assertEquals($withHoldingsArray['notes'], 'Note');
        $this->assertEquals($withHoldingsArray['label'], 'Label');
        $this->assertEquals($withHoldingsArray['bankCountry'], 'USA');
    }

    private function createClassObject()
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
