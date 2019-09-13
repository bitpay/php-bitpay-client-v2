<?php


namespace BitPay\Model\Invoice;


interface InvoiceStatus
{
    const New = "new";
    const Funded = "funded";
    const Processing = "processing";
    const Complete = "complete";
    const Failed = "failed";
    const Cancelled = "cancelled";
}