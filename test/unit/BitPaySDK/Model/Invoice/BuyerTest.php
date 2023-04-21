<?php

namespace BitPaySDK\Test\Model\Invoice;

use BitPaySDK\Model\Invoice\Buyer;
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
        $expectedName = 'Test name';

        $buyer = $this->createClassObject();
        $buyer->setName($expectedName);
        self::assertEquals($expectedName, $buyer->getName());
    }

    public function testGetAddress1()
    {
        $expectedAddress1 = 'Test address 1';

        $buyer = $this->createClassObject();
        $buyer->setAddress1($expectedAddress1);
        self::assertEquals($expectedAddress1, $buyer->getAddress1());
    }

    public function testGetAddress2()
    {
        $expectedAddress2 = 'Test address 2';

        $buyer = $this->createClassObject();
        $buyer->setAddress2($expectedAddress2);
        self::assertEquals($expectedAddress2, $buyer->getAddress2());
    }

    public function testGetLocality()
    {
        $expectedLocality = 'Tavares';

        $buyer = $this->createClassObject();
        $buyer->setLocality($expectedLocality);
        self::assertEquals($expectedLocality, $buyer->getLocality());
    }

    public function testGetRegion()
    {
        $expectedRegion = 'Test region';

        $buyer = $this->createClassObject();
        $buyer->setRegion($expectedRegion);
        self::assertEquals($expectedRegion, $buyer->getRegion());
    }

    public function testGetPostalCode()
    {
        $expectedPostalCode = '12345';

        $buyer = $this->createClassObject();
        $buyer->setPostalCode($expectedPostalCode);
        self::assertEquals($expectedPostalCode, $buyer->getPostalCode());
    }

    public function testGetCountry()
    {
        $expectedCountry = 'USA';

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
        self::assertArrayHasKey('locality', $buyerArray);
        self::assertArrayHasKey('region', $buyerArray);
        self::assertArrayHasKey('postalCode', $buyerArray);
        self::assertArrayHasKey('country', $buyerArray);
        self::assertArrayHasKey('email', $buyerArray);
        self::assertArrayHasKey('phone', $buyerArray);
        self::assertArrayHasKey('notify', $buyerArray);

        self::assertEquals('Test name', $buyerArray['name']);
        self::assertEquals('Address 1', $buyerArray['address1']);
        self::assertEquals('Address 2', $buyerArray['address2']);
        self::assertEquals('Tavares', $buyerArray['locality']);
        self::assertEquals('Test region', $buyerArray['region']);
        self::assertEquals('12345', $buyerArray['postalCode']);
        self::assertEquals('USA', $buyerArray['country']);
        self::assertEquals('test@email.com', $buyerArray['email']);
        self::assertEquals('123456789', $buyerArray['phone']);
        self::assertTrue($buyerArray['notify']);
    }

    public function testToArrayEmptyKey()
    {
        $buyer = $this->createClassObject();

        $buyerArray = $buyer->toArray();

        self::assertNotNull($buyerArray);
        self::assertIsArray($buyerArray);

        self::assertArrayNotHasKey('name', $buyerArray);
    }

    private function createClassObject(): Buyer
    {
        return new Buyer();
    }

    private function setSetters(Buyer $buyer)
    {
        $buyer->setName('Test name');
        $buyer->setAddress1('Address 1');
        $buyer->setAddress2('Address 2');
        $buyer->setLocality('Tavares');
        $buyer->setRegion('Test region');
        $buyer->setPostalCode('12345');
        $buyer->setCountry('USA');
        $buyer->setEmail('test@email.com');
        $buyer->setPhone('123456789');
        $buyer->setNotify(true);
    }
}
