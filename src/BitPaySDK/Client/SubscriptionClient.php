<?php

/**
 * Copyright (c) 2025 BitPay
 **/

declare(strict_types=1);

namespace BitPaySDK\Client;

use BitPaySDK\Exceptions\BitPayApiException;
use BitPaySDK\Exceptions\BitPayExceptionProvider;
use BitPaySDK\Exceptions\BitPayGenericException;
use BitPaySDK\Model\Subscription\Subscription;
use BitPaySDK\Model\Facade;
use BitPaySDK\Tokens;
use BitPaySDK\Util\JsonMapperFactory;
use BitPaySDK\Util\RESTcli\RESTcli;
use Exception;

/**
 * Handles interactions with the subscriptions endpoints.
 *
 * @package BitPaySDK\Client
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
class SubscriptionClient
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
     * Factory method for Subscription Client.
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
     * Create a BitPay Subscription.
     *
     * @param Subscription $subscription A Subscription object with request parameters defined.
     * @return Subscription Created Subscription object
     * @throws BitPayApiException
     * @throws BitPayGenericException
     */
    public function create(Subscription $subscription): Subscription
    {
        $subscription->setToken($this->tokenCache->getTokenByFacade(Facade::MERCHANT));

        $responseJson = $this->restCli->post("subscriptions", $subscription->toArray());

        try {
            return $this->mapJsonToSubscriptionClass($responseJson);
        } catch (Exception $e) {
            BitPayExceptionProvider::throwDeserializeResourceException('Subscription', $e->getMessage());
        }
    }

    /**
     * Retrieve a BitPay subscription by its resource ID.
     *
     * @param $subscriptionId      string The id of the subscription to retrieve.
     * @return Subscription Retrieved Subscription object
     * @throws BitPayApiException
     * @throws BitPayGenericException
     */
    public function get(string $subscriptionId): Subscription
    {
        $params = [];
        $params["token"] = $this->tokenCache->getTokenByFacade(Facade::MERCHANT);

        $responseJson = $this->restCli->get("subscriptions/" . $subscriptionId, $params);

        try {
            return $this->mapJsonToSubscriptionClass($responseJson);
        } catch (Exception $e) {
            BitPayExceptionProvider::throwDeserializeResourceException('Subscription', $e->getMessage());
        }
    }

    /**
     * Retrieve a collection of BitPay subscriptions.
     *
     * @param string|null $status The status to filter the subscriptions.
     * @return Subscription[] Filtered list of Subscription objects
     * @throws BitPayApiException
     * @throws BitPayGenericException
     */
    public function getSubscriptions(?string $status = null): array
    {
        $params = [];
        $params["token"] = $this->tokenCache->getTokenByFacade(Facade::MERCHANT);
        if ($status) {
            $params["status"] = $status;
        }

        $responseJson = $this->restCli->get("subscriptions", $params);

        try {
            $mapper = JsonMapperFactory::create();
            return $mapper->mapArray(
                json_decode($responseJson, true, 512, JSON_THROW_ON_ERROR),
                [],
                Subscription::class
            );
        } catch (Exception $e) {
            BitPayExceptionProvider::throwDeserializeResourceException('Subscription', $e->getMessage());
        }
    }

    /**
     * Update a BitPay Subscription.
     *
     * @param Subscription $subscription A Subscription object with the parameters to update defined.
     * @param string $subscriptionId The ID of the Subscription to update.
     * @return Subscription Updated Subscription object
     * @throws BitPayApiException
     * @throws BitPayGenericException
     */
    public function update(Subscription $subscription, string $subscriptionId): Subscription
    {
        $subscriptionToken = $this->get($subscription->getId())->getToken();
        $subscription->setToken($subscriptionToken);

        $responseJson = $this->restCli->update("subscriptions/" . $subscriptionId, $subscription->toArray());

        try {
            $mapper = JsonMapperFactory::create();

            return $mapper->map(
                json_decode($responseJson, true, 512, JSON_THROW_ON_ERROR),
                $subscription
            );
        } catch (Exception $e) {
            BitPayExceptionProvider::throwDeserializeResourceException('Subscription', $e->getMessage());
        }
    }

    /**
     * @param string|null $responseJson
     * @return Subscription
     * @throws \JsonException
     * @throws \JsonMapper_Exception
     */
    private function mapJsonToSubscriptionClass(?string $responseJson): Subscription
    {
        $mapper = JsonMapperFactory::create();

        return $mapper->map(
            json_decode($responseJson, true, 512, JSON_THROW_ON_ERROR),
            new Subscription()
        );
    }
}
