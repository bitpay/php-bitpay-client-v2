<?php

/**
 * Copyright (c) 2019 BitPay
 **/

declare(strict_types=1);

namespace BitPaySDK\Client;

use BitPaySDK\Exceptions\BillCreationException;
use BitPaySDK\Exceptions\BillDeliveryException;
use BitPaySDK\Exceptions\BillQueryException;
use BitPaySDK\Exceptions\BillUpdateException;
use BitPaySDK\Exceptions\BitPayException;
use BitPaySDK\Model\Bill\Bill;
use BitPaySDK\Model\Facade;
use BitPaySDK\Tokens;
use BitPaySDK\Util\JsonMapperFactory;
use BitPaySDK\Util\RESTcli\RESTcli;
use Exception;

class BillClient
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
     * Factory method for Bill Client.
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
     * Create a BitPay Bill.
     *
     * @param  Bill   $bill        A Bill object with request parameters defined.
     * @param  string $facade      The facade used to create it.
     * @param  bool   $signRequest Signed request.
     * @return Bill
     * @throws BitPayException
     */
    public function create(Bill $bill, string $facade = Facade::MERCHANT, bool $signRequest = true): Bill
    {
        try {
            $bill->setToken($this->tokenCache->getTokenByFacade($facade));

            $responseJson = $this->restCli->post("bills", $bill->toArray(), $signRequest);
        } catch (BitPayException $e) {
            throw new BillCreationException(
                "failed to serialize Bill object : " .
                $e->getMessage(),
                null,
                null,
                $e->getApiCode()
            );
        } catch (Exception $e) {
            throw new BillCreationException("failed to serialize Bill object : " . $e->getMessage());
        }

        try {
            return $this->mapJsonToBillClass($responseJson);
        } catch (Exception $e) {
            throw new BillCreationException(
                "failed to deserialize BitPay server response (Bill) : " . $e->getMessage()
            );
        }
    }

    /**
     * Retrieve a BitPay bill by bill id using the specified facade.
     *
     * @param $billId      string The id of the bill to retrieve.
     * @param $facade      string The facade used to retrieve it.
     * @param $signRequest bool Signed request.
     * @return Bill
     * @throws BitPayException
     */
    public function get(string $billId, string $facade = Facade::MERCHANT, bool $signRequest = true): Bill
    {
        try {
            $params = [];
            $params["token"] = $this->tokenCache->getTokenByFacade($facade);

            $responseJson = $this->restCli->get("bills/" . $billId, $params, $signRequest);
        } catch (BitPayException $e) {
            throw new BillQueryException(
                "failed to serialize Bill object : " .
                $e->getMessage(),
                null,
                null,
                $e->getApiCode()
            );
        } catch (Exception $e) {
            throw new BillQueryException("failed to serialize Bill object : " . $e->getMessage());
        }

        try {
            return $this->mapJsonToBillClass($responseJson);
        } catch (Exception $e) {
            throw new BillQueryException(
                "failed to deserialize BitPay server response (Bill) : " . $e->getMessage()
            );
        }
    }

    /**
     * Retrieve a collection of BitPay bills.
     *
     * @param  string|null The status to filter the bills.
     * @return Bill[]
     * @throws BitPayException
     */
    public function getBills(string $status = null): array
    {
        try {
            $params = [];
            $params["token"] = $this->tokenCache->getTokenByFacade(Facade::MERCHANT);
            if ($status) {
                $params["status"] = $status;
            }

            $responseJson = $this->restCli->get("bills", $params);
        } catch (BitPayException $e) {
            throw new BillQueryException(
                "failed to serialize Bill object : " .
                $e->getMessage(),
                null,
                null,
                $e->getApiCode()
            );
        } catch (Exception $e) {
            throw new BillQueryException("failed to serialize Bill object : " . $e->getMessage());
        }

        try {
            $mapper = JsonMapperFactory::create();
            $bills = $mapper->mapArray(
                json_decode($responseJson, true, 512, JSON_THROW_ON_ERROR),
                [],
                Bill::class
            );
        } catch (Exception $e) {
            throw new BillQueryException(
                "failed to deserialize BitPay server response (Bill) : " . $e->getMessage()
            );
        }

        return $bills;
    }

    /**
     * Update a BitPay Bill.
     *
     * @param  Bill   $bill   A Bill object with the parameters to update defined.
     * @param  string $billId The Id of the Bill to update.
     * @return Bill
     * @throws BitPayException
     */
    public function update(Bill $bill, string $billId): Bill
    {
        try {
            $billToken = $this->get($bill->getId())->getToken();
            $bill->setToken($billToken);

            $responseJson = $this->restCli->update("bills/" . $billId, $bill->toArray());
        } catch (BitPayException $e) {
            throw new BillUpdateException(
                "failed to serialize Bill object : " .
                $e->getMessage(),
                null,
                null,
                $e->getApiCode()
            );
        } catch (Exception $e) {
            throw new BillUpdateException("failed to serialize Bill object : " . $e->getMessage());
        }

        try {
            $mapper = JsonMapperFactory::create();

            return $mapper->map(
                json_decode($responseJson, true, 512, JSON_THROW_ON_ERROR),
                $bill
            );
        } catch (Exception $e) {
            throw new BillUpdateException("failed to deserialize BitPay server response (Bill) : " . $e->getMessage());
        }
    }

    /**
     * Deliver a BitPay Bill.
     *
     * @param  string $billId      The id of the requested bill.
     * @param  string $billToken   The token of the requested bill.
     * @param  bool   $signRequest Allow unsigned request
     * @return bool
     * @throws BitPayException
     */
    public function deliver(string $billId, string $billToken, bool $signRequest = true): bool
    {
        try {
            $responseJson = $this->restCli->post(
                "bills/" . $billId . "/deliveries",
                ['token' => $billToken],
                $signRequest
            );
        } catch (BitPayException $e) {
            throw new BillDeliveryException(
                "failed to serialize Bill object : " .
                $e->getMessage(),
                null,
                null,
                $e->getApiCode()
            );
        } catch (Exception $e) {
            throw new BillDeliveryException("failed to serialize Bill object : " . $e->getMessage());
        }

        try {
            $result = str_replace("\"", "", $responseJson);

            return strtolower($result) === 'success';
        } catch (Exception $e) {
            throw new BillDeliveryException(
                "failed to deserialize BitPay server response (Bill) : " . $e->getMessage()
            );
        }
    }

    /**
     * @param string|null $responseJson
     * @return mixed
     * @throws \JsonException
     * @throws \JsonMapper_Exception
     */
    private function mapJsonToBillClass(?string $responseJson): mixed
    {
        $mapper = JsonMapperFactory::create();

        return $mapper->map(
            json_decode($responseJson, true, 512, JSON_THROW_ON_ERROR),
            new Bill()
        );
    }
}
