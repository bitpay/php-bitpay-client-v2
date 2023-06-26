<?php

namespace BitPaySDK\Test\Model\Invoice;

use BitPaySDK\Model\Invoice\Shopper;
use PHPUnit\Framework\TestCase;

class ShopperTest extends TestCase
{
    public function testInstanceOf()
    {
        $shopper = $this->createClassObject();
        self::assertInstanceOf(Shopper::class, $shopper);
    }

    public function testGetUser()
    {
        $expectedUser = 'Test user';

        $shopper = $this->createClassObject();
        $shopper->setUser($expectedUser);
        self::assertEquals($expectedUser, $shopper->getUser());
    }

    public function testToArray()
    {
        $shopper = $this->createClassObject();
        $shopper->setUser('Test user');
        $shopperArray = $shopper->toArray();

        self::assertNotNull($shopperArray);
        self::assertIsArray($shopperArray);

        self::assertArrayHasKey('user', $shopperArray);
        self::assertEquals('Test user', $shopperArray['user']);
    }

    public function testToArrayEmptyUser()
    {
        $shopper = $this->createClassObject();
        $shopperArray = $shopper->toArray();
        self::assertArrayNotHasKey('user', $shopperArray);
    }

    private function createClassObject(): Shopper
    {
        return new Shopper();
    }
}