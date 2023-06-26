<?php

/**
 * Copyright (c) 2019 BitPay
 **/

declare(strict_types=1);

namespace BitPaySDK\Client;

use BitPaySDK\Exceptions\BitPayException;
use BitPaySDK\Exceptions\RateQueryException;
use BitPaySDK\Model\Rate\Rate;
use BitPaySDK\Model\Rate\Rates;
use BitPaySDK\Util\JsonMapperFactory;
use BitPaySDK\Util\RESTcli\RESTcli;
use Exception;

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
     * @throws BitPayException
     */
    public function getRates(): Rates
    {
        try {
            $responseJson = $this->restCli->get("rates", null, false);
        } catch (BitPayException $e) {
            throw new RateQueryException(
                "failed to serialize Rates object : " .
                $e->getMessage(),
                null,
                null,
                $e->getApiCode()
            );
        } catch (Exception $e) {
            throw new RateQueryException("failed to serialize Rates object : " . $e->getMessage());
        }

        try {
            $mapper = JsonMapperFactory::create();
            $rates = $mapper->mapArray(
                json_decode($responseJson, true, 512, JSON_THROW_ON_ERROR),
                [],
                Rate::class
            );
        } catch (Exception $e) {
            throw new RateQueryException(
                "failed to deserialize BitPay server response (Rates) : " . $e->getMessage()
            );
        }

        return new Rates($rates);
    }

    /**
     * Retrieve all the rates for a given cryptocurrency
     *
     * @param string $baseCurrency The cryptocurrency for which you want to fetch the rates.
     *                             Current supported values are BTC, BCH, ETH, XRP, DOGE and LTC
     * @return Rates               A Rates object populated with the currency rates for the requested baseCurrency.
     * @throws BitPayException
     */
    public function getCurrencyRates(string $baseCurrency): Rates
    {
        try {
            $responseJson = $this->restCli->get("rates/" . $baseCurrency, null, false);
        } catch (BitPayException $e) {
            throw new RateQueryException(
                "failed to serialize Rates object : " .
                $e->getMessage(),
                null,
                null,
                $e->getApiCode()
            );
        } catch (Exception $e) {
            throw new RateQueryException("failed to serialize Rates object : " . $e->getMessage());
        }

        try {
            $mapper = JsonMapperFactory::create();
            $rates = $mapper->mapArray(
                json_decode($responseJson, true, 512, JSON_THROW_ON_ERROR),
                [],
                Rate::class
            );
        } catch (Exception $e) {
            throw new RateQueryException(
                "failed to deserialize BitPay server response (Rates) : " . $e->getMessage()
            );
        }

        return new Rates($rates);
    }

    /**
     * Retrieve the rate for a cryptocurrency / fiat pair
     *
     * @param string $baseCurrency The cryptocurrency for which you want to fetch the fiat-equivalent rate.
     *                             Current supported values are BTC, BCH, ETH, XRP, DOGE and LTC
     * @param string $currency     The fiat currency for which you want to fetch the baseCurrency rate
     * @return Rate                A Rate object populated with the currency rate for the requested baseCurrency.
     * @throws BitPayException
     */
    public function getCurrencyPairRate(string $baseCurrency, string $currency): Rate
    {
        try {
            $responseJson = $this->restCli->get("rates/" . $baseCurrency . "/" . $currency, null, false);
        } catch (BitPayException $e) {
            throw new RateQueryException(
                "failed to serialize Rates object : " .
                $e->getMessage(),
                null,
                null,
                $e->getApiCode()
            );
        } catch (Exception $e) {
            throw new RateQueryException("failed to serialize Rate object : " . $e->getMessage());
        }

        try {
            $mapper = JsonMapperFactory::create();

            return $mapper->map(
                json_decode($responseJson, true, 512, JSON_THROW_ON_ERROR),
                new Rate()
            );
        } catch (Exception $e) {
            throw new RateQueryException(
                "failed to deserialize BitPay server response (Rate) : " . $e->getMessage()
            );
        }
    }
}
