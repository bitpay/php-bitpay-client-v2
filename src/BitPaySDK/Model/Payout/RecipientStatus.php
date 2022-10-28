<?php

/**
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace BitPaySDK\Model\Payout;

/**
 * Interface RecipientStatus
 * @package BitPaySDK\Model\Payout
 */
interface RecipientStatus
{
    /**
     * Invited recipient status.
     */
    const INVITED    = 'invited';

    /**
     * Unverified  recipient status.
     */
    const UNVERIFIED = 'unverified';

    /**
     * Verified recipient status.
     */

    const VERIFIED   = 'verified';

    /**
     * Active recipient status.
     */
    const ACTIVE     = 'active';

    /**
     * Paused recipient status.
     */
    const PAUSED     = 'paused';

    /**
     * Removed recipient status.
     */
    const REMOVED    = 'removed';
}
