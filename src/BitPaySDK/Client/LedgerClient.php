<?php

/**
 * Copyright (c) 2019 BitPay
 **/

declare(strict_types=1);

namespace BitPaySDK\Client;

use BitPaySDK\Exceptions\BitPayException;
use BitPaySDK\Exceptions\LedgerQueryException;
use BitPaySDK\Model\Facade;
use BitPaySDK\Model\Ledger\Ledger;
use BitPaySDK\Model\Ledger\LedgerEntry;
use BitPaySDK\Tokens;
use BitPaySDK\Util\JsonMapperFactory;
use BitPaySDK\Util\RESTcli\RESTcli;
use Exception;

class LedgerClient
{
    private static ?self $instance = null;
    private Tokens $tokenCache;
    private RESTcli $restCli;

    private function __construct(Tokens $tokenCache, RESTcli $restCli)
    {
        $this->tokenCache = $tokenCache;
        $this->restCli = $restCli;
    }

    /**
     * Factory method for Ledger Client.
     *
     * @param Tokens $tokenCache
     * @param RESTcli $restCli
     * @return static
     */
    public static function getInstance(Tokens $tokenCache, RESTcli $restCli): self
    {
        if (!self::$instance) {
            self::$instance = new self($tokenCache, $restCli);
        }

        return self::$instance;
    }

    /**
     * Retrieve a list of ledgers by date range using the merchant facade.
     *
     * @param string $currency The three digit currency string for the ledger to retrieve.
     * @param string $startDate The first date for the query filter.
     * @param string $endDate The last date for the query filter.
     * @return LedgerEntry[] A Ledger object populated with the BitPay ledger entries list.
     * @throws LedgerQueryException
     */
    public function get(string $currency, string $startDate, string $endDate): array
    {
        try {
            $params = [];
            $params["token"] = $this->tokenCache->getTokenByFacade(Facade::MERCHANT);
            if ($currency) {
                $params["currency"] = $currency;
            }
            if ($currency) {
                $params["startDate"] = $startDate;
            }
            if ($currency) {
                $params["endDate"] = $endDate;
            }

            $responseJson = $this->restCli->get("ledgers/" . $currency, $params);
        } catch (BitPayException $e) {
            throw new LedgerQueryException(
                "failed to serialize Ledger object : " .
                $e->getMessage(),
                null,
                null,
                $e->getApiCode()
            );
        } catch (Exception $e) {
            throw new LedgerQueryException("failed to serialize Ledger object : " . $e->getMessage());
        }

        try {
            $mapper = JsonMapperFactory::create();
            $ledger = $mapper->mapArray(
                json_decode($responseJson, true, 512, JSON_THROW_ON_ERROR),
                [],
                LedgerEntry::class
            );
        } catch (Exception $e) {
            throw new LedgerQueryException(
                "failed to deserialize BitPay server response (Ledger) : " . $e->getMessage()
            );
        }

        return $ledger;
    }

    /**
     * Retrieve a list of ledgers using the merchant facade.
     *
     * @return Ledger[] A list of Ledger objects populated with the currency and current balance of each one.
     * @throws BitPayException
     */
    public function getLedgers(): array
    {
        try {
            $params = [];
            $params["token"] = $this->tokenCache->getTokenByFacade(Facade::MERCHANT);

            $responseJson = $this->restCli->get("ledgers", $params);
        } catch (BitPayException $e) {
            throw new LedgerQueryException(
                "failed to serialize Ledger object : " .
                $e->getMessage(),
                null,
                null,
                $e->getApiCode()
            );
        } catch (Exception $e) {
            throw new LedgerQueryException("failed to serialize Ledger object : " . $e->getMessage());
        }

        try {
            $mapper = JsonMapperFactory::create();
            $ledgers = $mapper->mapArray(
                json_decode($responseJson, true, 512, JSON_THROW_ON_ERROR),
                [],
                Ledger::class
            );
        } catch (Exception $e) {
            throw new LedgerQueryException(
                "failed to deserialize BitPay server response (Ledger) : " . $e->getMessage()
            );
        }

        return $ledgers;
    }
}
