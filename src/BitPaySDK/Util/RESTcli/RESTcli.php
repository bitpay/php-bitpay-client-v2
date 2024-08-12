<?php

/**
 * Copyright (c) 2019 BitPay
 **/

declare(strict_types=1);

namespace BitPaySDK\Util\RESTcli;

use BitPayKeyUtils\KeyHelper\PrivateKey;
use BitPaySDK\Env;
use BitPaySDK\Exceptions\BitPayApiException;
use BitPaySDK\Exceptions\BitPayExceptionProvider;
use BitPaySDK\Exceptions\BitPayGenericException;
use BitPaySDK\Logger\LoggerProvider;
use Exception;
use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\RequestOptions;

/**
 * @package BitPaySDK\Util
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
class RESTcli
{
    /**
     * @var GuzzleHttpClient
     */
    protected GuzzleHttpClient $client;

    /**
     * @var string
     */
    protected string $baseUrl;

    /**
     * @var PrivateKey
     */
    protected PrivateKey $ecKey;

    /**
     * @var string
     */
    protected string $identity;

    /**
     * Value for the X-BitPay-Platform-Info header.
     * @var string
     */
    protected string $platformInfo;

    /**
     * @var string
     */
    protected string $proxy;


    /**
     * RESTcli constructor.
     * @param string $environment
     * @param PrivateKey $ecKey
     * @param string|null $proxy
     * @throws BitPayApiException
     */
    public function __construct(string $environment, PrivateKey $ecKey, ?string $proxy = null, ?string $platformInfo)
    {
        $this->ecKey = $ecKey;
        $this->baseUrl = $environment == Env::TEST ? Env::TEST_URL : Env::PROD_URL;
        $this->proxy = $proxy !== null ? trim($proxy) : '';
        $this->platformInfo = $platformInfo !== null ? trim($platformInfo) : '';
        $this->init();
    }

    /**
     * Initialize Client.
     *
     * @throws BitPayApiException
     */
    public function init(): void
    {
        try {
            $this->identity = $this->ecKey->getPublicKey()->__toString();
            $config = [
                'base_url' => $this->baseUrl,
                'defaults' => [
                    'headers' => [
                        'x-accept-version'           => Env::BITPAY_API_VERSION,
                        'x-bitpay-plugin-info'       => Env::BITPAY_PLUGIN_INFO,
                        'x-bitpay-api-frame'         => Env::BITPAY_API_FRAME,
                        'x-bitpay-api-frame-version' => Env::BITPAY_API_FRAME_VERSION,
                    ],
                ],
            ];

            if ($this->proxy !== '') {
                $config['proxy'] = $this->proxy;
            }

            if ($this->platformInfo !== '') {
                $config['defaults']['headers']['x-bitpay-platform-info'] = $this->platformInfo;
            }

            $this->client = new GuzzleHttpClient($config);
        } catch (Exception $e) {
            BitPayExceptionProvider::throwApiExceptionWithMessage($e->getMessage());
        }
    }

    /**
     * Send POST request.
     *
     * @param $uri
     * @param array $formData
     * @param bool $signatureRequired
     * @return string (json)
     * @throws BitPayApiException
     * @throws BitPayGenericException
     */
    public function post($uri, array $formData = [], bool $signatureRequired = true): string
    {
        try {
            $fullURL = $this->baseUrl . $uri;
            $headers = [
                'Content-Type' => 'application/json',
                'x-accept-version' => Env::BITPAY_API_VERSION,
                'x-bitpay-plugin-info' => Env::BITPAY_PLUGIN_INFO,
                'x-bitpay-api-frame' => Env::BITPAY_API_FRAME,
                'x-bitpay-api-frame-version' => Env::BITPAY_API_FRAME_VERSION,
            ];

            $jsonRequestData = json_encode($formData, JSON_THROW_ON_ERROR);

            if ($signatureRequired) {
                try {
                    $headers['x-signature'] = $this->ecKey->sign($fullURL . $jsonRequestData);
                } catch (Exception $e) {
                    BitPayExceptionProvider::throwGenericExceptionWithMessage('Wrong ecKey. ' . $e->getMessage());
                }
                $headers['x-identity'] = $this->identity;
            }

            if ($this->platformInfo !== '') {
                $headers['x-bitpay-platform-info'] = $this->platformInfo;
            }

            $method = "POST";

            LoggerProvider::getLogger()->logRequest($method, $fullURL, $jsonRequestData);

            /**
             * @var Response
             */
            $response = $this->client->requestAsync(
                $method,
                $fullURL,
                [
                    false,
                    'headers' => $headers,
                    RequestOptions::JSON => $formData,
                ]
            )->wait();

            LoggerProvider::getLogger()->logResponse($method, $fullURL, $response->getBody()->__toString());

            return $this->getJsonDataFromResponse($response);
        } catch (\JsonException $exception) {
            BitPayExceptionProvider::throwGenericExceptionWithMessage($exception->getMessage());
        } catch (RequestException $exception) {
            $this->parseException($exception);
        }
    }

    /**
     * Send GET request.
     *
     * @param $uri
     * @param array|null $parameters
     * @param bool $signatureRequired
     * @return string (json)
     * @throws BitPayApiException
     * @throws BitPayGenericException
     */
    public function get($uri, array $parameters = null, bool $signatureRequired = true): string
    {
        try {
            $fullURL = $this->baseUrl . $uri;
            $headers = [
                'Content-Type'               => 'application/json',
                'x-accept-version'           => Env::BITPAY_API_VERSION,
                'x-bitpay-plugin-info'       => Env::BITPAY_PLUGIN_INFO,
                'x-bitpay-api-frame'         => Env::BITPAY_API_FRAME,
                'x-bitpay-api-frame-version' => Env::BITPAY_API_FRAME_VERSION,
            ];

            if ($parameters) {
                $fullURL .= '?' . http_build_query($parameters);
            }

            if ($signatureRequired) {
                try {
                    $headers['x-signature'] = $this->ecKey->sign($fullURL);
                } catch (Exception $e) {
                    BitPayExceptionProvider::throwGenericExceptionWithMessage('Wrong ecKey. ' . $e->getMessage());
                }
                $headers['x-identity'] = $this->identity;
            }

            if ($this->platformInfo !== '') {
                $headers['x-bitpay-platform-info'] = $this->platformInfo;
            }

            $method = 'GET';

            LoggerProvider::getLogger()->logRequest($method, $fullURL, null);

            /**
             * @var Response
             */
            $response = $this->client->requestAsync(
                $method,
                $fullURL,
                [
                $options[RequestOptions::SYNCHRONOUS] = false,
                'headers' => $headers,
                'query'   => $parameters,
                ]
            )->wait();

            LoggerProvider::getLogger()->logResponse($method, $fullURL, $response->getBody()->__toString());

            return $this->getJsonDataFromResponse($response);
        } catch (RequestException $exception) {
            $this->parseException($exception);
        }
    }

    /**
     * Send DELETE request.
     *
     * @param $uri
     * @param array|null $parameters
     * @return string
     * @throws BitPayApiException
     * @throws BitPayGenericException
     */
    public function delete($uri, array $parameters = null): string
    {
        try {
            $fullURL = $this->baseUrl . $uri;
            if ($parameters) {
                $fullURL .= '?' . http_build_query($parameters);
            }

            $headers = [
                'x-accept-version' => Env::BITPAY_API_VERSION,
                'x-bitpay-plugin-info' => Env::BITPAY_PLUGIN_INFO,
                'x-bitpay-api-frame' => Env::BITPAY_API_FRAME,
                'x-bitpay-api-frame-version' => Env::BITPAY_API_FRAME_VERSION,
                'Content-Type' => 'application/json',
                'x-identity' => $this->identity,
            ];

            try {
                $headers['x-signature'] = $this->ecKey->sign($fullURL);
            } catch (Exception $e) {
                BitPayExceptionProvider::throwGenericExceptionWithMessage('Wrong ecKey. ' . $e->getMessage());
            }

            if ($this->platformInfo !== '') {
                $headers['x-bitpay-platform-info'] = $this->platformInfo;
            }

            $method = 'DELETE';

            $jsonRequestData = json_encode($parameters, JSON_THROW_ON_ERROR);

            LoggerProvider::getLogger()->logRequest($method, $fullURL, $jsonRequestData);

            /**
             * @var Response
             */
            $response = $this->client->requestAsync(
                $method,
                $fullURL,
                [
                    $options[RequestOptions::SYNCHRONOUS] = false,
                    'headers' => $headers,
                    'query' => $parameters,
                ]
            )->wait();

            LoggerProvider::getLogger()->logResponse($method, $fullURL, $response->getBody()->__toString());

            return $this->getJsonDataFromResponse($response);
        } catch (\JsonException $exception) {
            BitPayExceptionProvider::throwGenericExceptionWithMessage($exception->getMessage());
        } catch (RequestException $exception) {
            $this->parseException($exception);
        }
    }

    /**
     * Send PUT request.
     *
     * @param $uri
     * @param array $formData
     * @return string
     * @throws BitPayApiException
     * @throws BitPayGenericException
     */
    public function update($uri, array $formData = []): string
    {
        try {
            $jsonRequestData = json_encode($formData, JSON_THROW_ON_ERROR);
            $fullURL = $this->baseUrl . $uri;
            $headers = [
                'x-accept-version' => Env::BITPAY_API_VERSION,
                'x-bitpay-plugin-info' => Env::BITPAY_PLUGIN_INFO,
                'x-bitpay-api-frame' => Env::BITPAY_API_FRAME,
                'x-bitpay-api-frame-version' => Env::BITPAY_API_FRAME_VERSION,
                'Content-Type' => 'application/json',
                'x-identity' => $this->identity,
            ];

            try {
                $headers['x-signature'] = $this->ecKey->sign($fullURL . $jsonRequestData);
            } catch (Exception $e) {
                BitPayExceptionProvider::throwGenericExceptionWithMessage('Wrong ecKey. ' . $e->getMessage());
            }

            if ($this->platformInfo !== '') {
                $headers['x-bitpay-platform-info'] = $this->platformInfo;
            }

            $method = 'PUT';

            LoggerProvider::getLogger()->logRequest($method, $fullURL, $jsonRequestData);

            /**
             * @var Response
             */
            $response = $this->client->requestAsync(
                $method,
                $fullURL,
                [
                    $options[RequestOptions::SYNCHRONOUS] = false,
                    'headers' => $headers,
                    RequestOptions::JSON => $formData,
                ]
            )->wait();

            LoggerProvider::getLogger()->logResponse($method, $fullURL, $response->getBody()->__toString());

            return $this->getJsonDataFromResponse($response);
        } catch (\JsonException $exception) {
            BitPayExceptionProvider::throwGenericExceptionWithMessage($exception->getMessage());
        } catch (RequestException $exception) {
            $this->parseException($exception);
        }
    }

    /**
     * Parse Response object into json
     *
     * @return string
     * @throws BitPayApiException|BitPayGenericException
     */
    public function getJsonDataFromResponse(Response $response): string
    {
        try {
            $json = $response->getBody()->__toString();
        } catch (Exception $e) {
            BitPayExceptionProvider::throwGenericExceptionWithMessage($e->getMessage());
        }

        try {
            $body = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
            if (!is_array($body)) {
                BitPayExceptionProvider::throwApiExceptionWithMessage('Missing response body');
            }

            if ($this->hasError($body)) {
                BitPayExceptionProvider::throwApiExceptionByArrayResponse($body);
            }

            $success = $body['success'] ?? null;
            if ($success) {
                return json_encode($body, JSON_THROW_ON_ERROR);
            }

            if (!array_key_exists('data', $body)) { // some legacy response doesn't have 'data' key
                return json_encode($body, JSON_THROW_ON_ERROR);
            }

            return json_encode($body['data'], JSON_THROW_ON_ERROR);
        } catch (\JsonException $exception) {
            BitPayExceptionProvider::throwGenericExceptionWithMessage($exception->getMessage());
        }
    }

    /**
     * @param array $body
     * @return bool
     */
    private function hasError(array $body): bool
    {
        if (!empty($body['status']) && $body['status'] === 'error') {
            return true;
        }

        $error = $body['error'] ?? null;
        $errors = $body['errors'] ?? null;

        return $error || $errors;
    }

    /**
     * @throws BitPayApiException
     * @throws BitPayGenericException
     */
    private function parseException(RequestException $exception): void
    {
        $json = $exception->getResponse()->getBody()->__toString();

        if (!$json) {
            BitPayExceptionProvider::throwApiExceptionWithMessage('Invalid json');
        }

        try {
            $body = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $exception) {
            BitPayExceptionProvider::throwGenericExceptionWithMessage($exception->getMessage());
        }

        BitPayExceptionProvider::throwApiExceptionByArrayResponse($body);
    }
}
