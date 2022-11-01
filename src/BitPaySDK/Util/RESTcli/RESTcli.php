<?php

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
use GuzzleHttp\Exception\TransferException;
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
    protected $_client;
    /**
     * @var string
     */
    protected $_baseUrl;
    /**
     * @var PrivateKey
     */
    protected $_ecKey;
    /**
     * @var string
     */
    protected $_identity;

    /**
     * @var string
     */
    protected $_proxy;

    /**
     * RESTcli constructor.
     * @param string $environment
     * @param PrivateKey $ecKey
     * @param string|null $proxy
     * @throws BitPayException
     */
    public function __construct(string $environment, PrivateKey $ecKey, ?string $proxy = null)
    {
        $this->_ecKey = $ecKey;
        $this->_baseUrl = $environment == Env::Test ? Env::TestUrl : Env::ProdUrl;
        $this->_proxy = $proxy !== null ? trim($proxy) : '';
        $this->init();
    }

    /**
     * Initialize Client.
     *
     * @throws BitPayException
     */
    public function init()
    {
        try {
            $this->_identity = $this->_ecKey->getPublicKey()->__toString();
            $config = [
                'base_url' => $this->_baseUrl,
                'defaults' => [
                    'headers' => [
                        'x-accept-version'           => Env::BitpayApiVersion,
                        'x-bitpay-plugin-info'       => Env::BitpayPluginInfo,
                        'x-bitpay-api-frame'         => Env::BitpayApiFrame,
                        'x-bitpay-api-frame-version' => Env::BitpayApiFrameVersion,
                    ],
                ],
            ];

            if ($this->_proxy !== '') {
                $config['proxy'] = $this->_proxy;
            }

            $this->_client = new GuzzleHttpClient($config);
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
    public function post($uri, array $formData = [], $signatureRequired = true): string
    {
        try {
            $fullURL = $this->_baseUrl . $uri;
            $headers = [
                'Content-Type'               => 'application/json',
                'x-accept-version'           => Env::BitpayApiVersion,
                'x-bitpay-plugin-info'       => Env::BitpayPluginInfo,
                'x-bitpay-api-frame'         => Env::BitpayApiFrame,
                'x-bitpay-api-frame-version' => Env::BitpayApiFrameVersion,
            ];

            if ($signatureRequired) {
                $headers['x-signature'] = $this->_ecKey->sign($fullURL . json_encode($formData));
                $headers['x-identity'] = $this->_identity;
            }

            /**
             * @var Response
             */
            $response = $this->_client->requestAsync(
                'POST',
                $fullURL,
                [
                $options[RequestOptions::SYNCHRONOUS] = false,
                'headers'            => $headers,
                RequestOptions::JSON => $formData,
                ]
            )->wait();

            $responseJson = $this->responseToJsonString($response);

            return $responseJson;
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
    public function get($uri, array $parameters = null, $signatureRequired = true): string
    {
        try {
            $fullURL = $this->_baseUrl . $uri;
            $headers = [
                'Content-Type'               => 'application/json',
                'x-accept-version'           => Env::BitpayApiVersion,
                'x-bitpay-plugin-info'       => Env::BitpayPluginInfo,
                'x-bitpay-api-frame'         => Env::BitpayApiFrame,
                'x-bitpay-api-frame-version' => Env::BitpayApiFrameVersion,
            ];

            if ($parameters) {
                $fullURL .= '?' . http_build_query($parameters);
            }

            if ($signatureRequired) {
                $headers['x-signature'] = $this->_ecKey->sign($fullURL);
                $headers['x-identity'] = $this->_identity;
            }

            /**
             * @var Response
             */
            $response = $this->_client->requestAsync(
                'GET',
                $fullURL,
                [
                $options[RequestOptions::SYNCHRONOUS] = false,
                'headers' => $headers,
                'query'   => $parameters,
                ]
            )->wait();

            $responseJson = $this->responseToJsonString($response);

            return $responseJson;
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
            $fullURL = $this->_baseUrl . $uri;
            if ($parameters) {
                $fullURL .= '?' . http_build_query($parameters);
            }

            $headers = [
                'x-accept-version'           => Env::BitpayApiVersion,
                'x-bitpay-plugin-info'       => Env::BitpayPluginInfo,
                'x-bitpay-api-frame'         => Env::BitpayApiFrame,
                'x-bitpay-api-frame-version' => Env::BitpayApiFrameVersion,
                'Content-Type'               => 'application/json',
                'x-signature'                => $this->_ecKey->sign($fullURL),
                'x-identity'                 => $this->_identity,
            ];

            /**
             * @var Response
             */
            $response = $this->_client->requestAsync(
                'DELETE',
                $fullURL,
                [
                $options[RequestOptions::SYNCHRONOUS] = false,
                'headers' => $headers,
                'query'   => $parameters,
                ]
            )->wait();

            $responseJson = $this->responseToJsonString($response);

            return $responseJson;
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
            $fullURL = $this->_baseUrl . $uri;
            $headers = [
                'x-accept-version'           => Env::BitpayApiVersion,
                'x-bitpay-plugin-info'       => Env::BitpayPluginInfo,
                'x-bitpay-api-frame'         => Env::BitpayApiFrame,
                'x-bitpay-api-frame-version' => Env::BitpayApiFrameVersion,
                'Content-Type'               => 'application/json',
                'x-signature'                => $this->_ecKey->sign($fullURL . json_encode($formData)),
                'x-identity'                 => $this->_identity,
            ];

            /**
             * @var Response
             */
            $response = $this->_client->requestAsync(
                'PUT',
                $fullURL,
                [
                $options[RequestOptions::SYNCHRONOUS] = false,
                'headers'            => $headers,
                RequestOptions::JSON => $formData,
                ]
            )->wait();

            $responseJson = $this->responseToJsonString($response);

            return $responseJson;
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
     */
    public function responseToJsonString(Response $response): string
    {
        if ($response == null) {
            throw new Exception("Error: HTTP response is null");
        }

        try {
            $body = json_decode($response->getBody()->getContents(), true);
            if ($this->_proxy !== '' && !is_array($body)) {
                throw new BitPayException(
                    "Please check your proxy settings, HTTP Code:" .
                    $response->getStatusCode() .
                    ", failed to decode json: " .
                    json_last_error_msg()
                );
            }

            if (!empty($body['status'])) {
                if ($body['status'] == 'error') {
                    throw new BitpayException($body['message'], null, null, $body['code']);
                }
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
}
