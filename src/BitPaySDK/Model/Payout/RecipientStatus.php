<?php


namespace BitPaySDK\Model\Payout;


interface RecipientStatus
{
    const INVITED    = "invited";
    const UNVERIFIED = "unverified";
    const VERIFIED   = "verified";
    const ACTIVE     = "active";
    const PAUSED     = "paused";
    const REMOVED    = "removed";
}