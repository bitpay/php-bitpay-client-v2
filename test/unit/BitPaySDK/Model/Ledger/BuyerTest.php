<?php

namespace BitPaySDK\Test\Model\Ledger;

use BitPaySDK\Model\Ledger\Buyer;
use PHPUnit\Framework\TestCase;

class BuyerTest extends TestCase
{
    public function testInstanceOf()
    {
        $buyer = $this->createClassObject();
        self::assertInstanceOf(Buyer::class, $buyer);
    }

    public function testGetName()
    {
        $expectedName = 'Test Name';

        $buyer = $this->createClassObject();
        $buyer->setName($expectedName);
        self::assertEquals($expectedName, $buyer->getName());
    }

    public function testGetAddress1()
    {
        $expectedAddress1 = 'Address 1';

        $buyer = $this->createClassObject();
        $buyer->setAddress1($expectedAddress1);
        self::assertEquals($expectedAddress1, $buyer->getAddress1());
    }

    public function testGetAddress2()
    {
        $expectedAddress2 = 'Address 2';

        $buyer = $this->createClassObject();
        $buyer->setAddress2($expectedAddress2);
        self::assertEquals($expectedAddress2, $buyer->getAddress2());
    }

    public function testGetCity()
    {
        $expectedCity = 'Miami';

        $buyer = $this->createClassObject();
        $buyer->setCity($expectedCity);
        self::assertEquals($expectedCity, $buyer->getCity());
    }

    public function testGetState()
    {
        $expectedState = 'AB';

        $buyer = $this->createClassObject();
        $buyer->setState($expectedState);
        self::assertEquals($expectedState, $buyer->getState());
    }

    public function testGetZip()
    {
        $expectedZip = '12345';

        $buyer = $this->createClassObject();
        $buyer->setZip($expectedZip);
        self::assertEquals($expectedZip, $buyer->getZip());
    }

    public function testGetCountry()
    {
        $expectedCountry = 'Canada';

        $buyer = $this->createClassObject();
        $buyer->setCountry($expectedCountry);
        self::assertEquals($expectedCountry, $buyer->getCountry());
    }

    public function testGetEmail()
    {
        $expectedEmail = 'test@email.com';

        $buyer = $this->createClassObject();
        $buyer->setEmail($expectedEmail);
        self::assertEquals($expectedEmail, $buyer->getEmail());
    }

    public function testGetPhone()
    {
        $expectedPhone = '123456789';

        $buyer = $this->createClassObject();
        $buyer->setPhone($expectedPhone);
        self::assertEquals($expectedPhone, $buyer->getPhone());
    }

    public function testGetNotify()
    {
        $buyer = $this->createClassObject();
        $buyer->setNotify(true);
        self::assertTrue($buyer->getNotify());

        $buyer->setNotify(false);
        self::assertFalse($buyer->getNotify());
    }

    public function testToArray()
    {
        $buyer = $this->createClassObject();
        $this->setSetters($buyer);

        $buyerArray = $buyer->toArray();

        self::assertNotNull($buyerArray);
        self::assertIsArray($buyerArray);

        self::assertArrayHasKey('name', $buyerArray);
        self::assertArrayHasKey('address1', $buyerArray);
        self::assertArrayHasKey('address2', $buyerArray);
        self::assertArrayHasKey('city', $buyerArray);
        self::assertArrayHasKey('state', $buyerArray);
        self::assertArrayHasKey('zip', $buyerArray);
        self::assertArrayHasKey('country', $buyerArray);
        self::assertArrayHasKey('phone', $buyerArray);
        self::assertArrayHasKey('notify', $buyerArray);
        self::assertArrayHasKey('email', $buyerArray);

        self::assertEquals('TestName', $buyerArray['name']);
        self::assertEquals('Address1', $buyerArray['address1']);
        self::assertEquals('Address2', $buyerArray['address2']);
        self::assertEquals('Miami', $buyerArray['city']);
        self::assertEquals('AB', $buyerArray['state']);
        self::assertEquals('12345', $buyerArray['zip']);
        self::assertEquals('USA', $buyerArray['country']);
        self::assertEquals('123456789', $buyerArray['phone']);
        self::assertTrue($buyerArray['notify']);
        self::assertEquals('test@email.com', $buyerArray['email']);
    }

    private function createClassObject(): Buyer
    {
        return new Buyer();
    }

    private function setSetters(Buyer $buyer)
    {
        $buyer->setName('TestName');
        $buyer->setAddress1('Address1');
        $buyer->setAddress2('Address2');
        $buyer->setCity('Miami');
        $buyer->setState('AB');
        $buyer->setZip('12345');
        $buyer->setCountry('USA');
        $buyer->setPhone('123456789');
        $buyer->setNotify(true);
        $buyer->setEmail('test@email.com');
    }
}