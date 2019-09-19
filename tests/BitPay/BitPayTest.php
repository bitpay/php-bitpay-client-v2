<?php

namespace BitPay\Test;


use Bitpay;
use BitPay\Model\Currency;
use Bitpay\Model\Invoice\Invoice;
use BitPay\Model\Payout\PayoutStatus;
use PHPUnit\Framework\TestCase;

class BitPayTest extends TestCase
{
    protected $client;
    protected $clientMock;

    protected function setUp(): void
    {
        $this->clientMock = $this->createMock(Bitpay\Client::class);
        $this->clientMock->withData(
            Bitpay\Env::Test,
            __DIR__."/../../bitpay_private_test.key",
            new Bitpay\Tokens(
                "7UeQtMcsHamehE4gDZojUQbNRbSuSdggbH17sawtobGJ",
                "5j48K7pUrX5k59DLhRVYkCupgw2CtoEt8DBFrHo2vW47"
            ),
            "YourMasterPassword"
        );

        $this->client = Bitpay\Client::create()->withData(
            Bitpay\Env::Test,
            __DIR__."/../../bitpay_private_test.key",
            new Bitpay\Tokens(
                "7UeQtMcsHamehE4gDZojUQbNRbSuSdggbH17sawtobGJ",
                "5j48K7pUrX5k59DLhRVYkCupgw2CtoEt8DBFrHo2vW47"
            ),
            "YourMasterPassword");
        $this->assertNotNull($this->client);
    }

    public function testShouldGetInvoiceId()
    {
        $invoice = new Invoice("2.16", "eur");
        $invoice->setOrderId("98e572ea-910e-415d-b6de-65f5090680f6");
        $invoice->setFullNotifications(true);
        $invoice->setExtendedNotifications(true);
        $invoice->setTransactionSpeed("medium");
        $invoice->setNotificationURL("https://hookbin.com/lJnJg9WW7MtG9GZlPVdj");
        $invoice->setRedirectURL("https://hookbin.com/lJnJg9WW7MtG9GZlPVdj");
        $invoice->setPosData("98e572ea35hj356xft8y8cgh56h5090680f6");
        $invoice->setItemDesc("Ab tempora sed ut.");

        $buyer = new Bitpay\Model\Invoice\Buyer();
        $buyer->setName("Bily Matthews");
        $buyer->setEmail("");
        $buyer->setAddress1("168 General Grove");
        $buyer->setAddress2("");
        $buyer->setCountry("AD");
        $buyer->setLocality("Port Horizon");
        $buyer->setNotify(true);
        $buyer->setPhone("+99477512690");
        $buyer->setPostalCode("KY7 1TH");
        $buyer->setRegion("New Port");

        $invoice->setBuyer($buyer);

        try {
            $basicInvoice = $this->client->createInvoice($invoice);
            $retrievedInvoice = $this->client->getInvoice($basicInvoice->getId());
        } catch (\Exception $e) {
            $e->getTraceAsString();
            self::fail($e->getMessage());
        }

        $this->assertNotNull($basicInvoice->getId());
        $this->assertNotNull($retrievedInvoice->getId());
        $this->assertEquals($basicInvoice->getId(), $retrievedInvoice->getId());
    }

    public function testShouldGetInvoices() {
        $invoices = null;
        try {
            //check within the last few days
            $date = new \DateTime();
            $today = $date->format("Y-m-d");
            $dateBefore = $date->modify('-7 day');
            $sevenDaysAgo = $dateBefore->format("Y-m-d");
            $invoices = $this->client->getInvoices($sevenDaysAgo, $today);
        } catch (\Exception $e) {
            $e->getTraceAsString();
            self::fail($e->getMessage());
        }

        $this->assertNotNull($invoices);
        $this->assertTrue(count($invoices) > 0);
    }

    public function testShouldSubmitPayoutBatch() {
        $date = new \DateTime();
        $threeDaysFromNow = $date->modify('+3 day');

        $effectiveDate = $threeDaysFromNow->format("Y-m-d");
        $currency = Currency::USD;
        $instructions = [
            new Bitpay\Model\Payout\PayoutInstruction(100.0, "mtHDtQtkEkRRB5mgeWpLhALsSbga3iZV6u"),
            new Bitpay\Model\Payout\PayoutInstruction(200.0, "mvR4Xj7MYT7GJcL93xAQbSZ2p4eHJV5F7A")
        ];

        $batch = new Bitpay\Model\Payout\PayoutBatch($currency, $effectiveDate, $instructions);
        try {
            $batch = $this->client->submitPayoutBatch($batch);
        } catch (\Exception $e) {
            $e->getTraceAsString();
            self::fail($e->getMessage());
        }

        $this->assertNotNull($batch->getId());
        $this->assertTrue(count($batch->getInstructions()) == 2);
    }

    public function testShouldGetPayoutBatches() {
        try {
            $batches = $this->client->getPayoutBatches();
        } catch (\Exception $e) {
            $e->getTraceAsString();
            self::fail($e->getMessage());
        }

        $this->assertTrue(count($batches) > 0);
    }

    public function testShouldGetPayoutBatchesByStatus() {
        try {
            $batches = $this->client->getPayoutBatches(PayoutStatus::New);
        } catch (\Exception $e) {
            $e->getTraceAsString();
            self::fail($e->getMessage());
        }

        $this->assertTrue(count($batches) > 0);
    }

    public function testShouldSubmitGetAndDeletePayoutBatch() {
        $date = new \DateTime();
        $threeDaysFromNow = $date->modify('+3 day');

        $effectiveDate = $threeDaysFromNow->format("Y-m-d");
        $currency = Currency::USD;
        $instructions = [
            new Bitpay\Model\Payout\PayoutInstruction(100.0, "mtHDtQtkEkRRB5mgeWpLhALsSbga3iZV6u"),
            new Bitpay\Model\Payout\PayoutInstruction(200.0, "mvR4Xj7MYT7GJcL93xAQbSZ2p4eHJV5F7A")
        ];

        $batch = new Bitpay\Model\Payout\PayoutBatch($currency, $effectiveDate, $instructions);
        $batchRetrieved = null;
        try {
            $batch = $this->client->submitPayoutBatch($batch);
            $batchRetrieved = $this->client->getPayoutBatch($batch->getId());
            $batchCancelled = $this->client->cancelPayoutBatch($batchRetrieved->getId());
        } catch (\Exception $e) {
            $e->getTraceAsString();
            self::fail($e->getMessage());
        }

        $this->assertNotNull($batch->getId());
        $this->assertNotNull($batchRetrieved->getId());
        $this->assertNotNull($batchCancelled->getId());
        $this->assertTrue(count($batch->getInstructions()) == 2);
        $this->assertEquals($batch->getId(), $batchRetrieved->getId());
        $this->assertEquals($batchRetrieved->getId(), $batchCancelled->getId());
        $this->assertEquals($batchRetrieved->getStatus(), PayoutStatus::New);
        $this->assertEquals($batchCancelled->getStatus(), PayoutStatus::Cancelled);
    }
}
