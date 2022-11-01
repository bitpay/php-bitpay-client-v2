<?php

/**
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace BitPaySDK\Model\Bill;

/**
 * Contains bill statuses: Can be "draft", "sent", "new", "paid", or "complete"
 *
 * @see <a href="https://bitpay.com/api/#rest-api-resources-bills">REST API Bills</a>
 */
interface BillStatus
{
    const Draft    = "draft";
    const Sent     = "sent";
    const New      = "new";
    const Paid     = "paid";
    const Complete = "complete";
}
