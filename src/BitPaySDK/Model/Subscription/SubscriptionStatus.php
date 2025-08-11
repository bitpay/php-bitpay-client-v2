<?php

/**
 * Copyright (c) 2025 BitPay
 **/

/**
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace BitPaySDK\Model\Subscription;

/**
 * Subscription object status. Can be `draft`, `active` or `cancelled`.
 * Subscriptions in `active` state will create new Bills on the `nextDelivery` date.
 *
 * @package BitPaySDK\Model\Subscription
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 * @see https://developer.bitpay.com/reference/subscriptions Subscriptions
 */
interface SubscriptionStatus
{
    public const DRAFT = "draft";
    public const ACTIVE = "active";
    public const CANCELLED = "cancelled";
}
