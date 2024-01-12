<?php

declare(strict_types=1);

namespace BitPaySDKexamples\Merchant;

use BitPaySDKexamples\ClientProvider;

final class RefundRequests
{
    /**
     * @throws \BitPaySDK\Exceptions\BitPayApiException
     * @throws \BitPaySDK\Exceptions\BitPayGenericException
     */
    public function createRefund(): void
    {
        $client = ClientProvider::create();

        $refund = $client->createRefund("myInvoiceId", 12.34, "USD");
    }

    /**
     * @throws \BitPaySDK\Exceptions\BitPayApiException
     */
    public function updateRefund(): void
    {
        $client = ClientProvider::create();

        $updatedRefund = $client->updateRefund('myRefundId','created');
        $updatedRefundByGuid = $client->updateRefundByGuid('myRefundId','created');
    }

    /**
     * @throws \BitPaySDK\Exceptions\BitPayApiException
     * @throws \BitPaySDK\Exceptions\BitPayGenericException
     */
    public function getRefund(): void
    {
        $client = ClientProvider::create();

        $refund = $client->getRefund('someRefundId');
        $refundByGuid = $client->getRefundByGuid('someGuid');
    }

    /**
     * @throws \BitPaySDK\Exceptions\BitPayApiException
     */
    public function cancelRefund(): void
    {
        $client = ClientProvider::create();

        $cancelRefund = $client->cancelRefund('myRefundId');
        $cancelRefundByGuid = $client->cancelRefundByGuid('someGuid');
    }

    public function requestRefundNotificationToBeResent(): void
    {
        $client = ClientProvider::create();

        $client->sendRefundNotification('someRefundId');
    }
}
