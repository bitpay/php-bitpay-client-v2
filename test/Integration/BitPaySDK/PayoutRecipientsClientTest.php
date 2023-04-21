<?php
declare(strict_types=1);

namespace BitPaySDK\Integration;

use BitPaySDK\Client;
use BitPaySDK\Exceptions\PayoutRecipientCreationException;
use BitPaySDK\Exceptions\PayoutRecipientQueryException;
use BitPaySDK\Model\Payout\PayoutRecipient;
use BitPaySDK\Model\Payout\PayoutRecipients;
use PHPUnit\Framework\TestCase;

class PayoutRecipientsClientTest extends TestCase
{
    protected $client;

    public function setUp(): void
    {
        $this->client = Client::createWithFile(Config::INTEGRATION_TEST_PATH . DIRECTORY_SEPARATOR . Config::BITPAY_CONFIG_FILE);
    }

    /**
     * @throws PayoutRecipientCreationException
     */
    public function testPayoutRequests(): void
    {
        $recipientsList = [
            new PayoutRecipient(
                "test@emaill1.com",
                "recipient1",
                "https://yournotiticationURL.com/b3sarz5bg0wx01eq1bv9785amx")
        ];

        $recipients = new PayoutRecipients($recipientsList);

        $payoutRecipients = $this->client->submitPayoutRecipients($recipients);

        $this->assertCount(1, $payoutRecipients);
        $this->assertEquals('test@emaill1.com', $payoutRecipients[0]->getEmail());
        $this->assertEquals('recipient1', $payoutRecipients[0]->getLabel());
        $this->assertEquals(
            'invited',
            $payoutRecipients[0]->getStatus()
        );

        $recipient = $payoutRecipients[0];
        $recipientId = $recipient->getId();
        $recipient = $this->client->getPayoutRecipient($recipientId);

        $this->assertEquals('test@emaill1.com', $recipient->getEmail());
        $this->assertEquals('recipient1', $recipient->getLabel());
        $this->assertEquals('invited', $recipient->getStatus());


        $recipients = $this->client->getPayoutRecipients('invited', 1);

        $this->assertCount(1, $recipients);
        $this->assertEquals('invited', $recipients[0]->getStatus());
        $this->assertNotNull($recipients);

        $label = 'updateLabel';
        $recipient->setLabel($label);

        $updateRecipient = $this->client->updatePayoutRecipient($recipientId, $recipient);

        $this->assertEquals($label, $updateRecipient->getLabel());
        $this->assertEquals('test@emaill1.com', $updateRecipient->getEmail());
        $this->assertEquals('invited', $updateRecipient->getStatus());
        $this->assertEquals($recipient->getId(), $updateRecipient->getId());

        $result = $this->client->requestPayoutRecipientNotification($recipientId);
        $this->assertEquals(true, $result);

        $result = $this->client->deletePayoutRecipient($recipientId);
        $this->assertEquals(true, $result);
    }
}