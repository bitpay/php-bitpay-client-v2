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
            'test' => 'test',
            'test2' => 'value2'
        ];

        $item = $this->createClassObject();
        $item = $item::createFromArray($testArrayItem);

        $this->assertEquals('test', $item->_test);
        $this->assertEquals('value2', $item->_test2);
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
        $this->assertEquals($itemArray['price'], 100.50);
        $this->assertEquals($itemArray['quantity'], 5);
    }


    private function createClassObject()
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
