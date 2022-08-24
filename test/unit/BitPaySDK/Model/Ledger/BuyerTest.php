<?php

namespace BitPaySDK\Test\Model\Ledger;

use BitPaySDK\Model\Ledger\Buyer;
use PHPUnit\Framework\TestCase;

class BuyerTest extends TestCase
{
    public function testInstanceOf()
    {
        $buyer = $this->createClassObject();
        $this->assertInstanceOf(Buyer::class, $buyer);
    }

    public function testGetName()
    {
        $expectedName = 'Test Name';

        $buyer = $this->createClassObject();
        $buyer->setName($expectedName);
        $this->assertEquals($expectedName, $buyer->getName());
    }

    public function testGetAddress1()
    {
        $expectedAddress1 = 'Address 1';

        $buyer = $this->createClassObject();
        $buyer->setAddress1($expectedAddress1);
        $this->assertEquals($expectedAddress1, $buyer->getAddress1());
    }

    public function testGetAddress2()
    {
        $expectedAddress2 = 'Address 2';

        $buyer = $this->createClassObject();
        $buyer->setAddress2($expectedAddress2);
        $this->assertEquals($expectedAddress2, $buyer->getAddress2());
    }

    public function testGetCity()
    {
        $expectedCity = 'Miami';

        $buyer = $this->createClassObject();
        $buyer->setCity($expectedCity);
        $this->assertEquals($expectedCity, $buyer->getCity());
    }

    public function testGetState()
    {
        $expectedState = 'AB';

        $buyer = $this->createClassObject();
        $buyer->setState($expectedState);
        $this->assertEquals($expectedState, $buyer->getState());
    }

    public function testGetZip()
    {
        $expectedZip = '12345';

        $buyer = $this->createClassObject();
        $buyer->setZip($expectedZip);
        $this->assertEquals($expectedZip, $buyer->getZip());
    }

    public function testGetCountry()
    {
        $expectedCountry = 'Canada';

        $buyer = $this->createClassObject();
        $buyer->setCountry($expectedCountry);
        $this->assertEquals($expectedCountry, $buyer->getCountry());
    }

    public function testGetEmail()
    {
        $expectedEmail = 'test@email.com';

        $buyer = $this->createClassObject();
        $buyer->setEmail($expectedEmail);
        $this->assertEquals($expectedEmail, $buyer->getEmail());
    }

    public function testGetPhone()
    {
        $expectedPhone = '123456789';

        $buyer = $this->createClassObject();
        $buyer->setPhone($expectedPhone);
        $this->assertEquals($expectedPhone, $buyer->getPhone());
    }

    public function testGetNotify()
    {
        $buyer = $this->createClassObject();
        $buyer->setNotify(true);
        $this->assertTrue($buyer->getNotify());

        $buyer->setNotify(false);
        $this->assertFalse($buyer->getNotify());
    }

    public function testToArray()
    {
        $buyer = $this->createClassObject();
        $this->setSetters($buyer);

        $buyerArray = $buyer->toArray();

        $this->assertNotNull($buyerArray);
        $this->assertIsArray($buyerArray);

        $this->assertArrayHasKey('name', $buyerArray);
        $this->assertArrayHasKey('address1', $buyerArray);
        $this->assertArrayHasKey('address2', $buyerArray);
        $this->assertArrayHasKey('city', $buyerArray);
        $this->assertArrayHasKey('state', $buyerArray);
        $this->assertArrayHasKey('zip', $buyerArray);
        $this->assertArrayHasKey('country', $buyerArray);
        $this->assertArrayHasKey('phone', $buyerArray);
        $this->assertArrayHasKey('notify', $buyerArray);
        $this->assertArrayHasKey('email', $buyerArray);

        $this->assertEquals($buyerArray['name'], 'TestName');
        $this->assertEquals($buyerArray['address1'], 'Address1');
        $this->assertEquals($buyerArray['address2'], 'Address2');
        $this->assertEquals($buyerArray['city'], 'Miami');
        $this->assertEquals($buyerArray['state'], 'AB');
        $this->assertEquals($buyerArray['zip'], '12345');
        $this->assertEquals($buyerArray['country'], 'USA');
        $this->assertEquals($buyerArray['phone'], '123456789');
        $this->assertTrue($buyerArray['notify']);
        $this->assertEquals($buyerArray['email'], 'test@email.com');
    }

    private function createClassObject()
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