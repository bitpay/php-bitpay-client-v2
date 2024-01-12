<?php

declare(strict_types=1);

namespace BitPaySDKexamples\Public;

use BitPaySDKexamples\ClientProvider;

final class WalletRequests
{
    /**
     * @throws \BitPaySDK\Exceptions\BitPayApiException
     * @throws \BitPaySDK\Exceptions\BitPayGenericException
     */
    public function getSupportedWallets(): void
    {
        $client = ClientProvider::create();

        $client->getSupportedWallets();
    }
}
