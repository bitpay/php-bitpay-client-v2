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
 * List of recipient reference methods
 * @see <a href="https://bitpay.readme.io/reference/payouts">REST API Payouts</a>
 */
interface RecipientReferenceMethod
{
    /**
     * Email method will be used to target the recipient
     */
    public const EMAIL = 1;

    /**
     * Recipient id will be used to target the recipient
     */
    public const RECIPIENT_ID = 2;

    /**
     * Shopper id will be used to target the recipient
     */
    public const SHOPPER_ID = 3;
}
