<?php

declare(strict_types=1);

namespace BitPaySDKexamples\Payout;

use BitPaySDK\Model\Payout\Payout;
use BitPaySDKexamples\ClientProvider;

final class PayoutRequests
{
    /**
     * @throws \BitPaySDK\Exceptions\BitPayApiException
     * @throws \BitPaySDK\Exceptions\BitPayGenericException
     */
    public function createPayout(): void
    {
        $client = ClientProvider::create();

        $payout = new Payout(12.34, 'USD', 'USD');
        $payout->setNotificationEmail('myEmail@email.com');
        $payout->setNotificationURL('https://my-url.com');

        $payout = $client->submitPayout($payout);

        $payouts = $client->createPayoutGroup([
            new Payout(12.34, 'USD', 'USD'),
            new Payout(56.14, 'USD', 'USD'),
        ]);
    }

    public function getPayout(): void
    {
        $client = ClientProvider::create();

        $payout = $client->getPayout('myPayoutId');

        $payouts = $client->getPayouts('2023-08-14', '2023-08-22');
    }

    /**
     * @throws \BitPaySDK\Exceptions\BitPayApiException
     * @throws \BitPaySDK\Exceptions\BitPayGenericException
     */
    public function cancelPayout(): void
    {
        $client = ClientProvider::create();

        $client->cancelPayout('somePayoutId');

     //   $payoutGroupId = $payout->getGroupId();
        $cancelledPayouts = $client->cancelPayoutGroup('payoutGroupId');
    }

    public function requestPayoutWebhookToBeResent(): void
    {
        $client = ClientProvider::create();

        $client->requestPayoutNotification('somePayoutId');
    }
}
