<?php


namespace BitPaySDK\Model\Payout;


interface RecipientReferenceMethod
{
    const EMAIL      = 1;
    const RECIPIENT_ID         = 2;
    const SHOPPER_ID = 3;
}