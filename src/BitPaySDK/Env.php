<?php

namespace BitPaySDK;

/**
 * Constants used throughout the SDK.
 *
 * @package BitPaySDK
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */

interface Env
{
    public const TEST = "Test";
    public const PROD = "Prod";
    public const TEST_URL = "https://test.bitpay.com/";
    public const PROD_URL = "https://bitpay.com/";
    public const BITPAY_API_VERSION = "2.0.0";
    public const BITPAY_PLUGIN_INFO = "BitPay_PHP_Client_v9.2.2";
    public const BITPAY_API_FRAME = "std";
    public const BITPAY_API_FRAME_VERSION = "1.0.0";
    public const BITPAY_DATETIME_FORMAT = 'Y-m-d\TH:i:s\Z';
}
