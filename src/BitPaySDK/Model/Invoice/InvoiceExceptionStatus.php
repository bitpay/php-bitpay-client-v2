<?php

namespace BitPaySDK\Model\Invoice;

interface InvoiceExceptionStatus
{
    const PaidOver = 'paidOver';
    const PaidPartial = 'paidPartial';
}