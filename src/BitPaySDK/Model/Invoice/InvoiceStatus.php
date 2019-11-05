<?php


namespace BitPaySDK\Model\Invoice;


interface InvoiceStatus
{
    const New       = "new";
    const Paid      = "paid";
    const Confirmed = "confirmed";
    const Complete  = "complete";
    const Expired   = "expired";
    const Invalid   = "invalid";
}