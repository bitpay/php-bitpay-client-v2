<?php

/**
 * Copyright (c) 2019 BitPay
 **/

declare(strict_types=1);

namespace BitPaySDK\Client;

use BitPaySDK\Exceptions\BitPayException;
use BitPaySDK\Exceptions\WalletQueryException;
use BitPaySDK\Model\Wallet\Wallet;
use BitPaySDK\Util\JsonMapperFactory;
use BitPaySDK\Util\RESTcli\RESTcli;
use Exception;

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
     * @throws WalletQueryException
     * @throws BitPayException
     */
    public function getSupportedWallets(): array
    {
        try {
            $responseJson = $this->restCli->get("supportedWallets/", null, false);
        } catch (BitPayException $e) {
            throw new WalletQueryException(
                "failed to serialize Wallet object : " .
                $e->getMessage(),
                null,
                null,
                $e->getApiCode()
            );
        } catch (Exception $e) {
            throw new WalletQueryException(
                "failed to deserialize BitPay server response (Wallet) : " . $e->getMessage()
            );
        }

        try {
            $mapper = JsonMapperFactory::create();

            return $mapper->mapArray(
                json_decode($responseJson, true, 512, JSON_THROW_ON_ERROR),
                [],
                Wallet::class
            );
        } catch (Exception $e) {
            throw new WalletQueryException(
                "failed to deserialize BitPay server response (Wallet) : " . $e->getMessage()
            );
        }
    }
}
