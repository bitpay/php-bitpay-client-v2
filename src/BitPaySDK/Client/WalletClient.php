<?php

/**
 * Copyright (c) 2019 BitPay
 **/

declare(strict_types=1);

namespace BitPaySDK\Client;

use BitPaySDK\Exceptions\BitPayApiException;
use BitPaySDK\Exceptions\BitPayExceptionProvider;
use BitPaySDK\Exceptions\BitPayGenericException;
use BitPaySDK\Model\Wallet\Wallet;
use BitPaySDK\Util\JsonMapperFactory;
use BitPaySDK\Util\RESTcli\RESTcli;
use Exception;

/**
 * Handles interactions with the wallet endpoints.
 *
 * @package BitPaySDK\Client
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
class WalletClient
{
    private static ?self $instance = null;
    private RESTcli $restCli;

    private function __construct(RESTcli $restCli)
    {
        $this->restCli = $restCli;
    }

    /**
     * Factory method for Wallet Client.
     *
     * @param RESTcli $restCli
     * @return static
     */
    public static function getInstance(RESTcli $restCli): self
    {
        if (!self::$instance) {
            self::$instance = new self($restCli);
        }

        return self::$instance;
    }

    /**
     * Retrieve all supported wallets.
     *
     * @return Wallet[]
     * @throws BitPayApiException
     * @throws BitPayGenericException
     */
    public function getSupportedWallets(): array
    {
        $responseJson = $this->restCli->get("supportedWallets/", null, false);

        try {
            $mapper = JsonMapperFactory::create();

            return $mapper->mapArray(
                json_decode($responseJson, true, 512, JSON_THROW_ON_ERROR),
                [],
                Wallet::class
            );
        } catch (Exception $e) {
            BitPayExceptionProvider::throwDeserializeResourceException('Wallet', $e->getMessage());
        }
    }
}
