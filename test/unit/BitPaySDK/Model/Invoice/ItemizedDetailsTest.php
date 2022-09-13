<?php

namespace BitPaySDK\Test\Model\Invoice;

use BitPaySDK\Model\Invoice\ItemizedDetails;
use PHPUnit\Framework\TestCase;

class ItemizedDetailsTest extends TestCase
{
    public function testInstanceOf()
    {
        $itemizedDetails = $this->createClassObject();
        $this->assertInstanceOf(ItemizedDetails::class, $itemizedDetails);
    }

    public function testGetAmount()
    {
        $expectedAmount = 15.5;

        $itemizedDetails = $this->createClassObject();
        $itemizedDetails->setAmount($expectedAmount);
        $this->assertEquals($expectedAmount, $itemizedDetails->getAmount());
    }

    public function testGetDescription()
    {
        $expectedDescription = 'Test description';

        $itemizedDetails = $this->createClassObject();
        $itemizedDetails->setDescription($expectedDescription);
        $this->assertEquals($expectedDescription, $itemizedDetails->getDescription());
    }

    public function testGetIsFee()
    {
        $itemizedDetails = $this->createClassObject();
        $itemizedDetails->setIsFee(true);
        $this->assertTrue($itemizedDetails->getIsFee());
    }

    public function testToArray()
    {
        $itemizedDetails = $this->createClassObject();
        $this->setSetters($itemizedDetails);
        $itemizedDetailsArray = $itemizedDetails->toArray();

        $this->assertNotNull($itemizedDetailsArray);
        $this->assertIsArray($itemizedDetailsArray);

        $this->assertArrayHasKey('amount', $itemizedDetailsArray);
        $this->assertArrayHasKey('description', $itemizedDetailsArray);
        $this->assertArrayHasKey('isFee', $itemizedDetailsArray);

        $this->assertEquals($itemizedDetailsArray['amount'], 15.5);
        $this->assertEquals($itemizedDetailsArray['description'], 'Test description');
        $this->assertEquals($itemizedDetailsArray['isFee'], true);
    }

    private function createClassObject()
    {
        return new ItemizedDetails();
    }

    private function setSetters(ItemizedDetails $itemizedDetails)
    {
        $itemizedDetails->setAmount(15.5);
        $itemizedDetails->setDescription('Test description');
        $itemizedDetails->setIsFee(true);
    }
}
