<?php

namespace BitPaySDK\Test\Model\Payout;

use BitPaySDK\Model\Payout\PayoutRecipient;
use PHPUnit\Framework\TestCase;

class PayoutRecipientTest extends TestCase
{
  public function testInstanceOf()
  {
    $payoutRecipient = $this->createClassObject();
    self::assertInstanceOf(PayoutRecipient::class, $payoutRecipient);
  }

  public function testGetEmail()
  {
    $expectedEmail = 'john@doe.com';
    
    $payoutRecipient = $this->createClassObject();
    $payoutRecipient->setEmail($expectedEmail);

    self::assertEquals($expectedEmail, $payoutRecipient->getEmail());
  }

  public function testGetLabel()
  {
    $expectedLabel = 'My Label';
    
    $payoutRecipient = $this->createClassObject();
    $payoutRecipient->setLabel($expectedLabel);

    self::assertEquals($expectedLabel, $payoutRecipient->getLabel());
  }

  public function testGetNotificationURL()
  {
    $expectedNotificationURL = 'https://www.example.com';
    
    $payoutRecipient = $this->createClassObject();
    $payoutRecipient->setNotificationURL($expectedNotificationURL);

    self::assertEquals($expectedNotificationURL, $payoutRecipient->getNotificationURL());
  }

  public function testGetStatus()
  {
    $expectedStatus = 'success';
    
    $payoutRecipient = $this->createClassObject();
    $payoutRecipient->setStatus($expectedStatus);

    self::assertEquals($expectedStatus, $payoutRecipient->getStatus());
  }

  public function testGetId()
  {
    $expectedId = 'abcd123';
    
    $payoutRecipient = $this->createClassObject();
    $payoutRecipient->setId($expectedId);

    self::assertEquals($expectedId, $payoutRecipient->getId());
  }

  public function testGetShopperId()
  {
    $expectedShopperId = 'efgh456';
    
    $payoutRecipient = $this->createClassObject();
    $payoutRecipient->setShopperId($expectedShopperId);

    self::assertEquals($expectedShopperId, $payoutRecipient->getShopperId());
  }

  public function testGetToken()
  {
    $expectedToken = '6RZSTPtnzEaroAe2X4YijenRiqteRDNvzbT8NjtcHjUVd9FUFwa7dsX8RFgRDDC5SL';
    
    $payoutRecipient = $this->createClassObject();
    $payoutRecipient->setToken($expectedToken);

    self::assertEquals($expectedToken, $payoutRecipient->getToken());
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

    self::assertNotNull($payoutRecipientArray);
    self::assertIsArray($payoutRecipientArray);

    self::assertArrayHasKey('email', $payoutRecipientArray);
    self::assertArrayHasKey('label', $payoutRecipientArray);
    self::assertArrayHasKey('notificationURL', $payoutRecipientArray);
    self::assertArrayHasKey('status', $payoutRecipientArray);
    self::assertArrayHasKey('id', $payoutRecipientArray);
    self::assertArrayHasKey('shopperId', $payoutRecipientArray);
    self::assertArrayHasKey('token', $payoutRecipientArray);

    self::assertEquals('john@doe.com', $payoutRecipientArray['email']);
    self::assertEquals('My Label', $payoutRecipientArray['label']);
    self::assertEquals('https://www.example.com', $payoutRecipientArray['notificationURL']);
    self::assertEquals('success', $payoutRecipientArray['status']);
    self::assertEquals('abcd123', $payoutRecipientArray['id']);
    self::assertEquals('efgh456', $payoutRecipientArray['shopperId']);
    self::assertEquals('6RZSTPtnzEaroAe2X4YijenRiqteRDNvzbT8NjtcHjUVd9FUFwa7dsX8RFgRDDC5SL', $payoutRecipientArray['token']);
  }

  public function testToArrayEmptyKey()
  {
    $payoutRecipient = $this->createClassObject();
    $payoutRecipientArray = $payoutRecipient->toArray();

    self::assertArrayNotHasKey('email', $payoutRecipientArray);
  }

  private function createClassObject(): PayoutRecipient
  {
    return new PayoutRecipient();
  }
}