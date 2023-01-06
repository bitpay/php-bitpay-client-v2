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
        $this->client = Client::createWithFile('src/BitPaySDK/config.yml');
    }

    /**
     * @throws PayoutRecipientCreationException
     */
    public function testSubmitPayoutRecipients(): void
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
    }

    public function testGetPayoutRecipient()
    {
        $recipientsList = [
            new PayoutRecipient(
                "test@emaill1.com",
                "recipient1",
                "https://yournotiticationURL.com/b3sarz5bg0wx01eq1bv9785amx")
        ];

        $recipients = new PayoutRecipients($recipientsList);
        $payoutRecipients = $this->client->submitPayoutRecipients($recipients);

        $recipientId = $payoutRecipients[0]->getId();
        $recipient = $this->client->getPayoutRecipient($recipientId);

        $this->assertEquals($recipientId, $recipient->getId());
        $this->assertEquals('test@emaill1.com', $recipient->getEmail());
        $this->assertEquals('recipient1', $recipient->getLabel());
        $this->assertEquals('invited', $recipient->getStatus());
        $this->assertEquals(null, $recipient->getShopperId());
    }

    public function testPayoutRecipientShouldCatchRestCliException(): void
    {
        $recipientId = 'JA4cEtmBxCp5cybtnh1rds';

        $this->expectException(PayoutRecipientQueryException::class);
        $this->client->getPayoutRecipient($recipientId);
    }

    public function testGetPayoutRecipients(): void
    {
        $recipients = $this->client->getPayoutRecipients('invited', 1);

        $this->assertCount(1, $recipients);
        $this->assertEquals('invited', $recipients[0]->getStatus());
        $this->assertNotNull($recipients);
    }

    public function testUpdatePayoutRecipients(): void
    {
        $label = 'updateLabel';
        $recipientsList = [
            new PayoutRecipient(
                "test@emaill1.com",
                "recipient1",
                "https://yournotiticationURL.com/b3sarz5bg0wx01eq1bv9785amx")
        ];

        $recipients = new PayoutRecipients($recipientsList);
        $payoutRecipients = $this->client->submitPayoutRecipients($recipients);
        $payoutRecipient = $payoutRecipients[0];
        $payoutRecipient->setLabel($label);

        $updateRecipient = $this->client->updatePayoutRecipient($payoutRecipient->getId(), $payoutRecipient);

        $this->assertEquals($label, $updateRecipient->getLabel());
        $this->assertEquals('test@emaill1.com', $updateRecipient->getEmail());
        $this->assertEquals('invited', $updateRecipient->getStatus());
        $this->assertEquals($payoutRecipient->getId(), $updateRecipient->getId());
    }

    public function testDeletePayoutRecipient(): void
    {
        $recipientsList = [
            new PayoutRecipient(
                "test@emaill1.com",
                "recipient1",
                "https://yournotiticationURL.com/b3sarz5bg0wx01eq1bv9785amx")
        ];

        $recipients = new PayoutRecipients($recipientsList);
        $payoutRecipients = $this->client->submitPayoutRecipients($recipients);
        $payoutRecipientId = $payoutRecipients[0]->getId();

        $result = $this->client->deletePayoutRecipient($payoutRecipientId);

        $this->assertEquals(true, $result);
    }

    public function testPayoutRecipientRequestNotification(): void
    {
        $recipientsList = [
            new PayoutRecipient(
                "test@emaill1.com",
                "recipient1",
                "https://yournotiticationURL.com/b3sarz5bg0wx01eq1bv9785amx")
        ];

        $recipients = new PayoutRecipients($recipientsList);
        $payoutRecipients = $this->client->submitPayoutRecipients($recipients);
        $payoutRecipientId = $payoutRecipients[0]->getId();

        $result = $this->client->requestPayoutRecipientNotification($payoutRecipientId);

        $this->assertEquals(true, $result);
    }
}