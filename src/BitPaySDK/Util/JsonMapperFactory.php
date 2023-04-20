<?php

/**
 * Copyright (c) 2019 BitPay
 **/

declare(strict_types=1);

namespace BitPaySDK\Util;

class JsonMapperFactory
{
    public static function create(): \JsonMapper
    {
        $jsonMapper = new \JsonMapper();
        $jsonMapper->bEnforceMapType = false;

        return $jsonMapper;
    }
}
