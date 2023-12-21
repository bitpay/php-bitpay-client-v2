<?php

declare(strict_types=1);

namespace BitPaySDKexamples\Public;

use BitPaySDKexamples\ClientProvider;

final class RateRequests
{
    /**
     * @throws \BitPaySDK\Exceptions\BitPayApiException
     * @throws \BitPaySDK\Exceptions\BitPayGenericException
     */
    public function getRate(): void
    {
        $client = ClientProvider::create();

        $allRates = $client->getRates();

        $currencyRates = $client->getCurrencyRates('BTC');

        $currencyPairRate = $client->getCurrencyPairRate('BTC', 'USD');
    }
}
