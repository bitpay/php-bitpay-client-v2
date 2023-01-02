<?php

namespace BitPaySDK\Client;

use BitPayKeyUtils\Util\Util;
use BitPaySDK\Exceptions\BitPayException;
use BitPaySDK\Exceptions\RefundCancellationException;
use BitPaySDK\Exceptions\RefundCreationException;
use BitPaySDK\Exceptions\RefundNotificationException;
use BitPaySDK\Exceptions\RefundQueryException;
use BitPaySDK\Exceptions\RefundUpdateException;
use BitPaySDK\Model\Facade;
use BitPaySDK\Model\Invoice\Refund;
use BitPaySDK\Tokens;
use BitPaySDK\Util\JsonMapper\JsonMapper;
use BitPaySDK\Util\RESTcli\RESTcli;
use Exception;

class RefundClient
{
    private Tokens $tokenCache;
    private RESTcli $restCli;

    public function __construct(Tokens $tokenCache, RESTcli $restCli)
    {
        $this->tokenCache = $tokenCache;
        $this->restCli = $restCli;
    }

    /**
     * Create a refund for a BitPay invoice.
     *
     * @param  string $invoiceId          The BitPay invoice Id having the associated refund to be created.
     * @param  float  $amount             Amount to be refunded in the currency indicated.
     * @param  string $currency           Reference currency used for the refund, usually the same as the currency used
     *                                    to create the invoice.
     * @param  bool   $preview            Whether to create the refund request as a preview (which will not be acted on
     *                                    until status is updated)
     * @param  bool   $immediate          Whether funds should be removed from merchant ledger immediately on submission
     *                                    or at time of processing
     * @param  bool   $buyerPaysRefundFee Whether the buyer should pay the refund fee (default is merchant)
     * @param  string|null $guid          Variable provided by the merchant and designed to be used by the merchant to
     *                                    correlate the refund with a refund ID in their system (@since 7.2.0)
     * @return Refund $refund             An updated Refund Object
     * @throws RefundCreationException    RefundCreationException class
     * @throws BitPayException            BitPayException class
     */
    public function create(
        string $invoiceId,
        float $amount,
        string $currency,
        bool $preview = false,
        bool $immediate = false,
        bool $buyerPaysRefundFee = false,
        string $guid = null
    ): Refund {
        $params = [];
        $params["token"] = $this->tokenCache->getTokenByFacade(Facade::Merchant);
        $params["invoiceId"] =  $invoiceId;
        $params["amount"] = $amount;
        $params["currency"] = $currency;
        $params["preview"] = $preview;
        $params["immediate"] = $immediate;
        $params["buyerPaysRefundFee"] = $buyerPaysRefundFee;
        $params["guid"] = $guid ?: Util::guid();

        try {
            $responseJson = $this->restCli->post("refunds/", $params, true);
        } catch (BitPayException $e) {
            throw new RefundCreationException(
                "failed to serialize refund object : " .
                $e->getMessage(),
                null,
                null,
                $e->getApiCode()
            );
        } catch (Exception $e) {
            throw new RefundCreationException("failed to serialize refund object : " . $e->getMessage());
        }

        try {
            $mapper = new JsonMapper();
            $refund = $mapper->map(
                json_decode($responseJson),
                new Refund()
            );
        } catch (Exception $e) {
            throw new RefundCreationException(
                "failed to deserialize BitPay server response (Refund) : " . $e->getMessage()
            );
        }

        return $refund;
    }

    /**
     * Update the status of a BitPay invoice.
     *
     * @param  string $refundId    BitPay refund ID.
     * @param  string $status      The new status for the refund to be updated.
     * @return Refund $refund      Refund A BitPay generated Refund object.
     * @throws RefundUpdateException
     * @throws BitPayException
     */
    public function update(
        string $refundId,
        string $status
    ): Refund {
        $params = [];
        $params["token"] = $this->tokenCache->getTokenByFacade(Facade::Merchant);
        $params["status"] = $status;

        try {
            $responseJson = $this->restCli->update("refunds/" . $refundId, $params);
        } catch (BitPayException $e) {
            throw new RefundUpdateException(
                "failed to serialize refund object : " .
                $e->getMessage(),
                null,
                null,
                $e->getApiCode()
            );
        } catch (Exception $e) {
            throw new RefundUpdateException("failed to serialize refund object : " . $e->getMessage());
        }

        try {
            $mapper = new JsonMapper();
            $refund = $mapper->map(
                json_decode($responseJson),
                new Refund()
            );
        } catch (Exception $e) {
            throw new RefundUpdateException(
                "failed to deserialize BitPay server response (Refund) : " . $e->getMessage()
            );
        }

        return $refund;
    }

    /**
     * Update the status of a BitPay invoice.
     *
     * @param  string $guid        BitPay refund Guid.
     * @param  string $status      The new status for the refund to be updated.
     * @return Refund $refund      Refund A BitPay generated Refund object.
     * @throws RefundUpdateException
     * @throws BitPayException
     * @since 7.2.0
     */
    public function updateByGuid(
        string $guid,
        string $status
    ): Refund {
        $params = [];
        $params["token"] = $this->tokenCache->getTokenByFacade(Facade::Merchant);
        $params["status"] = $status;

        try {
            $responseJson = $this->restCli->update("refunds/guid/" . $guid, $params);
        } catch (BitPayException $e) {
            throw new RefundUpdateException(
                "failed to serialize refund object : " .
                $e->getMessage(),
                null,
                null,
                $e->getApiCode()
            );
        } catch (Exception $e) {
            throw new RefundUpdateException("failed to serialize refund object : " . $e->getMessage());
        }

        try {
            $mapper = new JsonMapper();
            $refund = $mapper->map(
                json_decode($responseJson),
                new Refund()
            );
        } catch (Exception $e) {
            throw new RefundUpdateException(
                "failed to deserialize BitPay server response (Refund) : " . $e->getMessage()
            );
        }

        return $refund;
    }

    /**
     * Retrieve all refund requests on a BitPay invoice.
     *
     * @param  string $invoiceId   The BitPay invoice object having the associated refunds.
     * @return Refund[]
     * @throws RefundQueryException
     * @throws BitPayException
     */
    public function getRefunds(
        string $invoiceId
    ): array {
        $params = [];
        $params["token"] = $this->tokenCache->getTokenByFacade(Facade::Merchant);
        $params["invoiceId"] = $invoiceId;

        try {
            $responseJson = $this->restCli->get("refunds/", $params, true);
        } catch (BitPayException $e) {
            throw new RefundQueryException(
                "failed to serialize refund object : " .
                $e->getMessage(),
                null,
                null,
                $e->getApiCode()
            );
        } catch (Exception $e) {
            throw new RefundQueryException("failed to serialize refund object : " . $e->getMessage());
        }

        try {
            $mapper = new JsonMapper();
            $refunds = $mapper->mapArray(
                json_decode($responseJson),
                [],
                'BitPaySDK\Model\Invoice\Refund'
            );
        } catch (Exception $e) {
            throw new RefundQueryException(
                "failed to deserialize BitPay server response (Refund) : " . $e->getMessage()
            );
        }

        return $refunds;
    }

    /**
     * Retrieve a previously made refund request on a BitPay invoice.
     *
     * @param  string $refundId The BitPay refund ID.
     * @return Refund $refund   BitPay Refund object with the associated Refund object.
     * @throws RefundQueryException
     * @throws BitPayException
     */
    public function get(
        string $refundId
    ): Refund {
        $params = [];
        $params["token"] = $this->tokenCache->getTokenByFacade(Facade::Merchant);

        try {
            $responseJson = $this->restCli->get("refunds/" . $refundId, $params, true);
        } catch (BitPayException $e) {
            throw new RefundQueryException(
                "failed to serialize refund object : " .
                $e->getMessage(),
                null,
                null,
                $e->getApiCode()
            );
        } catch (Exception $e) {
            throw new RefundQueryException("failed to serialize refund object : " . $e->getMessage());
        }

        try {
            $mapper = new JsonMapper();
            $refund = $mapper->map(
                json_decode($responseJson),
                new Refund()
            );
        } catch (Exception $e) {
            throw new RefundQueryException(
                "failed to deserialize BitPay server response (Refund) : " . $e->getMessage()
            );
        }

        return $refund;
    }

    /**
     * Retrieve a previously made refund request on a BitPay invoice by guid.
     *
     * @param  string $guid The BitPay refund Guid.
     * @return Refund $refund   BitPay Refund object with the associated Refund object.
     * @throws RefundQueryException
     * @throws BitPayException
     * @since 7.2.0
     */
    public function getByGuid(string $guid): Refund
    {
        $params = [];
        $params["token"] = $this->tokenCache->getTokenByFacade(Facade::Merchant);

        try {
            $responseJson = $this->restCli->get("refunds/guid/" . $guid, $params, true);
        } catch (BitPayException $e) {
            throw new RefundQueryException(
                "failed to serialize refund object : " .
                $e->getMessage(),
                null,
                null,
                $e->getApiCode()
            );
        } catch (Exception $e) {
            throw new RefundQueryException("failed to serialize refund object : " . $e->getMessage());
        }

        try {
            $mapper = new JsonMapper();
            $refund = $mapper->map(
                json_decode($responseJson),
                new Refund()
            );
        } catch (Exception $e) {
            throw new RefundQueryException(
                "failed to deserialize BitPay server response (Refund) : " . $e->getMessage()
            );
        }

        return $refund;
    }

    /**
     * Send a refund notification.
     *
     * @param  string $refundId    A BitPay refund ID.
     * @return bool   $result      An updated Refund Object
     * @throws RefundCreationException
     * @throws BitPayException
     */
    public function sendNotification(string $refundId): bool
    {
        $params = [];
        $params["token"] = $this->tokenCache->getTokenByFacade(Facade::Merchant);

        try {
            $responseJson = $this->restCli->post("refunds/" . $refundId . "/notifications", $params, true);
        } catch (BitPayException $e) {
            throw new RefundNotificationException(
                "failed to serialize refund object : " .
                $e->getMessage(),
                null,
                null,
                $e->getApiCode()
            );
        } catch (Exception $e) {
            throw new RefundNotificationException("failed to serialize refund object : " . $e->getMessage());
        }

        try {
            $result = json_decode($responseJson)->status == "success";
        } catch (Exception $e) {
            throw new RefundNotificationException(
                "failed to deserialize BitPay server response (Refund) : " . $e->getMessage()
            );
        }

        return $result;
    }


    /**
     * Cancel a previously submitted refund request on a BitPay invoice.
     *
     * @param  string $refundId The refund Id for the refund to be canceled.
     * @return Refund $refund   Cancelled refund Object.
     * @throws RefundCancellationException
     * @throws BitPayException
     */
    public function cancel(string $refundId): Refund
    {
        $params = [];
        $params["token"] = $this->tokenCache->getTokenByFacade(Facade::Merchant);

        try {
            $responseJson = $this->restCli->delete("refunds/" . $refundId, $params);
        } catch (BitPayException $e) {
            throw new RefundCancellationException(
                "failed to serialize refund object : " .
                $e->getMessage(),
                null,
                null,
                $e->getApiCode()
            );
        } catch (Exception $e) {
            throw new RefundCancellationException("failed to serialize refund object : " . $e->getMessage());
        }

        try {
            $mapper = new JsonMapper();
            $refund = $mapper->map(
                json_decode($responseJson),
                new Refund()
            );
        } catch (Exception $e) {
            throw new RefundCancellationException(
                "failed to deserialize BitPay server response (Refund) : " . $e->getMessage()
            );
        }

        return $refund;
    }

    /**
     * Cancel a previously submitted refund request on a BitPay invoice.
     *
     * @param  string $guid     The refund Guid for the refund to be canceled.
     * @return Refund $refund   Cancelled refund Object.
     * @throws RefundCancellationException
     * @throws BitPayException
     * @since 7.2.0
     */
    public function cancelByGuid(string $guid): Refund
    {
        $params = [];
        $params["token"] = $this->tokenCache->getTokenByFacade(Facade::Merchant);

        try {
            $responseJson = $this->restCli->delete("refunds/guid/" . $guid, $params);
        } catch (BitPayException $e) {
            throw new RefundCancellationException(
                "failed to serialize refund object : " .
                $e->getMessage(),
                null,
                null,
                $e->getApiCode()
            );
        } catch (Exception $e) {
            throw new RefundCancellationException("failed to serialize refund object : " . $e->getMessage());
        }

        try {
            $mapper = new JsonMapper();
            $refund = $mapper->map(
                json_decode($responseJson),
                new Refund()
            );
        } catch (Exception $e) {
            throw new RefundCancellationException(
                "failed to deserialize BitPay server response (Refund) : " . $e->getMessage()
            );
        }

        return $refund;
    }
}
