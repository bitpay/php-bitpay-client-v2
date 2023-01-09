<?php

namespace BitPaySDK\Client;

use BitPayKeyUtils\Util\Util;
use BitPaySDK\Exceptions\BitPayException;
use BitPaySDK\Exceptions\PayoutQueryException;
use BitPaySDK\Exceptions\PayoutRecipientCancellationException;
use BitPaySDK\Exceptions\PayoutRecipientCreationException;
use BitPaySDK\Exceptions\PayoutRecipientNotificationException;
use BitPaySDK\Exceptions\PayoutRecipientQueryException;
use BitPaySDK\Exceptions\PayoutRecipientUpdateException;
use BitPaySDK\Model\Facade;
use BitPaySDK\Model\Payout\PayoutRecipient;
use BitPaySDK\Model\Payout\PayoutRecipients;
use BitPaySDK\Tokens;
use BitPaySDK\Util\RESTcli\RESTcli;
use Exception;

class PayoutRecipientsClient
{
    private Tokens $tokenCache;
    private RESTcli $restCli;

    public function __construct(Tokens $tokenCache, RESTcli $restCli)
    {
        $this->tokenCache = $tokenCache;
        $this->restCli = $restCli;
    }

    /**
     * Submit BitPay Payout Recipients.
     *
     * @param  PayoutRecipients $recipients A PayoutRecipients object with request parameters defined.
     * @return PayoutRevipients[]           A list of BitPay PayoutRecipients objects.
     * @throws PayoutRecipientCreationException
     */
    public function submit(PayoutRecipients $recipients): array
    {
        try {
            $recipients->setToken($this->tokenCache->getTokenByFacade(Facade::Payout));
            $recipients->setGuid(Util::guid());

            $responseJson = $this->restCli->post("recipients", $recipients->toArray());
        } catch (BitPayException $e) {
            throw new PayoutRecipientCreationException(
                "failed to serialize PayoutRecipients object : " .
                $e->getMessage(),
                null,
                null,
                $e->getApiCode()
            );
        } catch (Exception $e) {
            throw new PayoutRecipientCreationException(
                "failed to serialize PayoutRecipients object : " . $e->getMessage()
            );
        }
        try {
            $mapper = new \JsonMapper();
            $mapper->bEnforceMapType = false;
            $recipients = $mapper->mapArray(
                json_decode($responseJson),
                [],
                'BitPaySDK\Model\Payout\PayoutRecipient'
            );
        } catch (Exception $e) {
            throw new PayoutRecipientCreationException(
                "failed to deserialize BitPay server response (PayoutRecipients) : " . $e->getMessage()
            );
        }

        return $recipients;
    }

    /**
     * Retrieve a BitPay payout recipient by batch id using.  The client must have been previously authorized for the
     * payout facade.
     *
     * @param  string $recipientId The id of the recipient to retrieve.
     * @return PayoutRecipient
     * @throws PayoutQueryException
     */
    public function get(string $recipientId): PayoutRecipient
    {
        try {
            $params = [];
            $params["token"] = $this->tokenCache->getTokenByFacade(Facade::Payout);

            $responseJson = $this->restCli->get("recipients/" . $recipientId, $params);
        } catch (BitPayException $e) {
            throw new PayoutRecipientQueryException(
                "failed to serialize PayoutRecipients object : " .
                $e->getMessage(),
                null,
                null,
                $e->getApiCode()
            );
        } catch (Exception $e) {
            throw new PayoutRecipientQueryException("failed to serialize PayoutRecipient object : " . $e->getMessage());
        }

        try {
            $mapper = new \JsonMapper();
            $recipient = $mapper->map(
                json_decode($responseJson),
                new PayoutRecipient()
            );
        } catch (Exception $e) {
            throw new PayoutQueryException(
                "failed to deserialize BitPay server response (PayoutRecipient) : " . $e->getMessage()
            );
        }

        return $recipient;
    }

    /**
     * Retrieve a collection of BitPay Payout Recipients.
     *
     * @param  string|null $status The recipient status you want to query on.
     * @param  int|null    $limit  Maximum results that the query will return (useful for paging results).
     * @param  int|null    $offset Number of results to offset (ex. skip 10 will give you results
     *                             starting with the 11th result).
     * @return BitPayRecipient[]
     * @throws BitPayException
     */
    public function getPayoutRecipients(string $status = null, int $limit = null, int $offset = null): array
    {
        try {
            $params = [];
            $params["token"] = $this->tokenCache->getTokenByFacade(Facade::Payout);

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
        } catch (BitPayException $e) {
            throw new PayoutRecipientQueryException(
                "failed to serialize PayoutRecipients object : " .
                $e->getMessage(),
                null,
                null,
                $e->getApiCode()
            );
        } catch (Exception $e) {
            throw new PayoutRecipientQueryException(
                "failed to serialize PayoutRecipients object : " . $e->getMessage()
            );
        }

        try {
            $mapper = new \JsonMapper();
            $mapper->bEnforceMapType = false;
            $recipients = $mapper->mapArray(
                json_decode($responseJson),
                [],
                'BitPaySDK\Model\Payout\PayoutRecipient'
            );
        } catch (Exception $e) {
            throw new PayoutRecipientQueryException(
                "failed to deserialize BitPay server response (PayoutRecipients) : " . $e->getMessage()
            );
        }

        return $recipients;
    }

    /**
     * Update a Payout Recipient.
     *
     * @param  string          $recipientId The recipient id for the recipient to be updated.
     * @param  PayoutRecipient $recipient   A PayoutRecipient object with updated parameters defined.
     * @return PayoutRecipient
     * @throws PayoutRecipientUpdateException
     */
    public function update(string $recipientId, PayoutRecipient $recipient): PayoutRecipient
    {
        try {
            $recipient->setToken($this->tokenCache->getTokenByFacade(Facade::Payout));

            $responseJson = $this->restCli->update("recipients/" . $recipientId, $recipient->toArray());
        } catch (BitPayException $e) {
            throw new PayoutRecipientUpdateException(
                "failed to serialize PayoutRecipient object : " .
                $e->getMessage(),
                null,
                null,
                $e->getApiCode()
            );
        } catch (Exception $e) {
            throw new PayoutRecipientUpdateException(
                "failed to serialize PayoutRecipient object : " . $e->getMessage()
            );
        }

        try {
            $mapper = new \JsonMapper();
            $recipient = $mapper->map(
                json_decode($responseJson),
                new PayoutRecipient()
            );
        } catch (Exception $e) {
            throw new PayoutRecipientUpdateException(
                "failed to deserialize BitPay server response (PayoutRecipient) : " . $e->getMessage()
            );
        }

        return $recipient;
    }

    /**
     * Delete a Payout Recipient.
     *
     * @param  string $recipientId The recipient id for the recipient to be deleted.
     * @return bool                True if the recipient was successfully deleted, false otherwise.
     * @throws PayoutRecipientCancellationException
     */
    public function delete(string $recipientId): bool
    {
        try {
            $params = [];
            $params["token"] = $this->tokenCache->getTokenByFacade(Facade::Payout);

            $responseJson = $this->restCli->delete("recipients/" . $recipientId, $params);
        } catch (BitPayException $e) {
            throw new PayoutRecipientCancellationException(
                "failed to serialize PayoutRecipient object : " .
                $e->getMessage(),
                null,
                null,
                $e->getApiCode()
            );
        } catch (Exception $e) {
            throw new PayoutRecipientCancellationException(
                "failed to serialize PayoutRecipient object : " . $e->getMessage()
            );
        }

        try {
            $result = strtolower(json_decode($responseJson)->status) == "success";
        } catch (Exception $e) {
            throw new PayoutRecipientCancellationException(
                "failed to deserialize BitPay server response (PayoutRecipient) : " . $e->getMessage()
            );
        }

        return $result;
    }

    /**
     * Notify BitPay Payout Recipient.
     *
     * @param  string $recipientId The id of the recipient to notify.
     * @return bool                True if the notification was successfully sent, false otherwise.
     * @throws PayoutRecipientNotificationException
     */
    public function requestNotification(string $recipientId): bool
    {
        try {
            $content = [];
            $content["token"] = $this->tokenCache->getTokenByFacade(Facade::Payout);

            $responseJson = $this->restCli->post("recipients/" . $recipientId . "/notifications", $content);
        } catch (BitPayException $e) {
            throw new PayoutRecipientNotificationException(
                "failed to serialize PayoutRecipient object : " .
                $e->getMessage(),
                null,
                null,
                $e->getApiCode()
            );
        } catch (Exception $e) {
            throw new PayoutRecipientNotificationException(
                "failed to serialize PayoutRecipient object : " . $e->getMessage()
            );
        }

        try {
            $result = strtolower(json_decode($responseJson)->status) == "success";
        } catch (Exception $e) {
            throw new PayoutRecipientNotificationException(
                "failed to deserialize BitPay server response (PayoutRecipient) : " . $e->getMessage()
            );
        }

        return $result;
    }
}
