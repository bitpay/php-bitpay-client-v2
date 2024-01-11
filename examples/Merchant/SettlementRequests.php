<?php

declare(strict_types=1);

namespace BitPaySDKexamples\Merchant;

use BitPaySDKexamples\ClientProvider;

final class SettlementRequests
{
    /**
     * @throws \BitPaySDK\Exceptions\BitPayApiException
     * @throws \BitPaySDK\Exceptions\BitPayGenericException
     */
    public function getSettlement(): void
    {
        $client = ClientProvider::create();

        $settlement = $client->getSettlement('someSettlementId');
        $settlements = $client->getSettlements('USD', '2023-08-14', '2023-08-22');
    }

    /**
     * @throws \BitPaySDK\Exceptions\BitPayApiException
     * @throws \BitPaySDK\Exceptions\BitPayGenericException
     */
    public function fetchReconciliationReport(): void
    {
        $client = ClientProvider::create();

        $client->getSettlementReconciliationReport('settlementId', 'settlementToken');
    }
}
