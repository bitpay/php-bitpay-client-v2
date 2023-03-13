<?php
declare(strict_types=1);

namespace BitPaySDK\Integration;

use BitPaySDK\Model\Invoice\Buyer;
use BitPaySDK\Model\Invoice\Invoice;
use BitPaySDK\Client;
use PHPUnit\Framework\TestCase;

class InvoiceClientTest extends TestCase
{
    protected $client;

    public function setUp(): void
    {
        $this->client = Client::createWithFile(Config::INTEGRATION_TEST_PATH . DIRECTORY_SEPARATOR . Config::BITPAY_CONFIG_FILE);
    }

    public function testCreateInvoice(): void
    {
        $invoice = $this->getInvoiceExample();
        $baseInvoice = $this->client->createInvoice($invoice);

        $this->assertEquals('new', $baseInvoice->getStatus());
        $this->assertEquals('USD', $baseInvoice->getCurrency());
        $this->assertEquals(50.0, $baseInvoice->getPrice());
        $this->assertEquals('Test', $baseInvoice->getBuyer()->getName());
        $this->assertEquals('168 General Grove', $baseInvoice->getBuyer()->getAddress1());
        $this->assertEquals('Port Horizon', $baseInvoice->getBuyer()->getLocality());
        $this->assertEquals('New Port', $baseInvoice->getBuyer()->getRegion());
    }

    public function testGetInvoice(): void
    {
        $invoice = $this->getInvoiceExample();
        $baseInvoice = $this->client->createInvoice($invoice);
        $baseInvoice = $this->client->getInvoice($baseInvoice->getId());

        $this->assertEquals('new', $baseInvoice->getStatus());
        $this->assertEquals(50.0, $baseInvoice->getPrice());
        $this->assertEquals('Test', $baseInvoice->getBuyer()->getName());
        $this->assertEquals('168 General Grove', $baseInvoice->getBuyer()->getAddress1());
        $this->assertInstanceOf(Invoice::class, $baseInvoice);
        $this->assertNotNull($baseInvoice);
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

        $this->assertEquals('test1@email.com', $updateInvoice->getBuyer()->getEmail());
    }

    public function testGetInvoices(): void
    {
        $dateStart = date('Y-m-d', strtotime("-30 day"));
        $dateEnd = date("Y-m-d", strtotime("+1 day"));
        $invoices = $this->client->getInvoices($dateStart, $dateEnd, 'new', null, 1);

        $this->assertCount(1, $invoices);
        $this->assertTrue(count($invoices) > 0);
        $this->assertNotNull($invoices);
    }

    public function testCancel(): void
    {
        $invoice = $this->getInvoiceExample();
        $baseInvoice = $this->client->createInvoice($invoice);
        $baseInvoice = $this->client->getInvoice($baseInvoice->getId());
        $cancelInvoice = $this->client->cancelInvoice($baseInvoice->getId());

        $this->assertEquals('expired', $cancelInvoice->getStatus());
    }

    public function testCancelInvoiceByGuid()
    {
        $invoice = $this->getInvoiceExample();
        $baseInvoice = $this->client->createInvoice($invoice);
        $baseInvoice = $this->client->cancelInvoiceByGuid($baseInvoice->getGuid());

        $this->assertEquals('expired', $baseInvoice->getStatus());
        $this->assertEquals(50.0, $baseInvoice->getPrice());
        $this->assertInstanceOf(Invoice::class, $baseInvoice);
        $this->assertNotNull($baseInvoice);
    }

    public function testPayInvoice(): void
    {
        $invoice = $this->getInvoiceExample();
        $invoice = $this->client->createInvoice($invoice);
        $invoice = $this->client->payInvoice($invoice->getId());

        $this->assertEquals('confirmed', $invoice->getStatus());
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