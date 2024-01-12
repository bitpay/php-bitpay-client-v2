<?php

declare(strict_types=1);

namespace BitPaySDKexamples\Ledger;

use BitPaySDKexamples\ClientProvider;

final class LedgerRequests
{
    /**
     * @throws \BitPaySDK\Exceptions\BitPayApiException
     * @throws \BitPaySDK\Exceptions\BitPayGenericException
     */
    public function getLedgers(): void
    {
        $client = ClientProvider::create();

        $ledgers = $client->getLedgers();
    }

    /**
     * @throws \BitPaySDK\Exceptions\BitPayApiException
     * @throws \BitPaySDK\Exceptions\BitPayGenericException
     */
    public function getLedgerEntries(): void
    {
        $client = ClientProvider::create();

        $ledgerEntries = $client->getLedgerEntries('USD', '2023-08-14', '2023-08-22');
    }
}
