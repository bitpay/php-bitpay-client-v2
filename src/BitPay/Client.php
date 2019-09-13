<?php


namespace Bitpay;


use BitPay\Exceptions\BitPayException;
use Bitpay\Model\Invoice\Invoice;
use BitPayKeyUtils\KeyHelper\PrivateKey;
use BitPayKeyUtils\Storage\EncryptedFilesystemStorage;
use BitPayKeyUtils\Util\Util;

/**
 * Class Client
 * @package Bitpay
 */
class Client
{
    protected $_configuration;
    protected $_env;

    /**
     * @var Tokens
     */
    protected $_tokenCache; // {facade, token}
    protected $_configFilePath;
    protected $_baseUrl;
    protected $_ecKey;
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
    public static function create() {
        $instance = new self();
        return $instance;
    }

    /**
     * Constructor for use if the keys and SIN are managed by this library.
     *
     * @param $environment    String Target environment. Options: Env.Test / Env.Prod
     * @param $privateKeyPath String Private Key file path.
     * @param $tokens         Tokens containing the available tokens.
     * @param $privateKeySecret String Private Key encryption password.
     * @return Client
     * @throws BitPayException BitPayException class
     */
    public function withData($environment, $privateKeyPath,Tokens $tokens, $privateKeySecret = null)
    {
        try {
            $this->_env = $environment;
            $this->BuildConfig($privateKeyPath, $tokens, $privateKeySecret);
            $this->initKeys();
            $this->init();

            return $this;
        } catch (\Exception $e) {
            throw new BitPayException("Error - failed to initialize BitPay Client (Config) : ".$e->getMessage());
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
            $this->GetConfig();
            $this->initKeys();
            $this->init();

            return $this;
        } catch (\Exception $e) {
            throw new BitPayException("Error - failed to initialize BitPay Client (Config) : ".$e->getMessage());
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
    public function createInvoice(Invoice $invoice, string $facade, bool $signRequest) : Invoice {
        try {
            $invoice->setToken($this->_tokenCache->getTokenByFacade($facade));
            $invoice->setGuid(Util::guid());
            $json = json_encode($invoice);
        } catch (\Exception $e) {
            throw new BitPayException("Error - failed to serialize Invoice object : ".$e->getMessage());
        }

        try {
//            $invoice = mapper.readerForUpdating($invoice).readValue($this->responseToJsonString(response));
        } catch (\Exception $e) {
            throw new BitPayException("Error - failed to deserialize BitPay server response (Invoice) : ".$e->getMessage());
        }

        return $invoice;
    }

    /**
     * Retrieve a BitPay invoice by invoice id using the specified facade.  The client must have been previously authorized for the specified facade (the public facade requires no authorization).
     *
     * @param $invoiceId   The id of the invoice to retrieve.
     * @param $facade      The facade used to create it.
     * @param $signRequest Signed request.
     * @return A BitPay Invoice object.
     * @throws BitPayException BitPayException class
     */
    public function getInvoice($invoiceId, $facade, $signRequest) {

        $invoiceId = 'asdas';
        try {
            $params = array();
            $params["token"] = $this->_tokenCache->getTokenByFacade($facade);
            $response = $this->get("invoices/" + $invoiceId, $params);

            $invoice = $this->responseToJsonString($response);

            return $invoice;
        } catch (\Exception $e) {
            throw new BitPayException("Error - failed to deserialize BitPay server response (Invoice) : ".$e->getMessage());
        }

        return invoice;
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Initialize this object with the client name and the environment Url.
     *
     * @throws BitPayException BitPayException class
     */
    private function init() {
        try {
            $this->_baseUrl = strcmp($this->_env, Env::Test) ? Env::TestUrl : Env::ProdUrl;
            $this->_httpClient = new \GuzzleHttp\Client();
            $this->deriveIdentity();
            $this->_httpClient->setDefaultOption(
                'headers', [
                    'x-bitpay-plugin-info' => Env::BitpayPluginInfo
                ]
            );
            $this->LoadAccessTokens();
        } catch (\Exception $e) {
            throw new BitPayException("Error - failed to build configuration : ".$e->getMessage());
        }
    }

    /**
     * Initialize the public/private key pair by either loading the existing one or by creating a new one.
     *
     * @throws BitPayException BitPayException class
     */
    private function initKeys() {
        $privateKeyPath = $this->_configuration->getEnvConfig()[$this->_env]["PrivateKeyPath"];
        $privateKeySecret = $this->_configuration->getEnvConfig()[$this->_env]["PrivateKeySecret"];

        try {
            $this->_ecKey = new PrivateKey($privateKeyPath);
            $storageEngine = new EncryptedFilesystemStorage($privateKeySecret);
            $this->_ecKey = $storageEngine->load($privateKeyPath);
        } catch (\Exception $e) {
            throw new BitPayException("Error - failed to build configuration : ".$e->getMessage());
        }
    }

    private function deriveIdentity() {
        try {
            // Identity in this implementation is defined to be the SIN.
            $this->_identity = $this->_ecKey->getPublicKey()->getSin();
        } catch (\Exception $e) {
            throw new BitPayException("Error - failed to get SIN from private key : ".$e->getMessage());
        }
    }

    private function clearAccessTokenCache() {
        $this->_tokenCache = new Tokens();
    }

    /**
     * Load tokens from configuration.
     *
     * @throws BitPayException BitPayException class
     */
    private function LoadAccessTokens() {
        try {
            $this->clearAccessTokenCache();

            $this->_tokenCache = $this->_configuration->getEnvConfig()[$this->_env]["ApiTokens"];
        } catch (\Exception $e) {
            throw new BitPayException("Error - When trying to load the tokens : ".$e->getMessage());
        }
    }

    public function get($uri, array $parameters = null, $signatureRequired = true) {
        try {
            $fullURL = $this->_baseUrl.$uri;
            $request = $this->_httpClient->get($fullURL);
            if ($parameters) {
                $request->getQuery()->set($parameters);
            }

            if ($signatureRequired) {
                $fullURL = $request->getUrl();
                $request->addHeader('x-signature', $this->_ecKey->sign($fullURL));
                $request->addHeader('x-identity', $this->_identity);
            }

            return $this->_httpClient->send($request);
        } catch (\Exception $e) {
            throw new BitPayException("Error - GET failed : ".$e->getMessage());
        }
    }

    public function post($uri, string $json = null, $signatureRequired = true) {
        try {
            $fullURL = $this->_baseUrl.$uri;
            $request = $this->_httpClient->get($fullURL);
------------
            if ($signatureRequired) {
                $fullURL = $request->getUrl();
                $request->addHeader('x-signature', $this->_ecKey->sign($fullURL));
                $request->addHeader('x-identity', $this->_identity);
            }

            return $this->_httpClient->send($request);
        } catch (\Exception $e) {
            throw new BitPayException("Error - GET failed : ".$e->getMessage());
        }
    }

    public function responseToJsonString($response) {
        if ($response == null) {
            throw new \Exception("Error: HTTP response is null");
        }

        try {

            $body = json_decode($response->getBody(), true);
            $error_message = false;
            $error_message = (!empty($body['error'])) ? $body['error'] : $error_message;
            $error_message = (!empty($body['errors'])) ? $body['errors'] : $error_message;
            $error_message = (is_array($error_message)) ? implode("\n", $error_message) : $error_message;
            if (false !== $error_message) {
                throw new \Bitpay\Client\BitpayException($error_message);
            }
            $jsonString = $body['data'];

            return $jsonString;

        } catch (\Exception $e) {
            throw new BitPayException("Error - failed to retrieve HTTP response body : " . $e->getMessage());
        }
    }

    /**
     * Loads the configuration file (JSON)
     *
     * @throws BitPayException BitPayException class
     */
    public function GetConfig() {
        try {
            $this->_configuration = new Config();
            if (!file_exists($this->_configFilePath)) {
                throw new BitPayException("Configuration file not found");
            }
            $jsonData = json_decode(file_get_contents($this->_configFilePath), true);
            $this->_configuration->setEnvironment($jsonData["BitPayConfiguration"]["Environment"]);
            $this->_env = $this->_configuration->getEnvironment();
            $this->_configuration->setEnvConfig($jsonData["BitPayConfiguration"]["EnvConfig"][$this->_env]);
        } catch (\Exception $e) {
            throw new BitPayException("Error - failed to initialize BitPay Client (Config) : ".$e->getMessage());
        }
    }

    /**
     * Builds the configuration object
     *
     * @param $privateKeyPath String The full path to the securely located private key.
     * @param $tokens         Tokens object containing the BitPay's API tokens.
     * @param $privateKeySecret String Private Key encryption password.
     * @throws BitPayException BitPayException class
     */
    private function BuildConfig($privateKeyPath, $tokens, $privateKeySecret = null)
    {
        try {
            if (!file_exists($privateKeyPath)) {
                throw new BitPayException("Private Key file not found");
            }
            $this->_configuration = new Config();
            $this->_configuration->setEnvironment($this->_env);

            $envConfig[$this->_env] = [
                    "PrivateKeyPath" => $privateKeyPath,
                    "PrivateKeySecret" => $privateKeySecret,
                    "ApiTokens" => $tokens
                ];

            $this->_configuration->setEnvConfig($envConfig);
        } catch (\Exception $e) {
            throw new BitPayException("Error - failed to build configuration : ".$e->getMessage());
        }
    }
}