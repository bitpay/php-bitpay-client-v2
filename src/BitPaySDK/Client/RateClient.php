<?php

/**
 * Copyright (c) 2019 BitPay
 **/

declare(strict_types=1);

namespace BitPaySDK\Client;

use BitPaySDK\Exceptions\BitPayApiException;
use BitPaySDK\Exceptions\BitPayExceptionProvider;
use BitPaySDK\Exceptions\BitPayGenericException;
use BitPaySDK\Model\Rate\Rate;
use BitPaySDK\Model\Rate\Rates;
use BitPaySDK\Util\JsonMapperFactory;
use BitPaySDK\Util\RESTcli\RESTcli;
use Exception;

/**
 * Handles interactions with the rate endpoints.
 *
 * @package BitPaySDK\Client
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
class RateClient
{
    private static ?self $instance = null;
    private RESTcli $restCli;

    private function __construct(RESTcli $restCli)
    {
        $this->restCli = $restCli;
    }

    /**
     * Factory method for Rate Client.
     *
     * @param RESTcli $restCli
     * @return static
     */
    public static function getInstance(RESTcli $restCli): self
    {
        if (!self::$instance) {
            self::$instance = new self($restCli);
        }

        return self::$instance;
    }

    /**
     * Retrieve the exchange rate table maintained by BitPay.  See https://bitpay.com/bitcoin-exchange-rates.
     *
     * @return Rates
     * @throws BitPayApiException
     * @throws BitPayGenericException
     */
    public function getRates(): Rates
    {
        $responseJson = $this->restCli->get("rates", null, false);

        try {
            $mapper = JsonMapperFactory::create();
            $rates = $mapper->mapArray(
                json_decode($responseJson, true, 512, JSON_THROW_ON_ERROR),
                [],
                Rate::class
            );
            return new Rates($rates);
        } catch (Exception $e) {
            BitPayExceptionProvider::throwDeserializeResourceException('Rate', $e->getMessage());
        }
    }

    /**
     * Retrieve all the rates for a given cryptocurrency
     *
     * @param string $baseCurrency The cryptocurrency for which you want to fetch the rates.
     *                             Current supported values are BTC, BCH, ETH, XRP, DOGE and LTC
     * @return Rates               A Rates object populated with the currency rates for the requested baseCurrency.
     * @throws BitPayApiException
     * @throws BitPayGenericException
     */
    public function getCurrencyRates(string $baseCurrency): Rates
    {
        $responseJson = $this->restCli->get("rates/" . $baseCurrency, null, false);

        try {
            $mapper = JsonMapperFactory::create();
            $rates = $mapper->mapArray(
                json_decode($responseJson, true, 512, JSON_THROW_ON_ERROR),
                [],
                Rate::class
            );
            return new Rates($rates);
        } catch (Exception $e) {
            BitPayExceptionProvider::throwDeserializeResourceException('Rate', $e->getMessage());
        }
    }

    /**
     * Retrieve the rate for a cryptocurrency / fiat pair
     *
     * @param string $baseCurrency The cryptocurrency for which you want to fetch the fiat-equivalent rate.
     *                             Current supported values are BTC, BCH, ETH, XRP, DOGE and LTC
     * @param string $currency The fiat currency for which you want to fetch the baseCurrency rate
     * @return Rate                A Rate object populated with the currency rate for the requested baseCurrency.
     * @throws BitPayApiException
     * @throws BitPayGenericException
     */
    public function getCurrencyPairRate(string $baseCurrency, string $currency): Rate
    {
        $responseJson = $this->restCli->get("rates/" . $baseCurrency . "/" . $currency, null, false);

        try {
            $mapper = JsonMapperFactory::create();

            return $mapper->map(
                json_decode($responseJson, true, 512, JSON_THROW_ON_ERROR),
                new Rate()
            );
        } catch (Exception $e) {
            BitPayExceptionProvider::throwDeserializeResourceException('Rate', $e->getMessage());
        }
    }
}
