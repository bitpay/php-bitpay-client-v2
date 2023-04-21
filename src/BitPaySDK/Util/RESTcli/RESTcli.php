<?php

/**
 * Copyright (c) 2019 BitPay
 **/

declare(strict_types=1);

/**
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace BitPaySDK\Util\RESTcli;

use BitPayKeyUtils\KeyHelper\PrivateKey;
use BitPaySDK\Env;
use BitPaySDK\Exceptions\BitPayException;
use Exception;
use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\InvalidArgumentException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Exception\TooManyRedirectsException;
use GuzzleHttp\Psr7\Response as Response;
use GuzzleHttp\RequestOptions as RequestOptions;

/**
 * Class RESTcli
 * @package BitPaySDK\Util\RESTcli
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
     * @var string
     */
    protected string $proxy;

    /**
     * RESTcli constructor.
     * @param string $environment
     * @param PrivateKey $ecKey
     * @param string|null $proxy
     * @throws BitPayException
     */
    public function __construct(string $environment, PrivateKey $ecKey, ?string $proxy = null)
    {
        $this->ecKey = $ecKey;
        $this->baseUrl = $environment == Env::TEST ? Env::TEST_URL : Env::PROD_URL;
        $this->proxy = $proxy !== null ? trim($proxy) : '';
        $this->init();
    }

    /**
     * Initialize Client.
     *
     * @throws BitPayException
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

            $this->client = new GuzzleHttpClient($config);
        } catch (Exception $e) {
            throw new BitPayException("RESTcli init failed : " . $e->getMessage());
        }
    }

    /**
     * Send POST request.
     *
     * @param $uri
     * @param array $formData
     * @param bool $signatureRequired
     * @return string (json)
     * @throws BitPayException
     */
    public function post($uri, array $formData = [], bool $signatureRequired = true): string
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

            if ($signatureRequired) {
                $headers['x-signature'] = $this->ecKey->sign($fullURL . json_encode($formData));
                $headers['x-identity'] = $this->identity;
            }

            /**
             * @var Response
             */
            $response = $this->client->requestAsync(
                'POST',
                $fullURL,
                [
                false,
                'headers'            => $headers,
                RequestOptions::JSON => $formData,
                ]
            )->wait();

            return $this->responseToJsonString($response);
        } catch (BadResponseException $e) {
            $errorJson = $this->responseToJsonString($e->getResponse());
            throw new BitPayException(
                "POST failed : Guzzle/BadResponseException : " .
                $errorJson['message'],
                $errorJson['code']
            );
        } catch (ClientException $e) {
            throw new BitPayException("POST failed : Guzzle/ClientException : " . $e->getMessage());
        } catch (ConnectException $e) {
            throw new BitPayException("POST failed : Guzzle/ConnectException : " . $e->getMessage());
        } catch (GuzzleException $e) {
            throw new BitPayException("POST failed : Guzzle/GuzzleException : " . $e->getMessage());
        } catch (InvalidArgumentException $e) {
            throw new BitPayException("POST failed : Guzzle/InvalidArgumentException : " . $e->getMessage());
        } catch (RequestException $e) {
            throw new BitPayException("POST failed : Guzzle/RequestException : " . $e->getMessage());
        } catch (ServerException $e) {
            throw new BitPayException("POST failed : Guzzle/ServerException : " . $e->getMessage());
        } catch (TooManyRedirectsException $e) {
            throw new BitPayException("POST failed : Guzzle/TooManyRedirectsException : " . $e->getMessage());
        } catch (Exception $e) {
            throw new BitPayException("POST failed : " . $e->getMessage());
        }
    }

    /**
     * Send GET request.
     *
     * @param $uri
     * @param array|null $parameters
     * @param bool $signatureRequired
     * @return string (json)
     * @throws BitPayException
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
                $headers['x-signature'] = $this->ecKey->sign($fullURL);
                $headers['x-identity'] = $this->identity;
            }

            /**
             * @var Response
             */
            $response = $this->client->requestAsync(
                'GET',
                $fullURL,
                [
                $options[RequestOptions::SYNCHRONOUS] = false,
                'headers' => $headers,
                'query'   => $parameters,
                ]
            )->wait();

            return $this->responseToJsonString($response);
        } catch (BadResponseException $e) {
            $errorJson = $this->responseToJsonString($e->getResponse());
            throw new BitPayException(
                "GET failed : Guzzle/BadResponseException : " .
                $errorJson['message'],
                $errorJson['code']
            );
        } catch (ClientException $e) {
            throw new BitPayException("GET failed : Guzzle/ClientException : " . $e->getMessage());
        } catch (ConnectException $e) {
            throw new BitPayException("GET failed : Guzzle/ConnectException : " . $e->getMessage());
        } catch (GuzzleException $e) {
            throw new BitPayException("GET failed : Guzzle/GuzzleException : " . $e->getMessage());
        } catch (InvalidArgumentException $e) {
            throw new BitPayException("GET failed : Guzzle/InvalidArgumentException : " . $e->getMessage());
        } catch (RequestException $e) {
            throw new BitPayException("GET failed : Guzzle/RequestException : " . $e->getMessage());
        } catch (ServerException $e) {
            throw new BitPayException("GET failed : Guzzle/ServerException : " . $e->getMessage());
        } catch (TooManyRedirectsException $e) {
            throw new BitPayException("GET failed : Guzzle/TooManyRedirectsException : " . $e->getMessage());
        } catch (Exception $e) {
            throw new BitPayException("GET failed : " . $e->getMessage());
        }
    }

    /**
     * Send DELETE request.
     *
     * @param $uri
     * @param array|null $parameters
     * @return string
     * @throws BitPayException
     */
    public function delete($uri, array $parameters = null): string
    {
        try {
            $fullURL = $this->baseUrl . $uri;
            if ($parameters) {
                $fullURL .= '?' . http_build_query($parameters);
            }

            $headers = [
                'x-accept-version'           => Env::BITPAY_API_VERSION,
                'x-bitpay-plugin-info'       => Env::BITPAY_PLUGIN_INFO,
                'x-bitpay-api-frame'         => Env::BITPAY_API_FRAME,
                'x-bitpay-api-frame-version' => Env::BITPAY_API_FRAME_VERSION,
                'Content-Type'               => 'application/json',
                'x-signature'                => $this->ecKey->sign($fullURL),
                'x-identity'                 => $this->identity,
            ];

            /**
             * @var Response
             */
            $response = $this->client->requestAsync(
                'DELETE',
                $fullURL,
                [
                $options[RequestOptions::SYNCHRONOUS] = false,
                'headers' => $headers,
                'query'   => $parameters,
                ]
            )->wait();

            return $this->responseToJsonString($response);
        } catch (BadResponseException $e) {
            $errorJson = $this->responseToJsonString($e->getResponse());
            throw new BitPayException(
                "DELETE failed : Guzzle/BadResponseException : " .
                $errorJson['message'],
                $errorJson['code']
            );
        } catch (ClientException $e) {
            throw new BitPayException("DELETE failed : Guzzle/ClientException : " . $e->getMessage());
        } catch (ConnectException $e) {
            throw new BitPayException("DELETE failed : Guzzle/ConnectException : " . $e->getMessage());
        } catch (GuzzleException $e) {
            throw new BitPayException("DELETE failed : Guzzle/GuzzleException : " . $e->getMessage());
        } catch (InvalidArgumentException $e) {
            throw new BitPayException("DELETE failed : Guzzle/InvalidArgumentException : " . $e->getMessage());
        } catch (RequestException $e) {
            throw new BitPayException("DELETE failed : Guzzle/RequestException : " . $e->getMessage());
        } catch (ServerException $e) {
            throw new BitPayException("DELETE failed : Guzzle/ServerException : " . $e->getMessage());
        } catch (TooManyRedirectsException $e) {
            throw new BitPayException("DELETE failed : Guzzle/TooManyRedirectsException : " . $e->getMessage());
        } catch (Exception $e) {
            throw new BitPayException("DELETE failed : " . $e->getMessage());
        }
    }

    /**
     * Send PUT request.
     *
     * @param $uri
     * @param array $formData
     * @return string
     * @throws BitPayException
     */
    public function update($uri, array $formData = []): string
    {
        try {
            $fullURL = $this->baseUrl . $uri;
            $headers = [
                'x-accept-version'           => Env::BITPAY_API_VERSION,
                'x-bitpay-plugin-info'       => Env::BITPAY_PLUGIN_INFO,
                'x-bitpay-api-frame'         => Env::BITPAY_API_FRAME,
                'x-bitpay-api-frame-version' => Env::BITPAY_API_FRAME_VERSION,
                'Content-Type'               => 'application/json',
                'x-signature'                => $this->ecKey->sign($fullURL . json_encode($formData)),
                'x-identity'                 => $this->identity,
            ];

            /**
             * @var Response
             */
            $response = $this->client->requestAsync(
                'PUT',
                $fullURL,
                [
                $options[RequestOptions::SYNCHRONOUS] = false,
                'headers'            => $headers,
                RequestOptions::JSON => $formData,
                ]
            )->wait();

            return $this->responseToJsonString($response);
        } catch (BadResponseException $e) {
            $errorJson = $this->responseToJsonString($e->getResponse());
            throw new BitPayException(
                "UPDATE failed : Guzzle/BadResponseException : " .
                $errorJson['message'],
                $errorJson['code']
            );
        } catch (ClientException $e) {
            throw new BitPayException("UPDATE failed : Guzzle/ClientException : " . $e->getMessage());
        } catch (ConnectException $e) {
            throw new BitPayException("UPDATE failed : Guzzle/ConnectException : " . $e->getMessage());
        } catch (GuzzleException $e) {
            throw new BitPayException("UPDATE failed : Guzzle/GuzzleException : " . $e->getMessage());
        } catch (InvalidArgumentException $e) {
            throw new BitPayException("UPDATE failed : Guzzle/InvalidArgumentException : " . $e->getMessage());
        } catch (RequestException $e) {
            throw new BitPayException("UPDATE failed : Guzzle/RequestException : " . $e->getMessage());
        } catch (ServerException $e) {
            throw new BitPayException("UPDATE failed : Guzzle/ServerException : " . $e->getMessage());
        } catch (TooManyRedirectsException $e) {
            throw new BitPayException("UPDATE failed : Guzzle/TooManyRedirectsException : " . $e->getMessage());
        } catch (Exception $e) {
            throw new BitPayException("UPDATE failed : " . $e->getMessage());
        }
    }

    /**
     * Convert Response object into json
     *
     * @param Response $response
     * @return string
     * @throws BitPayException
     * @throws Exception
     */
    public function responseToJsonString(Response $response): string
    {
        try {
            $body = json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
            if ($this->proxy !== '' && !is_array($body)) {
                throw new BitPayException(
                    "Please check your proxy settings, HTTP Code:" .
                    $response->getStatusCode() .
                    ", failed to decode json: " .
                    json_last_error_msg()
                );
            }

            if ($this->isErrorStatus($body)) {
                throw new BitpayException($body['message'], null, null, (string)$body['code']);
            }

            $error_message = false;
            $error_message = (!empty($body['error'])) ? $body['error'] : $error_message;
            $error_message = (!empty($body['errors'])) ? $body['errors'] : $error_message;

            if (is_array($error_message)) {
                if (count($error_message) == count($error_message, 1)) {
                    $error_message = implode("\n", $error_message);
                } else {
                    $errors = array();
                    foreach ($error_message as $error) {
                        $errors[] = $error['param'] . ": " . $error['error'];
                    }
                    $error_message = implode(',', $errors);
                }
            }

            if (false !== $error_message) {
                throw new BitpayException($error_message);
            }

            if (!empty($body['success'])) {
                return json_encode($body);
            }

            // TODO Temporary fix for legacy response
            if (!array_key_exists('data', $body)) {
                return json_encode($body);
            }

            return json_encode($body['data']);
        } catch (BitpayException $e) {
            throw new BitPayException(
                "failed to retrieve HTTP response body : " .
                $e->getMessage(),
                null,
                null,
                $e->getApiCode()
            );
        } catch (Exception $e) {
            throw new BitPayException("failed to retrieve HTTP response body : " . $e->getMessage());
        }
    }

    /**
     * @param array $body
     * @return bool
     */
    private function isErrorStatus(array $body): bool
    {
        return !empty($body['status']) && $body['status'] === 'error';
    }
}
