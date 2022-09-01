<?php

namespace BitPaySDK\Test\Model\Subscription;

use BitPaySDK\Exceptions\BitPayException;
use BitPaySDK\Model\Subscription\BillData;
use BitPaySDK\Model\Subscription\Item;
use PHPUnit\Framework\TestCase;

class BillDataTest extends TestCase
{
    public function testInstanceOf()
    {
        $billData = $this->createClassObject();
        $this->assertInstanceOf(BillData::class, $billData);
    }

    public function testGetEmailBill()
    {
        $billData = $this->createClassObject();
        $billData->setEmailBill(false);
        $this->assertFalse($billData->getEmailBill());
    }

    public function testGetCc()
    {
        $expectedCc = [''];

        $billData = $this->createClassObject();
        $billData->setCc($expectedCc);
        $this->assertEquals($expectedCc, $billData->getCc());
    }

    public function testGetNumber()
    {
        $expectedNumber = '123456789';

        $billData = $this->createClassObject();
        $billData->setNumber($expectedNumber);
        $this->assertEquals($expectedNumber, $billData->getNumber());
    }

    public function testGetCurrencyException()
    {
        $expectedCurrency = 'ELO';

        $billData = $this->createClassObject();
        $this->expectException(BitPayException::class);
        $this->expectExceptionMessage('currency code must be a type of Model.Currency');
        $billData->setCurrency($expectedCurrency);
    }

    public function testGetCurrency()
    {
        $expectedCurrency = 'BTC';

        $billData = $this->createClassObject();
        $billData->setCurrency($expectedCurrency);
        $this->assertEquals($expectedCurrency, $billData->getCurrency());
    }

    public function testGetName()
    {
        $expectedName = 'Test name';

        $billData = $this->createClassObject();
        $billData->setName($expectedName);
        $this->assertEquals($expectedName, $billData->getName());
    }

    public function testGetAddress1()
    {
        $expectedAddress1 = 'Test address1';

        $billData = $this->createClassObject();
        $billData->setAddress1($expectedAddress1);
        $this->assertEquals($expectedAddress1, $billData->getAddress1());
    }

    public function testGetAddress2()
    {
        $expectedAddress1 = 'Test address2';

        $billData = $this->createClassObject();
        $billData->setAddress2($expectedAddress1);
        $this->assertEquals($expectedAddress1, $billData->getAddress2());
    }

    public function testGetCity()
    {
        $expectedCity = 'Miami';

        $billData = $this->createClassObject();
        $billData->setCity($expectedCity);
        $this->assertEquals($expectedCity, $billData->getCity());
    }

    public function testGetState()
    {
        $expectedState = 'AB';

        $billData = $this->createClassObject();
        $billData->setState($expectedState);
        $this->assertEquals($expectedState, $billData->getState());
    }

    public function testGetZip()
    {
        $expectedZip = '12345';

        $billData = $this->createClassObject();
        $billData->setZip($expectedZip);
        $this->assertEquals($expectedZip, $billData->getZip());
    }

    public function testGetCountry()
    {
        $expectedCountry = 'USA';

        $billData = $this->createClassObject();
        $billData->setCountry($expectedCountry);
        $this->assertEquals($expectedCountry, $billData->getCountry());
    }

    public function testGetEmail()
    {
        $expectedEmail = 'test@email.com';

        $billData = $this->createClassObject();
        $billData->setEmail($expectedEmail);
        $this->assertEquals($expectedEmail, $billData->getEmail());
    }

    public function testGetPhone()
    {
        $expectedPhone = '123456789';

        $billData = $this->createClassObject();
        $billData->setPhone($expectedPhone);
        $this->assertEquals($expectedPhone, $billData->getPhone());
    }

    public function testGetDueDate()
    {
        $expectedDueDate = '2022-01-01';

        $billData = $this->createClassObject();
        $billData->setDueDate($expectedDueDate);
        $this->assertEquals($expectedDueDate, $billData->getDueDate());
    }

    public function testGetPassProcessingFee()
    {
        $billData = $this->createClassObject();
        $billData->setPassProcessingFee(true);
        $this->assertTrue($billData->getPassProcessingFee());
    }

    public function testGetMerchant()
    {
        $expectedMerchant = 'Test merchant';

        $billData = $this->createClassObject();
        $billData->setMerchant($expectedMerchant);
        $this->assertEquals($expectedMerchant, $billData->getMerchant());
    }

    public function testGetItems()
    {
        $billData = $this->createClassObject();
        $arrayWithoutObject = ['test' => 'gd'];

        $createdObject = Item::createFromArray($arrayWithoutObject);
        $testArray = [new Item(), $arrayWithoutObject];
        $testArray2 = [new Item(), $createdObject];

        $billData->setItems($testArray);

        $this->assertEquals($testArray2, $billData->getItems());
    }

    public function testGetItemsAsArray()
    {
        $billData = $this->createClassObject();
        $item = new Item(20, 1, 'test');
        $testArray = [$item];

        $billData->setItems($testArray);
        $this->assertEquals([$item->toArray()], $billData->getItemsAsArray());
    }

    public function testToArray()
    {
        $billData = $this->createClassObject();
        $this->setSetters($billData);
        $billDataArray = $billData->toArray();

        $this->assertNotNull($billDataArray);
        $this->assertIsArray($billDataArray);

        $this->assertArrayNotHasKey('emailBill', $billDataArray);
        $this->assertArrayHasKey('cc', $billDataArray);
        $this->assertArrayHasKey('number', $billDataArray);
        $this->assertArrayHasKey('currency', $billDataArray);
        $this->assertArrayHasKey('name', $billDataArray);
        $this->assertArrayHasKey('address1', $billDataArray);
        $this->assertArrayHasKey('address2', $billDataArray);
        $this->assertArrayHasKey('city', $billDataArray);
        $this->assertArrayHasKey('state', $billDataArray);
        $this->assertArrayHasKey('zip', $billDataArray);
        $this->assertArrayHasKey('country', $billDataArray);
        $this->assertArrayHasKey('email', $billDataArray);
        $this->assertArrayHasKey('phone', $billDataArray);
        $this->assertArrayHasKey('dueDate', $billDataArray);
        $this->assertArrayHasKey('passProcessingFee', $billDataArray);
        $this->assertArrayHasKey('items', $billDataArray);
        $this->assertArrayHasKey('merchant', $billDataArray);

        $this->assertEquals($billDataArray['cc'], ['']);
        $this->assertEquals($billDataArray['number'], '123456789');
        $this->assertEquals($billDataArray['currency'], 'BTC');
        $this->assertEquals($billDataArray['name'], 'Test name');
        $this->assertEquals($billDataArray['address1'], 'Address1');
        $this->assertEquals($billDataArray['address2'], 'Address2');
        $this->assertEquals($billDataArray['city'], 'Miami');
        $this->assertEquals($billDataArray['state'], 'AB');
        $this->assertEquals($billDataArray['zip'], '12345');
        $this->assertEquals($billDataArray['country'], 'USA');
        $this->assertEquals($billDataArray['email'], 'test@email.com');
        $this->assertEquals($billDataArray['phone'], '123456789');
        $this->assertEquals($billDataArray['dueDate'], '2022-01-01');
        $this->assertTrue($billDataArray['passProcessingFee']);
        $this->assertEquals($billDataArray['items'], ['test']);
        $this->assertEquals($billDataArray['merchant'], 'Test merchant');
    }


    private function createClassObject()
    {
        return new BillData('BTC', 'test@email.com', '2022-01-01', ['test' => 'test']);
    }

    private function setSetters(BillData $billData)
    {
        $billData->setEmailBill(false);
        $billData->setCc(['']);
        $billData->setNumber('123456789');
        $billData->setName('Test name');
        $billData->setAddress1('Address1');
        $billData->setAddress2('Address2');
        $billData->setCity('Miami');
        $billData->setState('AB');
        $billData->setZip('12345');
        $billData->setCountry('USA');
        $billData->setEmail('test@email.com');
        $billData->setPhone('123456789');
        $billData->setDueDate('2022-01-01');
        $billData->setPassProcessingFee(true);
        $billData->setMerchant('Test merchant');
    }
}
