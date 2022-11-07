<?php

/**
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace BitPaySDK\Model\Subscription;

/**
 * Interface SubscriptionStatus
 * @package BitPaySDK\Model\Subscription
 */
interface SubscriptionStatus
{
    /**
     * Draft Subscription Status.
     */
    const Draft     = "draft";

    /**
     * Active Subscription Status.
     */
    const Active    = "active";

    /**
     * Cancelled Subscription Status.
     */
    const Cancelled = "cancelled";
}
