<?php


namespace BitPaySDK\Model\Subscription;


interface SubscriptionStatus
{
    const Draft     = "draft";
    const Active    = "active";
    const Cancelled = "cancelled";
}