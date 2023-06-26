<?php

/**
 * Copyright (c) 2019 BitPay
 **/

declare(strict_types=1);

namespace BitPaySDK\Functional;

use BitPaySDK\Exceptions\PayoutRecipientCreationException;
use BitPaySDK\Exceptions\PayoutRecipientQueryException;
use BitPaySDK\Model\Payout\PayoutRecipient;
use BitPaySDK\Model\Payout\PayoutRecipients;

class PayoutRecipientsClientTest extends AbstractClientTest
{
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

        self::assertCount(1, $payoutRecipients);
        self::assertEquals('test@emaill1.com', $payoutRecipients[0]->getEmail());
        self::assertEquals('recipient1', $payoutRecipients[0]->getLabel());
        self::assertEquals(
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

        self::assertEquals($recipientId, $recipient->getId());
        self::assertEquals('test@emaill1.com', $recipient->getEmail());
        self::assertEquals('recipient1', $recipient->getLabel());
        self::assertEquals('invited', $recipient->getStatus());
        self::assertEquals(null, $recipient->getShopperId());
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

        self::assertCount(1, $recipients);
        self::assertEquals('invited', $recipients[0]->getStatus());
        self::assertNotNull($recipients);
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

        self::assertEquals($label, $updateRecipient->getLabel());
        self::assertEquals('test@emaill1.com', $updateRecipient->getEmail());
        self::assertEquals('invited', $updateRecipient->getStatus());
        self::assertEquals($payoutRecipient->getId(), $updateRecipient->getId());
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

        self::assertEquals(true, $result);
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

        self::assertEquals(true, $result);
    }
}