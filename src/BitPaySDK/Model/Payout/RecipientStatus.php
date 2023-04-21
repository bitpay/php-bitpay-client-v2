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
 * Interface RecipientStatus
 * @package BitPaySDK\Model\Payout
 * @see <a href="https://bitpay.readme.io/reference/payouts">REST API Payouts</a>
 */
interface RecipientStatus
{
    /**
     * Invited recipient status.
     */
    public const INVITED = 'invited';

    /**
     * Unverified  recipient status.
     */
    public const UNVERIFIED = 'unverified';

    /**
     * Verified recipient status.
     */

    public const VERIFIED = 'verified';

    /**
     * Active recipient status.
     */
    public const ACTIVE = 'active';

    /**
     * Paused recipient status.
     */
    public const PAUSED = 'paused';

    /**
     * Removed recipient status.
     */
    public const REMOVED = 'removed';
}
