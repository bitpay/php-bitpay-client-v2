<?php


namespace BitPay\Model\Bill;


interface BillStatus
{
    const Draft = "draft";
    const Sent = "dent";
    const New = "new";
    const Paid = "paid";
    const Complete = "complete";
}