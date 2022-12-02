<?php

namespace BitPaySDK\Client;

use BitPaySDK\Exceptions\BitPayException;
use BitPaySDK\Exceptions\PayoutBatchCancellationException;
use BitPaySDK\Exceptions\PayoutBatchCreationException;
use BitPaySDK\Exceptions\PayoutBatchNotificationException;
use BitPaySDK\Exceptions\PayoutBatchQueryException;
use BitPaySDK\Exceptions\PayoutCancellationException;
use BitPaySDK\Exceptions\PayoutCreationException;
use BitPaySDK\Exceptions\PayoutNotificationException;
use BitPaySDK\Exceptions\PayoutQueryException;
use BitPaySDK\Model\Facade;
use BitPaySDK\Model\Payout\Payout;
use BitPaySDK\Model\Payout\PayoutBatch;
use BitPaySDK\Tokens;
use BitPaySDK\Util\JsonMapper\JsonMapper;
use BitPaySDK\Util\RESTcli\RESTcli;
use Exception;

class PayoutClient
{
    private Tokens $tokenCache;
    private RESTcli $restCli;
    private RESTcli $currenciesInfo;

    public function __construct(Tokens $tokenCache, RESTcli $restCli, $currenciesInfo = null)
    {
        $this->tokenCache = $tokenCache;
        $this->restCli = $restCli;
        $this->currenciesInfo = $currenciesInfo;
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

            $precision = $this->getCurrencyInfo($payout->getCurrency())->precision ?? 2;
            $payout->formatAmount($precision);

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
            $mapper = new JsonMapper();
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
            $mapper = new JsonMapper();
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
            $mapper = new JsonMapper();
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

    /**
     * Submit a BitPay Payout batch.
     *
     * @param  PayoutBatch $batch A PayoutBatch object with request parameters defined.
     * @return PayoutBatch
     * @throws PayoutBatchCreationException
     */
    public function submitBatch(PayoutBatch $batch): PayoutBatch
    {
        try {
            $batch->setToken($this->tokenCache->getTokenByFacade(Facade::Payout));

            $precision = $this->getCurrencyInfo($batch->getCurrency())->precision ?? 2;
            $batch->formatAmount($precision);

            $responseJson = $this->restCli->post("payoutBatches", $batch->toArray());
        } catch (BitPayException $e) {
            throw new PayoutBatchCreationException(
                "failed to serialize PayoutBatch object : " .
                $e->getMessage(),
                null,
                null,
                $e->getApiCode()
            );
        } catch (Exception $e) {
            throw new PayoutBatchCreationException("failed to serialize PayoutBatch object : " . $e->getMessage());
        }

        try {
            $mapper = new JsonMapper();
            $batch = $mapper->map(
                json_decode($responseJson),
                new PayoutBatch()
            );
        } catch (Exception $e) {
            throw new PayoutBatchCreationException(
                "failed to deserialize BitPay server response (PayoutBatch) : " . $e->getMessage()
            );
        }

        return $batch;
    }

    /**
     * Retrieve a BitPay payout batch by batch id using. The client must have been previously authorized for the
     * payout facade.
     *
     * @param  string $payoutBatchId The id of the batch to retrieve.
     * @return PayoutBatch
     * @throws PayoutBatchQueryException
     */
    public function getBatch(string $payoutBatchId): PayoutBatch
    {
        try {
            $params = [];
            $params["token"] = $this->tokenCache->getTokenByFacade(Facade::Payout);

            $responseJson = $this->restCli->get("payoutBatches/" . $payoutBatchId, $params);
        } catch (BitPayException $e) {
            throw new PayoutBatchQueryException(
                "failed to serialize PayoutBatch object : " .
                $e->getMessage(),
                null,
                null,
                $e->getApiCode()
            );
        } catch (Exception $e) {
            throw new PayoutBatchQueryException("failed to serialize PayoutBatch object : " . $e->getMessage());
        }

        try {
            $mapper = new JsonMapper();
            $batch = $mapper->map(
                json_decode($responseJson),
                new PayoutBatch()
            );
        } catch (Exception $e) {
            throw new PayoutBatchQueryException(
                "failed to deserialize BitPay server response (PayoutBatch) : " . $e->getMessage()
            );
        }

        return $batch;
    }


    /**
     * Retrieve a collection of BitPay payout batches.
     *
     * @param  string $startDate The start date to filter the Payout Batches.
     * @param  string $endDate   The end date to filter the Payout Batches.
     * @param  string $status    The status to filter the Payout Batches.
     * @param  int    $limit     Maximum results that the query will return (useful for paging results).
     * @param  int    $offset    The offset to filter the Payout Batches.
     * @return PayoutBatch[]
     * @throws PayoutBatchQueryException
     */
    public function getBatches(
        string $startDate = null,
        string $endDate = null,
        string $status = null,
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
            if ($limit) {
                $params["limit"] = $limit;
            }
            if ($offset) {
                $params["offset"] = $offset;
            }

            $responseJson = $this->restCli->get("payoutBatches", $params);
        } catch (BitPayException $e) {
            throw new PayoutBatchQueryException(
                "failed to serialize PayoutBatch object : " .
                $e->getMessage(),
                null,
                null,
                $e->getApiCode()
            );
        } catch (Exception $e) {
            throw new PayoutBatchQueryException("failed to serialize PayoutBatch object : " . $e->getMessage());
        }

        try {
            $mapper = new JsonMapper();
            $batches = $mapper->mapArray(
                json_decode($responseJson),
                [],
                'BitPaySDK\Model\Payout\PayoutBatch'
            );
        } catch (Exception $e) {
            throw new PayoutBatchQueryException(
                "failed to deserialize BitPay server response (PayoutBatch) : " . $e->getMessage()
            );
        }

        return $batches;
    }

    /**
     * Cancel a BitPay Payout batch.
     *
     * @param $batchId string The id of the batch to cancel.
     * @return PayoutBatch A BitPay generated PayoutBatch object.
     * @throws PayoutBatchCancellationException PayoutBatchCancellationException class
     */
    public function cancelBatch(string $payoutBatchId): bool
    {
        try {
            $params = [];
            $params["token"] = $this->tokenCache->getTokenByFacade(Facade::Payout);

            $responseJson = $this->restCli->delete("payoutBatches/" . $payoutBatchId, $params);
        } catch (BitPayException $e) {
            throw new PayoutBatchCancellationException(
                "failed to serialize PayoutBatch object : " .
                $e->getMessage(),
                null,
                null,
                $e->getApiCode()
            );
        } catch (Exception $e) {
            throw new PayoutBatchCancellationException("failed to serialize PayoutBatch object : " . $e->getMessage());
        }

        try {
            $result = strtolower(json_decode($responseJson)->status) == "success";
        } catch (Exception $e) {
            throw new PayoutBatchCancellationException(
                "failed to deserialize BitPay server response (PayoutBatch) : " . $e->getMessage()
            );
        }

        return $result;
    }

    /**
     * Notify BitPay PayoutBatch.
     *
     * @param  string $payoutId The id of the PayoutBatch to notify.
     * @return PayoutBatch[]
     * @throws PayoutBatchNotificationException
     */
    public function requestBatchNotification(string $payoutBatchId): bool
    {
        try {
            $content = [];
            $content["token"] = $this->tokenCache->getTokenByFacade(Facade::Payout);

            $responseJson = $this->restCli->post("payoutBatches/" . $payoutBatchId . "/notifications", $content);
        } catch (BitPayException $e) {
            throw new PayoutBatchNotificationException(
                "failed to serialize PayoutBatch object : " .
                $e->getMessage(),
                null,
                null,
                $e->getApiCode()
            );
        } catch (Exception $e) {
            throw new PayoutBatchNotificationException("failed to serialize PayoutBatch object : " . $e->getMessage());
        }

        try {
            $result = strtolower(json_decode($responseJson)->status) == "success";
        } catch (Exception $e) {
            throw new PayoutBatchNotificationException(
                "failed to deserialize BitPay server response (PayoutBatch) : " . $e->getMessage()
            );
        }

        return $result;
    }

    /**
     * Gets info for specific currency.
     *
     * @param string $currencyCode Currency code for which the info will be retrieved.
     *
     * @return object|null
     */
    public function getCurrencyInfo(string $currencyCode)
    {
        foreach ($this->currenciesInfo as $currencyInfo) {
            if ($currencyInfo->code == $currencyCode) {
                return $currencyInfo;
            }
        }

        return null;
    }
}
