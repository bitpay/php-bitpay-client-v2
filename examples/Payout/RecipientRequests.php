<?php

declare(strict_types=1);

namespace BitPaySDKexamples\Payout;

use BitPaySDK\Model\Payout\PayoutRecipient;
use BitPaySDK\Model\Payout\PayoutRecipients;
use BitPaySDKexamples\ClientProvider;

final class RecipientRequests
{
    /**
     * @throws \BitPaySDK\Exceptions\BitPayApiException
     * @throws \BitPaySDK\Exceptions\BitPayGenericException
     */
    public function inviteRecipients(): void
    {
        $client = ClientProvider::create();

        $payoutRecipient = new PayoutRecipient();
        $payoutRecipient->setEmail('some@email.com');

        $payoutRecipients = new PayoutRecipients([$payoutRecipient]);

        $recipients = $client->submitPayoutRecipients($payoutRecipients);
    }

    /**
     * @throws \BitPaySDK\Exceptions\BitPayApiException
     * @throws \BitPaySDK\Exceptions\BitPayGenericException
     */
    public function getRecipient(): void
    {
        $client = ClientProvider::create();

        $recipient = $client->getPayoutRecipient('someRecipientId');

        $recipients = $client->getPayoutRecipients('invited');
    }

    /**
     * @throws \BitPaySDK\Exceptions\BitPayApiException
     * @throws \BitPaySDK\Exceptions\BitPayGenericException
     */
    public function updateRecipient(): void
    {
        $client = ClientProvider::create();

        $payoutRecipient = new PayoutRecipient();
        $payoutRecipient->setLabel('some label');

        $recipient = $client->updatePayoutRecipient($payoutRecipient->getId(), $payoutRecipient);
    }

    /**
     * @throws \BitPaySDK\Exceptions\BitPayApiException
     * @throws \BitPaySDK\Exceptions\BitPayGenericException
     */
    public function removeRecipient(): void
    {
        $client = ClientProvider::create();

        $result = $client->deletePayoutRecipient('somePayoutRecipientId');
    }
}
