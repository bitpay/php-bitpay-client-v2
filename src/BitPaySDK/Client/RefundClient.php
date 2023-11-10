<?php

/**
 * Copyright (c) 2019 BitPay
 **/

declare(strict_types=1);

namespace BitPaySDK\Client;

use BitPayKeyUtils\Util\Util;
use BitPaySDK\Exceptions\BitPayApiException;
use BitPaySDK\Exceptions\BitPayExceptionProvider;
use BitPaySDK\Exceptions\BitPayGenericException;
use BitPaySDK\Model\Facade;
use BitPaySDK\Model\Invoice\Refund;
use BitPaySDK\Tokens;
use BitPaySDK\Util\JsonMapperFactory;
use BitPaySDK\Util\RESTcli\RESTcli;
use Exception;

/**
 * Handles interactions with the refund endpoints.
 *
 * @package BitPaySDK\Client
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
class RefundClient
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
            self::$instance = new RefundClient($tokenCache, $restCli);
        }

        return self::$instance;
    }

    /**
     * Create a refund for a BitPay invoice.
     *
     * @param string $invoiceId The BitPay invoice Id having the associated refund to be created.
     * @param float $amount Amount to be refunded in the currency indicated.
     * @param string $currency Reference currency used for the refund, usually the same as the currency used
     *                                    to create the invoice.
     * @param bool $preview Whether to create the refund request as a preview (which will not be acted on
     *                                    until status is updated)
     * @param bool $immediate Whether funds should be removed from merchant ledger immediately on submission
     *                                    or at time of processing
     * @param bool $buyerPaysRefundFee Whether the buyer should pay the refund fee (default is merchant)
     * @param string|null $guid Variable provided by the merchant and designed to be used by the merchant to
     *                                    correlate the refund with a refund ID in their system
     * @return Refund $refund             An updated Refund Object
     * @throws BitPayApiException BitPayApiException class
     * @throws BitPayGenericException BitPayApiException class
     * @since 7.2.0)
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
        $params["token"] = $this->tokenCache->getTokenByFacade(Facade::MERCHANT);
        $params["invoiceId"] =  $invoiceId;
        $params["amount"] = $amount;
        $params["currency"] = $currency;
        $params["preview"] = $preview;
        $params["immediate"] = $immediate;
        $params["buyerPaysRefundFee"] = $buyerPaysRefundFee;
        $params["guid"] = $guid ?: Util::guid();

        $responseJson = $this->restCli->post("refunds/", $params, true);

        try {
            $mapper = JsonMapperFactory::create();

            return $mapper->map(
                json_decode($responseJson, true, 512, JSON_THROW_ON_ERROR),
                new Refund()
            );
        } catch (Exception $e) {
            BitPayExceptionProvider::throwDeserializeResourceException('Refund', $e->getMessage());
        }
    }

    /**
     * Update the status of a BitPay invoice.
     *
     * @param string $refundId BitPay refund ID.
     * @param string $status The new status for the refund to be updated.
     * @return Refund $refund      Refund A BitPay generated Refund object.
     * @throws BitPayApiException
     * @throws Exception
     */
    public function update(
        string $refundId,
        string $status
    ): Refund {
        $params = [];
        $params["token"] = $this->tokenCache->getTokenByFacade(Facade::MERCHANT);
        $params["status"] = $status;

        $responseJson = $this->restCli->update("refunds/" . $refundId, $params);

        try {
            $mapper = JsonMapperFactory::create();

            return $mapper->map(
                json_decode($responseJson, true, 512, JSON_THROW_ON_ERROR),
                new Refund()
            );
        } catch (Exception $e) {
            BitPayExceptionProvider::throwDeserializeResourceException('Refund', $e->getMessage());
        }
    }

    /**
     * Update the status of a BitPay invoice.
     *
     * @param string $guid BitPay refund Guid.
     * @param string $status The new status for the refund to be updated.
     * @return Refund $refund      Refund A BitPay generated Refund object.
     * @throws BitPayApiException
     * @throws Exception
     * @since 7.2.0
     */
    public function updateByGuid(
        string $guid,
        string $status
    ): Refund {
        $params = [];
        $params["token"] = $this->tokenCache->getTokenByFacade(Facade::MERCHANT);
        $params["status"] = $status;

        $responseJson = $this->restCli->update("refunds/guid/" . $guid, $params);

        try {
            $mapper = JsonMapperFactory::create();

            return $mapper->map(
                json_decode($responseJson, true, 512, JSON_THROW_ON_ERROR),
                new Refund()
            );
        } catch (Exception $e) {
            BitPayExceptionProvider::throwDeserializeResourceException('Refund', $e->getMessage());
        }
    }

    /**
     * Retrieve all refund requests on a BitPay invoice.
     *
     * @param string $invoiceId The BitPay invoice object having the associated refunds.
     * @return Refund[]
     * @throws BitPayApiException
     * @throws Exception
     */
    public function getRefunds(
        string $invoiceId
    ): array {
        $params = [];
        $params["token"] = $this->tokenCache->getTokenByFacade(Facade::MERCHANT);
        $params["invoiceId"] = $invoiceId;

        $responseJson = $this->restCli->get("refunds/", $params, true);

        try {
            $mapper = JsonMapperFactory::create();

            return $mapper->mapArray(
                json_decode($responseJson, true, 512, JSON_THROW_ON_ERROR),
                [],
                Refund::class
            );
        } catch (Exception $e) {
            BitPayExceptionProvider::throwDeserializeResourceException('Refund', $e->getMessage());
        }
    }

    /**
     * Retrieve a previously made refund request on a BitPay invoice.
     *
     * @param string $refundId The BitPay refund ID.
     * @return Refund $refund   BitPay Refund object with the associated Refund object.
     * @throws BitPayApiException
     * @throws BitPayGenericException
     */
    public function get(
        string $refundId
    ): Refund {
        $params = [];
        $params["token"] = $this->tokenCache->getTokenByFacade(Facade::MERCHANT);

        $responseJson = $this->restCli->get("refunds/" . $refundId, $params, true);

        try {
            $mapper = JsonMapperFactory::create();

            return $mapper->map(
                json_decode($responseJson, true, 512, JSON_THROW_ON_ERROR),
                new Refund()
            );
        } catch (Exception $e) {
            BitPayExceptionProvider::throwDeserializeResourceException('Refund', $e->getMessage());
        }
    }

    /**
     * Retrieve a previously made refund request on a BitPay invoice by guid.
     *
     * @param string $guid The BitPay refund Guid.
     * @return Refund $refund   BitPay Refund object with the associated Refund object.
     * @throws BitPayApiException
     * @throws BitPayGenericException
     * @since 7.2.0
     */
    public function getByGuid(string $guid): Refund
    {
        $params = [];
        $params["token"] = $this->tokenCache->getTokenByFacade(Facade::MERCHANT);

        $responseJson = $this->restCli->get("refunds/guid/" . $guid, $params, true);

        try {
            $mapper = JsonMapperFactory::create();

            return $mapper->map(
                json_decode($responseJson, true, 512, JSON_THROW_ON_ERROR),
                new Refund()
            );
        } catch (Exception $e) {
            BitPayExceptionProvider::throwDeserializeResourceException('Refund', $e->getMessage());
        }
    }

    /**
     * Send a refund notification.
     *
     * @param string $refundId A BitPay refund ID.
     * @return bool   $result      An updated Refund Object
     * @throws BitPayApiException
     * @throws Exception
     */
    public function sendNotification(string $refundId): bool
    {
        $params = [];
        $params["token"] = $this->tokenCache->getTokenByFacade(Facade::MERCHANT);

        $responseJson = $this->restCli->post("refunds/" . $refundId . "/notifications", $params, true);

        try {
            $result = json_decode($responseJson, true, 512, JSON_THROW_ON_ERROR);

            return $result['status'] === "success";
        } catch (Exception $e) {
            BitPayExceptionProvider::throwDeserializeException($e->getMessage());
        }
    }

    /**
     * Cancel a previously submitted refund request on a BitPay invoice.
     *
     * @param string $refundId The refund Id for the refund to be canceled.
     * @return Refund $refund   Cancelled refund Object.
     * @throws BitPayApiException
     * @throws Exception
     */
    public function cancel(string $refundId): Refund
    {
        $params = [];
        $params["token"] = $this->tokenCache->getTokenByFacade(Facade::MERCHANT);

        $responseJson = $this->restCli->delete("refunds/" . $refundId, $params);

        try {
            $mapper = JsonMapperFactory::create();

            return $mapper->map(
                json_decode($responseJson, true, 512, JSON_THROW_ON_ERROR),
                new Refund()
            );
        } catch (Exception $e) {
            BitPayExceptionProvider::throwDeserializeResourceException('Refund', $e->getMessage());
        }
    }

    /**
     * Cancel a previously submitted refund request on a BitPay invoice.
     *
     * @param string $guid The refund Guid for the refund to be canceled.
     * @return Refund $refund   Cancelled refund Object.
     * @throws BitPayApiException
     * @throws Exception
     * @since 7.2.0
     */
    public function cancelByGuid(string $guid): Refund
    {
        $params = [];
        $params["token"] = $this->tokenCache->getTokenByFacade(Facade::MERCHANT);

        $responseJson = $this->restCli->delete("refunds/guid/" . $guid, $params);

        try {
            $mapper = JsonMapperFactory::create();

            return $mapper->map(
                json_decode($responseJson, true, 512, JSON_THROW_ON_ERROR),
                new Refund()
            );
        } catch (Exception $e) {
            BitPayExceptionProvider::throwDeserializeResourceException('Refund', $e->getMessage());
        }
    }
}
