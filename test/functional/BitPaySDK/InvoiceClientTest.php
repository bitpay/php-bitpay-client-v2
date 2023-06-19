<?php
/**
 * Copyright (c) 2019 BitPay
 **/
declare(strict_types=1);

namespace BitPaySDK\Functional;

use BitPaySDK\Model\Invoice\Buyer;
use BitPaySDK\Model\Invoice\Invoice;

class InvoiceClientTest extends AbstractClientTest
{
    public function testCreateInvoice(): void
    {
        $invoice = $this->getInvoiceExample();
        $baseInvoice = $this->client->createInvoice($invoice);

        self::assertEquals('new', $baseInvoice->getStatus());
        self::assertEquals('USD', $baseInvoice->getCurrency());
        self::assertEquals(50.0, $baseInvoice->getPrice());
        self::assertEquals('Test', $baseInvoice->getBuyer()->getName());
        self::assertEquals('168 General Grove', $baseInvoice->getBuyer()->getAddress1());
        self::assertEquals('Port Horizon', $baseInvoice->getBuyer()->getLocality());
        self::assertEquals('New Port', $baseInvoice->getBuyer()->getRegion());
    }

    public function testGetInvoice(): void
    {
        $invoice = $this->getInvoiceExample();
        $baseInvoice = $this->client->createInvoice($invoice);
        $baseInvoice = $this->client->getInvoice($baseInvoice->getId());

        self::assertEquals('new', $baseInvoice->getStatus());
        self::assertEquals(50.0, $baseInvoice->getPrice());
        self::assertEquals('Test', $baseInvoice->getBuyer()->getName());
        self::assertEquals('168 General Grove', $baseInvoice->getBuyer()->getAddress1());
        self::assertInstanceOf(Invoice::class, $baseInvoice);
        self::assertNotNull($baseInvoice);
    }

    public function testGetInvoiceByGuid(): void
    {
        $invoice = $this->getInvoiceExample();
        $baseInvoice = $this->client->createInvoice($invoice);
        $baseInvoice = $this->client->getInvoiceByGuid($baseInvoice->getGuid());

        self::assertEquals('new', $baseInvoice->getStatus());
        self::assertEquals(50.0, $baseInvoice->getPrice());
        self::assertEquals('Test', $baseInvoice->getBuyer()->getName());
        self::assertEquals('168 General Grove', $baseInvoice->getBuyer()->getAddress1());
        self::assertInstanceOf(Invoice::class, $baseInvoice);
        self::assertNotNull($baseInvoice);
    }

    public function testUpdateInvoice(): void
    {
        $invoice = $this->getInvoiceExample();
        $baseInvoice = $this->client->createInvoice($invoice);
        $baseInvoice = $this->client->getInvoice($baseInvoice->getId());

        $updateInvoice = $this->client->updateInvoice(
            $baseInvoice->getId(),
            '',
            '',
            'test1@email.com'
        );

        self::assertEquals('test1@email.com', $updateInvoice->getBuyer()->getEmail());
    }

    public function testGetInvoices(): void
    {
        $dateStart = date('Y-m-d', strtotime("-30 day"));
        $dateEnd = date("Y-m-d", strtotime("+1 day"));
        $invoices = $this->client->getInvoices($dateStart, $dateEnd, 'new', null, 1);

        self::assertCount(1, $invoices);
        self::assertTrue(count($invoices) > 0);
        self::assertNotNull($invoices);
    }

    public function testCancel(): void
    {
        $invoice = $this->getInvoiceExample();
        $baseInvoice = $this->client->createInvoice($invoice);
        $baseInvoice = $this->client->getInvoice($baseInvoice->getId());
        $cancelInvoice = $this->client->cancelInvoice($baseInvoice->getId());

        self::assertEquals('expired', $cancelInvoice->getStatus());
    }

    public function testCancelInvoiceByGuid()
    {
        $invoice = $this->getInvoiceExample();
        $baseInvoice = $this->client->createInvoice($invoice);
        $baseInvoice = $this->client->cancelInvoiceByGuid($baseInvoice->getGuid());

        self::assertEquals('expired', $baseInvoice->getStatus());
        self::assertEquals(50.0, $baseInvoice->getPrice());
        self::assertInstanceOf(Invoice::class, $baseInvoice);
        self::assertNotNull($baseInvoice);
    }

    public function testPayInvoice(): void
    {
        $invoice = $this->getInvoiceExample();
        $invoice = $this->client->createInvoice($invoice);
        $invoice = $this->client->payInvoice($invoice->getId());

        self::assertEquals('confirmed', $invoice->getStatus());
    }

    private function getInvoiceExample(): Invoice
    {
        $invoice = new Invoice(50.0, "USD");
        $invoice->setFullNotifications(true);
        $invoice->setExtendedNotifications(true);
        $invoice->setNotificationURL("https://test/lJnJg9WW7MtG9GZlPVdj");
        $invoice->setRedirectURL("https://test/lJnJg9WW7MtG9GZlPVdj");
        $invoice->setItemDesc("Created by PHP functional test");
        $invoice->setNotificationEmail("");
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

        return $invoice;
    }
}