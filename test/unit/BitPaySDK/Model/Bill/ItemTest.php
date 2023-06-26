<?php

namespace BitPaySDK\Test\Model\Bill;

use BitPaySDK\Model\Bill\Item;
use PHPUnit\Framework\TestCase;

class ItemTest extends TestCase
{
    public function testInstanceOf()
    {
        $item = $this->createClassObject();
        self::assertInstanceOf(Item::class, $item);
    }

    public function testGetId()
    {
        $expectedId = 5;

        $item = $this->createClassObject();
        $item->setId($expectedId);
        self::assertEquals($expectedId, $item->getId());
    }

    public function testGetDescription()
    {
        $expectedDescription = 'test description';

        $item = $this->createClassObject();
        $item->setDescription($expectedDescription);
        self::assertEquals($expectedDescription, $item->getDescription());
    }

    public function testGetPrice()
    {
        $expectedPrice = 10.0;

        $item = $this->createClassObject();
        $item->setPrice($expectedPrice);
        self::assertEquals($expectedPrice, $item->getPrice());
    }

    public function testGetQuantity()
    {
        $expectedQuantity = 5;

        $item = $this->createClassObject();
        $item->setQuantity($expectedQuantity);
        self::assertEquals($expectedQuantity, $item->getQuantity());
    }

    public function testCreateFromArray()
    {
        $testArrayItem = [
            'description' => 'test',
            'price' => 12
        ];

        $item = $this->createClassObject();
        $item = $item::createFromArray($testArrayItem);

        self::assertEquals('test', $item->getDescription());
        self::assertEquals(12, $item->getPrice());
    }

    public function testToArray()
    {
        $item = $this->createClassObject();
        $this->objectSetters($item);

        $itemArray = $item->toArray();

        self::assertNotNull($itemArray);
        self::assertIsArray($itemArray);

        self::assertArrayHasKey('id', $itemArray);
        self::assertArrayHasKey('description', $itemArray);
        self::assertArrayHasKey('price', $itemArray);
        self::assertArrayHasKey('quantity', $itemArray);

        self::assertEquals(1, $itemArray['id']);
        self::assertEquals('description', $itemArray['description']);
        self::assertEquals(1.2, $itemArray['price']);
        self::assertEquals(1, $itemArray['quantity']);
    }

    private function createClassObject(): Item
    {
        return new Item();
    }

    private function objectSetters(Item $item)
    {
        $item->setId(1);
        $item->setDescription('description');
        $item->setPrice(1.2);
        $item->setQuantity(1);
    }
}