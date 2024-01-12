<?php

declare(strict_types=1);

namespace BitPaySDKexamples\Pos;

use BitPaySDK\Model\Invoice\Buyer;
use BitPaySDK\Model\Invoice\Invoice;
use BitPaySDKexamples\ClientProvider;

final class InvoiceRequests
{
    /**
     * @throws \BitPaySDK\Exceptions\BitPayApiException
     * @throws \BitPaySDK\Exceptions\BitPayGenericException
     */
    public function createInvoice(): void
    {
        $invoice = new Invoice(10.0, 'USD');
        $invoice->setFullNotifications(true);
        $invoice->setExtendedNotifications(true);
        $invoice->setNotificationURL('https://test/lJnJg9WW7MtG9GZlPVdj');
        $invoice->setRedirectURL('https://test/lJnJg9WW7MtG9GZlPVdj');
        $invoice->setNotificationEmail('my@email.com');
        $invoice->setBuyerSms('+12223334445');

        $buyer = new Buyer();
        $buyer->setName('Test');
        $buyer->setEmail('test@email.com');
        $buyer->setAddress1('168 General Grove');
        $buyer->setCountry('AD');
        $buyer->setLocality('Port Horizon');
        $buyer->setNotify(true);
        $buyer->setPhone('+990123456789');
        $buyer->setPostalCode('KY7 1TH');
        $buyer->setRegion('New Port');

        $invoice->setBuyer($buyer);

        $client = ClientProvider::createPos();

        $createdInvoice = $client->createInvoice($invoice);
    }

    /**
     * @throws \BitPaySDK\Exceptions\BitPayApiException
     * @throws \BitPaySDK\Exceptions\BitPayGenericException
     */
    public function getInvoice(): void
    {
        $client = ClientProvider::createPos();

        $invoiceById = $client->getInvoice('myInvoiceId');
    }
}
