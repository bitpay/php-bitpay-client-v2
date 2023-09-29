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
use BitPaySDK\Model\Payout\PayoutRecipient;
use BitPaySDK\Model\Payout\PayoutRecipients;
use BitPaySDK\Tokens;
use BitPaySDK\Util\JsonMapperFactory;
use BitPaySDK\Util\RESTcli\RESTcli;
use Exception;

/**
 * Handles interactions with the recipients endpoints.
 *
 * @package BitPaySDK\Client
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
class PayoutRecipientsClient
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
     * Factory method for Payout Recipients Client.
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
     * Submit BitPay Payout Recipients.
     *
     * @param PayoutRecipients $recipients A PayoutRecipients object with request parameters defined.
     * @return PayoutRecipients[]           A list of BitPay PayoutRecipients objects.
     * @throws BitPayApiException
     * @throws BitPayGenericException
     */
    public function submit(PayoutRecipients $recipients): array
    {
        $recipients->setToken($this->tokenCache->getTokenByFacade(Facade::PAYOUT));
        $recipients->setGuid(Util::guid());

        $responseJson = $this->restCli->post("recipients", $recipients->toArray());

        try {
            $mapper = JsonMapperFactory::create();

            return $mapper->mapArray(
                json_decode($responseJson, true, 512, JSON_THROW_ON_ERROR),
                [],
                PayoutRecipient::class
            );
        } catch (Exception $e) {
            BitPayExceptionProvider::throwDeserializeResourceException('Payout Recipient', $e->getMessage());
        }
    }

    /**
     * Retrieve a BitPay payout recipient by batch id using.  The client must have been previously authorized for the
     * payout facade.
     *
     * @param string $recipientId The id of the recipient to retrieve.
     * @return PayoutRecipient
     * @throws BitPayApiException
     * @throws BitPayGenericException
     */
    public function get(string $recipientId): PayoutRecipient
    {
        $params = [];
        $params["token"] = $this->tokenCache->getTokenByFacade(Facade::PAYOUT);

        $responseJson = $this->restCli->get("recipients/" . $recipientId, $params);
        try {
            $mapper = JsonMapperFactory::create();

            return $mapper->map(
                json_decode($responseJson, true, 512, JSON_THROW_ON_ERROR),
                new PayoutRecipient()
            );
        } catch (Exception $e) {
            BitPayExceptionProvider::throwDeserializeResourceException('Payout Recipient', $e->getMessage());
        }
    }

    /**
     * Retrieve a collection of BitPay Payout Recipients.
     *
     * @param string|null $status The recipient status you want to query on.
     * @param int|null $limit Maximum results that the query will return (useful for paging results).
     * @param int|null $offset Number of results to offset (ex. skip 10 will give you results
     *                             starting with the 11th result).
     * @return PayoutRecipient[]
     * @throws BitPayApiException
     * @throws BitPayGenericException
     */
    public function getPayoutRecipients(string $status = null, int $limit = null, int $offset = null): array
    {
        $params = [];
        $params["token"] = $this->tokenCache->getTokenByFacade(Facade::PAYOUT);

        if ($status) {
            $params["status"] = $status;
        }
        if ($limit) {
            $params["limit"] = $limit;
        }
        if ($offset) {
            $params["offset"] = $offset;
        }

        $responseJson = $this->restCli->get("recipients", $params);

        try {
            $mapper = JsonMapperFactory::create();

            return $mapper->mapArray(
                json_decode($responseJson, true, 512, JSON_THROW_ON_ERROR),
                [],
                PayoutRecipient::class
            );
        } catch (Exception $e) {
            BitPayExceptionProvider::throwDeserializeResourceException('Payout Recipient', $e->getMessage());
        }
    }

    /**
     * Update a Payout Recipient.
     *
     * @param string $recipientId The recipient id for the recipient to be updated.
     * @param PayoutRecipient $recipient A PayoutRecipient object with updated parameters defined.
     * @return PayoutRecipient
     * @throws BitPayApiException
     * @throws BitPayGenericException
     */
    public function update(string $recipientId, PayoutRecipient $recipient): PayoutRecipient
    {
        $recipient->setToken($this->tokenCache->getTokenByFacade(Facade::PAYOUT));

        $responseJson = $this->restCli->update("recipients/" . $recipientId, $recipient->toArray());

        try {
            $mapper = JsonMapperFactory::create();

            return $mapper->map(
                json_decode($responseJson, true, 512, JSON_THROW_ON_ERROR),
                new PayoutRecipient()
            );
        } catch (Exception $e) {
            BitPayExceptionProvider::throwDeserializeResourceException('Payout Recipient', $e->getMessage());
        }
    }

    /**
     * Delete a Payout Recipient.
     *
     * @param string $recipientId The recipient id for the recipient to be deleted.
     * @return bool                True if the recipient was successfully deleted, false otherwise.
     * @throws BitPayApiException
     * @throws BitPayGenericException
     */
    public function delete(string $recipientId): bool
    {
        $params = [];
        $params["token"] = $this->tokenCache->getTokenByFacade(Facade::PAYOUT);

        $responseJson = $this->restCli->delete("recipients/" . $recipientId, $params);

        try {
            $result = json_decode($responseJson, true, 512, JSON_THROW_ON_ERROR);

            return strtolower($result['status']) === "success";
        } catch (Exception $e) {
            BitPayExceptionProvider::throwDeserializeException($e->getMessage());
        }
    }

    /**
     * Notify BitPay Payout Recipient.
     *
     * @param string $recipientId The id of the recipient to notify.
     * @return bool                True if the notification was successfully sent, false otherwise.
     * @throws BitPayApiException
     * @throws BitPayGenericException
     */
    public function requestNotification(string $recipientId): bool
    {
        $content = [];
        $content["token"] = $this->tokenCache->getTokenByFacade(Facade::PAYOUT);

        $responseJson = $this->restCli->post("recipients/" . $recipientId . "/notifications", $content);

        try {
            $result = json_decode($responseJson, true, 512, JSON_THROW_ON_ERROR);

            return strtolower($result['status']) === "success";
        } catch (Exception $e) {
            BitPayExceptionProvider::throwDeserializeException($e->getMessage());
        }
    }
}
