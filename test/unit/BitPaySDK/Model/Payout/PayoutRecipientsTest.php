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
        self::assertInstanceOf(PayoutRecipients::class, $payoutRecipients);
    }

    public function testGetGuid()
    {
        $expectedGuid = 'cd47864e-374b-4a92-8592-4357fcbc6a89';

        $payoutRecipients = $this->createClassObject();
        $payoutRecipients->setGuid($expectedGuid);
        self::assertEquals($expectedGuid, $payoutRecipients->getGuid());
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
        self::assertEquals($expectedPayoutRecipients[0]->toArray(), $payoutRecipients->getRecipients()[0]->toArray());
    }

    /**
     * @throws \BitPaySDK\Exceptions\PayoutRecipientException
     */
    public function testGetRecipientsArray()
    {
        $payoutRecipient = new PayoutRecipient();
        $payoutRecipient->setNotificationURL('https://www.example.com');
        $payoutRecipient->setEmail('john@doe.com');
        $payoutRecipient->setLabel('My Label');
        $payoutRecipient->setStatus('success');
        $payoutRecipient->setId('abcd123');
        $payoutRecipient->setShopperId('efgh456');

        $payoutRecipients = $this->createClassObject();
        $payoutRecipients->setRecipients([$payoutRecipient]);
        self::assertEquals([$payoutRecipient], $payoutRecipients->getRecipients());
    }

    public function testGetToken()
    {
        $expectedToken = '6RZSTPtnzEaroAe2X4YijenRiqteRDNvzbT8NjtcHjUVd9FUFwa7dsX8RFgRDDC5SL';

        $payoutRecipients = $this->createClassObject();
        $payoutRecipients->setToken($expectedToken);
        self::assertEquals($expectedToken, $payoutRecipients->getToken());
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

        self::assertNotNull($payoutRecipientsArray);
        self::assertIsArray($payoutRecipientsArray);

        self::assertArrayHasKey('guid', $payoutRecipientsArray);
        self::assertArrayHasKey('recipients', $payoutRecipientsArray);
        self::assertArrayHasKey('token', $payoutRecipientsArray);

        self::assertEquals('cd47864e-374b-4a92-8592-4357fcbc6a89', $payoutRecipientsArray['guid']);
        self::assertEquals('john@doe.com', $payoutRecipientsArray['recipients'][0]['email']);
        self::assertEquals('My Label', $payoutRecipientsArray['recipients'][0]['label']);
        self::assertEquals('https://www.example.com', $payoutRecipientsArray['recipients'][0]['notificationURL']);
        self::assertEquals('success', $payoutRecipientsArray['recipients'][0]['status']);
        self::assertEquals('abcd123', $payoutRecipientsArray['recipients'][0]['id']);
        self::assertEquals('efgh456', $payoutRecipientsArray['recipients'][0]['shopperId']);
        self::assertEquals('6RZSTPtnzEaroAe2X4YijenRiqteRDNvzbT8NjtcHjUVd9FUFwa7dsX8RFgRDDC5SL', $payoutRecipientsArray['recipients'][0]['token']);
        self::assertEquals('6RZSTPtnzEaroAe2X4YijenRiqteRDNvzbT8NjtcHjUVd9FUFwa7dsX8RFgRDDC5SL', $payoutRecipientsArray['token']);
    }

    public function testToArrayEmptyKey()
    {
        $payoutRecipients = $this->createClassObject();
        $payoutRecipientsArray = $payoutRecipients->toArray();
        self::assertArrayNotHasKey('guid', $payoutRecipientsArray);
    }

    private function createClassObject(): PayoutRecipients
    {
        return new PayoutRecipients();
    }
}