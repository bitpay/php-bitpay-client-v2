<?php

/**
 * Copyright (c) 2025 BitPay
 **/

declare(strict_types=1);

namespace BitPaySDK\Test\Unit\Model\Subscription;

use BitPaySDK\Model\Bill\Item;
use PHPUnit\Framework\TestCase;

class ItemTest extends TestCase
{
    public function testInstanceOf(): void
    {
        $item = new Item();
        $this->assertInstanceOf(Item::class, $item);
    }

    public function testPriceGetterSetter(): void
    {
        $item = new Item();
        $item->setPrice(10.5);
        $this->assertEquals(10.5, $item->getPrice());
    }

    public function testQuantityGetterSetter(): void
    {
        $item = new Item();
        $item->setQuantity(5);
        $this->assertEquals(5, $item->getQuantity());
    }

    public function testDescriptionGetterSetter(): void
    {
        $item = new Item();
        $item->setDescription('Test Item');
        $this->assertEquals('Test Item', $item->getDescription());
    }

    public function testToArray(): void
    {
        $item = new Item();
        $item->setPrice(10.5);
        $item->setQuantity(5);
        $item->setDescription('Test Item');

        $result = $item->toArray();

        $this->assertArrayHasKey('price', $result);
        $this->assertArrayHasKey('quantity', $result);
        $this->assertArrayHasKey('description', $result);
        $this->assertEquals(10.5, $result['price']);
        $this->assertEquals(5, $result['quantity']);
        $this->assertEquals('Test Item', $result['description']);
    }
}
