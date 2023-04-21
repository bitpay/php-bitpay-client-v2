<?php

/**
 * Copyright (c) 2019 BitPay
 **/

/**
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace BitPaySDK\Model;

/**
 * Facades named collections of capabilities that can be granted,
 * such as the ability to create invoices or grant refunds
 *
 * @see <a href="https://bitpay.readme.io/reference/concepts#facades">REST API facades</a>
 */
interface Facade
{
    /**
     * The broadest set of capabilities against a merchant organization. Allows for create, search,
     * and view actions for Invoices and Bills; ledger download,
     * as well as the creation of new merchant or pos tokens associated with the account.
     */
    public const MERCHANT = "merchant";

    /**
     * This is the facade which allows merchant to access the Payouts related resources and corresponding endpoints.
     * Access to this facade is not enabled by default.
     */
    public const PAYOUT  = "payout";

    /**
     * Limited to creating new invoice or bills and search specific invoices
     * or bills based on their id for the merchant's organization
     */
    public const POS  = "pos";
}
