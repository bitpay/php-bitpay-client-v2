<?php

/**
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace BitPaySDK\Model\Payout;

/**
 * Interface PayoutStatus
 * @package BitPaySDK\Model\Payout
 */
interface PayoutStatus
{
    /**
     * New status.
     */
    const New        = 'new';

    /**
     * Funded status.
     */
    const Funded     = 'funded';

    /**
     * Processing status
     */
    const Processing = 'processing';

    /**
     * Complete status
     */
    const Complete   = 'complete';

    /**
     * Failed status.
     */
    const Failed     = 'failed';

    /**
     * Cancelled status.
     */
    const Cancelled  = 'cancelled';

    /**
     * Paid status.
     */
    const Paid       = 'paid';

    /**
     * Unpaid status.
     */
    const Unpaid     = 'unpaid';
}
