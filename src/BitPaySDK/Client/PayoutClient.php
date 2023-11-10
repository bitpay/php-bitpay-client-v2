<?php

/**
 * Copyright (c) 2019 BitPay
 **/

declare(strict_types=1);

namespace BitPaySDK\Client;

use BitPaySDK\Exceptions\BitPayApiException;
use BitPaySDK\Exceptions\BitPayExceptionProvider;
use BitPaySDK\Exceptions\BitPayGenericException;
use BitPaySDK\Model\Facade;
use BitPaySDK\Model\Payout\Payout;
use BitPaySDK\Model\Payout\PayoutGroup;
use BitPaySDK\Model\Payout\PayoutGroupFailed;
use BitPaySDK\Tokens;
use BitPaySDK\Util\JsonMapperFactory;
use BitPaySDK\Util\RESTcli\RESTcli;
use Exception;

/**
 * Handles interactions with the payout endpoints.
 *
 * @package BitPaySDK\Client
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
class PayoutClient
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
     * Factory method for Payout Client.
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
     * Submit a BitPay Payout.
     *
     * @param Payout $payout A Payout object with request parameters defined.
     * @return Payout
     * @throws BitPayApiException
     * @throws BitPayGenericException
     */
    public function submit(Payout $payout): Payout
    {
        $payout->setToken($this->tokenCache->getTokenByFacade(Facade::PAYOUT));
        $payout->formatAmount(2);

        $responseJson = $this->restCli->post("payouts", $payout->toArray());

        try {
            $mapper = JsonMapperFactory::create();

            return $mapper->map(
                json_decode($responseJson, true, 512, JSON_THROW_ON_ERROR),
                new Payout()
            );
        } catch (Exception $e) {
            BitPayExceptionProvider::throwDeserializeResourceException('Payout', $e->getMessage());
        }
    }

    /**
     * Retrieve a BitPay payout by payout id using. The client must have been previously authorized
     * for the payout facade.
     *
     * @param string $payoutId The id of the payout to retrieve.
     * @return Payout
     * @throws BitPayGenericException
     * @throws BitPayApiException
     */
    public function get(string $payoutId): Payout
    {
        $params = [];
        $params["token"] = $this->tokenCache->getTokenByFacade(Facade::PAYOUT);

        $responseJson = $this->restCli->get("payouts/" . $payoutId, $params);

        try {
            $mapper = JsonMapperFactory::create();

            return $mapper->map(
                json_decode($responseJson, true, 512, JSON_THROW_ON_ERROR),
                new Payout()
            );
        } catch (Exception $e) {
            BitPayExceptionProvider::throwDeserializeResourceException('Payout', $e->getMessage());
        }
    }

    /**
     * Retrieve a collection of BitPay payouts.
     *
     * @param string|null $startDate The start date to filter the Payout Batches.
     * @param string|null $endDate The end date to filter the Payout Batches.
     * @param string|null $status The status to filter the Payout Batches.
     * @param string|null $reference The optional reference specified at payout request creation.
     * @param int|null $limit Maximum results that the query will return (useful for paging results).
     * @param int|null $offset Number of results to offset (ex. skip 10 will give you results
     *                           starting with the 11th result).
     * @return Payout[]
     * @throws BitPayApiException
     * @throws BitPayGenericException
     */
    public function getPayouts(
        string $startDate = null,
        string $endDate = null,
        string $status = null,
        string $reference = null,
        int $limit = null,
        int $offset = null
    ): array {
        $params = [];
        $params["token"] = $this->tokenCache->getTokenByFacade(Facade::PAYOUT);
        if ($startDate) {
            $params["startDate"] = $startDate;
        }
        if ($endDate) {
            $params["endDate"] = $endDate;
        }
        if ($status) {
            $params["status"] = $status;
        }
        if ($reference) {
            $params["reference"] = $reference;
        }
        if ($limit) {
            $params["limit"] = $limit;
        }
        if ($offset) {
            $params["offset"] = $offset;
        }

        $responseJson = $this->restCli->get("payouts", $params);

        try {
            $mapper = JsonMapperFactory::create();

            return $mapper->mapArray(
                json_decode($responseJson, true, 512, JSON_THROW_ON_ERROR),
                [],
                Payout::class
            );
        } catch (Exception $e) {
            BitPayExceptionProvider::throwDeserializeResourceException('Payout', $e->getMessage());
        }
    }

    /**
     * Cancel a BitPay Payout.
     *
     * @param string $payoutId The id of the payout to cancel.
     * @return bool
     * @throws BitPayApiException
     * @throws BitPayGenericException
     */
    public function cancel(string $payoutId): bool
    {
        $params = [];
        $params["token"] = $this->tokenCache->getTokenByFacade(Facade::PAYOUT);

        $responseJson = $this->restCli->delete("payouts/" . $payoutId, $params);

        try {
            $result = json_decode($responseJson, false, 512, JSON_THROW_ON_ERROR);

            return strtolower($result->status) === "success";
        } catch (Exception $e) {
            BitPayExceptionProvider::throwDeserializeException($e->getMessage());
        }
    }

    /**
     * Notify BitPay Payout.
     *
     * @param string $payoutId The id of the Payout to notify.
     * @return bool
     * @throws BitPayApiException
     * @throws BitPayGenericException
     */
    public function requestNotification(string $payoutId): bool
    {
        $content = [];
        $content["token"] = $this->tokenCache->getTokenByFacade(Facade::PAYOUT);

        $responseJson = $this->restCli->post("payouts/" . $payoutId . "/notifications", $content);

        try {
            $result = json_decode($responseJson, false, 512, JSON_THROW_ON_ERROR);

            return strtolower($result->status) === "success";
        } catch (Exception $e) {
            BitPayExceptionProvider::throwDeserializeException($e->getMessage());
        }
    }

    /**
     * @param Payout[] $payouts
     * @throws BitPayApiException
     * @throws BitPayGenericException
     */
    public function createGroup(array $payouts): PayoutGroup
    {
        $request = [];
        $request['token'] = $this->tokenCache->getTokenByFacade(Facade::PAYOUT);

        foreach ($payouts as $payout) {
            $request['instructions'][] = $payout->toArray();
        }

        $responseJson = $this->restCli->post("payouts/group", $request);

        return $this->getPayoutGroupResponse($responseJson, 'created');
    }

    /**
     * @throws BitPayApiException
     * @throws BitPayGenericException
     */
    public function cancelGroup(string $groupId): PayoutGroup
    {
        $request = [];
        $request['token'] = $this->tokenCache->getTokenByFacade(Facade::PAYOUT);
        $responseJson = $this->restCli->delete("payouts/group/" . $groupId, $request);

        return $this->getPayoutGroupResponse($responseJson, 'cancelled');
    }

    /**
     * @param string $responseJson
     * @param string $responseType completed/cancelled
     * @return PayoutGroup
     * @throws BitPayGenericException
     */
    private function getPayoutGroupResponse(string $responseJson, string $responseType): PayoutGroup
    {
        try {
            $mapper = JsonMapperFactory::create();
            $response = json_decode($responseJson, true, 512, JSON_THROW_ON_ERROR);

            if (!array_key_exists($responseType, $response)) {
                throw new \RuntimeException(print_r($response, true));
            }

            $payouts = $mapper->mapArray($response[$responseType], [], Payout::class);
            $mapper->bIgnoreVisibility = true;
            $failed = $mapper->mapArray($response['failed'], [], PayoutGroupFailed::class);

            $payoutGroup = new PayoutGroup();
            $payoutGroup->setPayouts($payouts);
            $payoutGroup->setFailed($failed);

            return $payoutGroup;
        } catch (Exception $e) {
            BitPayExceptionProvider::throwDeserializeResourceException('Payout', $e->getMessage());
        }
    }
}
