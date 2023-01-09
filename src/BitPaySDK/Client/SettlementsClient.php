<?php

namespace BitPaySDK\Client;

use BitPaySDK\Exceptions\BitPayException;
use BitPaySDK\Exceptions\SettlementQueryException;
use BitPaySDK\Model\Facade;
use BitPaySDK\Model\Settlement\Settlement;
use BitPaySDK\Tokens;
use BitPaySDK\Util\JsonMapperFactory;
use BitPaySDK\Util\RESTcli\RESTcli;
use Exception;

class SettlementsClient
{
    private Tokens $tokenCache;
    private RESTcli $restCli;

    public function __construct(Tokens $tokenCache, RESTcli $restCli)
    {
        $this->tokenCache = $tokenCache;
        $this->restCli = $restCli;
    }

    /**
     * Retrieves settlement reports for the calling merchant filtered by query.
     * The `limit` and `offset` parameters
     * specify pages for large query sets.
     *
     * @param $currency  string The three digit currency string for the ledger to retrieve.
     * @param $dateStart string The start date for the query.
     * @param $dateEnd   string The end date for the query.
     * @param $status    string Can be `processing`, `completed`, or `failed`.
     * @param $limit     int Maximum number of settlements to retrieve.
     * @param $offset    int Offset for paging.
     * @return Settlement[]
     * @throws BitPayException
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
            $status = $status != null ? $status : "";
            $limit = $limit != null ? $limit : 100;
            $offset = $offset != null ? $offset : 0;

            $params = [];
            $params["token"] = $this->tokenCache->getTokenByFacade(Facade::Merchant);
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
            $settlements = $mapper->mapArray(
                json_decode($responseJson),
                [],
                'BitPaySDK\Model\Settlement\Settlement'
            );
        } catch (Exception $e) {
            throw new SettlementQueryException(
                "failed to deserialize BitPay server response (Settlement) : " . $e->getMessage()
            );
        }

        return $settlements;
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
            $params["token"] = $this->tokenCache->getTokenByFacade(Facade::Merchant);

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
            $settlement = $mapper->map(
                json_decode($responseJson),
                new Settlement()
            );
        } catch (Exception $e) {
            throw new SettlementQueryException(
                "failed to deserialize BitPay server response (Settlement) : " . $e->getMessage()
            );
        }

        return $settlement;
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
            $reconciliationReport = $mapper->map(
                json_decode($responseJson),
                new Settlement()
            );
        } catch (Exception $e) {
            throw new SettlementQueryException(
                "failed to deserialize BitPay server response (Reconciliation Report) : " . $e->getMessage()
            );
        }

        return $reconciliationReport;
    }
}
