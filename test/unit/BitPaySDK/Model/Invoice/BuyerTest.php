<?php

namespace BitPaySDK\Test\Model\Invoice;

use BitPaySDK\Model\Invoice\Buyer;
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
        $expectedName = 'Test name';

        $buyer = $this->createClassObject();
        $buyer->setName($expectedName);
        $this->assertEquals($expectedName, $buyer->getName());
    }

    public function testGetAddress1()
    {
        $expectedAddress1 = 'Test address 1';

        $buyer = $this->createClassObject();
        $buyer->setAddress1($expectedAddress1);
        $this->assertEquals($expectedAddress1, $buyer->getAddress1());
    }

    public function testGetAddress2()
    {
        $expectedAddress2 = 'Test address 2';

        $buyer = $this->createClassObject();
        $buyer->setAddress2($expectedAddress2);
        $this->assertEquals($expectedAddress2, $buyer->getAddress2());
    }

    public function testGetLocality()
    {
        $expectedLocality = 'Tavares';

        $buyer = $this->createClassObject();
        $buyer->setLocality($expectedLocality);
        $this->assertEquals($expectedLocality, $buyer->getLocality());
    }

    public function testGetRegion()
    {
        $expectedRegion = 'Test region';

        $buyer = $this->createClassObject();
        $buyer->setRegion($expectedRegion);
        $this->assertEquals($expectedRegion, $buyer->getRegion());
    }

    public function testGetPostalCode()
    {
        $expectedPostalCode = '12345';

        $buyer = $this->createClassObject();
        $buyer->setPostalCode($expectedPostalCode);
        $this->assertEquals($expectedPostalCode, $buyer->getPostalCode());
    }

    public function testGetCountry()
    {
        $expectedCountry = 'USA';

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
        $this->assertArrayHasKey('locality', $buyerArray);
        $this->assertArrayHasKey('region', $buyerArray);
        $this->assertArrayHasKey('postalCode', $buyerArray);
        $this->assertArrayHasKey('country', $buyerArray);
        $this->assertArrayHasKey('email', $buyerArray);
        $this->assertArrayHasKey('phone', $buyerArray);
        $this->assertArrayHasKey('notify', $buyerArray);

        $this->assertEquals($buyerArray['name'], 'Test name');
        $this->assertEquals($buyerArray['address1'], 'Address 1');
        $this->assertEquals($buyerArray['address2'], 'Address 2');
        $this->assertEquals($buyerArray['locality'], 'Tavares');
        $this->assertEquals($buyerArray['region'], 'Test region');
        $this->assertEquals($buyerArray['postalCode'], '12345');
        $this->assertEquals($buyerArray['country'], 'USA');
        $this->assertEquals($buyerArray['email'], 'test@email.com');
        $this->assertEquals($buyerArray['phone'], '123456789');
        $this->assertTrue($buyerArray['notify']);
    }

    public function testToArrayEmptyKey()
    {
        $buyer = $this->createClassObject();

        $buyerArray = $buyer->toArray();

        $this->assertNotNull($buyerArray);
        $this->assertIsArray($buyerArray);

        $this->assertArrayNotHasKey('name', $buyerArray);
    }

    private function createClassObject()
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
