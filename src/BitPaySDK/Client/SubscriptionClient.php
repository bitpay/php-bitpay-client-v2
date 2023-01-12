<?php

namespace BitPaySDK\Client;

use BitPaySDK\Exceptions\BitPayException;
use BitPaySDK\Exceptions\SubscriptionCreationException;
use BitPaySDK\Exceptions\SubscriptionQueryException;
use BitPaySDK\Exceptions\SubscriptionUpdateException;
use BitPaySDK\Model\Facade;
use BitPaySDK\Model\Subscription\Subscription;
use BitPaySDK\Tokens;
use BitPaySDK\Util\JsonMapperFactory;
use BitPaySDK\Util\RESTcli\RESTcli;
use Exception;

class SubscriptionClient
{
    private Tokens $tokenCache;
    private RESTcli $restCli;

    public function __construct(Tokens $tokenCache, RESTcli $restCli)
    {
        $this->tokenCache = $tokenCache;
        $this->restCli = $restCli;
    }

    /**
     * Create a BitPay Subscription.
     *
     * @param  Subscription $subscription A Subscription object with request parameters defined.
     * @return Subscription
     * @throws BitPayException
     */
    public function createSubscription(Subscription $subscription): Subscription
    {
        try {
            $subscription->setToken($this->tokenCache->getTokenByFacade(Facade::Merchant));

            $responseJson = $this->restCli->post("subscriptions", $subscription->toArray());
        } catch (BitPayException $e) {
            throw new SubscriptionCreationException(
                "failed to serialize Subscription object : " .
                $e->getMessage(),
                null,
                null,
                $e->getApiCode()
            );
        } catch (Exception $e) {
            throw new SubscriptionCreationException("failed to serialize Subscription object : " . $e->getMessage());
        }

        try {
            $mapper = JsonMapperFactory::create();
            $subscription = $mapper->map(
                json_decode($responseJson),
                new Subscription()
            );
        } catch (Exception $e) {
            throw new SubscriptionCreationException(
                "failed to deserialize BitPay server response (Subscription) : " . $e->getMessage()
            );
        }

        return $subscription;
    }

    /**
     * Retrieve a BitPay subscription by subscription id using the specified facade.
     *
     * @param  string $subscriptionId The id of the subscription to retrieve.
     * @return Subscription
     * @throws BitPayException
     */
    public function getSubscription(string $subscriptionId): Subscription
    {

        try {
            $params = [];
            $params["token"] = $this->tokenCache->getTokenByFacade(Facade::Merchant);

            $responseJson = $this->restCli->get("subscriptions/" . $subscriptionId, $params);
        } catch (BitPayException $e) {
            throw new SubscriptionQueryException(
                "failed to serialize Subscription object : " .
                $e->getMessage(),
                null,
                null,
                $e->getApiCode()
            );
        } catch (Exception $e) {
            throw new SubscriptionQueryException("failed to serialize Subscription object : " . $e->getMessage());
        }

        try {
            $mapper = JsonMapperFactory::create();
            $subscription = $mapper->map(
                json_decode($responseJson),
                new Subscription()
            );
        } catch (Exception $e) {
            throw new SubscriptionQueryException(
                "failed to deserialize BitPay server response (Subscription) : " . $e->getMessage()
            );
        }

        return $subscription;
    }

    /**
     * Retrieve a collection of BitPay subscriptions.
     *
     * @param  string|null $status The status to filter the subscriptions.
     * @return Subscription[]
     * @throws BitPayException
     */
    public function getSubscriptions(string $status = null): array
    {
        try {
            $params = [];
            $params["token"] = $this->tokenCache->getTokenByFacade(Facade::Merchant);
            if ($status) {
                $params["status"] = $status;
            }

            $responseJson = $this->restCli->get("subscriptions", $params);
        } catch (BitPayException $e) {
            throw new SubscriptionQueryException(
                "failed to serialize Subscription object : " .
                $e->getMessage(),
                null,
                null,
                $e->getApiCode()
            );
        } catch (Exception $e) {
            throw new SubscriptionQueryException("failed to serialize Subscription object : " . $e->getMessage());
        }

        try {
            $mapper = JsonMapperFactory::create();
            $subscriptions = $mapper->mapArray(
                json_decode($responseJson),
                [],
                'BitPaySDK\Model\Subscription\Subscription'
            );
        } catch (Exception $e) {
            throw new SubscriptionQueryException(
                "failed to deserialize BitPay server response (Subscription) : " . $e->getMessage()
            );
        }

        return $subscriptions;
    }

    /**
     * Update a BitPay Subscription.
     *
     * @param  Subscription $subscription   A Subscription object with the parameters to update defined.
     * @param  string       $subscriptionId The Id of the Subscription to update.
     * @return Subscription
     * @throws BitPayException
     */
    public function updateSubscription(Subscription $subscription, string $subscriptionId): Subscription
    {
        try {
            $subscriptionToken = $this->getSubscription($subscription->getId())->getToken();
            $subscription->setToken($subscriptionToken);

            $responseJson = $this->restCli->update("subscriptions/" . $subscriptionId, $subscription->toArray());
        } catch (BitPayException $e) {
            throw new SubscriptionUpdateException(
                "failed to serialize Subscription object : " .
                $e->getMessage(),
                null,
                null,
                $e->getApiCode()
            );
        } catch (Exception $e) {
            throw new SubscriptionUpdateException("failed to serialize Subscription object : " . $e->getMessage());
        }

        try {
            $mapper = JsonMapperFactory::create();
            $subscription = $mapper->map(
                json_decode($responseJson),
                $subscription
            );
        } catch (Exception $e) {
            throw new SubscriptionUpdateException(
                "failed to deserialize BitPay server response (Subscription) : " . $e->getMessage()
            );
        }

        return $subscription;
    }
}
