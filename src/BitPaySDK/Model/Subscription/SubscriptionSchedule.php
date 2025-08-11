<?php

/**
 * Copyright (c) 2025 BitPay
 */

/**
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace BitPaySDK\Model\Subscription;

/**
 * Schedule of repeat bill due dates. Can be `weekly`, `monthly`, `quarterly`, `yearly`, or a simple cron expression
 * specifying seconds, minutes, hours, day of month, month, and day of week. BitPay maintains the difference between
 * the due date and the delivery date in all subsequent, automatically-generated bills.
 *
 * +-------------- second (0 - 59)
 *
 * | +------------ minute (0 - 59)
 *
 * | | +---------- hour (0 - 23)
 *
 * | | | +-------- day of month (1 - 31)
 *
 * | | | | +------ month (1 - 12)
 *
 * | | | | | +---- day of week (0 - 6) (Sunday=0 or 7)
 *
 * | | | | | |
 *
 * \* * * * * Cron expression
 *
 * @package BitPaySDK\Model\Subscription
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 * @see https://developer.bitpay.com/reference/subscriptions Subscriptions
 */
interface SubscriptionSchedule
{
    public const WEEKLY = "weekly";
    public const MONTHLY = "monthly";
    public const QUARTERLY = "quarterly";
    public const YEARLY = "yearly";
}
