<?php

namespace BitPaySDK\Client;

use BitPaySDK\Exceptions\BillCreationException;
use BitPaySDK\Exceptions\BillDeliveryException;
use BitPaySDK\Exceptions\BillQueryException;
use BitPaySDK\Exceptions\BillUpdateException;
use BitPaySDK\Exceptions\BitPayException;
use BitPaySDK\Model\Bill\Bill;
use BitPaySDK\Model\Facade;
use BitPaySDK\Tokens;
use BitPaySDK\Util\RESTcli\RESTcli;
use Exception;

class BillClient
{
    private Tokens $tokenCache;
    private RESTcli $restCli;

    public function __construct(Tokens $tokenCache, RESTcli $restCli)
    {
        $this->tokenCache = $tokenCache;
        $this->restCli = $restCli;
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
    public function create(Bill $bill, string $facade = Facade::Merchant, bool $signRequest = true): Bill
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
            $mapper = new \JsonMapper();
            $mapper->bEnforceMapType = false;
            $bill = $mapper->map(
                json_decode($responseJson),
                new Bill()
            );
        } catch (Exception $e) {
            throw new BillCreationException(
                "failed to deserialize BitPay server response (Bill) : " . $e->getMessage()
            );
        }

        return $bill;
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
    public function get(string $billId, string $facade = Facade::Merchant, bool $signRequest = true): Bill
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
            $mapper = new \JsonMapper();
            $mapper->bEnforceMapType = false;
            $bill = $mapper->map(
                json_decode($responseJson),
                new Bill()
            );
        } catch (Exception $e) {
            throw new BillQueryException(
                "failed to deserialize BitPay server response (Bill) : " . $e->getMessage()
            );
        }

        return $bill;
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
            $params["token"] = $this->tokenCache->getTokenByFacade(Facade::Merchant);
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
            $mapper = new \JsonMapper();
            $mapper->bEnforceMapType = false;
            $bills = $mapper->mapArray(
                json_decode($responseJson),
                [],
                'BitPaySDK\Model\Bill\Bill'
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
            $mapper = new \JsonMapper();
            $mapper->bEnforceMapType = false;
            $bill = $mapper->map(
                json_decode($responseJson),
                $bill
            );
        } catch (Exception $e) {
            throw new BillUpdateException("failed to deserialize BitPay server response (Bill) : " . $e->getMessage());
        }

        return $bill;
    }

    /**
     * Deliver a BitPay Bill.
     *
     * @param  string $billId      The id of the requested bill.
     * @param  string $billToken   The token of the requested bill.
     * @param  bool   $signRequest Allow unsigned request
     * @return string
     * @throws BitPayException
     */
    public function deliver(string $billId, string $billToken, bool $signRequest = true): string
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
        } catch (Exception $e) {
            throw new BillDeliveryException(
                "failed to deserialize BitPay server response (Bill) : " . $e->getMessage()
            );
        }

        return $result;
    }
}
