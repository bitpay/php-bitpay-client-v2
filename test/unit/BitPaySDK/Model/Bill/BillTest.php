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
        $bill = $this->createClassObject();
        $bill->setToken('abcd123');
        $this->assertEquals('abcd123', $bill->getToken());
    }

    public function testGetCurrency()
    {
        $bill = $this->createClassObject();
        $bill->setCurrency('BTC');
        $this->assertEquals('BTC', $bill->getCurrency());
    }

    public function testGetEmail()
    {
        $bill = $this->createClassObject();
        $bill->setEmail('test@test.com');
        $this->assertEquals('test@test.com', $bill->getEmail());
    }

    public function testSetItems()
    {
        $bill = $this->createClassObject();
        $arrayWithOutObject = ['test' => 'gd'];

        $createdObject = Item::createFromArray($arrayWithOutObject);
        $testArray = [new Item(), $createdObject];

        $bill->setItems($testArray);

        $this->assertEquals($testArray, $bill->getItems());
    }

    public function testGetNumber()
    {
        $bill = $this->createClassObject();
        $bill->setNumber('12');
        $this->assertEquals('12', $bill->getNumber());
    }

    public function testGetName()
    {
        $bill = $this->createClassObject();
        $bill->setName('TestName');
        $this->assertEquals('TestName',  $bill->getName());
    }

    public function testGetAddress1()
    {
        $bill = $this->createClassObject();
        $bill->setAddress1('Address1');
        $this->assertEquals('Address1', $bill->getAddress1());
    }

    public function testGetAddress2()
    {
        $bill = $this->createClassObject();
        $bill->setAddress2('Address2');
        $this->assertEquals('Address2', $bill->getAddress2());
    }

    public function testGetCity()
    {
        $bill = $this->createClassObject();
        $bill->setCity('Miami');
        $this->assertEquals('Miami', $bill->getCity());
    }

    public function testGetState()
    {
        $bill = $this->createClassObject();
        $bill->setState('AB');
        $this->assertEquals('AB', $bill->getState());
    }

    public function testGetZip()
    {
        $bill = $this->createClassObject();
        $bill->setZip('12345');
        $this->assertEquals('12345', $bill->getZip());
    }

    public function testGetCountry()
    {
        $bill = $this->createClassObject();
        $bill->setCountry('Canada');
        $this->assertEquals('Canada', $bill->getCountry());
    }

    public function testGetCc()
    {
        $bill = $this->createClassObject();
        $bill->setCc(['']);
        $this->assertEquals([''], $bill->getCc());
    }

    public function testGetPhone()
    {
        $bill = $this->createClassObject();
        $bill->setPhone('123456789');
        $this->assertEquals('123456789', $bill->getPhone());
    }

    public function testGetDueDate()
    {
        $bill = $this->createClassObject();
        $bill->setDueDate('2022-01-01');
        $this->assertEquals('2022-01-01', $bill->getDueDate());
    }

    public function testGetPassProcessingFee()
    {
        $bill = $this->createClassObject();
        $bill->setPassProcessingFee(true);
        $this->assertTrue($bill->getPassProcessingFee());
    }

    public function testGetStatus()
    {
        $bill = $this->createClassObject();
        $bill->setStatus('status');
        $this->assertEquals('status', $bill->getStatus());
    }

    public function testGetUrl()
    {
        $bill = $this->createClassObject();
        $bill->setUrl('http://test.com');
        $this->assertEquals('http://test.com', $bill->getUrl());
    }

    public function testGetCreateDate()
    {
        $bill = $this->createClassObject();
        $bill->setCreateDate('2022-01-01');
        $this->assertEquals('2022-01-01', $bill->getCreateDate());
    }

    public function testGetId()
    {
        $bill = $this->createClassObject();
        $bill->setId('1');
        $this->assertEquals('1', $bill->getId());
    }

    public function testGetMerchant()
    {
        $bill = $this->createClassObject();
        $bill->setMerchant('TestUser');
        $this->assertEquals('TestUser', $bill->getMerchant());
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