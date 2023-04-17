<?php

namespace BitPaySDK\Test\Model\Payout;

use BitPaySDK\Model\Payout\PayoutRecipient;
use BitPaySDK\Model\Payout\PayoutRecipients;
use PHPUnit\Framework\TestCase;

class PayoutRecipientsTest extends TestCase
{
  public function testInstanceOf()
  {
    $payoutRecipients = $this->createClassObject();
    $this->assertInstanceOf(PayoutRecipients::class, $payoutRecipients);
  }

  public function testGetGuid()
  {
    $expectedGuid = 'cd47864e-374b-4a92-8592-4357fcbc6a89';

    $payoutRecipients = $this->createClassObject();
    $payoutRecipients->setGuid($expectedGuid);
    $this->assertEquals($expectedGuid, $payoutRecipients->getGuid());
  }

  public function testGetRecipientsObject()
  {
    $expectedPayoutRecipients = [];
    $payoutRecipient = new PayoutRecipient();
    $payoutRecipient->setEmail('john@doe.com');
    $payoutRecipient->setLabel('My Label');
    $payoutRecipient->setNotificationURL('https://www.example.com');
    $payoutRecipient->setStatus('success');
    $payoutRecipient->setId('abcd123');
    $payoutRecipient->setShopperId('efgh456');
    $payoutRecipient->setToken('6RZSTPtnzEaroAe2X4YijenRiqteRDNvzbT8NjtcHjUVd9FUFwa7dsX8RFgRDDC5SL');
    $expectedPayoutRecipients[] = $payoutRecipient;

    $payoutRecipients = $this->createClassObject();
    $payoutRecipients->setRecipients($expectedPayoutRecipients);
    $this->assertEquals($expectedPayoutRecipients[0]->toArray(), $payoutRecipients->getRecipients()[0]);
  }

  public function testGetRecipientsArray()
  {
    $expectedPayoutRecipients = [
      [
        'email' => 'john@doe.com',
        'label' => 'My Label',
        'notificationURL' => 'https://www.example.com',
        'status' => 'success',
        'id' => 'abcd123',
        'shopperId' => 'efgh456',
        'payoutRecipient' => '6RZSTPtnzEaroAe2X4YijenRiqteRDNvzbT8NjtcHjUVd9FUFwa7dsX8RFgRDDC5SL'
      ]
    ];

    $payoutRecipients = $this->createClassObject();
    $payoutRecipients->setRecipients($expectedPayoutRecipients);
    $this->assertEquals($expectedPayoutRecipients, $payoutRecipients->getRecipients());
  }

  public function testGetToken()
  {
    $expectedToken = '6RZSTPtnzEaroAe2X4YijenRiqteRDNvzbT8NjtcHjUVd9FUFwa7dsX8RFgRDDC5SL';

    $payoutRecipients = $this->createClassObject();
    $payoutRecipients->setToken($expectedToken);
    $this->assertEquals($expectedToken, $payoutRecipients->getToken());
  }

  public function testToArray()
  {
    $expectedPayoutRecipients = [];
    $payoutRecipient = new PayoutRecipient();
    $payoutRecipient->setEmail('john@doe.com');
    $payoutRecipient->setLabel('My Label');
    $payoutRecipient->setNotificationURL('https://www.example.com');
    $payoutRecipient->setStatus('success');
    $payoutRecipient->setId('abcd123');
    $payoutRecipient->setShopperId('efgh456');
    $payoutRecipient->setToken('6RZSTPtnzEaroAe2X4YijenRiqteRDNvzbT8NjtcHjUVd9FUFwa7dsX8RFgRDDC5SL');
    $expectedPayoutRecipients[] = $payoutRecipient;

    $payoutRecipients = $this->createClassObject();
    $payoutRecipients->setGuid('cd47864e-374b-4a92-8592-4357fcbc6a89');
    $payoutRecipients->setRecipients($expectedPayoutRecipients);
    $payoutRecipients->setToken('6RZSTPtnzEaroAe2X4YijenRiqteRDNvzbT8NjtcHjUVd9FUFwa7dsX8RFgRDDC5SL');
    $payoutRecipientsArray = $payoutRecipients->toArray();

    $this->assertNotNull($payoutRecipientsArray);
    $this->assertIsArray($payoutRecipientsArray);

    $this->assertArrayHasKey('guid', $payoutRecipientsArray);
    $this->assertArrayHasKey('recipients', $payoutRecipientsArray);
    $this->assertArrayHasKey('token', $payoutRecipientsArray);

    $this->assertEquals('cd47864e-374b-4a92-8592-4357fcbc6a89', $payoutRecipientsArray['guid']);
    $this->assertEquals('john@doe.com', $payoutRecipientsArray['recipients'][0]['email']);
    $this->assertEquals('My Label', $payoutRecipientsArray['recipients'][0]['label']);
    $this->assertEquals('https://www.example.com', $payoutRecipientsArray['recipients'][0]['notificationURL']);
    $this->assertEquals('success', $payoutRecipientsArray['recipients'][0]['status']);
    $this->assertEquals('abcd123', $payoutRecipientsArray['recipients'][0]['id']);
    $this->assertEquals('efgh456', $payoutRecipientsArray['recipients'][0]['shopperId']);
    $this->assertEquals('6RZSTPtnzEaroAe2X4YijenRiqteRDNvzbT8NjtcHjUVd9FUFwa7dsX8RFgRDDC5SL', $payoutRecipientsArray['recipients'][0]['token']);
    $this->assertEquals('6RZSTPtnzEaroAe2X4YijenRiqteRDNvzbT8NjtcHjUVd9FUFwa7dsX8RFgRDDC5SL', $payoutRecipientsArray['token']);
  }

  public function testToArrayEmptyKey()
  {
    $payoutRecipients = $this->createClassObject();
    $payoutRecipientsArray = $payoutRecipients->toArray();
    $this->assertArrayNotHasKey('guid', $payoutRecipientsArray);
  }

  private function createClassObject(): PayoutRecipients
  {
    return new PayoutRecipients();
  }
}