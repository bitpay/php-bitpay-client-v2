<?php

namespace BitPaySDK\Client;

use BitPaySDK\Exceptions\BitPayException;
use BitPaySDK\Exceptions\WalletQueryException;
use BitPaySDK\Model\Wallet\Wallet;
use BitPaySDK\Util\RESTcli\RESTcli;
use Exception;

class WalletClient
{
    private RESTcli $restCli;

    public function __construct(RESTcli $restCli)
    {
        $this->restCli = $restCli;
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
            $mapper = new \JsonMapper();
            $mapper->bEnforceMapType = false;
            $wallets = $mapper->mapArray(
                json_decode($responseJson),
                [],
                'BitPaySDK\Model\Wallet\Wallet'
            );
        } catch (Exception $e) {
            throw new WalletQueryException(
                "failed to deserialize BitPay server response (Wallet) : " . $e->getMessage()
            );
        }

        return $wallets;
    }
}
