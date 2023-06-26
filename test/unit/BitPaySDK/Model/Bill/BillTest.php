<?php

namespace BitPaySDK\Test\Model\Bill;

use BitPaySDK\Exceptions\BitPayException;
use BitPaySDK\Model\Bill\Bill;
use BitPaySDK\Model\Bill\Item;
use PHPUnit\Framework\TestCase;

class BillTest extends TestCase
{
    public function testInstanceOf()
    {
        $bill = $this->createClassObject();
        self::assertInstanceOf(Bill::class, $bill);
    }

    public function testGetToken()
    {
        $expectedToken = 'abcd123';

        $bill = $this->createClassObject();
        $bill->setToken($expectedToken);
        self::assertEquals($expectedToken, $bill->getToken());
    }

    /**
     * @throws BitPayException
     */
    public function testGetCurrency()
    {
        $expectedCurrency = 'BTC';

        $bill = $this->createClassObject();
        $bill->setCurrency($expectedCurrency);
        self::assertEquals($expectedCurrency, $bill->getCurrency());
    }

    public function testGetEmail()
    {
        $expectedEmail = 'test@test.com';

        $bill = $this->createClassObject();
        $bill->setEmail($expectedEmail);
        self::assertEquals($expectedEmail, $bill->getEmail());
    }

    public function testSetItems()
    {
        $bill = $this->createClassObject();
        $arrayWithoutObject = ['description' => 'gd'];

        $createdObject = Item::createFromArray($arrayWithoutObject);
        $testArray = [new Item(), $createdObject];

        $bill->setItems($testArray);

        self::assertEquals($testArray, $bill->getItems());
    }

    public function testGetNumber()
    {
        $expectedNumber = '12';

        $bill = $this->createClassObject();
        $bill->setNumber($expectedNumber);
        self::assertEquals($expectedNumber, $bill->getNumber());
    }

    public function testGetName()
    {
        $expectedName = 'TestName';

        $bill = $this->createClassObject();
        $bill->setName($expectedName);
        self::assertEquals($expectedName,  $bill->getName());
    }

    public function testGetAddress1()
    {
        $expectedAddress = 'Address1';

        $bill = $this->createClassObject();
        $bill->setAddress1($expectedAddress);
        self::assertEquals($expectedAddress, $bill->getAddress1());
    }

    public function testGetAddress2()
    {
        $expectedAddress2 = 'Address2';

        $bill = $this->createClassObject();
        $bill->setAddress2($expectedAddress2);
        self::assertEquals($expectedAddress2, $bill->getAddress2());
    }

    public function testGetCity()
    {
        $expectedCity = 'Miami';

        $bill = $this->createClassObject();
        $bill->setCity($expectedCity);
        self::assertEquals($expectedCity, $bill->getCity());
    }

    public function testGetState()
    {
        $expectedState = 'Ab';

        $bill = $this->createClassObject();
        $bill->setState($expectedState);
        self::assertEquals($expectedState, $bill->getState());
    }

    public function testGetZip()
    {
        $expectedZip = '12345';

        $bill = $this->createClassObject();
        $bill->setZip($expectedZip);
        self::assertEquals($expectedZip, $bill->getZip());
    }

    public function testGetCountry()
    {
        $expectedCountry = 'Canada';

        $bill = $this->createClassObject();
        $bill->setCountry($expectedCountry);
        self::assertEquals($expectedCountry, $bill->getCountry());
    }

    public function testGetCc()
    {
        $expectedCc = [''];

        $bill = $this->createClassObject();
        $bill->setCc($expectedCc);
        self::assertEquals($expectedCc, $bill->getCc());
    }

    public function testGetPhone()
    {
        $expectedPhone = '123456789';

        $bill = $this->createClassObject();
        $bill->setPhone($expectedPhone);
        self::assertEquals($expectedPhone, $bill->getPhone());
    }

    public function testGetDueDate()
    {
        $expectedDueDate = '2022-01-01';

        $bill = $this->createClassObject();
        $bill->setDueDate($expectedDueDate);
        self::assertEquals($expectedDueDate, $bill->getDueDate());
    }

    public function testGetPassProcessingFee()
    {
        $bill = $this->createClassObject();
        $bill->setPassProcessingFee(true);
        self::assertTrue($bill->getPassProcessingFee());
    }

    public function testGetStatus()
    {
        $expectedStatus = 'status';

        $bill = $this->createClassObject();
        $bill->setStatus($expectedStatus);
        self::assertEquals($expectedStatus, $bill->getStatus());
    }

    public function testGetUrl()
    {
        $expectedUrl = 'http://test.com';

        $bill = $this->createClassObject();
        $bill->setUrl($expectedUrl);
        self::assertEquals($expectedUrl, $bill->getUrl());
    }

    public function testGetCreateDate()
    {
        $expectedCreateDate = '2022-01-01';

        $bill = $this->createClassObject();
        $bill->setCreateDate($expectedCreateDate);
        self::assertEquals($expectedCreateDate, $bill->getCreateDate());
    }

    public function testGetId()
    {
        $expectedId = '1';

        $bill = $this->createClassObject();
        $bill->setId($expectedId);
        self::assertEquals($expectedId, $bill->getId());
    }

    public function testGetMerchant()
    {
        $expectedMerchant = 'TestUser';

        $bill = $this->createClassObject();
        $bill->setMerchant($expectedMerchant);
        self::assertEquals($expectedMerchant, $bill->getMerchant());
    }

    /**
     * @throws BitPayException
     */
    public function testToArray()
    {
        $bill = $this->createClassObject();
        $this->objectSetters($bill);

        $billArray = $bill->toArray();

        self::assertNotNull($billArray);
        self::assertIsArray($billArray);

        self::assertArrayHasKey('currency', $billArray);
        self::assertArrayHasKey('token', $billArray);
        self::assertArrayHasKey('email', $billArray);
        self::assertArrayHasKey('items', $billArray);
        self::assertArrayHasKey('number', $billArray);
        self::assertArrayHasKey('name', $billArray);
        self::assertArrayHasKey('address1', $billArray);
        self::assertArrayHasKey('address2', $billArray);
        self::assertArrayHasKey('city', $billArray);
        self::assertArrayHasKey('state', $billArray);
        self::assertArrayHasKey('zip', $billArray);
        self::assertArrayHasKey('country', $billArray);
        self::assertArrayHasKey('cc', $billArray);
        self::assertArrayHasKey('phone', $billArray);
        self::assertArrayHasKey('dueDate', $billArray);
        self::assertArrayHasKey('passProcessingFee', $billArray);
        self::assertArrayHasKey('status', $billArray);
        self::assertArrayHasKey('url', $billArray);
        self::assertArrayHasKey('createDate', $billArray);
        self::assertArrayHasKey('id', $billArray);
        self::assertArrayHasKey('merchant', $billArray);

        self::assertEquals('BTC', $billArray['currency']);
        self::assertEquals('abcd123', $billArray['token']);
        self::assertEquals('test@test.com', $billArray['email']);
        self::assertEquals([[]], $billArray['items']);
        self::assertEquals('12', $billArray['number']);
        self::assertEquals('TestName', $billArray['name']);
        self::assertEquals('Address1', $billArray['address1']);
        self::assertEquals('Address2', $billArray['address2']);
        self::assertEquals('Miami', $billArray['city']);
        self::assertEquals('AB', $billArray['state']);
        self::assertEquals('12345', $billArray['zip']);
        self::assertEquals('Canada', $billArray['country']);
        self::assertEquals([''], $billArray['cc']);
        self::assertEquals('123456789', $billArray['phone']);
        self::assertEquals('2022-01-01', $billArray['dueDate']);
        self::assertEquals(true, $billArray['passProcessingFee']);
        self::assertEquals('status', $billArray['status']);
        self::assertEquals('http://test.com', $billArray['url']);
        self::assertEquals('2022-01-01', $billArray['createDate']);
        self::assertEquals('1', $billArray['id']);
        self::assertEquals('TestUser', $billArray['merchant']);
    }

    private function createClassObject(): Bill
    {
        return new Bill();
    }

    /**
     * @throws BitPayException
     */
    private function objectSetters(Bill $bill): void
    {
        $bill->setCurrency('BTC');
        $bill->setToken('abcd123');
        $bill->setEmail('test@test.com');
        $bill->setItems([new Item()]);
        $bill->setNumber('12');
        $bill->setName('TestName');
        $bill->setAddress1('Address1');
        $bill->setAddress2('Address2');
        $bill->setCity('Miami');
        $bill->setState('AB');
        $bill->setZip('12345');
        $bill->setCountry('Canada');
        $bill->setCc(['']);
        $bill->setPhone('123456789');
        $bill->setDueDate('2022-01-01');
        $bill->setPassProcessingFee(true);
        $bill->setStatus('status');
        $bill->setUrl('http://test.com');
        $bill->setCreateDate('2022-01-01');
        $bill->setId('1');
        $bill->setMerchant('TestUser');
    }
}