<?php

namespace BitPaySDK\Test\Model\Invoice;

use BitPaySDK\Model\Invoice\MinerFeesItem;
use PHPUnit\Framework\TestCase;

class MinerFeesItemTest extends TestCase
{
    public function testInstanceOf()
    {
        $minerFeesItem = $this->createClassObject();
        $this->assertInstanceOf(MinerFeesItem::class, $minerFeesItem);
    }

    public function testGetSatoshisPerByte()
    {
        $expectedSatoshiPerByte = 1.1;

        $minerFeesItem = $this->createClassObject();
        $minerFeesItem->setSatoshisPerByte($expectedSatoshiPerByte);
        $this->assertEquals($expectedSatoshiPerByte, $minerFeesItem->getSatoshisPerByte());
    }

    public function testGetTotalFee()
    {
        $expectedTotalFee = 1.1;

        $minerFeesItem = $this->createClassObject();
        $minerFeesItem->setTotalFee($expectedTotalFee);
        $this->assertEquals($expectedTotalFee, $minerFeesItem->getTotalFee());
    }

    public function testGetFiatAmount()
    {
        $expectedFiatAmount = 1.1;

        $minerFeesItem = $this->createClassObject();
        $minerFeesItem->setFiatAmount($expectedFiatAmount);
        $this->assertEquals($expectedFiatAmount, $minerFeesItem->getFiatAmount());
    }

    public function testToArray()
    {
        $minerFeesItem = $this->createClassObject();
        $minerFeesItem->setSatoshisPerByte(1.1);
        $minerFeesItem->setTotalFee(1.1);
        $minerFeesItem->setFiatAmount(null);

        $minerFeesItemArray = $minerFeesItem->toArray();

        $this->assertNotNull($minerFeesItemArray);
        $this->assertIsArray($minerFeesItemArray);

        $this->assertArrayHasKey('satoshisPerByte', $minerFeesItemArray);
        $this->assertArrayHasKey('totalFee', $minerFeesItemArray);
        $this->assertArrayNotHasKey('fiatAmount', $minerFeesItemArray);

        $this->assertEquals($minerFeesItemArray['satoshisPerByte'], 1.1);
        $this->assertEquals($minerFeesItemArray['totalFee'], 1.1);
    }

    private function createClassObject()
    {
        return new MinerFeesItem();
    }
}
