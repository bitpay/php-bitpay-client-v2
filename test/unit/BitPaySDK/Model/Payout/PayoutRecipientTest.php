<?php

namespace BitPaySDK\Test\Model\Payout;

use BitPaySDK\Model\Payout\PayoutRecipient;
use PHPUnit\Framework\TestCase;

class PayoutRecipientTest extends TestCase
{
  public function testInstanceOf()
  {
    $payoutRecipient = $this->createClassObject();
    $this->assertInstanceOf(PayoutRecipient::class, $payoutRecipient);
  }

  public function testGetEmail()
  {
    $expectedEmail = 'john@doe.com';
    
    $payoutRecipient = $this->createClassObject();
    $payoutRecipient->setEmail($expectedEmail);

    $this->assertEquals($expectedEmail, $payoutRecipient->getEmail());
  }

  public function testGetLabel()
  {
    $expectedLabel = 'My Label';
    
    $payoutRecipient = $this->createClassObject();
    $payoutRecipient->setLabel($expectedLabel);

    $this->assertEquals($expectedLabel, $payoutRecipient->getLabel());
  }

  public function testGetNotificationURL()
  {
    $expectedNotificationURL = 'https://www.example.com';
    
    $payoutRecipient = $this->createClassObject();
    $payoutRecipient->setNotificationURL($expectedNotificationURL);

    $this->assertEquals($expectedNotificationURL, $payoutRecipient->getNotificationURL());
  }

  public function testGetStatus()
  {
    $expectedStatus = 'success';
    
    $payoutRecipient = $this->createClassObject();
    $payoutRecipient->setStatus($expectedStatus);

    $this->assertEquals($expectedStatus, $payoutRecipient->getStatus());
  }

  public function testGetId()
  {
    $expectedId = 'abcd123';
    
    $payoutRecipient = $this->createClassObject();
    $payoutRecipient->setId($expectedId);

    $this->assertEquals($expectedId, $payoutRecipient->getId());
  }

  public function testGetShopperId()
  {
    $expectedShopperId = 'efgh456';
    
    $payoutRecipient = $this->createClassObject();
    $payoutRecipient->setShopperId($expectedShopperId);

    $this->assertEquals($expectedShopperId, $payoutRecipient->getShopperId());
  }

  public function testGetToken()
  {
    $expectedToken = '6RZSTPtnzEaroAe2X4YijenRiqteRDNvzbT8NjtcHjUVd9FUFwa7dsX8RFgRDDC5SL';
    
    $payoutRecipient = $this->createClassObject();
    $payoutRecipient->setToken($expectedToken);

    $this->assertEquals($expectedToken, $payoutRecipient->getToken());
  }

  public function testToArray()
  {
    $payoutRecipient = $this->createClassObject();
    $payoutRecipient->setEmail('john@doe.com');
    $payoutRecipient->setLabel('My Label');
    $payoutRecipient->setNotificationURL('https://www.example.com');
    $payoutRecipient->setStatus('success');
    $payoutRecipient->setId('abcd123');
    $payoutRecipient->setShopperId('efgh456');
    $payoutRecipient->setToken('6RZSTPtnzEaroAe2X4YijenRiqteRDNvzbT8NjtcHjUVd9FUFwa7dsX8RFgRDDC5SL');
    $payoutRecipientArray = $payoutRecipient->toArray();

    $this->assertNotNull($payoutRecipientArray);
    $this->assertIsArray($payoutRecipientArray);

    $this->assertArrayHasKey('email', $payoutRecipientArray);
    $this->assertArrayHasKey('label', $payoutRecipientArray);
    $this->assertArrayHasKey('notificationURL', $payoutRecipientArray);
    $this->assertArrayHasKey('status', $payoutRecipientArray);
    $this->assertArrayHasKey('id', $payoutRecipientArray);
    $this->assertArrayHasKey('shopperId', $payoutRecipientArray);
    $this->assertArrayHasKey('token', $payoutRecipientArray);

    $this->assertEquals($payoutRecipientArray['email'], 'john@doe.com');
    $this->assertEquals($payoutRecipientArray['label'], 'My Label');
    $this->assertEquals($payoutRecipientArray['notificationURL'], 'https://www.example.com');
    $this->assertEquals($payoutRecipientArray['status'], 'success');
    $this->assertEquals($payoutRecipientArray['id'], 'abcd123');
    $this->assertEquals($payoutRecipientArray['shopperId'], 'efgh456');
    $this->assertEquals($payoutRecipientArray['token'], '6RZSTPtnzEaroAe2X4YijenRiqteRDNvzbT8NjtcHjUVd9FUFwa7dsX8RFgRDDC5SL');
  }

  public function testToArrayEmptyKey()
  {
    $payoutRecipient = $this->createClassObject();
    $payoutRecipientArray = $payoutRecipient->toArray();

    $this->assertArrayNotHasKey('email', $payoutRecipientArray);
  }

  private function createClassObject()
  {
    return new PayoutRecipient();
  }
}