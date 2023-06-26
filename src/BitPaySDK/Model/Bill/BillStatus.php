<?php

/**
 * Copyright (c) 2019 BitPay
 **/

/**
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace BitPaySDK\Model\Bill;

/**
 * Contains bill statuses: Can be "draft", "sent", "new", "paid", or "complete"
 *
 * @see <a href="https://developer.bitpay.com/reference/bills">REST API Bills</a>
 */
interface BillStatus
{
    public const DRAFT = "draft";
    public const SENT = "sent";
    public const NEW = "new";
    public const PAID = "paid";
    public const COMPLETE = "complete";
}
