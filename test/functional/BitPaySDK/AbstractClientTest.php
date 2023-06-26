<?php

declare(strict_types=1);

namespace BitPaySDK\Functional;

use BitPaySDK\Client;
use PHPUnit\Framework\TestCase;

abstract class AbstractClientTest extends TestCase
{
    protected Client $client;

    /**
     * @throws \BitPaySDK\Exceptions\BitPayException
     */
    public function setUp(): void
    {
        $this->client = Client::createWithFile(Config::FUNCTIONAL_TEST_PATH . DIRECTORY_SEPARATOR . Config::BITPAY_CONFIG_FILE);
    }
}
