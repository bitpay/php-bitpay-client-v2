<?php

/**
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace BitPaySDK\Model\Invoice;

/**
 * Refund status list
 */
interface RefundStatus
{
    /**
     * No funds deducted, refund will not proceed automatically
     */
    const Preview   = "preview";

    /**
     * Funds deducted/allocated if immediate, will proceed when transactions are confirmed
     * and the required data is collected
     */
    const Created   = "created";

    /**
     * Refund was canceled by merchant action. Immediate refunds cannot be canceled outside of preview state
     */
    const Cancelled = "cancelled";

    /**
     * Refund is in process of being fulfilled
     */
    const Pending   = "pending";

    /**
     * Refund was successfully processed
     */
    const Success   = "success";

    /**
     * Refund failed during processing (this is really more of an internal state)
     */
    const Failure   = "failure";
}
