<?php

namespace BitPaySDK\Test\Model\Ledger;

use BitPaySDK\Model\Ledger\Buyer;
use PHPUnit\Framework\TestCase;

class BuyerTest extends TestCase
{
    public function testInstanceOf(): void
    {
        $buyer = $this->createClassObject();
        self::assertInstanceOf(Buyer::class, $buyer);
    }

    public function testModifyBuyerName(): void
    {
        $expectedName = 'Test Name';

        $buyer = $this->createClassObject();
        $buyer->setBuyerName($expectedName);
        self::assertEquals($expectedName, $buyer->getBuyerName());
    }

    public function testModifyBuyerAddress1(): void
    {
        $expectedAddress1 = 'Address 1';

        $buyer = $this->createClassObject();
        $buyer->setBuyerAddress1($expectedAddress1);
        self::assertEquals($expectedAddress1, $buyer->getBuyerAddress1());
    }

    public function testModifyBuyerAddress2(): void
    {
        $expectedAddress2 = 'Address 2';

        $buyer = $this->createClassObject();
        $buyer->setBuyerAddress2($expectedAddress2);
        self::assertEquals($expectedAddress2, $buyer->getBuyerAddress2());
    }

    public function testModifyBuyerCity(): void
    {
        $expectedCity = 'Miami';

        $buyer = $this->createClassObject();
        $buyer->setBuyerCity($expectedCity);
        self::assertEquals($expectedCity, $buyer->getBuyerCity());
    }

    public function testModifyBuyerState(): void
    {
        $expectedState = 'AB';

        $buyer = $this->createClassObject();
        $buyer->setBuyerState($expectedState);
        self::assertEquals($expectedState, $buyer->getBuyerState());
    }

    public function testModifyBuyerZip(): void
    {
        $expectedZip = '12345';

        $buyer = $this->createClassObject();
        $buyer->setBuyerZip($expectedZip);
        self::assertEquals($expectedZip, $buyer->getBuyerZip());
    }

    public function testModifyBuyerCountry(): void
    {
        $expectedCountry = 'Canada';

        $buyer = $this->createClassObject();
        $buyer->setBuyerCountry($expectedCountry);
        self::assertEquals($expectedCountry, $buyer->getBuyerCountry());
    }

    public function testModifyBuyerEmail(): void
    {
        $expectedEmail = 'test@email.com';

        $buyer = $this->createClassObject();
        $buyer->setBuyerEmail($expectedEmail);
        self::assertEquals($expectedEmail, $buyer->getBuyerEmail());
    }

    public function testModifyBuyerPhone(): void
    {
        $expectedPhone = '123456789';

        $buyer = $this->createClassObject();
        $buyer->setBuyerPhone($expectedPhone);
        self::assertEquals($expectedPhone, $buyer->getBuyerPhone());
    }

    public function testModifyBuyerNotify(): void
    {
        $buyer = $this->createClassObject();
        $buyer->setBuyerNotify(true);
        self::assertTrue($buyer->getBuyerNotify());

        $buyer->setBuyerNotify(false);
        self::assertFalse($buyer->getBuyerNotify());
    }

    public function testToArray(): void
    {
        $buyer = $this->createClassObject();
        $this->setSetters($buyer);

        $buyerArray = $buyer->toArray();

        self::assertNotNull($buyerArray);
        self::assertIsArray($buyerArray);

        self::assertArrayHasKey('buyerName', $buyerArray);
        self::assertArrayHasKey('buyerAddress1', $buyerArray);
        self::assertArrayHasKey('buyerAddress2', $buyerArray);
        self::assertArrayHasKey('buyerCity', $buyerArray);
        self::assertArrayHasKey('buyerState', $buyerArray);
        self::assertArrayHasKey('buyerZip', $buyerArray);
        self::assertArrayHasKey('buyerCountry', $buyerArray);
        self::assertArrayHasKey('buyerPhone', $buyerArray);
        self::assertArrayHasKey('buyerNotify', $buyerArray);
        self::assertArrayHasKey('buyerEmail', $buyerArray);

        self::assertEquals('TestName', $buyerArray['buyerName']);
        self::assertEquals('Address1', $buyerArray['buyerAddress1']);
        self::assertEquals('Address2', $buyerArray['buyerAddress2']);
        self::assertEquals('Miami', $buyerArray['buyerCity']);
        self::assertEquals('AB', $buyerArray['buyerState']);
        self::assertEquals('12345', $buyerArray['buyerZip']);
        self::assertEquals('USA', $buyerArray['buyerCountry']);
        self::assertEquals('123456789', $buyerArray['buyerPhone']);
        self::assertTrue($buyerArray['buyerNotify']);
        self::assertEquals('test@email.com', $buyerArray['buyerEmail']);
    }

    private function createClassObject(): Buyer
    {
        return new Buyer();
    }

    private function setSetters(Buyer $buyer)
    {
        $buyer->setBuyerName('TestName');
        $buyer->setBuyerAddress1('Address1');
        $buyer->setBuyerAddress2('Address2');
        $buyer->setBuyerCity('Miami');
        $buyer->setBuyerState('AB');
        $buyer->setBuyerZip('12345');
        $buyer->setBuyerCountry('USA');
        $buyer->setBuyerPhone('123456789');
        $buyer->setBuyerNotify(true);
        $buyer->setBuyerEmail('test@email.com');
    }
}