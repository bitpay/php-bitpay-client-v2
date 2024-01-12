<?php

declare(strict_types=1);

namespace BitPaySDKexamples;

use BitPaySDK\Client;
use BitPaySDK\PosClient;

class ClientProvider
{
    public static function create(): Client
    {
        // to create private key, tokens & private key secret run setup/ConfigGenerator.php from CLI before

        return Client::createWithFile(__DIR__ . '/myConfigFile.json');
    }

    public static function createPos(): Client
    {
        return new PosClient('myPosToken');
    }
}
