<?php

/**
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace BitPaySDK\Model;

/**
 * Facades named collections of capabilities that can be granted,
 * such as the ability to create invoices or grant refunds
 */
interface Facade
{
    /**
     * The broadest set of capabilities against a merchant organization. Allows for create, search,
     * and view actions for Invoices and Bills; ledger download,
     * as well as the creation of new merchant or pos tokens associated with the account.
     */
    const Merchant = "merchant";

    /**
     * This is the facade which allows merchant to access the Payouts related resources and corresponding endpoints.
     * Access to this facade is not enabled by default.
     */
    const Payout  = "payout";
}
