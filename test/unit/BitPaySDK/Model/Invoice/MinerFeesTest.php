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
        self::assertInstanceOf(MinerFees::class, $minesFees);
    }

    public function testGetBTC()
    {
        $expectedBTC = $this->getMockBuilder(MinerFeesItem::class)->getMock();

        $minesFees = $this->createClassObject();
        $minesFees->setBTC($expectedBTC);
        self::assertEquals($expectedBTC, $minesFees->getBTC());
    }

    public function testGetBCH()
    {
        $expectedBCH = $this->getMockBuilder(MinerFeesItem::class)->getMock();

        $minesFees = $this->createClassObject();
        $minesFees->setBCH($expectedBCH);
        self::assertEquals($expectedBCH, $minesFees->getBCH());
    }

    public function testGetETH()
    {
        $expectedETH = $this->getMockBuilder(MinerFeesItem::class)->getMock();

        $minesFees = $this->createClassObject();
        $minesFees->setETH($expectedETH);
        self::assertEquals($expectedETH, $minesFees->getETH());
    }

    public function testGetUSDC()
    {
        $expectedUSDC = $this->getMockBuilder(MinerFeesItem::class)->getMock();

        $minesFees = $this->createClassObject();
        $minesFees->setUSDC($expectedUSDC);
        self::assertEquals($expectedUSDC, $minesFees->getUSDC());
    }

    public function testGetGUSD()
    {
        $expectedGUSD = $this->getMockBuilder(MinerFeesItem::class)->getMock();

        $minesFees = $this->createClassObject();
        $minesFees->setGUSD($expectedGUSD);
        self::assertEquals($expectedGUSD, $minesFees->getGUSD());
    }

    public function testGetPAX()
    {
        $expectedPAX = $this->getMockBuilder(MinerFeesItem::class)->getMock();

        $minesFees = $this->createClassObject();
        $minesFees->setPAX($expectedPAX);
        self::assertEquals($expectedPAX, $minesFees->getPAX());
    }

    public function testGetBUSD()
    {
        $expectedBUSD = $this->getMockBuilder(MinerFeesItem::class)->getMock();

        $minesFees = $this->createClassObject();
        $minesFees->setBUSD($expectedBUSD);
        self::assertEquals($expectedBUSD, $minesFees->getBUSD());
    }

    public function testGetXRP()
    {
        $expectedXRP = $this->getMockBuilder(MinerFeesItem::class)->getMock();

        $minesFees = $this->createClassObject();
        $minesFees->setXRP($expectedXRP);
        self::assertEquals($expectedXRP, $minesFees->getXRP());
    }

    public function testGetDOGE()
    {
        $expectedDOGE = $this->getMockBuilder(MinerFeesItem::class)->getMock();

        $minesFees = $this->createClassObject();
        $minesFees->setDOGE($expectedDOGE);
        self::assertEquals($expectedDOGE, $minesFees->getDOGE());
    }

    public function testGetLTC()
    {
        $expectedLTC = $this->getMockBuilder(MinerFeesItem::class)->getMock();

        $minesFees = $this->createClassObject();
        $minesFees->setLTC($expectedLTC);
        self::assertEquals($expectedLTC, $minesFees->getLTC());
    }

    public function testToArray()
    {
        $expectedMinerFeesItem = $this->getMockBuilder(MinerFeesItem::class)->getMock();
        $expectedMinerFeesItem->expects(self::once())->method('toArray')->willReturn(['satoshisPerByte' => 1.1, 'totalFee' => 1.1, 'fiatAmount' => 1.1]);
        $minesFees = $this->createClassObject();
        $minesFees->setBTC($expectedMinerFeesItem);
        $minesFeesArray = $minesFees->toArray();

        self::assertNotNull($minesFeesArray);
        self::assertIsArray($minesFeesArray);

        self::assertArrayHasKey('btc', $minesFeesArray);
        self::assertArrayNotHasKey('bch', $minesFeesArray);
        self::assertEquals(['btc' => ['satoshisPerByte' => 1.1,  'totalFee' => 1.1, 'fiatAmount' => 1.1]], $minesFeesArray);
    }

    public function testToArrayEmptyKey()
    {
        $minesFees = $this->createClassObject();

        $minesFeesArray = $minesFees->toArray();

        self::assertNotNull($minesFeesArray);
        self::assertIsArray($minesFeesArray);

        self::assertArrayNotHasKey('btc', $minesFeesArray);
    }

    private function createClassObject(): MinerFees
    {
        return new MinerFees();
    }
}
