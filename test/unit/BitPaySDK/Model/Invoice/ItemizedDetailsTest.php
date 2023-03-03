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

        $this->assertEquals(15.5, $itemizedDetailsArray['amount']);
        $this->assertEquals('Test description', $itemizedDetailsArray['description']);
        $this->assertEquals(true, $itemizedDetailsArray['isFee']);
    }

    private function createClassObject(): ItemizedDetails
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
