<?php

declare(strict_types=1);

namespace BitPaySDKexamples\Merchant;

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
        $invoice = new Invoice(10.0, "USD");
        $invoice->setFullNotifications(true);
        $invoice->setExtendedNotifications(true);
        $invoice->setNotificationURL("https://test/lJnJg9WW7MtG9GZlPVdj");
        $invoice->setRedirectURL("https://test/lJnJg9WW7MtG9GZlPVdj");
        $invoice->setNotificationEmail("my@email.com");
        $invoice->setBuyerSms('+12223334445');

        $buyer = new Buyer();
        $buyer->setName("Test");
        $buyer->setEmail("test@email.com");
        $buyer->setAddress1("168 General Grove");
        $buyer->setCountry("AD");
        $buyer->setLocality("Port Horizon");
        $buyer->setNotify(true);
        $buyer->setPhone("+990123456789");
        $buyer->setPostalCode("KY7 1TH");
        $buyer->setRegion("New Port");

        $invoice->setBuyer($buyer);

        $client = ClientProvider::create();

        $createdInvoice = $client->createInvoice($invoice);
    }

    /**
     * @throws \BitPaySDK\Exceptions\BitPayApiException
     * @throws \BitPaySDK\Exceptions\BitPayGenericException
     */
    public function getInvoice(): void
    {
        $client = ClientProvider::create();

        $invoiceById = $client->getInvoice("myInvoiceId");
        $invoiceByGuid = $client->getInvoiceByGuid("someGuid"); // we can add a GUID during the invoice creation
        $invoices = $client->getInvoices("2023-04-14", "2023-04-17");
    }

    /**
     * @throws \BitPaySDK\Exceptions\BitPayApiException
     * @throws \BitPaySDK\Exceptions\BitPayGenericException
     */
    public function updateInvoice(): void
    {
        $client = ClientProvider::create();

        $invoice = $client->updateInvoice("someId", "123321312", null, null);
    }

    /**
     * @throws \BitPaySDK\Exceptions\BitPayApiException
     * @throws \BitPaySDK\Exceptions\BitPayGenericException
     */
    public function cancelInvoice(): void
    {
        $client = ClientProvider::create();

        $client->cancelInvoice('invoiceId');

        $client->cancelInvoiceByGuid('invoiceGuid');
    }

    /**
     * @throws \BitPaySDK\Exceptions\BitPayApiException
     * @throws \BitPaySDK\Exceptions\BitPayGenericException
     */
    public function requestInvoiceWebhookToBeResent(): void
    {
        $client = ClientProvider::create();

        $client->requestInvoiceNotification('someInvoiceId');
    }
}
