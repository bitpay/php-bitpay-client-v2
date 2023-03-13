<?php

namespace BitPaySDK\Test\Model\Subscription;

use BitPaySDK\Model\Subscription\Item;
use PHPUnit\Framework\TestCase;

class ItemTest extends TestCase
{
    public function testInstanceOf()
    {
        $item = $this->createClassObject();
        $this->assertInstanceOf(Item::class, $item);
    }

    public function testGetDescription()
    {
        $expectedDescription = 'Test description';

        $item = $this->createClassObject();
        $item->setDescription($expectedDescription);
        $this->assertEquals($expectedDescription, $item->getDescription());
    }

    public function testGetPrice()
    {
        $expectedPrice = 100.50;

        $item = $this->createClassObject();
        $item->setPrice($expectedPrice);
        $this->assertEquals($expectedPrice, $item->getPrice());
    }

    public function testGetQuantity()
    {
        $expectedQuantity = 5;

        $item = $this->createClassObject();
        $item->setQuantity($expectedQuantity);
        $this->assertEquals($expectedQuantity, $item->getQuantity());
    }

    public function testCreateFromArray()
    {
        $testArrayItem = [
            'description' => 'test',
            'price' => 21
        ];

        $item = $this->createClassObject();
        $item = $item::createFromArray($testArrayItem);

        $this->assertEquals('test', $item->getDescription());
        $this->assertEquals(21, $item->getPrice());
    }

    public function testToArray()
    {
        $item = $this->createClassObject();
        $this->setSetters($item);
        $itemArray = $item->toArray();

        $this->assertNotNull($itemArray);
        $this->assertIsArray($itemArray);

        $this->assertArrayNotHasKey('description', $itemArray);
        $this->assertArrayHasKey('price', $itemArray);
        $this->assertArrayHasKey('quantity', $itemArray);
        $this->assertEquals(100.50, $itemArray['price']);
        $this->assertEquals(5, $itemArray['quantity']);
    }


    private function createClassObject(): Item
    {
        return new Item();
    }

    private function setSetters(Item $item)
    {
        $item->setDescription('');
        $item->setPrice(100.50);
        $item->setQuantity(5);
    }
}
