<?php

/**
 * Copyright (c) 2019 BitPay
 **/

/**
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace BitPaySDK\Model\Payout;

/**
 * Interface PayoutStatus
 * @package BitPaySDK\Model\Payout
 * @see <a href="https://bitpay.readme.io/reference/payouts">REST API Payouts</a>
 */
interface PayoutStatus
{
    /**
     * New status.
     */
    public const NEW = 'new';

    /**
     * Funded status.
     */
    public const FUNDED = 'funded';

    /**
     * Processing status
     */
    public const PROCESSING = 'processing';

    /**
     * Complete status
     */
    public const COMPLETE   = 'complete';

    /**
     * Failed status.
     */
    public const FAILED = 'failed';

    /**
     * Cancelled status.
     */
    public const CANCELLED = 'cancelled';

    /**
     * Paid status.
     */
    public const PAID = 'paid';

    /**
     * Unpaid status.
     */
    public const UNPAID = 'unpaid';
}
