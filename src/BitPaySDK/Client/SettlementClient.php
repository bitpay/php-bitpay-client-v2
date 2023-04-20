<?php

/**
 * Copyright (c) 2019 BitPay
 **/

declare(strict_types=1);

namespace BitPaySDK\Client;

use BitPaySDK\Exceptions\BitPayException;
use BitPaySDK\Exceptions\SettlementQueryException;
use BitPaySDK\Model\Facade;
use BitPaySDK\Model\Settlement\Settlement;
use BitPaySDK\Tokens;
use BitPaySDK\Util\JsonMapperFactory;
use BitPaySDK\Util\RESTcli\RESTcli;
use Exception;

class SettlementClient
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
     * Factory method for Settlements Client.
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
     * Retrieves settlement reports for the calling merchant filtered by query.
     * The `limit` and `offset` parameters
     * specify pages for large query sets.
     *
     * @param string $currency The three digit currency string for the ledger to retrieve.
     * @param string $dateStart  The start date for the query.
     * @param string $dateEnd The end date for the query.
     * @param string|null $status string Can be `processing`, `completed`, or `failed`.
     * @param int|null $limit int Maximum number of settlements to retrieve.
     * @param int|null $offset int Offset for paging.
     * @return Settlement[]
     * @throws SettlementQueryException
     */
    public function getSettlements(
        string $currency,
        string $dateStart,
        string $dateEnd,
        string $status = null,
        int $limit = null,
        int $offset = null
    ): array {
        try {
            $status = $status ?? "";
            $limit = $limit ?? 100;
            $offset = $offset ?? 0;

            $params = [];
            $params["token"] = $this->tokenCache->getTokenByFacade(Facade::MERCHANT);
            $params["dateStart"] = $dateStart;
            $params["dateEnd"] = $dateEnd;
            $params["currency"] = $currency;
            $params["status"] = $status;
            $params["limit"] = (string)$limit;
            $params["offset"] = (string)$offset;

            $responseJson = $this->restCli->get("settlements", $params);
        } catch (BitPayException $e) {
            throw new SettlementQueryException(
                "failed to serialize Settlement object : " .
                $e->getMessage(),
                null,
                null,
                $e->getApiCode()
            );
        } catch (Exception $e) {
            throw new SettlementQueryException("failed to serialize Settlement object : " . $e->getMessage());
        }

        try {
            $mapper = JsonMapperFactory::create();

            return $mapper->mapArray(
                json_decode($responseJson, true, 512, JSON_THROW_ON_ERROR),
                [],
                Settlement::class
            );
        } catch (Exception $e) {
            throw new SettlementQueryException(
                "failed to deserialize BitPay server response (Settlement) : " . $e->getMessage()
            );
        }
    }

    /**
     * Retrieves a summary of the specified settlement.
     *
     * @param  string $settlementId Settlement Id.
     * @return Settlement
     * @throws BitPayException
     */
    public function get(string $settlementId): Settlement
    {
        try {
            $params = [];
            $params["token"] = $this->tokenCache->getTokenByFacade(Facade::MERCHANT);

            $responseJson = $this->restCli->get("settlements/" . $settlementId, $params);
        } catch (BitPayException $e) {
            throw new SettlementQueryException(
                "failed to serialize Settlement object : " .
                $e->getMessage(),
                null,
                null,
                $e->getApiCode()
            );
        } catch (Exception $e) {
            throw new SettlementQueryException("failed to serialize Settlement object : " . $e->getMessage());
        }

        try {
            $mapper = JsonMapperFactory::create();

            return $mapper->map(
                json_decode($responseJson, true, 512, JSON_THROW_ON_ERROR),
                new Settlement()
            );
        } catch (Exception $e) {
            throw new SettlementQueryException(
                "failed to deserialize BitPay server response (Settlement) : " . $e->getMessage()
            );
        }
    }

    /**
     * Gets a detailed reconciliation report of the activity within the settlement period.
     *
     * @param  Settlement $settlement Settlement to generate report for.
     * @return Settlement
     * @throws BitPayException
     */
    public function getReconciliationReport(Settlement $settlement): Settlement
    {
        try {
            $params = [];
            $params["token"] = $settlement->getToken();

            $responseJson = $this->restCli->get(
                "settlements/" . $settlement->getId() . "/reconciliationReport",
                $params
            );
        } catch (BitPayException $e) {
            throw new SettlementQueryException(
                "failed to serialize Reconciliation Report object : " .
                $e->getMessage(),
                null,
                null,
                $e->getApiCode()
            );
        } catch (Exception $e) {
            throw new SettlementQueryException(
                "failed to serialize Reconciliation Report object : " . $e->getMessage()
            );
        }

        try {
            $mapper = JsonMapperFactory::create();

            return $mapper->map(
                json_decode($responseJson, true, 512, JSON_THROW_ON_ERROR),
                new Settlement()
            );
        } catch (Exception $e) {
            throw new SettlementQueryException(
                "failed to deserialize BitPay server response (Reconciliation Report) : " . $e->getMessage()
            );
        }
    }
}
