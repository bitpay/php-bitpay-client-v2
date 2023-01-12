<?php

namespace BitPaySDK\Client;

use BitPaySDK\Exceptions\BitPayException;
use BitPaySDK\Exceptions\PayoutCancellationException;
use BitPaySDK\Exceptions\PayoutCreationException;
use BitPaySDK\Exceptions\PayoutNotificationException;
use BitPaySDK\Exceptions\PayoutQueryException;
use BitPaySDK\Model\Facade;
use BitPaySDK\Model\Payout\Payout;
use BitPaySDK\Tokens;
use BitPaySDK\Util\JsonMapperFactory;
use BitPaySDK\Util\RESTcli\RESTcli;
use Exception;

class PayoutClient
{
    private Tokens $tokenCache;
    private RESTcli $restCli;

    public function __construct(Tokens $tokenCache, RESTcli $restCli)
    {
        $this->tokenCache = $tokenCache;
        $this->restCli = $restCli;
    }

    /**
     * Submit a BitPay Payout.
     *
     * @param  Payout $payout A Payout object with request parameters defined.
     * @return Payout
     * @throws PayoutCreationException
     */
    public function submit(Payout $payout): Payout
    {
        try {
            $payout->setToken($this->tokenCache->getTokenByFacade(Facade::Payout));

            $payout->formatAmount(2);

            $responseJson = $this->restCli->post("payouts", $payout->toArray());
        } catch (BitPayException $e) {
            throw new PayoutCreationException(
                "failed to serialize Payout object : " .
                $e->getMessage(),
                null,
                null,
                $e->getApiCode()
            );
        } catch (Exception $e) {
            throw new PayoutCreationException("failed to serialize Payout object : " . $e->getMessage());
        }

        try {
            $mapper = JsonMapperFactory::create();
            $payout = $mapper->map(
                json_decode($responseJson),
                new Payout()
            );
        } catch (Exception $e) {
            throw new PayoutCreationException(
                "failed to deserialize BitPay server response (Payout) : " . $e->getMessage()
            );
        }

        return $payout;
    }

    /**
     * Retrieve a BitPay payout by payout id using. The client must have been previously authorized
     * for the payout facade.
     *
     * @param  string $payoutId The id of the payout to retrieve.
     * @return Payout
     * @throws PayoutQueryException
     */
    public function get(string $payoutId): Payout
    {
        try {
            $params = [];
            $params["token"] = $this->tokenCache->getTokenByFacade(Facade::Payout);

            $responseJson = $this->restCli->get("payouts/" . $payoutId, $params);
        } catch (BitPayException $e) {
            throw new PayoutQueryException(
                "failed to serialize Payout object : " .
                $e->getMessage(),
                null,
                null,
                $e->getApiCode()
            );
        } catch (Exception $e) {
            throw new PayoutQueryException("failed to serialize Payout object : " . $e->getMessage());
        }

        try {
            $mapper = JsonMapperFactory::create();
            $payout = $mapper->map(
                json_decode($responseJson),
                new Payout()
            );
        } catch (Exception $e) {
            throw new PayoutQueryException(
                "failed to deserialize BitPay server response (Payout) : " . $e->getMessage()
            );
        }

        return $payout;
    }

    /**
     * Retrieve a collection of BitPay payouts.
     *
     * @param  string $startDate The start date to filter the Payout Batches.
     * @param  string $endDate   The end date to filter the Payout Batches.
     * @param  string $status    The status to filter the Payout Batches.
     * @param  string $reference The optional reference specified at payout request creation.
     * @param  int    $limit     Maximum results that the query will return (useful for paging results).
     * @param  int    $offset    Number of results to offset (ex. skip 10 will give you results
     *                           starting with the 11th result).
     * @return Payout[]
     * @throws PayoutQueryException
     */
    public function getPayouts(
        string $startDate = null,
        string $endDate = null,
        string $status = null,
        string $reference = null,
        int $limit = null,
        int $offset = null
    ): array {
        try {
            $params = [];
            $params["token"] = $this->tokenCache->getTokenByFacade(Facade::Payout);
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
        } catch (BitPayException $e) {
            throw new PayoutQueryException(
                "failed to serialize Payout object : " .
                $e->getMessage(),
                null,
                null,
                $e->getApiCode()
            );
        } catch (Exception $e) {
            throw new PayoutQueryException("failed to serialize Payout object : " . $e->getMessage());
        }

        try {
            $mapper = JsonMapperFactory::create();
            $payouts = $mapper->mapArray(
                json_decode($responseJson),
                [],
                'BitPaySDK\Model\Payout\Payout'
            );
        } catch (Exception $e) {
            throw new PayoutQueryException(
                "failed to deserialize BitPay server response (Payout) : " . $e->getMessage()
            );
        }

        return $payouts;
    }

    /**
     * Cancel a BitPay Payout.
     *
     * @param  string $payoutId The id of the payout to cancel.
     * @return Payout
     * @throws PayoutCancellationException
     */
    public function cancel(string $payoutId): bool
    {
        try {
            $params = [];
            $params["token"] = $this->tokenCache->getTokenByFacade(Facade::Payout);

            $responseJson = $this->restCli->delete("payouts/" . $payoutId, $params);
        } catch (BitPayException $e) {
            throw new PayoutCancellationException(
                "failed to serialize Payout object : " .
                $e->getMessage(),
                null,
                null,
                $e->getApiCode()
            );
        } catch (Exception $e) {
            throw new PayoutCancellationException("failed to serialize Payout object : " . $e->getMessage());
        }

        try {
            $result = strtolower(json_decode($responseJson)->status) == "success";
        } catch (Exception $e) {
            throw new PayoutCancellationException(
                "failed to deserialize BitPay server response (Payout) : " . $e->getMessage()
            );
        }

        return $result;
    }

    /**
     * Notify BitPay Payout.
     *
     * @param  string $payoutId The id of the Payout to notify.
     * @return Payout[]
     * @throws PayoutNotificationException BitPayException class
     */
    public function requestNotification(string $payoutId): bool
    {
        try {
            $content = [];
            $content["token"] = $this->tokenCache->getTokenByFacade(Facade::Payout);

            $responseJson = $this->restCli->post("payouts/" . $payoutId . "/notifications", $content);
        } catch (BitPayException $e) {
            throw new PayoutNotificationException(
                "failed to serialize Payout object : " .
                $e->getMessage(),
                null,
                null,
                $e->getApiCode()
            );
        } catch (Exception $e) {
            throw new PayoutNotificationException("failed to serialize Payout object : " . $e->getMessage());
        }

        try {
            $result = strtolower(json_decode($responseJson)->status) == "success";
        } catch (Exception $e) {
            throw new PayoutNotificationException(
                "failed to deserialize BitPay server response (Payout) : " . $e->getMessage()
            );
        }

        return $result;
    }
}
