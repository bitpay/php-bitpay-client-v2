<?php

namespace BitPaySDK\Test\Model\Payout;

use BitPaySDK\Model\Payout\PayoutReceivedInfo;
use BitPaySDK\Model\Payout\PayoutReceivedInfoAddress;
use PHPUnit\Framework\TestCase;

class PayoutReceivedInfoTest extends TestCase
{
  public function testInstanceOf()
  {
    $payoutReceivedInfo = $this->createClassObject();
    $this->assertInstanceOf(PayoutReceivedInfo::class, $payoutReceivedInfo);
  }

  public function testGetName()
  {
    $expectedName = 'John Doe';

    $payoutReceivedInfo = $this->createClassObject();
    $payoutReceivedInfo->setName($expectedName);
    $this->assertEquals($expectedName, $payoutReceivedInfo->getName());
  }

  public function testGetEmail()
  {
    $expectedEmail = 'john@doe.com';

    $payoutReceivedInfo = $this->createClassObject();
    $payoutReceivedInfo->setEmail($expectedEmail);
    $this->assertEquals($expectedEmail, $payoutReceivedInfo->getEmail());
  }

  public function testGetAddress()
  {
    $expectedAddress = new PayoutReceivedInfoAddress();
    $expectedAddress->setAddress1('123 Main St.');
    $expectedAddress->setAddress2('#4');
    $expectedAddress->setLocality('Locality Name');
    $expectedAddress->setRegion('Region Name');
    $expectedAddress->setPostalCode('00000');
    $expectedAddress->setCountry('US');

    $payoutReceivedInfo = $this->createClassObject();
    $payoutReceivedInfo->setAddress($expectedAddress);
    $this->assertEquals($expectedAddress, $payoutReceivedInfo->getAddress());
  }

  public function testToArray()
  {
    $payoutReceivedInfo = $this->createClassObject();
    $this->objectSetters($payoutReceivedInfo);
    $payoutReceivedInfoArray = $payoutReceivedInfo->toArray();

    $this->assertNotNull($payoutReceivedInfoArray);
    $this->assertIsArray($payoutReceivedInfoArray);

    $this->assertArrayHasKey('name', $payoutReceivedInfoArray);
    $this->assertArrayHasKey('email', $payoutReceivedInfoArray);
    $this->assertArrayHasKey('address', $payoutReceivedInfoArray);

    $this->assertEquals($payoutReceivedInfoArray['name'], 'John Doe');
    $this->assertEquals($payoutReceivedInfoArray['email'], 'john@doe.com');
    $this->assertEquals($payoutReceivedInfoArray['address']['address1'], '123 Main St.');
    $this->assertEquals($payoutReceivedInfoArray['address']['address2'], '#4');
    $this->assertEquals($payoutReceivedInfoArray['address']['locality'], 'Locality Name');
    $this->assertEquals($payoutReceivedInfoArray['address']['region'], 'Region Name');
    $this->assertEquals($payoutReceivedInfoArray['address']['postalCode'], '00000');
    $this->assertEquals($payoutReceivedInfoArray['address']['country'], 'US');
  }

  public function testToArrayEmptyKey()
  {
    $address = new PayoutReceivedInfoAddress();
    $address->setAddress1('123 Main St.');
    $address->setAddress2('#4');
    $address->setLocality('Locality Name');
    $address->setRegion('Region Name');
    $address->setPostalCode('00000');
    $address->setCountry('US');

    $payoutReceivedInfo = $this->createClassObject();
    $payoutReceivedInfo->setAddress($address);
    $payoutReceivedInfoArray = $payoutReceivedInfo->toArray();
    
    $this->assertArrayNotHasKey('name', $payoutReceivedInfoArray);
  }

  private function createClassObject()
  {
    return new PayoutReceivedInfo();
  }

  private function objectSetters(PayoutReceivedInfo $payoutReceivedInfo)
  {
    $address = new PayoutReceivedInfoAddress();
    $address->setAddress1('123 Main St.');
    $address->setAddress2('#4');
    $address->setLocality('Locality Name');
    $address->setRegion('Region Name');
    $address->setPostalCode('00000');
    $address->setCountry('US');

    $payoutReceivedInfo->setName('John Doe');
    $payoutReceivedInfo->setEmail('john@doe.com');
    $payoutReceivedInfo->setAddress($address);
  }
}