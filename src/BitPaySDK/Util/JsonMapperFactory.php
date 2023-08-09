<?php

/**
 * Copyright (c) 2019 BitPay
 **/

declare(strict_types=1);

namespace BitPaySDK\Util;

/**
 * @package BitPaySDK\Util
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
class JsonMapperFactory
{
    public static function create(): \JsonMapper
    {
        $jsonMapper = new \JsonMapper();
        $jsonMapper->bEnforceMapType = false;

        return $jsonMapper;
    }
}
