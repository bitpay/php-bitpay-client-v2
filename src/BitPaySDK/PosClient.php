<?php

/**
 * Copyright (c) 2019 BitPay
 **/

declare(strict_types=1);

namespace BitPaySDK;

use BitPayKeyUtils\KeyHelper\PrivateKey;
use BitpaySDK\Exceptions\BitPayApiException;
use BitPaySDK\Exceptions\BitPayExceptionProvider;
use BitPaySDK\Exceptions\BitPayGenericException;
use BitPaySDK\Model\Currency;
use BitPaySDK\Util\RESTcli\RESTcli;
use Exception;
use JsonMapper;

/**
 * Client for handling POS facade specific calls.
 *
 * @package BitPaySDK
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
class PosClient extends Client
{
    protected string $env;

    /**
     * Value for the X-BitPay-Platform-Info header
     * @var string
     */
    protected string $platformInfo;
    protected Tokens $token;
    protected RESTcli $RESTcli;

    /**
     * Constructor for the BitPay SDK to use with the POS facade.
     *
     * @param string       $token        The token generated on the BitPay account.
     * @param string|null  $environment  The target environment [Default: Production].
     * @param string|null  $platformInfo Value for the X-BitPay-Platform-Info header.
     *
     * @throws BitPayGenericException
     */
    public function __construct(string $token, string $environment = null, ?string $platformInfo = null)
    {
        try {
            $this->token = new Tokens(null, null, $token);
            $this->env = strtolower($environment) === "test" ? Env::TEST : Env::PROD;
            $this->platformInfo = $platformInfo !== null ? trim($platformInfo) : '';
            $this->init();
            parent::__construct($this->RESTcli, new Tokens(null, null, $token));
        } catch (Exception $e) {
            BitPayExceptionProvider::throwGenericExceptionWithMessage(
                'failed to initialize BitPay Light Client (Config) : ' . $e->getMessage()
            );
        }
    }

    /**
     * Initialize this object with the selected environment.
     *
     * @throws BitPayGenericException
     */
    private function init(): void
    {
        try {
            $this->RESTcli = new RESTcli($this->env, new PrivateKey(), null, $this->platformInfo);
        } catch (Exception $e) {
            BitPayExceptionProvider::throwGenericExceptionWithMessage(
                'failed to build configuration : ' . $e->getMessage()
            );
        }
    }

    /**
     * Fetch the supported currencies.
     *
     * @return array A list of BitPay Invoice objects.
     * @throws BitPayGenericException
     * @throws BitPayApiException
     */
    public function getCurrencies(): array
    {
        $responseJson = $this->RESTcli->get("currencies", null, false);

        try {
            $mapper = new JsonMapper();
            $mapper->bEnforceMapType = false;
            return $mapper->mapArray(
                json_decode($responseJson, true, 512, JSON_THROW_ON_ERROR),
                [],
                Currency::class
            );
        } catch (Exception $e) {
            BitPayExceptionProvider::throwDeserializeResourceException('Currency', $e->getMessage());
        }
    }
}
