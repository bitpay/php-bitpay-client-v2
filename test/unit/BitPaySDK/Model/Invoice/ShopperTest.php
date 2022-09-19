<?php

namespace BitPaySDK\Test\Model\Invoice;

use BitPaySDK\Model\Invoice\Shopper;
use PHPUnit\Framework\TestCase;

class ShopperTest extends TestCase
{
    public function testInstanceOf()
    {
        $shopper = $this->createClassObject();
        $this->assertInstanceOf(Shopper::class, $shopper);
    }

    public function testGetUser()
    {
        $expectedUser = 'Test user';

        $shopper = $this->createClassObject();
        $shopper->setUser($expectedUser);
        $this->assertEquals($expectedUser, $shopper->getUser());
    }

    public function testToArray()
    {
        $shopper = $this->createClassObject();
        $shopper->setUser('Test user');
        $shopperArray = $shopper->toArray();

        $this->assertNotNull($shopperArray);
        $this->assertIsArray($shopperArray);

        $this->assertArrayHasKey('user', $shopperArray);
        $this->assertEquals($shopperArray['user'], 'Test user');
    }

    public function testToArrayEmptyUser()
    {
        $shopper = $this->createClassObject();
        $shopperArray = $shopper->toArray();
        $this->assertArrayNotHasKey('user', $shopperArray);
    }

    private function createClassObject()
    {
        return new Shopper();
    }
}