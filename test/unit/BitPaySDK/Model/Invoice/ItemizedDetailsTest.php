<?php

namespace BitPaySDK\Test\Model\Invoice;

use BitPaySDK\Model\Invoice\ItemizedDetails;
use PHPUnit\Framework\TestCase;

class ItemizedDetailsTest extends TestCase
{
    public function testInstanceOf()
    {
        $itemizedDetails = $this->createClassObject();
        self::assertInstanceOf(ItemizedDetails::class, $itemizedDetails);
    }

    public function testGetAmount()
    {
        $expectedAmount = 15.5;

        $itemizedDetails = $this->createClassObject();
        $itemizedDetails->setAmount($expectedAmount);
        self::assertEquals($expectedAmount, $itemizedDetails->getAmount());
    }

    public function testGetDescription()
    {
        $expectedDescription = 'Test description';

        $itemizedDetails = $this->createClassObject();
        $itemizedDetails->setDescription($expectedDescription);
        self::assertEquals($expectedDescription, $itemizedDetails->getDescription());
    }

    public function testGetIsFee()
    {
        $itemizedDetails = $this->createClassObject();
        $itemizedDetails->setIsFee(true);
        self::assertTrue($itemizedDetails->getIsFee());
    }

    public function testToArray()
    {
        $itemizedDetails = $this->createClassObject();
        $this->setSetters($itemizedDetails);
        $itemizedDetailsArray = $itemizedDetails->toArray();

        self::assertNotNull($itemizedDetailsArray);
        self::assertIsArray($itemizedDetailsArray);

        self::assertArrayHasKey('amount', $itemizedDetailsArray);
        self::assertArrayHasKey('description', $itemizedDetailsArray);
        self::assertArrayHasKey('isFee', $itemizedDetailsArray);

        self::assertEquals(15.5, $itemizedDetailsArray['amount']);
        self::assertEquals('Test description', $itemizedDetailsArray['description']);
        self::assertEquals(true, $itemizedDetailsArray['isFee']);
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
