<?php

/**
 * Copyright (c) 2019 BitPay
 **/

declare(strict_types=1);

namespace BitPaySDK\Client;

use BitPaySDK\Util\RESTcli\RESTcli;

class TokenClient
{
    private static ?self $instance = null;
    private RESTcli $restCli;

    private function __construct(RESTcli $restCli)
    {
        $this->restCli = $restCli;
    }

    /**
     * Factory method for Token Client.
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
     * Get Tokens.
     *
     * @throws \BitPaySDK\Exceptions\BitPayException
     * @throws \JsonException
     */
    public function getTokens(): array
    {
        $response = $this->restCli->get('tokens');

        return json_decode($response, true, 512, JSON_THROW_ON_ERROR);
    }
}
