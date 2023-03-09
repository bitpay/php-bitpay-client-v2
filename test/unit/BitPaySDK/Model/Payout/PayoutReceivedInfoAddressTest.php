<?php

namespace BitPaySDK\Test\Model\Payout;

use BitPaySDK\Model\Payout\PayoutReceivedInfoAddress;
use PHPUnit\Framework\TestCase;

class PayoutReceivedInfoAddressTest extends TestCase
{
  public function testInstanceOf()
  {
    $payoutReceivedInfoAddress = $this->createClassObject();
    $this->assertInstanceOf(PayoutReceivedInfoAddress::class, $payoutReceivedInfoAddress);
  }

  public function testGetAddress1()
  {
    $expectedAddress1 = '123 Main St.';
    
    $payoutReceivedInfoAddress = $this->createClassObject();
    $payoutReceivedInfoAddress->setAddress1($expectedAddress1);
    $this->assertEquals($expectedAddress1, $payoutReceivedInfoAddress->getAddress1());
  }

  public function testGetAddress2()
  {
    $expectedAddress2 = '#4';
    
    $payoutReceivedInfoAddress = $this->createClassObject();
    $payoutReceivedInfoAddress->setAddress2($expectedAddress2);
    $this->assertEquals($expectedAddress2, $payoutReceivedInfoAddress->getAddress2());
  }

  public function testGetLocality()
  {
    $expectedLocality = 'Locality Name';
    
    $payoutReceivedInfoAddress = $this->createClassObject();
    $payoutReceivedInfoAddress->setLocality($expectedLocality);
    $this->assertEquals($expectedLocality, $payoutReceivedInfoAddress->getLocality());
  }

  public function testGetRegion()
  {
    $expectedRegion = 'Region Name';
    
    $payoutReceivedInfoAddress = $this->createClassObject();
    $payoutReceivedInfoAddress->setRegion($expectedRegion);
    $this->assertEquals($expectedRegion, $payoutReceivedInfoAddress->getRegion());
  }

  public function testGetPostalCode()
  {
    $expectedPostalCode = '00000';
    
    $payoutReceivedInfoAddress = $this->createClassObject();
    $payoutReceivedInfoAddress->setPostalCode($expectedPostalCode);
    $this->assertEquals($expectedPostalCode, $payoutReceivedInfoAddress->getPostalCode());
  }

  public function testGetCountry()
  {
    $expectedCountry = 'US';
    
    $payoutReceivedInfoAddress = $this->createClassObject();
    $payoutReceivedInfoAddress->setCountry($expectedCountry);
    $this->assertEquals($expectedCountry, $payoutReceivedInfoAddress->getCountry());
  }

  public function testToArray()
  {
    $payoutReceivedInfoAddress = $this->createClassObject();
    $payoutReceivedInfoAddress->setAddress1('123 Main St.');
    $payoutReceivedInfoAddress->setAddress2('#4');
    $payoutReceivedInfoAddress->setLocality('Locality Name');
    $payoutReceivedInfoAddress->setRegion('Region Name');
    $payoutReceivedInfoAddress->setPostalCode('00000');
    $payoutReceivedInfoAddress->setCountry('US');
    $payoutReceivedInfoAddressArray = $payoutReceivedInfoAddress->toArray();

    $this->assertNotNull($payoutReceivedInfoAddressArray);
    $this->assertIsArray($payoutReceivedInfoAddressArray);

    $this->assertArrayHasKey('address1', $payoutReceivedInfoAddressArray);
    $this->assertArrayHasKey('address2', $payoutReceivedInfoAddressArray);
    $this->assertArrayHasKey('locality', $payoutReceivedInfoAddressArray);
    $this->assertArrayHasKey('region', $payoutReceivedInfoAddressArray);
    $this->assertArrayHasKey('postalCode', $payoutReceivedInfoAddressArray);
    $this->assertArrayHasKey('country', $payoutReceivedInfoAddressArray);

    $this->assertEquals('123 Main St.', $payoutReceivedInfoAddressArray['address1']);
    $this->assertEquals('#4', $payoutReceivedInfoAddressArray['address2']);
    $this->assertEquals('Locality Name', $payoutReceivedInfoAddressArray['locality']);
    $this->assertEquals('Region Name', $payoutReceivedInfoAddressArray['region']);
    $this->assertEquals('00000', $payoutReceivedInfoAddressArray['postalCode']);
    $this->assertEquals('US', $payoutReceivedInfoAddressArray['country']);
  }

  public function testToArrayEmptyKey()
  {
    $payoutReceivedInfoAddress = $this->createClassObject();
    $payoutReceivedInfoAddressArray = $payoutReceivedInfoAddress->toArray();

    $this->assertArrayNotHasKey('address1', $payoutReceivedInfoAddressArray);
  }

  private function createClassObject(): PayoutReceivedInfoAddress
  {
    return new PayoutReceivedInfoAddress();
  }
}