<?php

/**
 * Copyright (c) 2019 BitPay
 **/

/**
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace BitPaySDK\Model\Invoice;

/**
 * Refund status list
 * @see <a href="https://bitpay.readme.io/reference/invoices">REST API Invoices</a>
 */
interface RefundStatus
{
    /**
     * No funds deducted, refund will not proceed automatically
     */
    public const PREVIEW = "preview";

    /**
     * Funds deducted/allocated if immediate, will proceed when transactions are confirmed
     * and the required data is collected
     */
    public const CREATED = "created";

    /**
     * Refund was canceled by merchant action. Immediate refunds cannot be canceled outside of preview state
     */
    public const CANCELLED = "cancelled";

    /**
     * Refund is in process of being fulfilled
     */
    public const PENDING = "pending";

    /**
     * Refund was successfully processed
     */
    public const SUCCESS = "success";

    /**
     * Refund failed during processing (this is really more of an internal state)
     */
    public const FAILURE = "failure";
}
