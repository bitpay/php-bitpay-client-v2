<?php
declare(strict_types=1);

namespace BitPaySDK\Integration;

use BitPaySDK\Client;
use BitPaySDK\Exceptions\RefundCreationException;
use BitPaySDK\Model\Currency;
use BitPaySDK\Model\Invoice\Buyer;
use BitPaySDK\Model\Invoice\Invoice;
use BitPaySDK\Model\Invoice\Refund;
use PHPUnit\Framework\TestCase;

class RefundClientTest extends TestCase
{
    protected $client;

    public function setUp(): void
    {
        $this->client = Client::createWithFile(Config::INTEGRATION_TEST_PATH . DIRECTORY_SEPARATOR . Config::BITPAY_CONFIG_FILE);
    }

    public function testCreateRefund(): void
    {
        $invoice = $this->getInvoiceExample();
        $baseInvoice = $this->client->createInvoice($invoice);
        $baseInvoice = $this->client->payInvoice($baseInvoice->getId(), 'complete');
        $refund = $this->client->createRefund($baseInvoice->getId(), 50.0, Currency::USD);

        $this->assertEquals(50.0, $refund->getAmount());
        $this->assertEquals('USD', $refund->getCurrency());
    }

    public function testCreateRefundShouldCatchRestCliException(): void
    {
        $invoice = $this->getInvoiceExample();
        $invoice->setId('WoE46gSLkJQS48RJEiNw3L');
        $this->expectException(RefundCreationException::class);

        $this->client->createRefund($invoice->getId(), 50.0, Currency::USD, true);
    }

    public function testUpdateRefund(): void
    {
        $dateStart = date('Y-m-d', strtotime("-30 day"));
        $dateEnd = date("Y-m-d", strtotime("+1 day"));
        $invoices = $this->client->getInvoices($dateStart, $dateEnd, 'complete', null, 1);
        $refunds = $this->client->getRefunds($invoices[0]->getId());
        $refund = $this->client->updateRefund($refunds[0]->getId(), 'created');

        $this->assertEquals('created', $refund->getStatus());
        $this->assertEquals('USD', $refund->getCurrency());
    }

    public function testGetRefunds(): void
    {
        $dateStart = date('Y-m-d', strtotime("-30 day"));
        $dateEnd = date("Y-m-d", strtotime("+1 day"));
        $invoices = $this->client->getInvoices($dateStart, $dateEnd, 'complete', null, 1);
        $refunds = $this->client->getRefunds($invoices[0]->getId());

        $this->assertCount(1, $refunds);
        $this->assertNotNull($refunds);
        $this->assertTrue(is_array($refunds));
        $this->assertEquals('complete', $invoices[0]->getStatus());
        $this->assertEquals('created', $refunds[0]->getStatus());
    }

    public function testGetRefund(): void
    {
        $dateStart = date('Y-m-d', strtotime("-30 day"));
        $dateEnd = date("Y-m-d", strtotime("+1 day"));
        $invoices = $this->client->getInvoices($dateStart, $dateEnd, 'complete', null, 1);
        $refunds = $this->client->getRefunds($invoices[0]->getId());
        $refund = $this->client->getRefund($refunds[0]->getId());

        $this->assertInstanceOf(Refund::class, $refund);
        $this->assertEquals('complete', $invoices[0]->getStatus());
        $this->assertCount(1, $invoices);
        $this->assertEquals('created', $refund->getStatus());
    }

    public function testSendNotification(): void
    {
        $dateStart = date('Y-m-d', strtotime("-30 day"));
        $dateEnd = date("Y-m-d", strtotime("+1 day"));
        $invoices = $this->client->getInvoices($dateStart, $dateEnd, 'complete', null, 1);
        $refunds = $this->client->getRefunds($invoices[0]->getId());

        $this->assertTrue($this->client->sendRefundNotification($refunds[0]->getId()));
    }

    public function testCancelRefund(): void
    {
        $dateStart = date('Y-m-d', strtotime("-30 day"));
        $dateEnd = date("Y-m-d", strtotime("+1 day"));
        $invoices = $this->client->getInvoices($dateStart, $dateEnd, 'complete', null, 1);
        $refunds = $this->client->getRefunds($invoices[0]->getId());
        $refundId = $refunds[0]->getId();
        $refund = $this->client->cancelRefund($refundId);

        $this->assertInstanceOf(Refund::class, $refund);
        $this->assertNotNull($refund);
        $this->assertEquals('canceled', $refund->getStatus());
    }

    private function getInvoiceExample(): Invoice
    {
        $invoice = new Invoice(50.0, "USD");
        $invoice->setFullNotifications(true);
        $invoice->setExtendedNotifications(true);
        $invoice->setNotificationURL("https://test/lJnJg9WW7MtG9GZlPVdj");
        $invoice->setRedirectURL("https://test/lJnJg9WW7MtG9GZlPVdj");
        $invoice->setItemDesc("Created by PHP Integration test");
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