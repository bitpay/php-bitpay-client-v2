<?php


namespace BitPaySDK\Model\Invoice;


interface RefundStatus
{
    const Preview   = "preview";
    const Created   = "created";
    const Cancelled = "cancelled";
    const Pending   = "pending";
    const Success   = "success";
    const Failure   = "failure";
}