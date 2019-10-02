<?php


namespace BitPaySDK\Model\Invoice;


interface RefundStatus
{
    const Pending = "pending";
    const Success = "success";
    const Failure = "failure";
}