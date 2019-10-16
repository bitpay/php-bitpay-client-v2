<?php


namespace BitPaySDK\Model\Bill;


interface BillStatus
{
    const Draft    = "draft";
    const Sent     = "sent";
    const New      = "new";
    const Paid     = "paid";
    const Complete = "complete";
}
