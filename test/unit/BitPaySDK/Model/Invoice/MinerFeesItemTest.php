<?php

namespace BitPaySDK\Test\Model\Invoice;

use BitPaySDK\Model\Invoice\MinerFeesItem;
use PHPUnit\Framework\TestCase;

class MinerFeesItemTest extends TestCase
{
    public function testInstanceOf()
    {
        $minerFeesItem = $this->createClassObject();
        self::assertInstanceOf(MinerFeesItem::class, $minerFeesItem);
    }

    public function testGetSatoshisPerByte()
    {
        $expectedSatoshiPerByte = 1.1;

        $minerFeesItem = $this->createClassObject();
        $minerFeesItem->setSatoshisPerByte($expectedSatoshiPerByte);
        self::assertEquals($expectedSatoshiPerByte, $minerFeesItem->getSatoshisPerByte());
    }

    public function testGetTotalFee()
    {
        $expectedTotalFee = 1.1;

        $minerFeesItem = $this->createClassObject();
        $minerFeesItem->setTotalFee($expectedTotalFee);
        self::assertEquals($expectedTotalFee, $minerFeesItem->getTotalFee());
    }

    public function testGetFiatAmount()
    {
        $expectedFiatAmount = 1.1;

        $minerFeesItem = $this->createClassObject();
        $minerFeesItem->setFiatAmount($expectedFiatAmount);
        self::assertEquals($expectedFiatAmount, $minerFeesItem->getFiatAmount());
    }

    public function testToArray()
    {
        $minerFeesItem = $this->createClassObject();
        $minerFeesItem->setSatoshisPerByte(1.1);
        $minerFeesItem->setTotalFee(1.1);
        $minerFeesItem->setFiatAmount(null);

        $minerFeesItemArray = $minerFeesItem->toArray();

        self::assertNotNull($minerFeesItemArray);
        self::assertIsArray($minerFeesItemArray);

        self::assertArrayHasKey('satoshisPerByte', $minerFeesItemArray);
        self::assertArrayHasKey('totalFee', $minerFeesItemArray);
        self::assertArrayNotHasKey('fiatAmount', $minerFeesItemArray);

        self::assertEquals(1.1, $minerFeesItemArray['satoshisPerByte']);
        self::assertEquals(1.1, $minerFeesItemArray['totalFee']);
    }

    private function createClassObject(): MinerFeesItem
    {
        return new MinerFeesItem();
    }
}
