<?php

namespace BitPaySDK\Test\Model\Bill;

use BitPaySDK\Model\Bill\Item;
use PHPUnit\Framework\TestCase;

class ItemTest extends TestCase
{
    public function testInstanceOf()
    {
        $item = $this->createClassObject();
        $this->assertInstanceOf(Item::class, $item);
    }

    public function testGetId()
    {
        $item = $this->createClassObject();
        $item->setId(5);
        $this->assertEquals(5, $item->getId());
    }

    public function testGetDescription()
    {
        $item = $this->createClassObject();
        $item->setDescription('test description');
        $this->assertEquals('test description', $item->getDescription());
    }

    public function testGetPrice()
    {
        $item = $this->createClassObject();
        $item->setPrice(10.0);
        $this->assertEquals(10.0, $item->getPrice());
    }

    public function testGetQuantity()
    {
        $item = $this->createClassObject();
        $item->setQuantity(5);
        $this->assertEquals(5, $item->getQuantity());
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
        $this->objectSetters($item);

        $itemArray = $item->toArray();

        $this->assertNotNull($itemArray);
        $this->assertIsArray($itemArray);

        $this->assertArrayHasKey('id', $itemArray);
        $this->assertArrayHasKey('description', $itemArray);
        $this->assertArrayHasKey('price', $itemArray);
        $this->assertArrayHasKey('quantity', $itemArray);

        $this->assertEquals($itemArray['id'], 1);
        $this->assertEquals($itemArray['description'], 'description');
        $this->assertEquals($itemArray['price'], 1.2);
        $this->assertEquals($itemArray['quantity'], 1);
    }

    private function createClassObject()
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