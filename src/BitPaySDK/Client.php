<?php

/**
 * Copyright (c) 2019 BitPay
 **/

declare(strict_types=1);

namespace BitPaySDK;

use BitPayKeyUtils\KeyHelper\PrivateKey;
use BitPayKeyUtils\Storage\EncryptedFilesystemStorage;
use BitPaySDK\Client\BillClient;
use BitPaySDK\Client\InvoiceClient;
use BitPaySDK\Client\LedgerClient;
use BitPaySDK\Client\PayoutClient;
use BitPaySDK\Client\PayoutRecipientsClient;
use BitPaySDK\Client\RateClient;
use BitPaySDK\Client\RefundClient;
use BitPaySDK\Client\SettlementClient;
use BitPaySDK\Client\SubscriptionClient;
use BitPaySDK\Client\TokenClient;
use BitPaySDK\Client\WalletClient;
use BitPaySDK\Exceptions\BitPayApiException;
use BitPaySDK\Exceptions\BitPayExceptionProvider;
use BitPaySDK\Exceptions\BitPayGenericException;
use BitPaySDK\Model\Bill\Bill;
use BitPaySDK\Model\Facade;
use BitPaySDK\Model\Invoice\Invoice;
use BitPaySDK\Model\Invoice\Refund;
use BitPaySDK\Model\Ledger\Ledger;
use BitPaySDK\Model\Ledger\LedgerEntry;
use BitPaySDK\Model\Payout\Payout;
use BitPaySDK\Model\Payout\PayoutGroup;
use BitPaySDK\Model\Payout\PayoutRecipient;
use BitPaySDK\Model\Payout\PayoutRecipients;
use BitPaySDK\Model\Rate\Rate;
use BitPaySDK\Model\Rate\Rates;
use BitPaySDK\Model\Settlement\Settlement;
use BitPaySDK\Model\Subscription\Subscription;
use BitPaySDK\Model\Wallet\Wallet;
use BitPaySDK\Util\RESTcli\RESTcli;
use Exception;
use Symfony\Component\Yaml\Yaml;

/**
 * Client class to interact with the BitPay API.
 *
 * @package BitPaySDK
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
class Client
{
    protected Tokens $tokenCache;
    protected RESTcli $restCli;

    /**
     * Client constructor.
     */
    public function __construct(RESTcli $restCli, Tokens $tokenCache)
    {
        $this->restCli = $restCli;
        $this->tokenCache = $tokenCache;
    }

    /**
     * Constructor for use if the keys and SIN are managed by this library.
     *
     * @param string           $environment      Target environment. Options: Env.Test / Env.Prod
     * @param string           $privateKey       Private Key file path or the HEX value.
     * @param Tokens           $tokens           Tokens containing the available tokens.
     * @param string|null      $privateKeySecret Private Key encryption password.
     * @param string|null      $proxy            The url of your proxy to forward requests through. Example:
     *                                           http://********.com:3128
     * @param string|null      $platformInfo     Value for the X-BitPay-Platform header.
     * @return Client
     * @throws BitPayApiException
     * @throws BitPayGenericException
     */
    public static function createWithData(
        string $environment,
        string $privateKey,
        Tokens $tokens,
        ?string $privateKeySecret = null,
        ?string $proxy = null,
        ?string $platformInfo = null,
    ): Client {
        try {
            $key = self::initKeys($privateKey, $privateKeySecret);

            $restCli = new RESTcli($environment, $key, $proxy, $platformInfo);
            $tokenCache = $tokens;

            return new Client($restCli, $tokenCache);
        } catch (Exception $e) {
            BitPayExceptionProvider::throwGenericExceptionWithMessage(
                'failed to initialize BitPay Client (Config) : ' . $e->getMessage()
            );
        }
    }

    /**
     * Constructor for use if the keys and SIN are managed by this library.
     *
     * @param string      $configFilePath  The path to the configuration file.
     * @param string|null $platformInfo    Value for the X-BitPay-Platform header.
     * @return Client
     * @throws BitPayGenericException
     */
    public static function createWithFile(string $configFilePath, ?string $platformInfo = null): Client
    {
        try {
            $configData = self::getConfigData($configFilePath);
            $env = $configData["BitPayConfiguration"]["Environment"];
            $config = $configData["BitPayConfiguration"]["EnvConfig"][$env];

            $key = self::initKeys($config['PrivateKeyPath'], $config['PrivateKeySecret']);
            $proxy = $config['Proxy'] ?? null;

            $restCli = new RESTcli($env, $key, $proxy, $platformInfo);
            $tokenCache = new Tokens($config['ApiTokens']['merchant'], $config['ApiTokens']['payout']);

            return new Client($restCli, $tokenCache);
        } catch (Exception $e) {
            BitPayExceptionProvider::throwGenericExceptionWithMessage(
                'failed to initialize BitPay Client (Config) : ' . $e->getMessage()
            );
        }
    }

    /**
     * Get Tokens.
     *
     * @return array
     * @throws BitPayApiException
     * @throws BitPayGenericException
     */
    public function getTokens(): array
    {
        $tokenClient = $this->getTokenClient();

        return $tokenClient->getTokens();
    }

    /**
     * Create a BitPay invoice.
     *
     * @see https://developer.bitpay.com/reference/create-an-invoice Create an Invoice
     *
     * @param Invoice $invoice     An Invoice object with request parameters defined.
     * @param string  $facade      The facade used to create it.
     * @param bool    $signRequest Signed request.
     * @return Invoice
     * @throws BitPayApiException
     * @throws BitPayGenericException
     */
    public function createInvoice(
        Invoice $invoice,
        string $facade = Facade::MERCHANT,
        bool $signRequest = true
    ): Invoice {
        $invoiceClient = $this->getInvoiceClient();

        return $invoiceClient->create($invoice, $facade, $signRequest);
    }

    /**
     * Update a BitPay invoice.
     *
     * @see https://developer.bitpay.com/reference/update-an-invoice Update an Invoice
     *
     * @param string $invoiceId The id of the invoice to updated.
     * @param string|null $buyerSms The buyer's cell number.
     * @param string|null $smsCode The buyer's received verification code.
     * @param string|null $buyerEmail The buyer's email address.
     * @param bool $autoVerify Skip the user verification on sandbox ONLY.
     * @return Invoice
     * @throws BitPayApiException
     * @throws BitPayGenericException
     */
    public function updateInvoice(
        string $invoiceId,
        ?string $buyerSms,
        ?string $smsCode,
        ?string $buyerEmail,
        bool $autoVerify = false
    ): Invoice {
        $invoiceClient = $this->getInvoiceClient();

        return $invoiceClient->update($invoiceId, $buyerSms, $smsCode, $buyerEmail, $autoVerify);
    }

    /**
     * Retrieve a BitPay invoice by invoice id using the specified facade.  The client must have been previously
     * authorized for the specified facade (the public facade requires no authorization).
     *
     * @see https://developer.bitpay.com/reference/retrieve-an-invoice-by-guid Retrieve an Invoice by GUID
     *
     * @param string $invoiceId The id of the invoice to retrieve.
     * @param string $facade The facade used to create it.
     * @param bool $signRequest Signed request.
     * @return Invoice
     * @throws BitPayApiException
     * @throws BitPayGenericException
     */
    public function getInvoice(
        string $invoiceId,
        string $facade = Facade::MERCHANT,
        bool $signRequest = true
    ): Invoice {
        $invoiceClient = $this->getInvoiceClient();

        return $invoiceClient->get($invoiceId, $facade, $signRequest);
    }

    /**
     * Retrieve a BitPay invoice by guid using the specified facade.
     * The client must have been previously authorized for the specified facade.
     *
     * @see https://developer.bitpay.com/reference/retrieve-an-invoice-by-guid Retrieve an Invoice by GUID
     *
     * @param string $guid The guid of the invoice to retrieve.
     * @param string $facade The facade used to create it.
     * @param bool $signRequest Signed request.
     * @return Invoice
     * @throws BitPayApiException
     * @throws BitPayGenericException
     *
     */
    public function getInvoiceByGuid(
        string $guid,
        string $facade = Facade::MERCHANT,
        bool $signRequest = true
    ): Invoice {
        $invoiceClient = $this->getInvoiceClient();

        return $invoiceClient->getByGuid($guid, $facade, $signRequest);
    }

    /**
     * Retrieve a collection of BitPay invoices.
     *
     * @see https://developer.bitpay.com/reference/retrieve-invoices-filtered-by-query
     * Retrieve Invoices Filtered by Query
     *
     *
     * @param string      $dateStart The start of the date window to query for invoices. Format YYYY-MM-DD.
     * @param string      $dateEnd   The end of the date window to query for invoices. Format YYYY-MM-DD.
     * @param string|null $status    The invoice status you want to query on.
     * @param string|null $orderId   The optional order id specified at time of invoice creation.
     * @param int|null    $limit     Maximum results that the query will return (useful for paging results).
     * @param int|null    $offset    Number of results to offset (ex. skip 10 will give you results starting
     *                               with the 11th result).
     * @return Invoice[]
     * @throws BitPayApiException
     * @throws BitPayGenericException
     */
    public function getInvoices(
        string $dateStart,
        string $dateEnd,
        ?string $status = null,
        ?string $orderId = null,
        ?int $limit = null,
        ?int $offset = null
    ): array {
        $invoiceClient = $this->getInvoiceClient();

        return $invoiceClient->getInvoices($dateStart, $dateEnd, $status, $orderId, $limit, $offset);
    }

    /**
     * Request a BitPay Invoice Webhook.
     *
     * @see https://developer.bitpay.com/reference/retrieve-an-event-token Retrieve an Event Token
     *
     * @param  string $invoiceId    A BitPay invoice ID.
     * @param  string $invoiceToken The resource token for the invoiceId.
     *                              This token can be retrieved from the Bitpay's invoice object.
     * @return bool                 True if the webhook was successfully requested, false otherwise.
     * @throws BitPayApiException
     * @throws BitPayGenericException
     */
    public function requestInvoiceNotification(string $invoiceId, string $invoiceToken): bool
    {
        $invoiceClient = $this->getInvoiceClient();

        return $invoiceClient->requestNotification($invoiceId, $invoiceToken);
    }

    /**
     * Cancel a BitPay invoice.
     *
     * @see https://developer.bitpay.com/reference/cancel-an-invoice Cancel an Invoice
     *
     * @param string $invoiceId The id of the invoice to updated.
     * @return Invoice  $invoice   Cancelled invoice object.
     * @throws BitPayApiException
     * @throws BitPayGenericException
     */
    public function cancelInvoice(
        string $invoiceId,
        bool $forceCancel = false
    ): Invoice {
        $invoiceClient = $this->getInvoiceClient();

        return $invoiceClient->cancel($invoiceId, $forceCancel);
    }

    /**
     * Cancel a BitPay invoice.
     *
     * @see https://developer.bitpay.com/reference/cancel-an-invoice-by-guid Cancel an Invoice by GUID
     *
     * @param string $guid The guid of the invoice to cancel.
     * @return Invoice $invoice Cancelled invoice object.
     * @throws BitPayApiException
     * @throws BitPayGenericException
     */
    public function cancelInvoiceByGuid(
        string $guid,
        bool $forceCancel = false
    ): Invoice {
        $invoiceClient = $this->getInvoiceClient();

        return $invoiceClient->cancelByGuid($guid, $forceCancel);
    }

    /**
     * Pay an invoice with a mock transaction
     *
     * @param string $invoiceId The id of the invoice.
     * @param string $status Status the invoice will become. Acceptable values are confirmed (default) and complete.
     * @return Invoice $invoice  Invoice object.
     * @throws BitPayApiException
     * @throws BitPayGenericException
     */
    public function payInvoice(
        string $invoiceId,
        string $status = 'confirmed'
    ): Invoice {
        $invoiceClient = $this->getInvoiceClient();

        return $invoiceClient->pay($invoiceId, $status);
    }

    /**
     * Create a refund for a BitPay invoice.
     *
     * @see https://developer.bitpay.com/reference/create-a-refund-request Create a Refund Request
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
     * @return Refund $refund             An updated Refund Object
     * @throws BitPayApiException            BitPayException class
     * @throws BitPayGenericException   BitPayGenericException
     */
    public function createRefund(
        string $invoiceId,
        float $amount,
        string $currency,
        bool $preview = false,
        bool $immediate = false,
        bool $buyerPaysRefundFee = false,
        ?string $guid = null
    ): Refund {
        $refundClient = $this->getRefundClient();

        return $refundClient->create($invoiceId, $amount, $currency, $preview, $immediate, $buyerPaysRefundFee, $guid);
    }

    /**
     * Update the status of a BitPay invoice.
     *
     * @see https://developer.bitpay.com/reference/update-a-refund-request Update a Refund Request
     *
     * @param  string $refundId    BitPay refund ID.
     * @param  string $status      The new status for the refund to be updated.
     * @return Refund $refund      Refund A BitPay generated Refund object.
     * @throws BitPayApiException
     */
    public function updateRefund(
        string $refundId,
        string $status
    ): Refund {
        $refundClient = $this->getRefundClient();

        return $refundClient->update($refundId, $status);
    }

    /**
     * Update the status of a BitPay invoice.
     *
     * @see https://developer.bitpay.com/reference/update-a-refund-by-guid-request Update a Refund by GUID Request
     *
     * @param  string $guid        BitPay refund Guid.
     * @param  string $status      The new status for the refund to be updated.
     * @return Refund $refund      Refund A BitPay generated Refund object.
     * @throws BitPayApiException
     */
    public function updateRefundByGuid(
        string $guid,
        string $status
    ): Refund {
        $refundClient = $this->getRefundClient();

        return $refundClient->updateByGuid($guid, $status);
    }

    /**
     * Retrieve all refund requests on a BitPay invoice.
     *
     * @see https://developer.bitpay.com/reference/retrieve-refunds-of-an-invoice Retrieve Refunds of an Invoice
     *
     * @param  string $invoiceId   The BitPay invoice object having the associated refunds.
     * @return Refund[]
     * @throws BitPayApiException
     */
    public function getRefunds(
        string $invoiceId
    ): array {
        $refundClient = $this->getRefundClient();

        return $refundClient->getRefunds($invoiceId);
    }

    /**
     * Retrieve a previously made refund request on a BitPay invoice.
     *
     * @see https://developer.bitpay.com/reference/retrieve-a-refund-request Retrieve a Refund Request
     *
     * @param string $refundId The BitPay refund ID.
     * @return Refund $refund   BitPay Refund object with the associated Refund object.
     * @throws BitPayApiException
     * @throws BitPayGenericException
     */
    public function getRefund(
        string $refundId
    ): Refund {
        $refundClient = $this->getRefundClient();

        return $refundClient->get($refundId);
    }

    /**
     * Retrieve a previously made refund request on a BitPay invoice.
     *
     * @see https://developer.bitpay.com/reference/retrieve-a-refund-by-guid-request Retrieve a Refund by GUID Request
     *
     * @param string $guid The BitPay refund Guid
     * @return Refund BitPay Refund object with the associated Refund object.
     * @throws BitPayApiException
     * @throws BitPayGenericException
     */
    public function getRefundByGuid(string $guid): Refund
    {
        $refundClient = $this->getRefundClient();

        return $refundClient->getByGuid($guid);
    }

    /**
     * Send a refund notification.
     *
     * @see https://developer.bitpay.com/reference/request-a-refund-notification-to-be-resent
     * Request a Refund Notification to be Resent
     *
     * @param  string $refundId    A BitPay refund ID.
     * @param  string $refundToken The resource token for the refundId.
     *                             This token can be retrieved from the Bitpay's refund object.
     * @return bool   $result      An updated Refund Object
     * @throws BitPayApiException
     */
    public function sendRefundNotification(string $refundId, string $refundToken): bool
    {
        $refundClient = $this->getRefundClient();

        return $refundClient->sendNotification($refundId, $refundToken);
    }

    /**
     * Cancel a previously submitted refund request on a BitPay invoice.
     *
     * @see https://developer.bitpay.com/reference/cancel-a-refund-request Cancel a Refund Request
     *
     * @param  string $refundId The refund Id for the refund to be canceled.
     * @return Refund $refund   Cancelled refund Object.
     * @throws BitPayApiException
     */
    public function cancelRefund(string $refundId): Refund
    {
        $refundClient = $this->getRefundClient();

        return $refundClient->cancel($refundId);
    }

    /**
     * Cancel a previously submitted refund request on a BitPay invoice.
     *
     * @see https://developer.bitpay.com/reference/cancel-a-refund-by-guid-request
     * Cancel a Refund by GUID Request
     *
     * @param  string $guid     The refund Guid for the refund to be canceled.
     * @return Refund $refund   Cancelled refund Object.
     * @throws BitPayApiException
     */
    public function cancelRefundByGuid(string $guid): Refund
    {
        $refundClient = $this->getRefundClient();

        return $refundClient->cancelByGuid($guid);
    }

    /**
     * Retrieve all supported wallets.
     *
     * @see https://developer.bitpay.com/reference/retrieve-the-supported-wallets
     * Retrieve the Supported Wallets
     *
     * @return Wallet[]
     * @throws BitPayApiException
     * @throws BitPayGenericException
     */
    public function getSupportedWallets(): array
    {
        $walletClient = $this->getWalletClient();

        return $walletClient->getSupportedWallets();
    }

    /**
     * Create a BitPay Bill.
     *
     * @see https://developer.bitpay.com/reference/create-a-bill Create a Bill
     *
     * @param Bill $bill A Bill object with request parameters defined.
     * @param string $facade The facade used to create it.
     * @param bool $signRequest Signed request.
     * @return Bill
     * @throws BitPayApiException
     * @throws BitPayGenericException
     */
    public function createBill(Bill $bill, string $facade = Facade::MERCHANT, bool $signRequest = true): Bill
    {
        $billClient = $this->getBillClient();

        return $billClient->create($bill, $facade, $signRequest);
    }

    /**
     * Retrieve a BitPay bill by bill id using the specified facade.
     *
     * @see https://developer.bitpay.com/reference/retrieve-a-bill Retrieve a Bill
     *
     * @param $billId      string The id of the bill to retrieve.
     * @param $facade      string The facade used to retrieve it.
     * @param $signRequest bool Signed request.
     * @return Bill
     * @throws BitPayApiException
     * @throws BitPayGenericException
     */
    public function getBill(string $billId, string $facade = Facade::MERCHANT, bool $signRequest = true): Bill
    {
        $billClient = $this->getBillClient();

        return $billClient->get($billId, $facade, $signRequest);
    }

    /**
     * Retrieve a collection of BitPay bills.
     *
     * @see https://developer.bitpay.com/reference/retrieve-bills-by-status Retrieve Bills by Status
     *
     * @param string|null $status The status to filter the bills.
     * @return Bill[]
     * @throws BitPayApiException
     * @throws BitPayGenericException
     */
    public function getBills(?string $status = null): array
    {
        $billClient = $this->getBillClient();

        return $billClient->getBills($status);
    }

    /**
     * Update a BitPay Bill.
     *
     * @see https://developer.bitpay.com/reference/update-a-bill Update a Bill
     *
     * @param Bill $bill A Bill object with the parameters to update defined.
     * @param string $billId The Id of the Bill to update.
     * @return Bill
     * @throws BitPayApiException
     * @throws BitPayGenericException
     */
    public function updateBill(Bill $bill, string $billId): Bill
    {
        $billClient = $this->getBillClient();

        return $billClient->update($bill, $billId);
    }

    /**
     * Deliver a BitPay Bill.
     *
     * @see https://developer.bitpay.com/reference/deliver-a-bill-via-email Deliver a Bill Via Email
     *
     * @param string $billId The id of the requested bill.
     * @param string $billToken The token of the requested bill.
     * @param bool $signRequest Allow unsigned request
     * @return bool
     * @throws BitPayApiException
     * @throws BitPayGenericException
     */
    public function deliverBill(string $billId, string $billToken, bool $signRequest = true): bool
    {
        $billClient = $this->getBillClient();

        return $billClient->deliver($billId, $billToken, $signRequest);
    }

    /**
     * Create a BitPay Subscription.
     *
     * @see https://developer.bitpay.com/reference/create-a-subscription Create a Subscription
     *
     * @param Subscription $subscription A Subscription object with request parameters defined.
     * @return Subscription Created Subscription object
     * @throws BitPayApiException
     * @throws BitPayGenericException
     */
    public function createSubscription(Subscription $subscription): Subscription
    {
        $subscriptionClient = $this->getSubscriptionClient();

        return $subscriptionClient->create($subscription);
    }

    /**
     * Retrieve a BitPay subscription by its ID.
     *
     * @see https://developer.bitpay.com/reference/retrieve-a-subscription Retrieve a Subscription
     *
     * @param string $subscriptionId The ID of the subscription to retrieve.
     * @return Subscription
     * @throws BitPayApiException
     * @throws BitPayGenericException
     */
    public function getSubscription(string $subscriptionId): Subscription
    {
        $subscriptionClient = $this->getSubscriptionClient();

        return $subscriptionClient->get($subscriptionId);
    }

    /**
     * Retrieve a collection of BitPay subscriptions.
     *
     * @see https://developer.bitpay.com/reference/retrieve-subscriptions-by-status Retrieve Subscriptions by Status
     *
     * @param string|null $status The status on which to filter the subscriptions.
     * @return Subscription[] Filtered list of Subscription objects
     * @throws BitPayApiException
     * @throws BitPayGenericException
     */
    public function getSubscriptions(?string $status = null): array
    {
        $subscriptionClient = $this->getSubscriptionClient();

        return $subscriptionClient->getSubscriptions($status);
    }

    /**
     * Update a BitPay Subscription.
     *
     * @see https://developer.bitpay.com/reference/update-a-subscription Update a Subscription
     *
     * @param Subscription $subscription A Subscription object with the parameters to update defined.
     * @param string $subscriptionId The ID of the Subscription to update.
     * @return Subscription Updated Subscription object
     * @throws BitPayApiException
     * @throws BitPayGenericException
     */
    public function updateSubscription(Subscription $subscription, string $subscriptionId): Subscription
    {
        $subscriptionClient = $this->getSubscriptionClient();

        return $subscriptionClient->update($subscription, $subscriptionId);
    }

    /**
     * Retrieve the exchange rate table maintained by BitPay.
     * @see https://bitpay.com/bitcoin-exchange-rates
     *
     * @return Rates
     * @throws BitPayApiException
     * @throws BitPayGenericException
     */
    public function getRates(): Rates
    {
        $rateClient = $this->getRateClient();

        return $rateClient->getRates();
    }

    /**
     * Retrieve all the rates for a given cryptocurrency
     *
     * @see https://developer.bitpay.com/reference/retrieve-all-the-rates-for-a-given-cryptocurrency
     * Retrieve all the rates for a given cryptocurrency
     *
     * @param string $baseCurrency The cryptocurrency for which you want to fetch the rates.
     *                             Current supported values are BTC, BCH, ETH, XRP, DOGE and LTC
     * @return Rates               A Rates object populated with the currency rates for the requested baseCurrency.
     * @throws BitPayApiException
     * @throws BitPayGenericException
     */
    public function getCurrencyRates(string $baseCurrency): Rates
    {
        $rateClient = $this->getRateClient();

        return $rateClient->getCurrencyRates($baseCurrency);
    }

    /**
     * Retrieve the rate for a cryptocurrency / fiat pair
     *
     * @see https://developer.bitpay.com/reference/retrieve-the-rates-for-a-cryptocurrency-fiat-pair
     * Retrieve the rates for a cryptocurrency / fiat pair
     *
     * @param string $baseCurrency The cryptocurrency for which you want to fetch the fiat-equivalent rate.
     *                             Current supported values are BTC, BCH, ETH, XRP, DOGE and LTC
     * @param string $currency The fiat currency for which you want to fetch the baseCurrency rate
     * @return Rate                A Rate object populated with the currency rate for the requested baseCurrency.
     * @throws BitPayApiException
     * @throws BitPayGenericException
     */
    public function getCurrencyPairRate(string $baseCurrency, string $currency): Rate
    {
        $rateClient = $this->getRateClient();

        return $rateClient->getCurrencyPairRate($baseCurrency, $currency);
    }

    /**
     * Retrieve a list of ledgers by date range using the merchant facade.
     *
     * @see https://developer.bitpay.com/reference/retrieve-ledger-entries Retrieve Ledger Entries
     *
     * @param string $currency The three digit currency string for the ledger to retrieve.
     * @param string $startDate The first date for the query filter.
     * @param string $endDate The last date for the query filter.
     * @return LedgerEntry[] A Ledger object populated with the BitPay ledger entries list.
     * @throws BitPayApiException
     * @throws BitPayGenericException
     */
    public function getLedgerEntries(string $currency, string $startDate, string $endDate): array
    {
        $ledgerClient = $this->getLedgerClient();

        return $ledgerClient->get($currency, $startDate, $endDate);
    }

    /**
     * Retrieve a list of ledgers using the merchant facade.
     *
     * @see https://developer.bitpay.com/reference/retrieve-account-balances Retrieve Account Balances
     *
     * @return Ledger[] A list of Ledger objects populated with the currency and current balance of each one.
     * @throws BitPayApiException
     * @throws BitPayGenericException
     */
    public function getLedgers(): array
    {
        $ledgerClient = $this->getLedgerClient();

        return $ledgerClient->getLedgers();
    }

    /**
     * Submit BitPay Payout Recipients.
     *
     * @see https://developer.bitpay.com/reference/invite-recipients Invite Recipients
     *
     * @param PayoutRecipients $recipients A PayoutRecipients object with request parameters defined.
     * @return PayoutRecipient[]       A list of BitPay PayoutRecipients objects.
     * @throws BitPayGenericException
     * @throws BitPayApiException
     */
    public function submitPayoutRecipients(PayoutRecipients $recipients): array
    {
        $payoutRecipientsClient = $this->getPayoutRecipientsClient();

        return $payoutRecipientsClient->submit($recipients);
    }

    /**
     * Retrieve a BitPay payout recipient by batch id using.  The client must have been previously authorized for the
     * payout facade.
     *
     * @see https://developer.bitpay.com/reference/retrieve-a-recipient Retrieve a Recipient
     *
     * @param string $recipientId The id of the recipient to retrieve.
     * @return PayoutRecipient
     * @throws BitPayGenericException
     * @throws BitPayApiException
     */
    public function getPayoutRecipient(string $recipientId): PayoutRecipient
    {
        $payoutRecipientsClient = $this->getPayoutRecipientsClient();

        return $payoutRecipientsClient->get($recipientId);
    }

    /**
     * Retrieve a collection of BitPay Payout Recipients.
     *
     * @see https://developer.bitpay.com/reference/retrieve-recipients-by-status Retrieve Recipients by Status
     *
     * @param string|null $status The recipient status you want to query on.
     * @param int|null $limit Maximum results that the query will return (useful for paging results).
     * @param int|null $offset Number of results to offset (ex. skip 10 will give you results
     *                             starting with the 11th result).
     * @return PayoutRecipient[]
     * @throws BitPayApiException
     * @throws BitPayGenericException
     */
    public function getPayoutRecipients(?string $status = null, ?int $limit = null, ?int $offset = null): array
    {
        $payoutRecipientsClient = $this->getPayoutRecipientsClient();

        return $payoutRecipientsClient->getPayoutRecipients($status, $limit, $offset);
    }

    /**
     * Update a Payout Recipient.
     *
     * @see https://developer.bitpay.com/reference/update-a-recipient Update a Recipient
     *
     * @param string $recipientId The recipient id for the recipient to be updated.
     * @param PayoutRecipient $recipient A PayoutRecipient object with updated parameters defined.
     * @return PayoutRecipient
     * @throws BitPayGenericException
     * @throws BitPayApiException
     */
    public function updatePayoutRecipient(string $recipientId, PayoutRecipient $recipient): PayoutRecipient
    {
        $payoutRecipientsClient = $this->getPayoutRecipientsClient();

        return $payoutRecipientsClient->update($recipientId, $recipient);
    }

    /**
     * Delete a Payout Recipient.
     *
     * @see https://developer.bitpay.com/reference/remove-a-recipient Remove a Recipient
     *
     * @param string $recipientId The recipient id for the recipient to be deleted.
     * @return bool                True if the recipient was successfully deleted, false otherwise.
     * @throws BitPayGenericException
     * @throws BitPayApiException
     */
    public function deletePayoutRecipient(string $recipientId): bool
    {
        $payoutRecipientsClient = $this->getPayoutRecipientsClient();

        return $payoutRecipientsClient->delete($recipientId);
    }

    /**
     * Notify BitPay Payout Recipient.
     *
     * @see https://developer.bitpay.com/reference/request-a-recipient-webhook-to-be-resent
     * Request a Recipient Webhook to be Resent
     *
     * @param string $recipientId The id of the recipient to notify.
     * @return bool                True if the notification was successfully sent, false otherwise.
     * @throws BitPayGenericException
     * @throws BitPayApiException
     */
    public function requestPayoutRecipientNotification(string $recipientId): bool
    {
        $payoutRecipientsClient = $this->getPayoutRecipientsClient();

        return $payoutRecipientsClient->requestNotification($recipientId);
    }

    /**
     * Submit a BitPay Payout.
     *
     * @see https://developer.bitpay.com/reference/create-a-payout Create a Payout
     *
     * @param Payout $payout A Payout object with request parameters defined.
     * @return Payout
     * @throws BitPayGenericException
     * @throws BitPayApiException
     */
    public function submitPayout(Payout $payout): Payout
    {
        $payoutClient = $this->getPayoutClient();

        return $payoutClient->submit($payout);
    }

    /**
     * Retrieve a BitPay payout by payout id using. The client must have been previously authorized
     * for the payout facade.
     *
     * @see https://developer.bitpay.com/reference/retrieve-a-payout Retrieve a Payout
     *
     * @param string $payoutId The id of the payout to retrieve.
     * @return Payout
     * @throws BitPayGenericException
     * @throws BitPayApiException
     */
    public function getPayout(string $payoutId): Payout
    {
        $payoutClient = $this->getPayoutClient();

        return $payoutClient->get($payoutId);
    }

    /**
     * Retrieve a collection of BitPay payouts.
     *
     * @see https://developer.bitpay.com/reference/retrieve-payouts-filtered-by-query Retrieve Payouts Filtered by Query
     *
     * @param string|null $startDate The start date to filter the Payout Batches.
     * @param string|null $endDate The end date to filter the Payout Batches.
     * @param string|null $status The status to filter the Payout Batches.
     * @param string|null $reference The optional reference specified at payout request creation.
     * @param int|null $limit Maximum results that the query will return (useful for paging results).
     * @param int|null $offset Number of results to offset (ex. skip 10 will give you results
     *                           starting with the 11th result).
     * @return Payout[]
     * @throws BitPayGenericException
     * @throws BitPayApiException
     */
    public function getPayouts(
        ?string $startDate = null,
        ?string $endDate = null,
        ?string $status = null,
        ?string $reference = null,
        ?int $limit = null,
        ?int $offset = null
    ): array {
        $payoutClient = $this->getPayoutClient();

        return $payoutClient->getPayouts($startDate, $endDate, $status, $reference, $limit, $offset);
    }

    /**
     * Cancel a BitPay Payout.
     *
     * @see https://developer.bitpay.com/reference/cancel-a-payout Cancel a Payout
     *
     * @param string $payoutId The id of the payout to cancel.
     * @return bool
     * @throws BitPayGenericException
     * @throws BitPayApiException
     */
    public function cancelPayout(string $payoutId): bool
    {
        $payoutClient = $this->getPayoutClient();

        return $payoutClient->cancel($payoutId);
    }

    /**
     * Notify BitPay Payout.
     *
     * @see https://developer.bitpay.com/reference/request-a-payout-webhook-to-be-resent
     * Request a Payout Webhook to be Resent
     *
     * @param string $payoutId The id of the Payout to notify.
     * @return bool
     * @throws BitPayGenericException
     * @throws BitPayApiException
     */
    public function requestPayoutNotification(string $payoutId): bool
    {
        $payoutClient = $this->getPayoutClient();

        return $payoutClient->requestNotification($payoutId);
    }

    /**
     * @see https://developer.bitpay.com/reference/create-payout-group Create Payout Group
     *
     * @param Payout[] $payouts
     * @return PayoutGroup
     * @throws BitPayGenericException
     * @throws BitPayApiException
     */
    public function createPayoutGroup(array $payouts): PayoutGroup
    {
        $payoutClient = $this->getPayoutClient();

        return $payoutClient->createGroup($payouts);
    }

    /**
     * @see https://developer.bitpay.com/reference/cancel-a-payout-group Cancel a Payout Group
     *
     * @param string $groupId
     * @return PayoutGroup
     * @throws BitPayApiException
     * @throws BitPayGenericException
     */
    public function cancelPayoutGroup(string $groupId): PayoutGroup
    {
        $payoutClient = $this->getPayoutClient();

        return $payoutClient->cancelGroup($groupId);
    }

    /**
     * Retrieves settlement reports for the calling merchant filtered by query.
     * The `limit` and `offset` parameters
     * specify pages for large query sets.
     *
     * @see https://developer.bitpay.com/reference/retrieve-settlements Retrieve Settlements
     *
     * @param $currency  string The three digit currency string for the ledger to retrieve.
     * @param $dateStart string The start date for the query.
     * @param $dateEnd   string The end date for the query.
     * @param string|null $status string Can be `processing`, `completed`, or `failed`.
     * @param int|null $limit int Maximum number of settlements to retrieve.
     * @param int|null $offset int Offset for paging.
     * @return Settlement[]
     * @throws BitPayApiException
     * @throws BitPayGenericException
     */
    public function getSettlements(
        string $currency,
        string $dateStart,
        string $dateEnd,
        ?string $status = null,
        ?int $limit = null,
        ?int $offset = null
    ): array {
        $settlementsClient = $this->getSettlementClient();

        return $settlementsClient->getSettlements($currency, $dateStart, $dateEnd, $status, $limit, $offset);
    }

    /**
     * Retrieves a summary of the specified settlement.
     *
     * @see https://developer.bitpay.com/reference/retrieve-a-settlement Retrieve a Settlement
     *
     * @param string $settlementId Settlement Id.
     * @return Settlement
     * @throws BitPayApiException
     * @throws BitPayGenericException
     */
    public function getSettlement(string $settlementId): Settlement
    {
        $settlementsClient = $this->getSettlementClient();

        return $settlementsClient->get($settlementId);
    }

    /**
     * Gets a detailed reconciliation report of the activity within the settlement period.
     *
     * @see https://developer.bitpay.com/reference/fetch-a-reconciliation-report Fetch a Reconciliation Report
     *
     * @param string $settlementId Settlement ID
     * @param string $settlementToken Settlement Token
     * @return Settlement
     * @throws BitPayApiException
     * @throws BitPayGenericException
     */
    public function getSettlementReconciliationReport(string $settlementId, string $settlementToken): Settlement
    {
        $settlementsClient = $this->getSettlementClient();

        return $settlementsClient->getReconciliationReport($settlementId, $settlementToken);
    }

    /**
     * @param string|null $privateKey
     * @param string|null $privateKeySecret
     * @return PrivateKey|null
     * @throws BitPayApiException
     * @throws Exception
     */
    private static function initKeys(?string $privateKey, ?string $privateKeySecret): ?PrivateKey
    {
        $key = null;

        if (!file_exists($privateKey)) {
            $key = new PrivateKey("plainHex");
            $key->setHex($privateKey);
            if (!$key->isValid()) {
                BitPayExceptionProvider::throwGenericExceptionWithMessage('Private Key not found/valid');
            }
        }

        if (!$key) {
            $storageEngine = new EncryptedFilesystemStorage($privateKeySecret);
            $key = $storageEngine->load($privateKey);
        }

        return $key;
    }

    /**
     * @param string $configFilePath
     * @return array
     * @throws BitPayGenericException
     */
    private static function getConfigData(string $configFilePath): array
    {
        if (!file_exists($configFilePath)) {
            BitPayExceptionProvider::throwGenericExceptionWithMessage('Configuration file not found');
        }

        try {
            $configData = json_decode(file_get_contents($configFilePath), true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            $configData = Yaml::parseFile($configFilePath);
        }

        return $configData;
    }

    /**
     * Gets token client
     *
     * @return TokenClient
     */
    private function getTokenClient(): TokenClient
    {
        return TokenClient::getInstance($this->restCli);
    }

    /**
     * Gets invoice client
     *
     * @return InvoiceClient the invoice client
     */
    protected function getInvoiceClient(): InvoiceClient
    {
        return InvoiceClient::getInstance($this->tokenCache, $this->restCli);
    }

    /**
     * Gets refund client
     *
     * @return RefundClient the refund client
     */
    protected function getRefundClient(): RefundClient
    {
        return RefundClient::getInstance($this->tokenCache, $this->restCli);
    }

    /**
     * Gets wallet client
     *
     * @return WalletClient the wallet client
     */
    protected function getWalletClient(): WalletClient
    {
        return WalletClient::getInstance($this->restCli);
    }

    /**
     * Gets bill client
     *
     * @return BillClient the bill client
     */
    protected function getBillClient(): BillClient
    {
        return BillClient::getInstance($this->tokenCache, $this->restCli);
    }

    /**
     * Gets subscription client
     *
     * @return SubscriptionClient the subscription client
     */
    protected function getSubscriptionClient(): SubscriptionClient
    {
        return SubscriptionClient::getInstance($this->tokenCache, $this->restCli);
    }

    /**
     * Gets rate client
     *
     * @return RateClient the rate client
     */
    protected function getRateClient(): RateClient
    {
        return RateClient::getInstance($this->restCli);
    }

    /**
     * Gets ledger client
     *
     * @return LedgerClient the ledger client
     */
    protected function getLedgerClient(): LedgerClient
    {
        return LedgerClient::getInstance($this->tokenCache, $this->restCli);
    }

    /**
     * Gets payout recipients client
     *
     * @return PayoutRecipientsClient the payout recipients client
     */
    protected function getPayoutRecipientsClient(): PayoutRecipientsClient
    {
        return PayoutRecipientsClient::getInstance($this->tokenCache, $this->restCli);
    }

    /**
     * Gets payout client
     *
     * @return PayoutClient the payout client
     */
    protected function getPayoutClient(): PayoutClient
    {
        return PayoutClient::getInstance($this->tokenCache, $this->restCli);
    }

    /**
     * Gets settlement client
     *
     * @return SettlementClient the settlements client
     */
    protected function getSettlementClient(): SettlementClient
    {
        return SettlementClient::getInstance($this->tokenCache, $this->restCli);
    }
}
