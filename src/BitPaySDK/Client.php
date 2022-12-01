<?php

namespace BitPaySDK;

use BitPayKeyUtils\KeyHelper\PrivateKey;
use BitPayKeyUtils\Storage\EncryptedFilesystemStorage;
use BitPayKeyUtils\Util\Util;
use BitPaySDK\Client\BillClient;
use BitPaySDK\Client\InvoiceClient;
use BitPaySDK\Client\LedgerClient;
use BitPaySDK\Client\PayoutClient;
use BitPaySDK\Client\PayoutRecipientsClient;
use BitPaySDK\Client\RateClient;
use BitPaySDK\Client\RefundClient;
use BitPaySDK\Client\SettlementsClient;
use BitPaySDK\Client\SubscriptionClient;
use BitPaySDK\Client\WalletClient;
use BitPaySDK\Exceptions\BitPayException;
use BitPaySDK\Exceptions\CurrencyQueryException;
use BitPaySDK\Exceptions\InvoiceUpdateException;
use BitPaySDK\Exceptions\InvoiceQueryException;
use BitPaySDK\Exceptions\InvoiceCancellationException;
use BitPaySDK\Exceptions\InvoicePaymentException;
use BitPaySDK\Exceptions\PayoutRecipientCreationException;
use BitPaySDK\Exceptions\PayoutRecipientCancellationException;
use BitPaySDK\Exceptions\PayoutRecipientUpdateException;
use BitPaySDK\Exceptions\PayoutRecipientNotificationException;
use BitPaySDK\Exceptions\PayoutCancellationException;
use BitPaySDK\Exceptions\PayoutCreationException;
use BitPaySDK\Exceptions\PayoutQueryException;
use BitPaySDK\Exceptions\PayoutNotificationException;
use BitPaySDK\Exceptions\PayoutBatchCreationException;
use BitPaySDK\Exceptions\PayoutBatchQueryException;
use BitPaySDK\Exceptions\PayoutBatchCancellationException;
use BitPaySDK\Exceptions\PayoutBatchNotificationException;
use BitPaySDK\Exceptions\RefundCreationException;
use BitPaySDK\Exceptions\RefundUpdateException;
use BitPaySDK\Exceptions\RefundCancellationException;
use BitPaySDK\Exceptions\RefundQueryException;
use BitPaySDK\Exceptions\WalletQueryException;
use BitPaySDK\Model\Bill\Bill;
use BitPaySDK\Model\Facade;
use BitPaySDK\Model\Invoice\Invoice;
use BitPaySDK\Model\Invoice\Refund;
use BitPaySDK\Model\Wallet\Wallet;
use BitPaySDK\Model\Ledger\Ledger;
use BitPaySDK\Model\Payout\Payout;
use BitPaySDK\Model\Payout\PayoutBatch;
use BitPaySDK\Model\Payout\PayoutRecipient;
use BitPaySDK\Model\Payout\PayoutRecipients;
use BitPaySDK\Model\Rate\Rate;
use BitPaySDK\Model\Rate\Rates;
use BitPaySDK\Model\Settlement\Settlement;
use BitPaySDK\Model\Subscription\Subscription;
use BitPaySDK\Util\RESTcli\RESTcli;
use Exception;
use Symfony\Component\Yaml\Yaml;

/**
 * Class Client
 * @package Bitpay
 * @author  Antonio Buedo
 * @version 7.1.0
 * See bitpay.com/api for more information.
 * date 15.11.2021
 */
class Client
{
    /**
     * @var Config
     */
    protected $_configuration;

    /**
     * @var string
     */
    protected $_env;

    /**
     * @var Tokens
     */
    protected $_tokenCache; // {facade, token}

    /**
     * @var string
     */
    protected $_configFilePath;

    /**
     * @var PrivateKey
     */
    protected $_ecKey;

    /**
     * @var RESTcli
     */
    protected $_RESTcli = null;

    /**
     * @var RESTcli
     */
    protected $_currenciesInfo = null;

    /**
     * Client constructor.
     */
    public function __construct()
    {
    }

    /**
     * Static constructor / factory
     */
    public static function create()
    {
        $instance = new self();

        return $instance;
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
     * @return Client
     * @throws BitPayException
     */
    public function withData($environment, $privateKey, Tokens $tokens, $privateKeySecret = null, ?string $proxy = null)
    {
        try {
            $this->_env = $environment;
            $this->buildConfig($privateKey, $tokens, $privateKeySecret, $proxy);
            $this->initKeys();
            $this->init();

            return $this;
        } catch (Exception $e) {
            throw new BitPayException("failed to initialize BitPay Client (Config) : " . $e->getMessage());
        }
    }

    /**
     * Constructor for use if the keys and SIN are managed by this library.
     *
     * @param string $configFilePath  The path to the configuration file.
     * @return Client
     * @throws BitPayException        BitPayException class
     */
    public function withFile($configFilePath)
    {
        try {
            $this->_configFilePath = $configFilePath;
            $this->getConfig();
            $this->initKeys();
            $this->init();

            return $this;
        } catch (Exception $e) {
            throw new BitPayException("failed to initialize BitPay Client (Config) : " . $e->getMessage());
        }
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
    public function createInvoice(
        Invoice $invoice,
        string $facade = Facade::Merchant,
        bool $signRequest = true
    ): Invoice {
        $invoiceClient = $this->createInvoiceClient();

        return $invoiceClient->create($invoice, $facade, $signRequest);
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
    public function updateInvoice(
        string $invoiceId,
        string $buyerSms,
        string $smsCode,
        string $buyerEmail,
        bool $autoVerify = false
    ): Invoice {
        $invoiceClient = $this->createInvoiceClient();

        return $invoiceClient->update($invoiceId, $buyerSms, $smsCode, $buyerEmail, $autoVerify);
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
    public function getInvoice(
        string $invoiceId,
        string $facade = Facade::Merchant,
        bool $signRequest = true
    ): Invoice {
        $invoiceClient = $this->createInvoiceClient();

        return $invoiceClient->get($invoiceId, $facade, $signRequest);
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
        $invoiceClient = $this->createInvoiceClient();

        return $invoiceClient->getInvoices($dateStart, $dateEnd, $status, $orderId, $limit, $offset);
    }

    /**
     * Request a BitPay Invoice Webhook.
     *
     * @param  string $invoiceId A BitPay invoice ID.
     * @return bool              True if the webhook was successfully requested, false otherwise.
     * @throws InvoiceQueryException
     * @throws BitPayException
     */
    public function requestInvoiceNotification(string $invoiceId): bool
    {
        $invoiceClient = $this->createInvoiceClient();

        return $invoiceClient->requestNotification($invoiceId);
    }

    /**
     * Cancel a BitPay invoice.
     *
     * @param  string   $invoiceId The id of the invoice to updated.
     * @return Invoice  $invoice   Cancelled invoice object.
     * @throws InvoiceCancellationException
     * @throws BitPayException
     */
    public function cancelInvoice(
        string $invoiceId,
        bool $forceCancel = false
    ): Invoice {
        $invoiceClient = $this->createInvoiceClient();

        return $invoiceClient->cancel($invoiceId, $forceCancel);
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
    public function payInvoice(
        string $invoiceId,
        string $status = 'confirmed'
    ): Invoice {
        $invoiceClient = $this->createInvoiceClient();

        return $invoiceClient->pay($invoiceId, $this->_env, $status);
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
     * @return Refund $refund             An updated Refund Object
     * @throws RefundCreationException    RefundCreationException class
     * @throws BitPayException            BitPayException class
     */
    public function createRefund(
        string $invoiceId,
        float $amount,
        string $currency,
        bool $preview = false,
        bool $immediate = false,
        bool $buyerPaysRefundFee = false
    ): Refund {
        $refundClient = $this->createRefundClient();

        return $refundClient->create($invoiceId, $amount, $currency, $preview, $immediate, $buyerPaysRefundFee);
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
    public function updateRefund(
        string $refundId,
        string $status
    ): Refund {
        $refundClient = $this->createRefundClient();

        return $refundClient->update($refundId, $status);
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
        $refundClient = $this->createRefundClient();

        return $refundClient->getRefunds($invoiceId);
    }

    /**
     * Retrieve a previously made refund request on a BitPay invoice.
     *
     * @param  string $refundId The BitPay refund ID.
     * @return Refund $refund   BitPay Refund object with the associated Refund object.
     * @throws RefundQueryException
     * @throws BitPayException
     */
    public function getRefund(
        string $refundId
    ): Refund {
        $refundClient = $this->createRefundClient();

        return $refundClient->get($refundId);
    }

    /**
     * Send a refund notification.
     *
     * @param  string $refundId    A BitPay refund ID.
     * @return bool   $result      An updated Refund Object
     * @throws RefundCreationException
     * @throws BitPayException
     */
    public function sendRefundNotification(string $refundId): bool
    {
        $refundClient = $this->createRefundClient();

        return $refundClient->sendNotification($refundId);
    }

    /**
     * Cancel a previously submitted refund request on a BitPay invoice.
     *
     * @param  string $refundId The refund Id for the refund to be canceled.
     * @return Refund $refund   Cancelled refund Object.
     * @throws RefundCancellationException
     * @throws BitPayException
     */
    public function cancelRefund(string $refundId): Refund
    {
        $refundClient = $this->createRefundClient();

        return $refundClient->cancel($refundId);
    }

    /**
     * Retrieve all supported wallets.
     *
     * @return Wallet[]
     * @throws WalletQueryException
     * @throws BitPayException
     */
    public function getSupportedWallets(): array
    {
        $walletClient = $this->createWalletClient();

        return $walletClient->getSupportedWallets();
    }

    /**
     * Create a BitPay Bill.
     *
     * @param  Bill   $bill        A Bill object with request parameters defined.
     * @param  string $facade      The facade used to create it.
     * @param  bool   $signRequest Signed request.
     * @return Bill
     * @throws BitPayException
     */
    public function createBill(Bill $bill, string $facade = Facade::Merchant, bool $signRequest = true): Bill
    {
        $billClient = $this->createBillClient();

        return $billClient->create($bill, $facade, $signRequest);
    }

    /**
     * Retrieve a BitPay bill by bill id using the specified facade.
     *
     * @param $billId      string The id of the bill to retrieve.
     * @param $facade      string The facade used to retrieve it.
     * @param $signRequest bool Signed request.
     * @return Bill
     * @throws BitPayException
     */
    public function getBill(string $billId, string $facade = Facade::Merchant, bool $signRequest = true): Bill
    {
        $billClient = $this->createBillClient();

        return $billClient->get($billId, $facade, $signRequest);
    }

    /**
     * Retrieve a collection of BitPay bills.
     *
     * @param  string|null The status to filter the bills.
     * @return Bill[]
     * @throws BitPayException
     */
    public function getBills(string $status = null): array
    {
        $billClient = $this->createBillClient();

        return $billClient->getBills($status);
    }

    /**
     * Update a BitPay Bill.
     *
     * @param  Bill   $bill   A Bill object with the parameters to update defined.
     * @param  string $billId The Id of the Bill to update.
     * @return Bill
     * @throws BitPayException
     */
    public function updateBill(Bill $bill, string $billId): Bill
    {
        $billClient = $this->createBillClient();

        return $billClient->update($bill, $billId);
    }

    /**
     * Deliver a BitPay Bill.
     *
     * @param  string $billId      The id of the requested bill.
     * @param  string $billToken   The token of the requested bill.
     * @param  bool   $signRequest Allow unsigned request
     * @return string
     * @throws BitPayException
     */
    public function deliverBill(string $billId, string $billToken, bool $signRequest = true): string
    {
        $billClient = $this->createBillClient();

        return $billClient->deliver($billId, $billToken, $signRequest);
    }

    /**
     * Retrieve the exchange rate table maintained by BitPay.  See https://bitpay.com/bitcoin-exchange-rates.
     *
     * @return Rates
     * @throws BitPayException
     */
    public function getRates(): Rates
    {
        $rateClient = $this->createRateClient();

        return $rateClient->getRates();
    }

    /**
     * Retrieve all the rates for a given cryptocurrency
     *
     * @param string $baseCurrency The cryptocurrency for which you want to fetch the rates.
     *                             Current supported values are BTC, BCH, ETH, XRP, DOGE and LTC
     * @return Rates               A Rates object populated with the currency rates for the requested baseCurrency.
     * @throws BitPayException
     */
    public function getCurrencyRates(string $baseCurrency): Rates
    {
        $rateClient = $this->createRateClient();

        return $rateClient->getCurrencyRates($baseCurrency);
    }

    /**
     * Retrieve the rate for a cryptocurrency / fiat pair
     *
     * @param string $baseCurrency The cryptocurrency for which you want to fetch the fiat-equivalent rate.
     *                             Current supported values are BTC, BCH, ETH, XRP, DOGE and LTC
     * @param string $currency     The fiat currency for which you want to fetch the baseCurrency rate
     * @return Rate                A Rate object populated with the currency rate for the requested baseCurrency.
     * @throws BitPayException
     */
    public function getCurrencyPairRate(string $baseCurrency, string $currency): Rate
    {
        $rateClient = $this->createRateClient();

        return $rateClient->getCurrencyPairRate($baseCurrency, $currency);
    }

    /**
     * Retrieve a list of ledgers by date range using the merchant facade.
     *
     * @param  string $currency  The three digit currency string for the ledger to retrieve.
     * @param  string $startDate The first date for the query filter.
     * @param  string $endDate   The last date for the query filter.
     * @return Ledger            A Ledger object populated with the BitPay ledger entries list.
     * @throws BitPayException
     */
    public function getLedger(string $currency, string $startDate, string $endDate): array
    {
        $ledgerClient = $this->createLedgerClient();

        return $ledgerClient->get($currency, $startDate, $endDate);
    }

    /**
     * Retrieve a list of ledgers using the merchant facade.
     *
     * @return Ledger[] A list of Ledger objects populated with the currency and current balance of each one.
     * @throws BitPayException
     */
    public function getLedgers(): array
    {
        $ledgerClient = $this->createLedgerClient();

        return $ledgerClient->getLedgers();
    }

    /**
     * Submit BitPay Payout Recipients.
     *
     * @param  PayoutRecipients $recipients A PayoutRecipients object with request parameters defined.
     * @return PayoutRevipients[]           A list of BitPay PayoutRecipients objects.
     * @throws PayoutRecipientCreationException
     */
    public function submitPayoutRecipients(PayoutRecipients $recipients): array
    {
        $payoutRecipientsClient = $this->createPayoutRecipientsClient();

        return $payoutRecipientsClient->submit($recipients);
    }

    /**
     * Retrieve a BitPay payout recipient by batch id using.  The client must have been previously authorized for the
     * payout facade.
     *
     * @param  string $recipientId The id of the recipient to retrieve.
     * @return PayoutRecipient
     * @throws PayoutQueryException
     */
    public function getPayoutRecipient(string $recipientId): PayoutRecipient
    {
        $payoutRecipientsClient = $this->createPayoutRecipientsClient();

        return $payoutRecipientsClient->get($recipientId);
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
        $payoutRecipientsClient = $this->createPayoutRecipientsClient();

        return $payoutRecipientsClient->getPayoutRecipients($status, $limit, $offset);
    }

    /**
     * Update a Payout Recipient.
     *
     * @param  string          $recipientId The recipient id for the recipient to be updated.
     * @param  PayoutRecipient $recipient   A PayoutRecipient object with updated parameters defined.
     * @return PayoutRecipient
     * @throws PayoutRecipientUpdateException
     */
    public function updatePayoutRecipient(string $recipientId, PayoutRecipient $recipient): PayoutRecipient
    {
        $payoutRecipientsClient = $this->createPayoutRecipientsClient();

        return $payoutRecipientsClient->update($recipientId, $recipient);
    }

    /**
     * Delete a Payout Recipient.
     *
     * @param  string $recipientId The recipient id for the recipient to be deleted.
     * @return bool                True if the recipient was successfully deleted, false otherwise.
     * @throws PayoutRecipientCancellationException
     */
    public function deletePayoutRecipient(string $recipientId): bool
    {
        $payoutRecipientsClient = $this->createPayoutRecipientsClient();

        return $payoutRecipientsClient->delete($recipientId);
    }

    /**
     * Notify BitPay Payout Recipient.
     *
     * @param  string $recipientId The id of the recipient to notify.
     * @return bool                True if the notification was successfully sent, false otherwise.
     * @throws PayoutRecipientNotificationException
     */
    public function requestPayoutRecipientNotification(string $recipientId): bool
    {
        $payoutRecipientsClient = $this->createPayoutRecipientsClient();

        return $payoutRecipientsClient->requestNotification($recipientId);
    }

    /**
     * Submit a BitPay Payout.
     *
     * @param  Payout $payout A Payout object with request parameters defined.
     * @return Payout
     * @throws PayoutCreationException
     */
    public function submitPayout(Payout $payout): Payout
    {
        $payoutClient = $this->createPayoutClient();

        return $payoutClient->submit($payout);
    }

    /**
     * Retrieve a BitPay payout by payout id using. The client must have been previously authorized
     * for the payout facade.
     *
     * @param  string $payoutId The id of the payout to retrieve.
     * @return Payout
     * @throws PayoutQueryException
     */
    public function getPayout(string $payoutId): Payout
    {
        $payoutClient = $this->createPayoutClient();

        return $payoutClient->get($payoutId);
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
        $payoutClient = $this->createPayoutClient();

        return $payoutClient->getPayouts($startDate, $endDate, $status, $reference, $limit, $offset);
    }

    /**
     * Cancel a BitPay Payout.
     *
     * @param  string $payoutId The id of the payout to cancel.
     * @return Payout
     * @throws PayoutCancellationException
     */
    public function cancelPayout(string $payoutId): bool
    {
        $payoutClient = $this->createPayoutClient();

        return $payoutClient->cancel($payoutId);
    }

    /**
     * Notify BitPay Payout.
     *
     * @param  string $payoutId The id of the Payout to notify.
     * @return Payout[]
     * @throws PayoutNotificationException BitPayException class
     */
    public function requestPayoutNotification(string $payoutId): bool
    {
        $payoutClient = $this->createPayoutClient();

        return $payoutClient->requestBatchNotification($payoutId);
    }

    /**
     * Submit a BitPay Payout batch.
     *
     * @param  PayoutBatch $batch A PayoutBatch object with request parameters defined.
     * @return PayoutBatch
     * @throws PayoutBatchCreationException
     */
    public function submitPayoutBatch(PayoutBatch $batch): PayoutBatch
    {
        $payoutClient = $this->createPayoutClient();

        return $payoutClient->submitBatch($batch);
    }

    /**
     * Retrieve a BitPay payout batch by batch id using. The client must have been previously authorized for the
     * payout facade.
     *
     * @param  string $payoutBatchId The id of the batch to retrieve.
     * @return PayoutBatch
     * @throws PayoutBatchQueryException
     */
    public function getPayoutBatch(string $payoutBatchId): PayoutBatch
    {
        $payoutClient = $this->createPayoutClient();

        return $payoutClient->getBatch($payoutBatchId);
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
    public function getPayoutBatches(
        string $startDate = null,
        string $endDate = null,
        string $status = null,
        int $limit = null,
        int $offset = null
    ): array {
        $payoutClient = $this->createPayoutClient();

        return $payoutClient->getBatches($startDate, $endDate, $status, $limit, $offset);
    }

    /**
     * Cancel a BitPay Payout batch.
     *
     * @param $batchId string The id of the batch to cancel.
     * @return PayoutBatch A BitPay generated PayoutBatch object.
     * @throws PayoutBatchCancellationException PayoutBatchCancellationException class
     */
    public function cancelPayoutBatch(string $payoutBatchId): bool
    {
        $payoutClient = $this->createPayoutClient();

        return $payoutClient->cancelBatch($payoutBatchId);
    }

    /**
     * Notify BitPay PayoutBatch.
     *
     * @param  string $payoutId The id of the PayoutBatch to notify.
     * @return PayoutBatch[]
     * @throws PayoutBatchNotificationException
     */
    public function requestPayoutBatchNotification(string $payoutBatchId): bool
    {
        $payoutClient = $this->createPayoutClient();

        return $payoutClient->requestBatchNotification($payoutBatchId);
    }

    /**
     * Retrieves settlement reports for the calling merchant filtered by query.
     * The `limit` and `offset` parameters
     * specify pages for large query sets.
     *
     * @param $currency  string The three digit currency string for the ledger to retrieve.
     * @param $dateStart string The start date for the query.
     * @param $dateEnd   string The end date for the query.
     * @param $status    string Can be `processing`, `completed`, or `failed`.
     * @param $limit     int Maximum number of settlements to retrieve.
     * @param $offset    int Offset for paging.
     * @return Settlement[]
     * @throws BitPayException
     */
    public function getSettlements(
        string $currency,
        string $dateStart,
        string $dateEnd,
        string $status = null,
        int $limit = null,
        int $offset = null
    ): array {
        $settlementsClient = $this->createSettlementsClient();

        return $settlementsClient->getSettlements($currency, $dateStart, $dateEnd, $status, $limit, $offset);
    }

    /**
     * Retrieves a summary of the specified settlement.
     *
     * @param  string $settlementId Settlement Id.
     * @return Settlement
     * @throws BitPayException
     */
    public function getSettlement(string $settlementId): Settlement
    {
        $settlementsClient = $this->createSettlementsClient();

        return $settlementsClient->get($settlementId);
    }

    /**
     * Gets a detailed reconciliation report of the activity within the settlement period.
     *
     * @param  Settlement $settlement Settlement to generate report for.
     * @return Settlement
     * @throws BitPayException
     */
    public function getSettlementReconciliationReport(Settlement $settlement): Settlement
    {
        $settlementsClient = $this->createSettlementsClient();

        return $settlementsClient->getReconciliationReport($settlement);
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
        $subscriptionClient = $this->createSubscriptionClient();

        return $subscriptionClient->createSubscription($subscription);
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
        $subscriptionClient = $this->createSubscriptionClient();

        return $subscriptionClient->getSubscription($subscriptionId);
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
        $subscriptionClient = $this->createSubscriptionClient();

        return $subscriptionClient->getSubscriptions($status);
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
        $subscriptionClient = $this->createSubscriptionClient();

        return $subscriptionClient->updateSubscription($subscription, $subscriptionId);
    }

    /**
     * Fetch the supported currencies.
     *
     * @return Invoice[]
     * @throws BitPayException
     */
    public function getCurrencies(): array
    {
        try {
            $currencies = json_decode($this->_RESTcli->get("currencies/", null, false), false);
        } catch (BitPayException $e) {
            throw new CurrencyQueryException(
                "failed to serialize Currency object : " .
                $e->getMessage(),
                null,
                null,
                $e->getApiCode()
            );
        } catch (Exception $e) {
            throw new CurrencyQueryException("failed to serialize Currency object : " . $e->getMessage());
        }

        return $currencies;
    }

    /**
     * Builds the configuration object
     *
     * @param string      $privateKey       The full path to the securely located private key or the HEX key value.
     * @param Tokens      $tokens           Tokens object containing the BitPay's API tokens.
     * @param string      $privateKeySecret Private Key encryption password only for key file.
     * @param string|null $proxy            An http url of a proxy to foward requests through.
     * @throws BitPayException
     */
    private function buildConfig($privateKey, $tokens, $privateKeySecret = null, ?string $proxy = null)
    {
        try {
            if (!file_exists($privateKey)) {
                $key = new PrivateKey("plainHex");
                $key->setHex($privateKey);
                if (!$key->isValid()) {
                    throw new BitPayException("Private Key not found/valid");
                }
                $this->_ecKey = $key;
            }
            $this->_configuration = new Config();
            $this->_configuration->setEnvironment($this->_env);

            $envConfig[$this->_env] = [
                "PrivateKeyPath"   => $privateKey,
                "PrivateKeySecret" => $privateKeySecret,
                "ApiTokens"        => $tokens,
                "Proxy"            => $proxy,
            ];

            $this->_configuration->setEnvConfig($envConfig);
        } catch (Exception $e) {
            throw new BitPayException("failed to build configuration : " . $e->getMessage());
        }
    }

    /**
     * Loads the configuration file (JSON)
     *
     * @throws BitPayException
     */
    public function getConfig()
    {
        try {
            $this->_configuration = new Config();
            if (!file_exists($this->_configFilePath)) {
                throw new BitPayException("Configuration file not found");
            }
            $configData = json_decode(file_get_contents($this->_configFilePath), true);

            if (!$configData) {
                $configData = Yaml::parseFile($this->_configFilePath);
            }
            $this->_configuration->setEnvironment($configData["BitPayConfiguration"]["Environment"]);
            $this->_env = $this->_configuration->getEnvironment();

            $tokens = Tokens::loadFromArray($configData["BitPayConfiguration"]["EnvConfig"][$this->_env]["ApiTokens"]);
            $privateKeyPath = $configData["BitPayConfiguration"]["EnvConfig"][$this->_env]["PrivateKeyPath"];
            $privateKeySecret = $configData["BitPayConfiguration"]["EnvConfig"][$this->_env]["PrivateKeySecret"];
            $proxy = $configData["BitPayConfiguration"]["EnvConfig"][$this->_env]["Proxy"] ?? null;

            $envConfig[$this->_env] = [
                "PrivateKeyPath"   => $privateKeyPath,
                "PrivateKeySecret" => $privateKeySecret,
                "ApiTokens"        => $tokens,
                "Proxy"            => $proxy,
            ];

            $this->_configuration->setEnvConfig($envConfig);
        } catch (Exception $e) {
            throw new BitPayException("failed to initialize BitPay Client (Config) : " . $e->getMessage());
        }
    }

    /**
     * Initialize the public/private key pair by either loading the existing one or by creating a new one.
     *
     * @throws BitPayException
     */
    private function initKeys()
    {
        $privateKey = $this->_configuration->getEnvConfig()[$this->_env]["PrivateKeyPath"];
        $privateKeySecret = $this->_configuration->getEnvConfig()[$this->_env]["PrivateKeySecret"];

        try {
            if (!$this->_ecKey) {
                $this->_ecKey = new PrivateKey($privateKey);
                $storageEngine = new EncryptedFilesystemStorage($privateKeySecret);
                $this->_ecKey = $storageEngine->load($privateKey);
            }
        } catch (Exception $e) {
            throw new BitPayException("failed to build configuration : " . $e->getMessage());
        }
    }

    /**
     * Initialize this object with the client name and the environment Url.
     *
     * @throws BitPayException
     */
    private function init()
    {
        try {
            $proxy = $this->_configuration->getEnvConfig()[$this->_env]["Proxy"] ?? null;
            $this->_RESTcli = new RESTcli($this->_env, $this->_ecKey, $proxy);
            $this->loadAccessTokens();
            $this->loadCurrencies();
        } catch (Exception $e) {
            throw new BitPayException("failed to build configuration : " . $e->getMessage());
        }
    }

    /**
     * Load tokens from configuration.
     *
     * @throws BitPayException
     */
    private function loadAccessTokens()
    {
        try {
            $this->clearAccessTokenCache();

            $this->_tokenCache = $this->_configuration->getEnvConfig()[$this->_env]["ApiTokens"];
        } catch (Exception $e) {
            throw new BitPayException("When trying to load the tokens : " . $e->getMessage());
        }
    }

    private function clearAccessTokenCache()
    {
        $this->_tokenCache = new Tokens();
    }

    /**
     * Load currencies info.
     *
     * @throws BitPayException
     */
    private function loadCurrencies()
    {
        try {
            $this->_currenciesInfo = $this->getCurrencies();
        } catch (Exception $e) {
            throw new BitPayException("When loading currencies info : " . $e->getMessage());
        }
    }

    protected function createInvoiceClient(): InvoiceClient {
        return new InvoiceClient($this->_tokenCache, $this->_RESTcli, new Util());
    }

    protected function createRefundClient(): RefundClient {
        return new RefundClient($this->_tokenCache, $this->_RESTcli);
    }

    protected function createWalletClient(): WalletClient {
        return new WalletClient($this->_RESTcli);
    }

    protected function createBillClient(): BillClient {
        return new BillClient($this->_tokenCache, $this->_RESTcli);
    }

    protected function createRateClient(): RateClient {
        return new RateClient($this->_RESTcli, $this);
    }

    protected function createLedgerClient(): LedgerClient {
        return new LedgerClient($this->_tokenCache, $this->_RESTcli);
    }

    protected function createPayoutRecipientsClient(): PayoutRecipientsClient {
        return new PayoutRecipientsClient($this->_tokenCache, $this->_RESTcli, new Util());
    }

    protected function createPayoutClient(): PayoutClient {
        return new PayoutClient($this->_tokenCache, $this->_RESTcli, $this->_currenciesInfo);
    }

    protected function createSettlementsClient(): SettlementsClient {
        return new SettlementsClient($this->_tokenCache, $this->_RESTcli);
    }

    protected function createSubscriptionClient(): SubscriptionClient {
        return new SubscriptionClient($this->_tokenCache, $this->_RESTcli);
    }
}
