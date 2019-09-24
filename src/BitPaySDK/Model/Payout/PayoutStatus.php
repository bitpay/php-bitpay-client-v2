<?php


namespace BitPaySDK\Model\Payout;


interface PayoutStatus
{
    const New        = "new";
    const Funded     = "funded";
    const Processing = "processing";
    const Complete   = "complete";
    const Failed     = "failed";
    const Cancelled  = "cancelled";
    const Paid       = "paid";
    const Unpaid     = "unpaid";
}