<?php

namespace BitPaySDK\Test\Model\Bill;

use BitPaySDK\Model\Bill\Bill;
use BitPaySDK\Model\Bill\Item;
use PHPUnit\Framework\TestCase;

class BillTest extends TestCase
{
    public function testInstanceOf()
    {
        $bill = $this->createClassObject();
        $this->assertInstanceOf(Bill::class, $bill);
    }

    public function testGetToken()
    {
        $expectedToken = 'abcd123';

        $bill = $this->createClassObject();
        $bill->setToken($expectedToken);
        $this->assertEquals($expectedToken, $bill->getToken());
    }

    public function testGetCurrency()
    {
        $expectedCurrency = 'BTC';

        $bill = $this->createClassObject();
        $bill->setCurrency($expectedCurrency);
        $this->assertEquals($expectedCurrency, $bill->getCurrency());
    }

    public function testGetEmail()
    {
        $expectedEmail = 'test@test.com';

        $bill = $this->createClassObject();
        $bill->setEmail($expectedEmail);
        $this->assertEquals($expectedEmail, $bill->getEmail());
    }

    public function testSetItems()
    {
        $bill = $this->createClassObject();
        $arrayWithoutObject = ['test' => 'gd'];

        $createdObject = Item::createFromArray($arrayWithoutObject);
        $testArray = [new Item(), $createdObject];

        $bill->setItems($testArray);

        $this->assertEquals($testArray, $bill->getItems());
    }

    public function testGetNumber()
    {
        $expectedNumber = '12';

        $bill = $this->createClassObject();
        $bill->setNumber($expectedNumber);
        $this->assertEquals($expectedNumber, $bill->getNumber());
    }

    public function testGetName()
    {
        $expectedName = 'TestName';

        $bill = $this->createClassObject();
        $bill->setName($expectedName);
        $this->assertEquals($expectedName,  $bill->getName());
    }

    public function testGetAddress1()
    {
        $expectedAddress = 'Address1';

        $bill = $this->createClassObject();
        $bill->setAddress1($expectedAddress);
        $this->assertEquals($expectedAddress, $bill->getAddress1());
    }

    public function testGetAddress2()
    {
        $expectedAddress2 = 'Address2';

        $bill = $this->createClassObject();
        $bill->setAddress2($expectedAddress2);
        $this->assertEquals($expectedAddress2, $bill->getAddress2());
    }

    public function testGetCity()
    {
        $expectedCity = 'Miami';

        $bill = $this->createClassObject();
        $bill->setCity($expectedCity);
        $this->assertEquals($expectedCity, $bill->getCity());
    }

    public function testGetState()
    {
        $expectedState = 'Ab';

        $bill = $this->createClassObject();
        $bill->setState($expectedState);
        $this->assertEquals($expectedState, $bill->getState());
    }

    public function testGetZip()
    {
        $expectedZip = '12345';

        $bill = $this->createClassObject();
        $bill->setZip($expectedZip);
        $this->assertEquals($expectedZip, $bill->getZip());
    }

    public function testGetCountry()
    {
        $expectedCountry = 'Canada';

        $bill = $this->createClassObject();
        $bill->setCountry($expectedCountry);
        $this->assertEquals($expectedCountry, $bill->getCountry());
    }

    public function testGetCc()
    {
        $expectedCc = [''];

        $bill = $this->createClassObject();
        $bill->setCc($expectedCc);
        $this->assertEquals($expectedCc, $bill->getCc());
    }

    public function testGetPhone()
    {
        $expectedPhone = '123456789';

        $bill = $this->createClassObject();
        $bill->setPhone($expectedPhone);
        $this->assertEquals($expectedPhone, $bill->getPhone());
    }

    public function testGetDueDate()
    {
        $expectedDueDate = '2022-01-01';

        $bill = $this->createClassObject();
        $bill->setDueDate($expectedDueDate);
        $this->assertEquals($expectedDueDate, $bill->getDueDate());
    }

    public function testGetPassProcessingFee()
    {
        $bill = $this->createClassObject();
        $bill->setPassProcessingFee(true);
        $this->assertTrue($bill->getPassProcessingFee());
    }

    public function testGetStatus()
    {
        $expectedStatus = 'status';

        $bill = $this->createClassObject();
        $bill->setStatus($expectedStatus);
        $this->assertEquals($expectedStatus, $bill->getStatus());
    }

    public function testGetUrl()
    {
        $expectedUrl = 'http://test.com';

        $bill = $this->createClassObject();
        $bill->setUrl($expectedUrl);
        $this->assertEquals($expectedUrl, $bill->getUrl());
    }

    public function testGetCreateDate()
    {
        $expectedCreateDate = '2022-01-01';

        $bill = $this->createClassObject();
        $bill->setCreateDate($expectedCreateDate);
        $this->assertEquals($expectedCreateDate, $bill->getCreateDate());
    }

    public function testGetId()
    {
        $expectedId = '1';

        $bill = $this->createClassObject();
        $bill->setId($expectedId);
        $this->assertEquals($expectedId, $bill->getId());
    }

    public function testGetMerchant()
    {
        $expectedMerchant = 'TestUser';

        $bill = $this->createClassObject();
        $bill->setMerchant($expectedMerchant);
        $this->assertEquals($expectedMerchant, $bill->getMerchant());
    }

    public function testToArray()
    {
        $bill = $this->createClassObject();
        $this->objectSetters($bill);

        $billArray = $bill->toArray();

        $this->assertNotNull($billArray);
        $this->assertIsArray($billArray);

        $this->assertArrayHasKey('currency', $billArray);
        $this->assertArrayHasKey('token', $billArray);
        $this->assertArrayHasKey('email', $billArray);
        $this->assertArrayHasKey('items', $billArray);
        $this->assertArrayHasKey('number', $billArray);
        $this->assertArrayHasKey('name', $billArray);
        $this->assertArrayHasKey('address1', $billArray);
        $this->assertArrayHasKey('address2', $billArray);
        $this->assertArrayHasKey('city', $billArray);
        $this->assertArrayHasKey('state', $billArray);
        $this->assertArrayHasKey('zip', $billArray);
        $this->assertArrayHasKey('country', $billArray);
        $this->assertArrayHasKey('cc', $billArray);
        $this->assertArrayHasKey('phone', $billArray);
        $this->assertArrayHasKey('dueDate', $billArray);
        $this->assertArrayHasKey('passProcessingFee', $billArray);
        $this->assertArrayHasKey('status', $billArray);
        $this->assertArrayHasKey('url', $billArray);
        $this->assertArrayHasKey('createDate', $billArray);
        $this->assertArrayHasKey('id', $billArray);
        $this->assertArrayHasKey('merchant', $billArray);

        $this->assertEquals($billArray['currency'], 'BTC');
        $this->assertEquals($billArray['token'], 'abcd123');
        $this->assertEquals($billArray['email'], 'test@test.com');
        $this->assertEquals($billArray['items'], [[]]);
        $this->assertEquals($billArray['number'], '12');
        $this->assertEquals($billArray['name'], 'TestName');
        $this->assertEquals($billArray['address1'], 'Address1');
        $this->assertEquals($billArray['address2'], 'Address2');
        $this->assertEquals($billArray['city'], 'Miami');
        $this->assertEquals($billArray['state'], 'AB');
        $this->assertEquals($billArray['zip'], '12345');
        $this->assertEquals($billArray['country'], 'Canada');
        $this->assertEquals($billArray['cc'], ['']);
        $this->assertEquals($billArray['phone'], '123456789');
        $this->assertEquals($billArray['dueDate'], '2022-01-01');
        $this->assertEquals($billArray['passProcessingFee'], true);
        $this->assertEquals($billArray['status'], 'status');
        $this->assertEquals($billArray['url'], 'http://test.com');
        $this->assertEquals($billArray['createDate'], '2022-01-01');
        $this->assertEquals($billArray['id'], '1');
        $this->assertEquals($billArray['merchant'], 'TestUser');
    }

    private function createClassObject()
    {
        return new Bill();
    }

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