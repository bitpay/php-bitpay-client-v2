<?php

namespace BitPaySDK\Model\Settlement;

interface SettlementStatus
{
    const New = 'new';
    const Processing = 'processing';
    const Rejected = 'rejected';
    const Completed = 'completed';
}