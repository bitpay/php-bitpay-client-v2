<?php

/**
 * Copyright (c) 2025 BitPay
 **/

/**
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace BitPaySDK\Model\Settlement;

/**
 * Status of the settlement.
 * Possible statuses are "new", "processing", "rejected" and "completed".
 *
 * @package BitPaySDK\Model\Settlement
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 * @see https://developer.bitpay.com/reference/settlements Settlements
 */
interface SettlementStatus
{
    public const NEW = "new";
    public const PROCESSING = "processing";
    public const REJECTED = "rejected";
    public const COMPLETED = "completed";
}
