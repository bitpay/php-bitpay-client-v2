<?php

namespace BitPaySDK\Client;

use BitPayKeyUtils\Util\Util;
use BitPaySDK\Exceptions\BitPayException;
use BitPaySDK\Exceptions\InvoiceCancellationException;
use BitPaySDK\Exceptions\InvoiceCreationException;
use BitPaySDK\Exceptions\InvoicePaymentException;
use BitPaySDK\Exceptions\InvoiceQueryException;
use BitPaySDK\Exceptions\InvoiceUpdateException;
use BitPaySDK\Model\Facade;
use BitPaySDK\Model\Invoice\Invoice;
use BitPaySDK\Tokens;
use BitPaySDK\Util\JsonMapper\JsonMapper;
use BitPaySDK\Util\RESTcli\RESTcli;
use Exception;

class InvoiceClient
{
    private Tokens $tokenCache;
    private RESTcli $restCli;
    private Util $util;

    public function __construct(Tokens $tokenCache, RESTcli $restCli, Util $util)
    {
        $this->tokenCache = $tokenCache;
        $this->restCli = $restCli;
        $this->util = $util;
    }

    /**
     * Create a BitPay invoice.
     *
     * @param Invoice $invoice     An Invoice object with request parameters defined.
     * @param string  $facade      The facade used to create it.
     * @param bool    $signRequest Signed request.
     * @return Invoice
     * @throws BitPayException
     */
    public function create(
        Invoice $invoice,
        string $facade = Facade::Merchant,
        bool $signRequest = true
    ): Invoice {
        try {
            $invoice->setToken($this->tokenCache->getTokenByFacade($facade));
            $invoice->setGuid($this->util->guid());

            $responseJson = $this->restCli->post("invoices", $invoice->toArray(), $signRequest);
        } catch (BitPayException $e) {
            throw new InvoiceCreationException(
                "failed to serialize Invoice object : " .
                $e->getMessage(),
                null,
                null,
                $e->getApiCode()
            );
        } catch (Exception $e) {
            throw new InvoiceCreationException("failed to serialize Invoice object : " . $e->getMessage());
        }

        try {
            $mapper = new JsonMapper();
            $invoice = $mapper->map(
                json_decode($responseJson),
                new Invoice()
            );
        } catch (Exception $e) {
            throw new InvoiceCreationException(
                "failed to deserialize BitPay server response (Invoice) : " . $e->getMessage()
            );
        }

        return $invoice;
    }

    /**
     * Update a BitPay invoice.
     *
     * @param string $invoiceId       The id of the invoice to updated.
     * @param string $buyerSms        The buyer's cell number.
     * @param string $smsCode         The buyer's received verification code.
     * @param string $buyerEmail      The buyer's email address.
     * @param string $autoVerify      Skip the user verification on sandbox ONLY.
     * @return Invoice
     * @throws InvoiceUpdateException
     * @throws BitPayException
     */
    public function update(
        string $invoiceId,
        string $buyerSms,
        string $smsCode,
        string $buyerEmail,
        bool $autoVerify = false
    ): Invoice {
        // Updating the invoice will require EITHER SMS or E-mail, but not both.
        if ($this->buyerEmailOrSms($buyerEmail, $buyerSms)) {
            throw new InvoiceUpdateException("Updating the invoice requires buyerSms or buyerEmail, but not both.");
        }

        // smsCode required only when verifying SMS, except when autoVerify is true.
        if ($this->isSmsCodeRequired($autoVerify, $buyerSms, $smsCode)) {
            throw new InvoiceUpdateException(
                "Updating the invoice requires both buyerSms and smsCode when verifying SMS."
            );
        }

        try {
            $params = [];
            $params["token"]      = $this->tokenCache->getTokenByFacade(Facade::Merchant);
            $params["buyerEmail"] = $buyerEmail;
            $params["buyerSms"]   = $buyerSms;
            $params["smsCode"]    = $smsCode;
            $params["autoVerify"] = $autoVerify;

            $responseJson = $this->restCli->update("invoices/" . $invoiceId, $params);
        } catch (BitPayException $e) {
            throw new InvoiceUpdateException(
                "failed to serialize Invoice object : " .
                $e->getMessage(),
                null,
                null,
                $e->getApiCode()
            );
        } catch (Exception $e) {
            throw new InvoiceUpdateException("failed to serialize Invoice object : " . $e->getMessage());
        }

        try {
            $mapper = new JsonMapper();
            $invoice = $mapper->map(
                json_decode($responseJson),
                new Invoice()
            );
        } catch (Exception $e) {
            throw new InvoiceUpdateException(
                "failed to deserialize BitPay server response (Invoice) : " . $e->getMessage()
            );
        }

        return $invoice;
    }

    /**
     * Retrieve a BitPay invoice by invoice id using the specified facade.  The client must have been previously
     * authorized for the specified facade (the public facade requires no authorization).
     *
     * @param string $invoiceId   The id of the invoice to retrieve.
     * @param string $facade      The facade used to create it.
     * @param string $signRequest Signed request.
     * @return Invoice
     * @throws BitPayException
     */
    public function get(
        string $invoiceId,
        string $facade = Facade::Merchant,
        bool $signRequest = true
    ): Invoice {
        try {
            $params = [];
            $params["token"] = $this->tokenCache->getTokenByFacade($facade);

            $responseJson = $this->restCli->get("invoices/" . $invoiceId, $params, $signRequest);
        } catch (BitPayException $e) {
            throw new InvoiceQueryException(
                "failed to serialize Invoice object : " .
                $e->getMessage(),
                null,
                null,
                $e->getApiCode()
            );
        } catch (Exception $e) {
            throw new InvoiceQueryException("failed to serialize Invoice object : " . $e->getMessage());
        }

        try {
            $mapper = new JsonMapper();
            $invoice = $mapper->map(
                json_decode($responseJson),
                new Invoice()
            );
        } catch (Exception $e) {
            throw new InvoiceQueryException(
                "failed to deserialize BitPay server response (Invoice) : " . $e->getMessage()
            );
        }

        return $invoice;
    }

    /**
     * Retrieve a collection of BitPay invoices.
     *
     * @param string      $dateStart The start of the date window to query for invoices. Format YYYY-MM-DD.
     * @param string      $dateEnd   The end of the date window to query for invoices. Format YYYY-MM-DD.
     * @param string|null $status    The invoice status you want to query on.
     * @param string|null $orderId   The optional order id specified at time of invoice creation.
     * @param int|null    $limit     Maximum results that the query will return (useful for paging results).
     * @param int|null    $offset    Number of results to offset (ex. skip 10 will give you results starting
     *                               with the 11th result).
     * @return Invoice[]
     * @throws BitPayException
     */
    public function getInvoices(
        string $dateStart,
        string $dateEnd,
        string $status = null,
        string $orderId = null,
        int $limit = null,
        int $offset = null
    ): array {
        try {
            $params = [];
            $params["token"] = $this->tokenCache->getTokenByFacade(Facade::Merchant);
            $params["dateStart"] = $dateStart;
            $params["dateEnd"] = $dateEnd;
            if ($status) {
                $params["status"] = $status;
            }
            if ($orderId) {
                $params["orderId"] = $orderId;
            }
            if ($limit) {
                $params["limit"] = $limit;
            }
            if ($offset) {
                $params["offset"] = $offset;
            }

            $responseJson = $this->restCli->get("invoices", $params);
        } catch (BitPayException $e) {
            throw new InvoiceQueryException(
                "failed to serialize Invoice object : " .
                $e->getMessage(),
                null,
                null,
                $e->getApiCode()
            );
        } catch (Exception $e) {
            throw new InvoiceQueryException("failed to serialize Invoice object : " . $e->getMessage());
        }

        try {
            $mapper = new JsonMapper();
            $invoices = $mapper->mapArray(
                json_decode($responseJson),
                [],
                'BitPaySDK\Model\Invoice\Invoice'
            );
        } catch (Exception $e) {
            throw new InvoiceQueryException(
                "failed to deserialize BitPay server response (Invoice) : " . $e->getMessage()
            );
        }

        return $invoices;
    }

    /**
     * Request a BitPay Invoice Webhook.
     *
     * @param  string $invoiceId A BitPay invoice ID.
     * @return bool              True if the webhook was successfully requested, false otherwise.
     * @throws InvoiceQueryException
     * @throws BitPayException
     */
    public function requestNotification(string $invoiceId): bool
    {
        try {
            $params = [];
            $invoice = $this->get($invoiceId);
        } catch (BitPayException $e) {
            throw new InvoiceQueryException(
                "failed to serialize invoice object : " .
                $e->getMessage(),
                null,
                null,
                $e->getApiCode()
            );
        } catch (Exception $e) {
            throw new InvoiceQueryException("failed to serialize invoice object : " . $e->getMessage());
        }

        $params["token"] = $invoice->getToken();

        try {
            $responseJson = $this->restCli->post("invoices/" . $invoiceId . "/notifications", $params);
            $decodedResponseJson = json_decode($responseJson) ?? '';
            $result = strtolower($decodedResponseJson) == "success";
        } catch (Exception $e) {
            throw new InvoiceQueryException(
                "failed to deserialize BitPay server response (Invoice) : " . $e->getMessage()
            );
        }

        return $result;
    }

    /**
     * Cancel a BitPay invoice.
     *
     * @param  string   $invoiceId The id of the invoice to updated.
     * @return Invoice  $invoice   Cancelled invoice object.
     * @throws InvoiceCancellationException
     * @throws BitPayException
     */
    public function cancel(
        string $invoiceId,
        bool $forceCancel = false
    ): Invoice {
        try {
            $params = [];
            $params["token"] = $this->tokenCache->getTokenByFacade(Facade::Merchant);
            if ($forceCancel) {
                $params["forceCancel"] = $forceCancel;
            }

            $responseJson = $this->restCli->delete("invoices/" . $invoiceId, $params);
        } catch (BitPayException $e) {
            throw new InvoiceCancellationException(
                "failed to serialize Invoice object : " .
                $e->getMessage(),
                null,
                null,
                $e->getApiCode()
            );
        } catch (Exception $e) {
            throw new InvoiceCancellationException("failed to serialize Invoice object : " . $e->getMessage());
        }

        try {
            $mapper = new JsonMapper();
            $invoice = $mapper->map(
                json_decode($responseJson),
                new Invoice()
            );
        } catch (Exception $e) {
            throw new InvoiceCancellationException(
                "failed to deserialize BitPay server response (Invoice) : " . $e->getMessage()
            );
        }

        return $invoice;
    }

    /**
     * Pay an invoice with a mock transaction
     *
     * @param  string $invoiceId The id of the invoice.
     * @param  string $status    Status the invoice will become. Acceptable values are confirmed (default) and complete.
     * @return Invoice $invoice  Invoice object.
     * @throws InvoicePaymentException
     * @throws BitPayException
     */
    public function pay(
        string $invoiceId,
        string $env,
        string $status = 'confirmed'
    ): Invoice {
        if (strtolower($env) != "test") {
            throw new InvoicePaymentException("Pay Invoice method only available in test or demo environments");
        }

        try {
            $params = [];
            $params["token"] = $this->tokenCache->getTokenByFacade(Facade::Merchant);
            $params["status"] = $status;
            $responseJson = $this->restCli->update("invoices/pay/" . $invoiceId, $params, true);
        } catch (BitPayException $e) {
            throw new InvoicePaymentException(
                "failed to serialize Invoice object : " .
                $e->getMessage(),
                null,
                null,
                $e->getApiCode()
            );
        } catch (Exception $e) {
            throw new InvoicePaymentException("failed to serialize Invoice object : " . $e->getMessage());
        }

        try {
            $mapper = new JsonMapper();
            $invoice = $mapper->map(
                json_decode($responseJson),
                new Invoice()
            );
        } catch (Exception $e) {
            throw new InvoicePaymentException(
                "failed to deserialize BitPay server response (Invoice) : " . $e->getMessage()
            );
        }

        return $invoice;
    }

    /**
     * Check if buyerEmail or buyerSms is present, and not both.
     *
     * @param string $buyerEmail The buyer's email address.
     * @param string $buyerSms   The buyer's cell number.
     *
     * @return bool
     */
    private function buyerEmailOrSms(string $buyerEmail, string $buyerSms): bool
    {
        return (empty($buyerSms) && empty($buyerEmail)) || (!empty($buyerSms) && empty(!$buyerEmail));
    }

    /**
     * Check if smsCode is required.
     *
     * @param bool   $autoVerify Skip the user verification on sandbox ONLY.
     * @param string $buyerEmail The buyer's email address.
     * @param string $smsCode    The buyer's received verification code.
     */
    private function isSmsCodeRequired(bool $autoVerify, string $buyerSms, string $smsCode): bool
    {
        return $autoVerify == false &&
            (!empty($buyerSms) && empty($smsCode)) || (!empty($smsCode) && empty($buyerSms));
    }
}
