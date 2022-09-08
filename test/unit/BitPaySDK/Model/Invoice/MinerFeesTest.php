<?php

namespace BitPaySDK\Test\Model\Invoice;

use BitPaySDK\Model\Invoice\MinerFees;
use BitPaySDK\Model\Invoice\MinerFeesItem;
use PHPUnit\Framework\TestCase;

class MinerFeesTest extends TestCase
{
    public function testInstanceOf()
    {
        $minesFees = $this->createClassObject();
        $this->assertInstanceOf(MinerFees::class, $minesFees);
    }

    public function testGetBTC()
    {
        $expectedBTC = $this->getMockBuilder(MinerFeesItem::class)->getMock();

        $minesFees = $this->createClassObject();
        $minesFees->setBTC($expectedBTC);
        $this->assertEquals($expectedBTC, $minesFees->getBTC());
    }

    public function testGetBCH()
    {
        $expectedBCH = $this->getMockBuilder(MinerFeesItem::class)->getMock();

        $minesFees = $this->createClassObject();
        $minesFees->setBCH($expectedBCH);
        $this->assertEquals($expectedBCH, $minesFees->getBCH());
    }

    public function testGetETH()
    {
        $expectedETH = $this->getMockBuilder(MinerFeesItem::class)->getMock();

        $minesFees = $this->createClassObject();
        $minesFees->setETH($expectedETH);
        $this->assertEquals($expectedETH, $minesFees->getETH());
    }

    public function testGetUSDC()
    {
        $expectedUSDC = $this->getMockBuilder(MinerFeesItem::class)->getMock();

        $minesFees = $this->createClassObject();
        $minesFees->setUSDC($expectedUSDC);
        $this->assertEquals($expectedUSDC, $minesFees->getUSDC());
    }

    public function testGetGUSD()
    {
        $expectedGUSD = $this->getMockBuilder(MinerFeesItem::class)->getMock();

        $minesFees = $this->createClassObject();
        $minesFees->setGUSD($expectedGUSD);
        $this->assertEquals($expectedGUSD, $minesFees->getGUSD());
    }

    public function testGetPAX()
    {
        $expectedPAX = $this->getMockBuilder(MinerFeesItem::class)->getMock();

        $minesFees = $this->createClassObject();
        $minesFees->setPAX($expectedPAX);
        $this->assertEquals($expectedPAX, $minesFees->getPAX());
    }

    public function testGetBUSD()
    {
        $expectedBUSD = $this->getMockBuilder(MinerFeesItem::class)->getMock();

        $minesFees = $this->createClassObject();
        $minesFees->setBUSD($expectedBUSD);
        $this->assertEquals($expectedBUSD, $minesFees->getBUSD());
    }

    public function testGetXRP()
    {
        $expectedXRP = $this->getMockBuilder(MinerFeesItem::class)->getMock();

        $minesFees = $this->createClassObject();
        $minesFees->setXRP($expectedXRP);
        $this->assertEquals($expectedXRP, $minesFees->getXRP());
    }

    public function testGetDOGE()
    {
        $expectedDOGE = $this->getMockBuilder(MinerFeesItem::class)->getMock();

        $minesFees = $this->createClassObject();
        $minesFees->setDOGE($expectedDOGE);
        $this->assertEquals($expectedDOGE, $minesFees->getDOGE());
    }

    public function testGetLTC()
    {
        $expectedLTC = $this->getMockBuilder(MinerFeesItem::class)->getMock();

        $minesFees = $this->createClassObject();
        $minesFees->setLTC($expectedLTC);
        $this->assertEquals($expectedLTC, $minesFees->getLTC());
    }

    public function testToArray()
    {
        $expectedMinerFeesItem = $this->getMockBuilder(MinerFeesItem::class)->getMock();
        $expectedMinerFeesItem->expects($this->once())->method('toArray')->willReturn(['satoshisPerByte' => 1.1, 'totalFee' => 1.1, 'fiatAmount' => 1.1]);
        $minesFees = $this->createClassObject();
        $minesFees->setBTC($expectedMinerFeesItem);
        $minesFeesArray = $minesFees->toArray();

        $this->assertNotNull($minesFeesArray);
        $this->assertIsArray($minesFeesArray);

        $this->assertArrayHasKey('btc', $minesFeesArray);
        $this->assertArrayNotHasKey('bch', $minesFeesArray);
        $this->assertEquals(['btc' => ['satoshisPerByte' => 1.1,  'totalFee' => 1.1, 'fiatAmount' => 1.1]], $minesFeesArray);
    }

    public function testToArrayEmptyKey()
    {
        $minesFees = $this->createClassObject();

        $minesFeesArray = $minesFees->toArray();

        $this->assertNotNull($minesFeesArray);
        $this->assertIsArray($minesFeesArray);

        $this->assertArrayNotHasKey('btc', $minesFeesArray);
    }

    private function createClassObject()
    {
        return new MinerFees();
    }
}
