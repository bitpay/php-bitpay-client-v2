<?php


namespace BitPaySDK;


use BitPayKeyUtils\KeyHelper\PrivateKey;
use BitPayKeyUtils\Storage\EncryptedFilesystemStorage;
use BitPayKeyUtils\Util\Util;
use BitPaySDK\Exceptions\BillCreationException;
use BitPaySDK\Exceptions\BillDeliveryException;
use BitPaySDK\Exceptions\BillQueryException;
use BitPaySDK\Exceptions\BillUpdateException;
use BitPaySDK\Exceptions\BitPayException;
use BitPaySDK\Exceptions\CurrencyQueryException;
use BitPaySDK\Exceptions\InvoiceCreationException;
use BitPaySDK\Exceptions\InvoiceQueryException;
use BitPaySDK\Exceptions\LedgerQueryException;
use BitPaySDK\Exceptions\PayoutCancellationException;
use BitPaySDK\Exceptions\PayoutCreationException;
use BitPaySDK\Exceptions\PayoutQueryException;
use BitPaySDK\Exceptions\RateQueryException;
use BitPaySDK\Exceptions\RefundCreationException;
use BitPaySDK\Exceptions\RefundQueryException;
use BitPaySDK\Exceptions\SettlementQueryException;
use BitPaySDK\Exceptions\SubscriptionCreationException;
use BitPaySDK\Exceptions\SubscriptionQueryException;
use BitPaySDK\Exceptions\SubscriptionUpdateException;
use BitPaySDK\Model\Bill\Bill;
use BitPaySDK\Model\Facade;
use BitPaySDK\Model\Invoice\Invoice;
use BitPaySDK\Model\Invoice\Refund;
use BitPaySDK\Model\Ledger\Ledger;
use BitPaySDK\Model\Payout\PayoutBatch;
use BitPaySDK\Model\Rate\Rates;
use BitPaySDK\Model\Settlement\Settlement;
use BitPaySDK\Model\Subscription\Subscription;
use BitPaySDK\Util\JsonMapper\JsonMapper;
use BitPaySDK\Util\RESTcli\RESTcli;
use Exception;
use Symfony\Component\Yaml\Yaml;

/**
 * Class Client
 * @package Bitpay
 * @author  Antonio Buedo
 * @version 4.0.2006
 * See bitpay.com/api for more information.
 * date 19.06.2020
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
     * @param $environment      String Target environment. Options: Env.Test / Env.Prod
     * @param $privateKey       String Private Key file path or the HEX value.
     * @param $tokens           Tokens containing the available tokens.
     * @param $privateKeySecret String|null Private Key encryption password.
     * @return Client
     * @throws BitPayException BitPayException class
     */
    public function withData($environment, $privateKey, Tokens $tokens, $privateKeySecret = null)
    {
        try {
            $this->_env = $environment;
            $this->buildConfig($privateKey, $tokens, $privateKeySecret);
            $this->initKeys();
            $this->init();

            return $this;
        } catch (Exception $e) {
            throw new BitPayException("failed to initialize BitPay Client (Config) : ".$e->getMessage());
        }
    }

    /**
     * Constructor for use if the keys and SIN are managed by this library.
     *
     * @param $configFilePath  String The path to the configuration file.
     * @return Client
     * @throws BitPayException BitPayException class
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
            throw new BitPayException("failed to initialize BitPay Client (Config) : ".$e->getMessage());
        }
    }

    /**
     * Create a BitPay invoice.
     *
     * @param $invoice     Invoice An Invoice object with request parameters defined.
     * @param $facade      string The facade used to create it.
     * @param $signRequest bool Signed request.
     * @return $invoice Invoice A BitPay generated Invoice object.
     * @throws BitPayException BitPayException class
     */
    public function createInvoice(
        Invoice $invoice,
        string $facade = Facade::Merchant,
        bool $signRequest = true
    ): Invoice {
        try {
            $invoice->setToken($this->_tokenCache->getTokenByFacade($facade));
            $invoice->setGuid(Util::guid());

            $responseJson = $this->_RESTcli->post("invoices", $invoice->toArray(), $signRequest);
        } catch (Exception $e) {
            throw new InvoiceCreationException("failed to serialize Invoice object : ".$e->getMessage());
        }

        try {
            $mapper = new JsonMapper();
            $invoice = $mapper->map(
                json_decode($responseJson),
                new Invoice()
            );

        } catch (Exception $e) {
            throw new InvoiceCreationException(
                "failed to deserialize BitPay server response (Invoice) : ".$e->getMessage());
        }

        return $invoice;
    }

    /**
     * Retrieve a BitPay invoice by invoice id using the specified facade.  The client must have been previously
     * authorized for the specified facade (the public facade requires no authorization).
     *
     * @param $invoiceId   string The id of the invoice to retrieve.
     * @param $facade      string The facade used to create it.
     * @param $signRequest bool Signed request.
     * @return Invoice A BitPay Invoice object.
     * @throws BitPayException BitPayException class
     */
    public function getInvoice(
        string $invoiceId,
        string $facade = Facade::Merchant,
        bool $signRequest = true
    ): Invoice {
        try {
            $params = [];
            $params["token"] = $this->_tokenCache->getTokenByFacade($facade);

            $responseJson = $this->_RESTcli->get("invoices/".$invoiceId, $params, $signRequest);
        } catch (Exception $e) {
            throw new InvoiceQueryException("failed to serialize Invoice object : ".$e->getMessage());
        }

        try {
            $mapper = new JsonMapper();
            $invoice = $mapper->map(
                json_decode($responseJson),
                new Invoice()
            );

        } catch (Exception $e) {
            throw new InvoiceQueryException(
                "failed to deserialize BitPay server response (Invoice) : ".$e->getMessage());
        }

        return $invoice;
    }

    /**
     * Retrieve a collection of BitPay invoices.
     *
     * @param $dateStart string The start of the date window to query for invoices. Format YYYY-MM-DD.
     * @param $dateEnd   string The end of the date window to query for invoices. Format YYYY-MM-DD.
     * @param $status    string|null The invoice status you want to query on.
     * @param $orderId   string|null The optional order id specified at time of invoice creation.
     * @param $limit     int|null Maximum results that the query will return (useful for paging results).
     * @param $offset    int|null Number of results to offset (ex. skip 10 will give you results starting with the 11th
     *                   result).
     * @return array     A list of BitPay Invoice objects.
     * @throws BitPayException BitPayException class
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
            $params["token"] = $this->_tokenCache->getTokenByFacade(Facade::Merchant);
            $params["dateStart"] = $dateStart;
            $params["dateEnd"] = $dateEnd;
            if ($status) {
                $params["status"] = $status;
            }
            if ($status) {
                $params["orderId"] = $orderId;
            }
            if ($status) {
                $params["limit"] = $limit;
            }
            if ($status) {
                $params["offset"] = $offset;
            }

            $responseJson = $this->_RESTcli->get("invoices", $params);
        } catch (Exception $e) {
            throw new InvoiceQueryException("failed to serialize Invoice object : ".$e->getMessage());
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
                "failed to deserialize BitPay server response (Invoice) : ".$e->getMessage());
        }

        return $invoices;
    }

    /**
     * Create a BitPay refund.
     *
     * @param $invoice          Invoice A BitPay invoice object for which a refund request should be made.  Must have
     *                          been obtained using the merchant facade.
     * @param $refundEmail      string The email of the buyer to which the refund email will be sent
     * @param $amount           float The amount of money to refund. If zero then a request for 100% of the invoice
     *                          value is created.
     * @param $currency         string The three digit currency code specifying the exchange rate to use when
     *                          calculating the refund bitcoin amount. If this value is "BTC" then no exchange rate
     *                          calculation is performed.
     * @return bool True if the refund was successfully canceled, false otherwise.
     * @throws BitPayException BitPayException class
     */
    public function createRefund(
        Invoice $invoice,
        string $refundEmail,
        float $amount,
        string $currency
    ): bool {
        try {
            $refund = new Refund($refundEmail, $amount, $currency, $invoice->getToken());
            $refund->setGuid(Util::guid());

            $responseJson = $this->_RESTcli->post("invoices/".$invoice->getId()."/refunds", $refund->toArray());
        } catch (Exception $e) {
            throw new RefundCreationException("failed to serialize Refund object : ".$e->getMessage());
        }

        try {
            $result = json_decode($responseJson)->success;

        } catch (Exception $e) {
            throw new RefundCreationException(
                "failed to deserialize BitPay server response (Refund) : ".$e->getMessage());
        }

        return $result;
    }

    /**
     * Retrieve all refund requests on a BitPay invoice.
     *
     * @param $invoice  Invoice The BitPay invoice having the associated refunds.
     * @return array A array of BitPay refund object with the associated Refund object updated.
     * @throws BitPayException BitPayException class
     */
    public function getRefunds(
        Invoice $invoice
    ): array {
        try {
            $params = [];
            $params["token"] = $invoice->getToken();

            $responseJson = $this->_RESTcli->get("invoices/".$invoice->getId()."/refunds", $params);
        } catch (Exception $e) {
            throw new RefundQueryException("failed to serialize refund object : ".$e->getMessage());
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
                "failed to deserialize BitPay server response (Refund) : ".$e->getMessage());
        }

        return $refunds;
    }

    /**
     * Retrieve a previously made refund request on a BitPay invoice.
     *
     * @param $invoice  Invoice The BitPay invoice having the associated refund.
     * @param $refundId string The refund id for the refund to be updated with new status.
     * @return Refund A BitPay refund object with the associated Refund object updated.
     * @throws BitPayException BitPayException class
     */
    public function getRefund(
        Invoice $invoice,
        string $refundId
    ): Refund {
        try {
            $params = [];
            $params["token"] = $invoice->getToken();

            $responseJson = $this->_RESTcli->get("invoices/".$invoice->getId()."/refunds/".$refundId, $params);
        } catch (Exception $e) {
            throw new RefundQueryException("failed to serialize refund object : ".$e->getMessage());
        }

        try {
            $mapper = new JsonMapper();
            $Refund = $mapper->map(
                json_decode($responseJson),
                new Refund()
            );

        } catch (Exception $e) {
            throw new RefundQueryException(
                "failed to deserialize BitPay server response (Refund) : ".$e->getMessage());
        }

        return $Refund;
    }

    /**
     * Cancel a previously submitted refund request on a BitPay invoice.
     *
     * @param $invoiceId string The refund id for the refund to be canceled.
     * @param $refund    Refund The BitPay invoice having the associated refund to be canceled. Must have been obtained
     *                   using the merchant facade.
     * @return bool True if the refund was successfully canceled, false otherwise.
     * @throws BitPayException BitPayException class
     */
    public function cancelRefund(string $invoiceId, Refund $refund): bool
    {
        try {
            $params = [];
            $params["token"] = $refund->getToken();

            $responseJson = $this->_RESTcli->delete("invoices/".$invoiceId."/refunds/".$refund->getId(), $params);
        } catch (Exception $e) {
            throw new PayoutCancellationException("failed to serialize server object : ".$e->getMessage());
        }

        try {
            $result = strtolower(trim($responseJson, '"')) === "success";

        } catch (Exception $e) {
            throw new PayoutCancellationException(
                "failed to deserialize BitPay server response (Refund) : ".$e->getMessage());
        }

        return $result;
    }

    /**
     * Create a BitPay Bill.
     *
     * @param $bill        string A Bill object with request parameters defined.
     * @param $facade      string The facade used to create it.
     * @param $signRequest bool Signed request.
     * @return Bill A BitPay generated Bill object.
     * @throws BitPayException BitPayException class
     */
    public function createBill(Bill $bill, string $facade = Facade::Merchant, bool $signRequest = true): Bill
    {
        try {
            $bill->setToken($this->_tokenCache->getTokenByFacade($facade));

            $responseJson = $this->_RESTcli->post("bills", $bill->toArray(), $signRequest);
        } catch (Exception $e) {
            throw new BillCreationException("failed to serialize Bill object : ".$e->getMessage());
        }

        try {
            $mapper = new JsonMapper();
            $bill = $mapper->map(
                json_decode($responseJson),
                new Bill()
            );

        } catch (Exception $e) {
            throw new BillCreationException(
                "failed to deserialize BitPay server response (Bill) : ".$e->getMessage());
        }

        return $bill;
    }

    /**
     * Retrieve a BitPay bill by bill id using the specified facade.
     *
     * @param $billId      string The id of the bill to retrieve.
     * @param $facade      string The facade used to retrieve it.
     * @param $signRequest bool Signed request.
     * @return Bill A BitPay Bill object.
     * @throws BitPayException BitPayException class
     */
    public function getBill(string $billId, string $facade = Facade::Merchant, bool $signRequest = true): Bill
    {

        try {
            $params = [];
            $params["token"] = $this->_tokenCache->getTokenByFacade($facade);

            $responseJson = $this->_RESTcli->get("bills/".$billId, $params, $signRequest);
        } catch (Exception $e) {
            throw new BillQueryException("failed to serialize Bill object : ".$e->getMessage());
        }

        try {
            $mapper = new JsonMapper();
            $bill = $mapper->map(
                json_decode($responseJson),
                new Bill()
            );

        } catch (Exception $e) {
            throw new BillQueryException(
                "failed to deserialize BitPay server response (Bill) : ".$e->getMessage());
        }

        return $bill;
    }

    /**
     * Retrieve a collection of BitPay bills.
     *
     * @param $status string|null The status to filter the bills.
     * @return array A list of BitPay Bill objects.
     * @throws BitPayException BitPayException class
     */
    public function getBills(string $status = null): array
    {
        try {
            $params = [];
            $params["token"] = $this->_tokenCache->getTokenByFacade(Facade::Merchant);
            if ($status) {
                $params["status"] = $status;
            }

            $responseJson = $this->_RESTcli->get("bills", $params);
        } catch (Exception $e) {
            throw new BillQueryException("failed to serialize Bill object : ".$e->getMessage());
        }

        try {
            $mapper = new JsonMapper();
            $bills = $mapper->mapArray(
                json_decode($responseJson),
                [],
                'BitPaySDK\Model\Bill\Bill'
            );

        } catch (Exception $e) {
            throw new BillQueryException(
                "failed to deserialize BitPay server response (Bill) : ".$e->getMessage());
        }

        return $bills;
    }

    /**
     * Update a BitPay Bill.
     *
     * @param $bill   Bill A Bill object with the parameters to update defined.
     * @param $billId string $billIdThe Id of the Bill to update.
     * @return Bill An updated Bill object.
     * @throws BitPayException BitPayException class
     */
    public function updateBill(Bill $bill, string $billId): Bill
    {
        try {
            $billToken = $this->getBill($bill->getId())->getToken();
            $bill->setToken($billToken);

            $responseJson = $this->_RESTcli->update("bills/".$billId, $bill->toArray());
        } catch (Exception $e) {
            throw new BillUpdateException("failed to serialize Bill object : ".$e->getMessage());
        }

        try {
            $mapper = new JsonMapper();
            $bill = $mapper->map(
                json_decode($responseJson),
                $bill
            );

        } catch (Exception $e) {
            throw new BillUpdateException("failed to deserialize BitPay server response (Bill) : ".$e->getMessage());
        }

        return $bill;
    }

    /**
     * Deliver a BitPay Bill.
     *
     * @param $billId      string The id of the requested bill.
     * @param $billToken   string The token of the requested bill.
     * @param $signRequest bool Allow unsigned request
     * @return string A response status returned from the API.
     * @throws BitPayException BitPayException class
     */
    public function deliverBill(string $billId, string $billToken, bool $signRequest = true): string
    {
        try {
            $responseJson = $this->_RESTcli->post(
                "bills/".$billId."/deliveries", ['token' => $billToken], $signRequest);
        } catch (Exception $e) {
            throw new BillDeliveryException("failed to serialize Bill object : ".$e->getMessage());
        }

        try {
            $result = str_replace("\"", "", $responseJson);
        } catch (Exception $e) {
            throw new BillDeliveryException("failed to deserialize BitPay server response (Bill) : ".$e->getMessage());
        }

        return $result;
    }

    /**
     * Retrieve the exchange rate table maintained by BitPay.  See https://bitpay.com/bitcoin-exchange-rates.
     *
     * @return Rates A Rates object populated with the BitPay exchange rate table.
     * @throws BitPayException BitPayException class
     */
    public function getRates(): Rates
    {
        try {
            $responseJson = $this->_RESTcli->get("rates", null, false);
        } catch (Exception $e) {
            throw new RateQueryException("failed to serialize Rates object : ".$e->getMessage());
        }

        try {
            $mapper = new JsonMapper();
            $rates = $mapper->mapArray(
                json_decode($responseJson),
                [],
                'BitPaySDK\Model\Rate\Rate'
            );

        } catch (Exception $e) {
            throw new RateQueryException(
                "failed to deserialize BitPay server response (Rates) : ".$e->getMessage());
        }

        return new Rates($rates, $this);
    }

    /**
     * Retrieve a list of ledgers by date range using the merchant facade.
     *
     * @param $currency  string The three digit currency string for the ledger to retrieve.
     * @param $startDate string The first date for the query filter.
     * @param $endDate   string The last date for the query filter.
     * @return Ledger A Ledger object populated with the BitPay ledger entries list.
     * @throws BitPayException BitPayException class
     */
    public function getLedger(string $currency, string $startDate, string $endDate): array
    {
        try {
            $params = [];
            $params["token"] = $this->_tokenCache->getTokenByFacade(Facade::Merchant);
            if ($currency) {
                $params["currency"] = $currency;
            }
            if ($currency) {
                $params["startDate"] = $startDate;
            }
            if ($currency) {
                $params["endDate"] = $endDate;
            }

            $responseJson = $this->_RESTcli->get("ledgers/".$currency, $params);
        } catch (Exception $e) {
            throw new LedgerQueryException("failed to serialize Ledger object : ".$e->getMessage());
        }

        try {
            $mapper = new JsonMapper();
            $ledger = $mapper->mapArray(
                json_decode($responseJson),
                [],
                'BitPaySDK\Model\Ledger\LedgerEntry'
            );

        } catch (Exception $e) {
            throw new LedgerQueryException(
                "failed to deserialize BitPay server response (Ledger) : ".$e->getMessage());
        }

        return $ledger;
    }

    /**
     * Retrieve a list of ledgers using the merchant facade.
     *
     * @return array A list of Ledger objects populated with the currency and current balance of each one.
     * @throws BitPayException BitPayException class
     */
    public function getLedgers(): array
    {
        try {
            $params = [];
            $params["token"] = $this->_tokenCache->getTokenByFacade(Facade::Merchant);

            $responseJson = $this->_RESTcli->get("ledgers", $params);
        } catch (Exception $e) {
            throw new LedgerQueryException("failed to serialize Ledger object : ".$e->getMessage());
        }

        try {
            $mapper = new JsonMapper();
            $ledgers = $mapper->mapArray(
                json_decode($responseJson),
                [],
                'BitPaySDK\Model\Ledger\Ledger'
            );

        } catch (Exception $e) {
            throw new LedgerQueryException(
                "failed to deserialize BitPay server response (Ledger) : ".$e->getMessage());
        }

        return $ledgers;
    }

    /**
     * Submit a BitPay Payout batch.
     *
     * @param $batch PayoutBatch A PayoutBatch object with request parameters defined.
     * @return PayoutBatch A PayoutBatch BitPay generated PayoutBatch object.
     * @throws PayoutCreationException BitPayException class
     */
    public function submitPayoutBatch(PayoutBatch $batch): PayoutBatch
    {
        try {
            $batch->setToken($this->_tokenCache->getTokenByFacade(Facade::Payroll));
            $batch->setGuid(Util::guid());

            $precision = $this->getCurrencyInfo($batch->getCurrency())->precision ?? 2;
            $batch->formatAmount($precision);

            $responseJson = $this->_RESTcli->post("payouts", $batch->toArray());
        } catch (Exception $e) {
            throw new PayoutCreationException("failed to serialize PayoutBatch object : ".$e->getMessage());
        }

        try {
            $mapper = new JsonMapper();
            $batch = $mapper->map(
                json_decode($responseJson),
                new PayoutBatch()
            );

        } catch (Exception $e) {
            throw new PayoutCreationException(
                "failed to deserialize BitPay server response (PayoutBatch) : ".$e->getMessage());
        }

        return $batch;
    }

    /**
     * Retrieve a collection of BitPay payout batches.
     *
     * @param $status string The status to filter the Payout Batches.
     * @return array A list of BitPay PayoutBatch objects.
     * @throws PayoutQueryException
     */
    public function getPayoutBatches(string $status = null): array
    {
        try {
            $params = [];
            $params["token"] = $this->_tokenCache->getTokenByFacade(Facade::Payroll);
            if ($status) {
                $params["status"] = $status;
            }

            $responseJson = $this->_RESTcli->get("payouts", $params);
        } catch (Exception $e) {
            throw new PayoutQueryException("failed to serialize PayoutBatch object : ".$e->getMessage());
        }

        try {
            $mapper = new JsonMapper();
            $batches = $mapper->mapArray(
                json_decode($responseJson),
                [],
                'BitPaySDK\Model\Payout\PayoutBatch'
            );

        } catch (Exception $e) {
            throw new PayoutQueryException(
                "failed to deserialize BitPay server response (PayoutBatch) : ".$e->getMessage());
        }

        return $batches;
    }

    /**
     * Retrieve a BitPay payout batch by batch id using.  The client must have been previously authorized for the
     * payroll facade.
     *
     * @param $batchId string The id of the batch to retrieve.
     * @return PayoutBatch A BitPay PayoutBatch object.
     * @throws PayoutQueryException BitPayException class
     */
    public function getPayoutBatch(string $batchId): PayoutBatch
    {
        try {
            $params = [];
            $params["token"] = $this->_tokenCache->getTokenByFacade(Facade::Payroll);

            $responseJson = $this->_RESTcli->get("payouts/".$batchId, $params);
        } catch (Exception $e) {
            throw new PayoutQueryException("failed to serialize PayoutBatch object : ".$e->getMessage());
        }

        try {
            $mapper = new JsonMapper();
            $batch = $mapper->map(
                json_decode($responseJson),
                new PayoutBatch()
            );

        } catch (Exception $e) {
            throw new PayoutQueryException(
                "failed to deserialize BitPay server response (PayoutBatch) : ".$e->getMessage());
        }

        return $batch;
    }

    /**
     * Cancel a BitPay Payout batch.
     *
     * @param $batchId string The id of the batch to cancel.
     * @return PayoutBatch A BitPay generated PayoutBatch object.
     * @throws PayoutCancellationException BitPayException class
     */
    public function cancelPayoutBatch(string $batchId): PayoutBatch
    {
        try {
            $batch = $this->getPayoutBatch($batchId);
            $params = [];
            $params["token"] = $batch->getToken();

            $responseJson = $this->_RESTcli->delete("payouts/".$batchId, $params);
        } catch (Exception $e) {
            throw new PayoutCancellationException("failed to serialize PayoutBatch object : ".$e->getMessage());
        }

        try {
            $mapper = new JsonMapper();
            $batch = $mapper->map(
                json_decode($responseJson),
                new PayoutBatch()
            );

        } catch (Exception $e) {
            throw new PayoutCancellationException(
                "failed to deserialize BitPay server response (PayoutBatch) : ".$e->getMessage());
        }

        return $batch;
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
     * @return array A list of BitPay Settlement objects.
     * @throws BitPayException BitPayException class
     */
    public function getSettlements(
        string $currency,
        string $dateStart,
        string $dateEnd,
        string $status = null,
        int $limit = null,
        int $offset = null
    ): array {
        try {
            $status = $status != null ? $status : "";
            $limit = $limit != null ? $limit : 100;
            $offset = $offset != null ? $offset : 0;

            $params = [];
            $params["token"] = $this->_tokenCache->getTokenByFacade(Facade::Merchant);
            $params["dateStart"] = $dateStart;
            $params["dateEnd"] = $dateEnd;
            $params["currency"] = $currency;
            $params["status"] = $status;
            $params["limit"] = (string)$limit;
            $params["offset"] = (string)$offset;

            $responseJson = $this->_RESTcli->get("settlements", $params);
        } catch (Exception $e) {
            throw new SettlementQueryException("failed to serialize Settlement object : ".$e->getMessage());
        }

        try {
            $mapper = new JsonMapper();
            $settlements = $mapper->mapArray(
                json_decode($responseJson),
                [],
                'BitPaySDK\Model\Settlement\Settlement'
            );

        } catch (Exception $e) {
            throw new SettlementQueryException(
                "failed to deserialize BitPay server response (Settlement) : ".$e->getMessage());
        }

        return $settlements;
    }

    /**
     * Retrieves a summary of the specified settlement.
     *
     * @param $settlementId Settlement Id.
     * @return Settlement A BitPay Settlement object.
     * @throws BitPayException BitPayException class
     */
    public function getSettlement(string $settlementId): Settlement
    {
        try {
            $params = [];
            $params["token"] = $this->_tokenCache->getTokenByFacade(Facade::Merchant);

            $responseJson = $this->_RESTcli->get("settlements/".$settlementId, $params);
        } catch (Exception $e) {
            throw new SettlementQueryException("failed to serialize Settlement object : ".$e->getMessage());
        }

        try {
            $mapper = new JsonMapper();
            $settlement = $mapper->map(
                json_decode($responseJson),
                new Settlement()
            );

        } catch (Exception $e) {
            throw new SettlementQueryException(
                "failed to deserialize BitPay server response (Settlement) : ".$e->getMessage());
        }

        return $settlement;
    }

    /**
     * Gets a detailed reconciliation report of the activity within the settlement period.
     *
     * @param $settlement Settlement to generate report for.
     * @return Settlement A detailed BitPay Settlement object.
     * @throws BitPayException BitPayException class
     */
    public function getSettlementReconciliationReport(Settlement $settlement): Settlement
    {
        try {
            $params = [];
            $params["token"] = $settlement->getToken();

            $responseJson = $this->_RESTcli->get("settlements/".$settlement->getId()."/reconciliationReport", $params);
        } catch (Exception $e) {
            throw new SettlementQueryException("failed to serialize Reconciliation Report object : ".$e->getMessage());
        }

        try {
            $mapper = new JsonMapper();
            $reconciliationReport = $mapper->map(
                json_decode($responseJson),
                new Settlement()
            );

        } catch (Exception $e) {
            throw new SettlementQueryException(
                "failed to deserialize BitPay server response (Reconciliation Report) : ".$e->getMessage());
        }

        return $reconciliationReport;
    }

    /**
     * Create a BitPay Subscription.
     *
     * @param $subscription string A Subscription object with request parameters defined.
     * @return Subscription A BitPay generated Subscription object.
     * @throws BitPayException BitPayException class
     */
    public function createSubscription(Subscription $subscription): Subscription
    {
        try {
            $subscription->setToken($this->_tokenCache->getTokenByFacade(Facade::Merchant));

            $responseJson = $this->_RESTcli->post("subscriptions", $subscription->toArray());
        } catch (Exception $e) {
            throw new SubscriptionCreationException("failed to serialize Subscription object : ".$e->getMessage());
        }

        try {
            $mapper = new JsonMapper();
            $subscription = $mapper->map(
                json_decode($responseJson),
                new Subscription()
            );

        } catch (Exception $e) {
            throw new SubscriptionCreationException(
                "failed to deserialize BitPay server response (Subscription) : ".$e->getMessage());
        }

        return $subscription;
    }

    /**
     * Retrieve a BitPay subscription by subscription id using the specified facade.
     *
     * @param $subscriptionId string The id of the subscription to retrieve.
     * @return Subscription A BitPay Subscription object.
     * @throws BitPayException BitPayException class
     */
    public function getSubscription(string $subscriptionId): Subscription
    {

        try {
            $params = [];
            $params["token"] = $this->_tokenCache->getTokenByFacade(Facade::Merchant);

            $responseJson = $this->_RESTcli->get("subscriptions/".$subscriptionId, $params);
        } catch (Exception $e) {
            throw new SubscriptionQueryException("failed to serialize Subscription object : ".$e->getMessage());
        }

        try {
            $mapper = new JsonMapper();
            $subscription = $mapper->map(
                json_decode($responseJson),
                new Subscription()
            );

        } catch (Exception $e) {
            throw new SubscriptionQueryException(
                "failed to deserialize BitPay server response (Subscription) : ".$e->getMessage());
        }

        return $subscription;
    }

    /**
     * Retrieve a collection of BitPay subscriptions.
     *
     * @param $status string|null The status to filter the subscriptions.
     * @return array A list of BitPay Subscription objects.
     * @throws BitPayException BitPayException class
     */
    public function getSubscriptions(string $status = null): array
    {
        try {
            $params = [];
            $params["token"] = $this->_tokenCache->getTokenByFacade(Facade::Merchant);
            if ($status) {
                $params["status"] = $status;
            }

            $responseJson = $this->_RESTcli->get("subscriptions", $params);
        } catch (Exception $e) {
            throw new SubscriptionQueryException("failed to serialize Subscription object : ".$e->getMessage());
        }

        try {
            $mapper = new JsonMapper();
            $subscriptions = $mapper->mapArray(
                json_decode($responseJson),
                [],
                'BitPaySDK\Model\Subscription\Subscription'
            );

        } catch (Exception $e) {
            throw new SubscriptionQueryException(
                "failed to deserialize BitPay server response (Subscription) : ".$e->getMessage());
        }

        return $subscriptions;
    }

    /**
     * Update a BitPay Subscription.
     *
     * @param $subscription   Subscription A Subscription object with the parameters to update defined.
     * @param $subscriptionId string $subscriptionIdThe Id of the Subscription to update.
     * @return Subscription An updated Subscription object.
     * @throws BitPayException BitPayException class
     */
    public function updateSubscription(Subscription $subscription, string $subscriptionId): Subscription
    {
        try {
            $subscriptionToken = $this->getSubscription($subscription->getId())->getToken();
            $subscription->setToken($subscriptionToken);

            $responseJson = $this->_RESTcli->update("subscriptions/".$subscriptionId, $subscription->toArray());
        } catch (Exception $e) {
            throw new SubscriptionUpdateException("failed to serialize Subscription object : ".$e->getMessage());
        }

        try {
            $mapper = new JsonMapper();
            $subscription = $mapper->map(
                json_decode($responseJson),
                $subscription
            );

        } catch (Exception $e) {
            throw new SubscriptionUpdateException(
                "failed to deserialize BitPay server response (Subscription) : ".$e->getMessage());
        }

        return $subscription;
    }

    /**
     * Fetch the supported currencies.
     *
     * @return array     A list of BitPay Invoice objects.
     * @throws BitPayException BitPayException class
     */
    public function getCurrencies(): array
    {
        try {
            $currencies = json_decode($this->_RESTcli->get("currencies/", null, false), false);
        } catch (Exception $e) {
            throw new CurrencyQueryException("failed to serialize Currency object : ".$e->getMessage());
        }

        return $currencies;
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Builds the configuration object
     *
     * @param $privateKey       String The full path to the securely located private key or the HEX key value.
     * @param $tokens           Tokens object containing the BitPay's API tokens.
     * @param $privateKeySecret String Private Key encryption password only for key file.
     * @throws BitPayException BitPayException class
     */
    private function buildConfig($privateKey, $tokens, $privateKeySecret = null)
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
            ];

            $this->_configuration->setEnvConfig($envConfig);
        } catch (Exception $e) {
            throw new BitPayException("failed to build configuration : ".$e->getMessage());
        }
    }

    /**
     * Loads the configuration file (JSON)
     *
     * @throws BitPayException BitPayException class
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

            $envConfig[$this->_env] = [
                "PrivateKeyPath"   => $privateKeyPath,
                "PrivateKeySecret" => $privateKeySecret,
                "ApiTokens"        => $tokens,
            ];

            $this->_configuration->setEnvConfig($envConfig);
        } catch (Exception $e) {
            throw new BitPayException("failed to initialize BitPay Client (Config) : ".$e->getMessage());
        }
    }

    /**
     * Initialize the public/private key pair by either loading the existing one or by creating a new one.
     *
     * @throws BitPayException BitPayException class
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
            throw new BitPayException("failed to build configuration : ".$e->getMessage());
        }
    }

    /**
     * Initialize this object with the client name and the environment Url.
     *
     * @throws BitPayException BitPayException class
     */
    private function init()
    {
        try {
            $this->_RESTcli = new RESTcli($this->_env, $this->_ecKey);
            $this->loadAccessTokens();
            $this->loadCurrencies();
        } catch (Exception $e) {
            throw new BitPayException("failed to build configuration : ".$e->getMessage());
        }
    }

    /**
     * Load tokens from configuration.
     *
     * @throws BitPayException BitPayException class
     */
    private function loadAccessTokens()
    {
        try {
            $this->clearAccessTokenCache();

            $this->_tokenCache = $this->_configuration->getEnvConfig()[$this->_env]["ApiTokens"];
        } catch (Exception $e) {
            throw new BitPayException("When trying to load the tokens : ".$e->getMessage());
        }
    }

    private function clearAccessTokenCache()
    {
        $this->_tokenCache = new Tokens();
    }

    /**
     * Load currencies info.
     *
     * @throws BitPayException BitPayException class
     */
    private function loadCurrencies()
    {
        try {
            $this->_currenciesInfo = $this->getCurrencies();
        } catch (Exception $e) {
            throw new BitPayException("When loading currencies info : ".$e->getMessage());
        }
    }

    /**
     * Gets info for specific currency.
     *
     * @param $currencyCode String Currency code for which the info will be retrieved.
     *
     * @return object|null
     */
    public function getCurrencyInfo(string $currencyCode)
    {
        foreach ($this->_currenciesInfo as $currencyInfo) {
            if ($currencyInfo->code == $currencyCode) {
                return $currencyInfo;
            }
        }

        return null;
    }
}