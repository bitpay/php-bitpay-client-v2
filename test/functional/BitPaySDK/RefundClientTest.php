<?php
/**
 * Copyright (c) 2019 BitPay
 **/
declare(strict_types=1);

namespace BitPaySDK\Functional;

use BitPaySDK\Exceptions\RefundCreationException;
use BitPaySDK\Model\Currency;
use BitPaySDK\Model\Invoice\Buyer;
use BitPaySDK\Model\Invoice\Invoice;
use BitPaySDK\Model\Invoice\Refund;

class RefundClientTest extends AbstractClientTest
{
    public function testCreateRefund(): void
    {
        $invoice = $this->getInvoiceExample();
        $baseInvoice = $this->client->createInvoice($invoice);
        $baseInvoice = $this->client->payInvoice($baseInvoice->getId(), 'complete');
        $refund = $this->client->createRefund($baseInvoice->getId(), 50.0, Currency::USD);

        self::assertEquals(50.0, $refund->getAmount());
        self::assertEquals('USD', $refund->getCurrency());
    }

    public function testCreateRefundShouldCatchRestCliException(): void
    {
        $invoice = $this->getInvoiceExample();
        $invoice->setId('WoE46gSLkJQS48RJEiNw3L');
        $this->expectException(RefundCreationException::class);

        $this->client->createRefund($invoice->getId(), 50.0, Currency::USD, true);
    }

    public function testGetRefunds(): void
    {
        $dateStart = date('Y-m-d', strtotime("-30 day"));
        $dateEnd = date("Y-m-d", strtotime("+1 day"));
        $invoices = $this->client->getInvoices($dateStart, $dateEnd, 'complete', null, 1);
        $refunds = $this->client->getRefunds($invoices[0]->getId());

        self::assertCount(1, $refunds);
        self::assertNotNull($refunds);
        self::assertIsArray($refunds);
        self::assertEquals('complete', $invoices[0]->getStatus());
        self::assertEquals('created', $refunds[0]->getStatus());
    }

    public function testGetRefund(): void
    {
        $dateStart = date('Y-m-d', strtotime("-30 day"));
        $dateEnd = date("Y-m-d", strtotime("+1 day"));
        $invoices = $this->client->getInvoices($dateStart, $dateEnd, 'complete', null, 1);
        $refunds = $this->client->getRefunds($invoices[0]->getId());
        $refund = $this->client->getRefund($refunds[0]->getId());

        self::assertInstanceOf(Refund::class, $refund);
        self::assertEquals('complete', $invoices[0]->getStatus());
        self::assertCount(1, $invoices);
        self::assertEquals('created', $refund->getStatus());
    }

    public function testSendNotification(): void
    {
        $dateStart = date('Y-m-d', strtotime("-30 day"));
        $dateEnd = date("Y-m-d", strtotime("+1 day"));
        $invoices = $this->client->getInvoices($dateStart, $dateEnd, 'complete', null, 1);
        $refunds = $this->client->getRefunds($invoices[0]->getId());

        self::assertTrue($this->client->sendRefundNotification($refunds[0]->getId()));
    }

    public function testCancelRefund(): void
    {
        $dateStart = date('Y-m-d', strtotime("-30 day"));
        $dateEnd = date("Y-m-d", strtotime("+1 day"));
        $invoices = $this->client->getInvoices($dateStart, $dateEnd, 'complete', null, 1);
        $refunds = $this->client->getRefunds($invoices[0]->getId());
        $refundId = $refunds[0]->getId();
        $refund = $this->client->cancelRefund($refundId);

        self::assertInstanceOf(Refund::class, $refund);
        self::assertNotNull($refund);
        self::assertEquals('canceled', $refund->getStatus());
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