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
use BitPaySDK\Exceptions\InvoiceCreationException;
use BitPaySDK\Exceptions\InvoiceQueryException;
use BitPaySDK\Exceptions\PayoutCancellationException;
use BitPaySDK\Exceptions\PayoutCreationException;
use BitPaySDK\Exceptions\PayoutQueryException;
use BitPaySDK\Model\Bill\Bill;
use BitPaySDK\Model\Facade;
use BitPaySDK\Model\Invoice\Invoice;
use BitPaySDK\Model\Payout\PayoutBatch;
use BitPaySDK\Util\JsonMapper\JsonMapper;
use Exception;
use GuzzleHttp;
use GuzzleHttp\RequestOptions;
use Symfony\Component\Yaml\Yaml;

/**
 * Class Client
 * @package Bitpay
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
     * @var string
     */
    protected $_baseUrl;

    /**
     * @var PrivateKey
     */
    protected $_ecKey;

    /**
     * @var GuzzleHttp\Client
     */
    protected $_httpClient = null;

    /**
     * Return the identity of this client (i.e. the public key).
     */
    protected $_identity;

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
     * @param $privateKeyPath   String Private Key file path.
     * @param $tokens           Tokens containing the available tokens.
     * @param $privateKeySecret String|null Private Key encryption password.
     * @return Client
     * @throws BitPayException BitPayException class
     */
    public function withData($environment, $privateKeyPath, Tokens $tokens, $privateKeySecret = null)
    {
        try {
            $this->_env = $environment;
            $this->buildConfig($privateKeyPath, $tokens, $privateKeySecret);
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

            $response = $this->post("invoices", $invoice->toArray(), $signRequest);

            $jsonString = $this->responseToJsonString($response);
        } catch (Exception $e) {
            throw new InvoiceCreationException("failed to serialize Invoice object : ".$e->getMessage());
        }

        try {
            $mapper = new JsonMapper();
            $invoice = $mapper->map(
                json_decode($jsonString),
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
            $response = $this->get("invoices/".$invoiceId, $params, $signRequest);

            $jsonString = $this->responseToJsonString($response);
        } catch (Exception $e) {
            throw new InvoiceQueryException("failed to serialize Invoice object : ".$e->getMessage());
        }

        try {
            $mapper = new JsonMapper();
            $invoice = $mapper->map(
                json_decode($jsonString),
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
            $response = $this->get("invoices", $params);

            $jsonString = $this->responseToJsonString($response);
        } catch (Exception $e) {
            throw new InvoiceQueryException("failed to serialize Invoice object : ".$e->getMessage());
        }

        try {
            $mapper = new JsonMapper();
            $invoices = $mapper->mapArray(
                json_decode($jsonString),
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

            $response = $this->post("bills", $bill->toArray(), $signRequest);

            $jsonString = $this->responseToJsonString($response);
        } catch (Exception $e) {
            throw new BillCreationException("failed to serialize Bill object : ".$e->getMessage());
        }

        try {
            $mapper = new JsonMapper();
            $bill = $mapper->map(
                json_decode($jsonString),
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
            $response = $this->get("bills/".$billId, $params, $signRequest);

            $jsonString = $this->responseToJsonString($response);
        } catch (Exception $e) {
            throw new BillQueryException("failed to serialize Bill object : ".$e->getMessage());
        }

        try {
            $mapper = new JsonMapper();
            $bill = $mapper->map(
                json_decode($jsonString),
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
            $response = $this->get("bills", $params);

            $jsonString = $this->responseToJsonString($response);
        } catch (Exception $e) {
            throw new BillQueryException("failed to serialize Bill object : ".$e->getMessage());
        }

        try {
            $mapper = new JsonMapper();
            $bills = $mapper->mapArray(
                json_decode($jsonString),
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
            $response = $this->update("bills/".$billId, $bill->toArray());

            $jsonString = $this->responseToJsonString($response);
        } catch (Exception $e) {
            throw new BillUpdateException("failed to serialize Bill object : ".$e->getMessage());
        }

        try {
            $mapper = new JsonMapper();
            $bill = $mapper->map(
                json_decode($jsonString),
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
            $response = $this->post("bills/".$billId."/deliveries", ['token' => $billToken], $signRequest);

            $jsonString = $this->responseToJsonString($response);
        } catch (Exception $e) {
            throw new BillDeliveryException("failed to serialize Bill object : ".$e->getMessage());
        }

        try {
            $result = str_replace("\"", "", $jsonString);
        } catch (Exception $e) {
            throw new BillDeliveryException("failed to deserialize BitPay server response (Bill) : ".$e->getMessage());
        }

        return $result;
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

            $response = $this->post("payouts", $batch->toArray());

            $jsonString = $this->responseToJsonString($response);
        } catch (Exception $e) {
            throw new PayoutCreationException("failed to serialize PayoutBatch object : ".$e->getMessage());
        }

        try {
            $mapper = new JsonMapper();
            $batch = $mapper->map(
                json_decode($jsonString),
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
            $response = $this->get("payouts", $params);

            $jsonString = $this->responseToJsonString($response);
        } catch (Exception $e) {
            throw new PayoutQueryException("failed to serialize PayoutBatch object : ".$e->getMessage());
        }

        try {
            $mapper = new JsonMapper();
            $batches = $mapper->mapArray(
                json_decode($jsonString),
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
            $response = $this->get("payouts/".$batchId, $params);

            $jsonString = $this->responseToJsonString($response);
        } catch (Exception $e) {
            throw new PayoutQueryException("failed to serialize PayoutBatch object : ".$e->getMessage());
        }

        try {
            $mapper = new JsonMapper();
            $batch = $mapper->map(
                json_decode($jsonString),
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
            $response = $this->delete("payouts/".$batchId, $params);

            $jsonString = $this->responseToJsonString($response);
        } catch (Exception $e) {
            throw new PayoutCancellationException("failed to serialize PayoutBatch object : ".$e->getMessage());
        }

        try {
            $mapper = new JsonMapper();
            $batch = $mapper->map(
                json_decode($jsonString),
                new PayoutBatch()
            );

        } catch (Exception $e) {
            throw new PayoutCancellationException(
                "failed to deserialize BitPay server response (PayoutBatch) : ".$e->getMessage());
        }

        return $batch;
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Builds the configuration object
     *
     * @param $privateKeyPath   String The full path to the securely located private key.
     * @param $tokens           Tokens object containing the BitPay's API tokens.
     * @param $privateKeySecret String Private Key encryption password.
     * @throws BitPayException BitPayException class
     */
    private function buildConfig($privateKeyPath, $tokens, $privateKeySecret = null)
    {
        try {
            if (!file_exists($privateKeyPath)) {
                throw new BitPayException("Private Key file not found");
            }
            $this->_configuration = new Config();
            $this->_configuration->setEnvironment($this->_env);

            $envConfig[$this->_env] = [
                "PrivateKeyPath"   => $privateKeyPath,
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
        $privateKeyPath = $this->_configuration->getEnvConfig()[$this->_env]["PrivateKeyPath"];
        $privateKeySecret = $this->_configuration->getEnvConfig()[$this->_env]["PrivateKeySecret"];

        try {
            $this->_ecKey = new PrivateKey($privateKeyPath);
            $storageEngine = new EncryptedFilesystemStorage($privateKeySecret);
            $this->_ecKey = $storageEngine->load($privateKeyPath);
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
            $this->_baseUrl = $this->_env == Env::Test ? Env::TestUrl : Env::ProdUrl;
            $this->deriveIdentity();
            $this->_httpClient = new \GuzzleHttp\Client(
                [
                    'base_url' => $this->_baseUrl,
                    'defaults' => [
                        'headers' => [
                            "x-accept-version"     => Env::BitpayApiVersion,
                            'x-bitpay-plugin-info' => Env::BitpayPluginInfo,
                        ],
                    ],
                ]);
            $this->loadAccessTokens();
        } catch (Exception $e) {
            throw new BitPayException("failed to build configuration : ".$e->getMessage());
        }
    }

    private function deriveIdentity()
    {
        try {
            // Identity in this implementation is defined to be the SIN.
            $this->_identity = $this->_ecKey->getPublicKey()->__toString();
        } catch (Exception $e) {
            throw new BitPayException("failed to get SIN from private key : ".$e->getMessage());
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

    public function post($uri, array $formData = [], $signatureRequired = true)
    {
        try {
            $fullURL = $this->_baseUrl.$uri;
            $headers = [
                'Content-Type' => 'application/json',
            ];

            if ($signatureRequired) {
                $headers['x-signature'] = $this->_ecKey->sign($fullURL.json_encode($formData));
                $headers['x-identity'] = $this->_identity;
            }

            $response = $this->_httpClient->requestAsync(
                'POST', $fullURL, [
                $options[RequestOptions::SYNCHRONOUS] = false,
                'headers'                       => $headers,
                GuzzleHttp\RequestOptions::JSON => $formData,
            ])->wait();

            return $response;
        } catch (Exception $e) {
            throw new BitPayException("POST failed : ".$e->getMessage());
        }
    }

    public function get($uri, array $parameters = null, $signatureRequired = true)
    {
        try {
            $fullURL = $this->_baseUrl.$uri;
            $headers = [
                'Content-Type' => 'application/json',
            ];

            if ($parameters) {
                $fullURL .= '?'.http_build_query($parameters);
            }

            if ($signatureRequired) {
                $headers['x-signature'] = $this->_ecKey->sign($fullURL);
                $headers['x-identity'] = $this->_identity;
            }

            $response = $this->_httpClient->requestAsync(
                'GET', $fullURL, [
                $options[RequestOptions::SYNCHRONOUS] = false,
                'headers' => $headers,
                'query'   => $parameters,
            ])->wait();

            return $response;
        } catch (Exception $e) {
            throw new BitPayException("GET failed : ".$e->getMessage());
        }
    }

    public function delete($uri, array $parameters = null)
    {
        try {
            $fullURL = $this->_baseUrl.$uri;
            $headers = [
                'Content-Type' => 'application/json',
                'x-signature'  => $this->_ecKey->sign($fullURL),
                'x-identity'   => $this->_identity,
            ];

            if ($parameters) {
                $fullURL .= '?'.http_build_query($parameters);
            }

            $response = $this->_httpClient->requestAsync(
                'DELETE', $fullURL, [
                $options[RequestOptions::SYNCHRONOUS] = false,
                'headers' => $headers,
                'query'   => $parameters,
            ])->wait();

            return $response;
        } catch (Exception $e) {
            throw new BitPayException("DELETE failed : ".$e->getMessage());
        }
    }

    public function update($uri, array $formData = [])
    {
        try {
            $fullURL = $this->_baseUrl.$uri;
            $headers = [
                'Content-Type' => 'application/json',
                'x-signature'  => $this->_ecKey->sign($fullURL.json_encode($formData)),
                'x-identity'   => $this->_identity,
            ];

            $response = $this->_httpClient->requestAsync(
                'PUT', $fullURL, [
                $options[RequestOptions::SYNCHRONOUS] = false,
                'headers'                       => $headers,
                GuzzleHttp\RequestOptions::JSON => $formData,
            ])->wait();

            return $response;
        } catch (Exception $e) {
            throw new BitPayException("UPDATE failed : ".$e->getMessage());
        }
    }

    public function responseToJsonString($response)
    {
        if ($response == null) {
            throw new Exception("Error: HTTP response is null");
        }

        try {

            $body = json_decode($response->getBody()->getContents(), true);
            $error_message = false;
            $error_message = (!empty($body['error'])) ? $body['error'] : $error_message;
            $error_message = (!empty($body['errors'])) ? $body['errors'] : $error_message;
            $error_message = (is_array($error_message)) ? implode("\n", $error_message) : $error_message;
            if (false !== $error_message) {
                throw new BitpayException($error_message);
            }
            $jsonString = json_encode($body['data']);

            return $jsonString;

        } catch (Exception $e) {
            throw new BitPayException("failed to retrieve HTTP response body : ".$e->getMessage());
        }
    }
}