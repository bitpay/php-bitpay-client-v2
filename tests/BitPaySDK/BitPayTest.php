<?php

namespace BitPaySDK\Tests;


use BitPaySDK;
use BitPaySDK\Model\Bill\BillStatus;
use BitPaySDK\Model\Currency;
use BitPaySDK\Model\Invoice\Invoice;
use BitPaySDK\Model\Payout\PayoutStatus;
use PHPUnit\Framework\TestCase;

class BitPayTest extends TestCase
{
    /**
     * @var BitPaySDK\Client
     */
    protected $client;
    protected $client1;
    protected $client2;
    protected $clientMock;

    protected function setUp(): void
    {
        /**
         * You need to generate new tokens first
         * */
        $this->clientMock = $this->createMock(BitPaySDK\Client::class);
        $this->clientMock->withData(
            BitPaySDK\Env::Test,
            __DIR__."/../../examples/bitpay_private_test.key",
            new BitPaySDK\Tokens(
                "7UeQtMcsHamehE4gDZojUQbNRbSuSdggbH17sawtobGJ",
                "5j48K7pUrX5k59DLhRVYkCupgw2CtoEt8DBFrHo2vW47"
            ),
            "YourMasterPassword"
        );

        $this->client = BitPaySDK\Client::create()->withData(
            BitPaySDK\Env::Test,
            __DIR__."/../../examples/bitpay_private_test.key",
            new BitPaySDK\Tokens(
                "7UeQtMcsHamehE4gDZojUQbNRbSuSdggbH17sawtobGJ",
                "5j48K7pUrX5k59DLhRVYkCupgw2CtoEt8DBFrHo2vW47"
            ),
            "YourMasterPassword");

        /**
         * Uncomment only if you wish to test the client with config files
         * */
//        $this->client1 = BitPaySDK\Client::create()->withFile(__DIR__."/../../examples/BitPay.config.json");
//        $this->client2 = BitPaySDK\Client::create()->withFile(__DIR__."/../../examples/BitPay.config.yml");


        $this->assertNotNull($this->client);
        /**
         * Uncomment only if you wish to test the client with config files
         * */
//        $this->assertNotNull($this->client1);
//        $this->assertNotNull($this->client2);
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

        $buyer = new BitPaySDK\Model\Invoice\Buyer();
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

    public function testShouldGetInvoices()
    {
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

    public function testShouldCreateBillUSD()
    {
        $items = [];

        $item = new BitPaySDK\Model\Bill\Item();
        $item->setPrice(30.0);
        $item->setQuantity(9);
        $item->setDescription("product-a");
        array_push($items, $item);

        $item = new BitPaySDK\Model\Bill\Item();
        $item->setPrice(14.0);
        $item->setQuantity(16);
        $item->setDescription("product-b");
        array_push($items, $item);

        $item = new BitPaySDK\Model\Bill\Item();
        $item->setPrice(3.90);
        $item->setQuantity(42);
        $item->setDescription("product-c");
        array_push($items, $item);

        $item = new BitPaySDK\Model\Bill\Item();
        $item->setPrice(6.99);
        $item->setQuantity(12);
        $item->setDescription("product-d");
        array_push($items, $item);

        $bill = new BitPaySDK\Model\Bill\Bill("1001", Currency::USD, "", $items);
        $basicBill = null;
        try {
            $basicBill = $this->client->createBill($bill);
        } catch (\Exception $e) {
            $e->getTraceAsString();
            self::fail($e->getMessage());
        }

        $this->assertNotNull($basicBill->getId());
        $this->assertNotNull($basicBill->getItems()[0]->getId());
    }

    public function testShouldCreateBillEUR()
    {
        $items = [];

        $item = new BitPaySDK\Model\Bill\Item();
        $item->setPrice(30.0);
        $item->setQuantity(9);
        $item->setDescription("product-a");
        array_push($items, $item);

        $item = new BitPaySDK\Model\Bill\Item();
        $item->setPrice(14.0);
        $item->setQuantity(16);
        $item->setDescription("product-b");
        array_push($items, $item);

        $item = new BitPaySDK\Model\Bill\Item();
        $item->setPrice(3.90);
        $item->setQuantity(42);
        $item->setDescription("product-c");
        array_push($items, $item);

        $item = new BitPaySDK\Model\Bill\Item();
        $item->setPrice(6.99);
        $item->setQuantity(12);
        $item->setDescription("product-d");
        array_push($items, $item);

        $bill = new BitPaySDK\Model\Bill\Bill("1002", Currency::EUR, "", $items);
        $basicBill = null;
        try {
            $basicBill = $this->client->createBill($bill);
        } catch (\Exception $e) {
            $e->getTraceAsString();
            self::fail($e->getMessage());
        }

        $this->assertNotNull($basicBill->getId());
        $this->assertNotNull($basicBill->getUrl());
        $this->assertEquals(BillStatus::Draft, $basicBill->getStatus());
        $this->assertNotNull($basicBill->getItems()[0]->getId());
    }

    public function testShouldGetBill()
    {
        $items = [];

        $item = new BitPaySDK\Model\Bill\Item();
        $item->setPrice(30.0);
        $item->setQuantity(9);
        $item->setDescription("product-a");
        array_push($items, $item);

        $item = new BitPaySDK\Model\Bill\Item();
        $item->setPrice(14.0);
        $item->setQuantity(16);
        $item->setDescription("product-b");
        array_push($items, $item);

        $item = new BitPaySDK\Model\Bill\Item();
        $item->setPrice(3.90);
        $item->setQuantity(42);
        $item->setDescription("product-c");
        array_push($items, $item);

        $item = new BitPaySDK\Model\Bill\Item();
        $item->setPrice(6.99);
        $item->setQuantity(12);
        $item->setDescription("product-d");
        array_push($items, $item);

        $bill = new BitPaySDK\Model\Bill\Bill("1003", Currency::EUR, "", $items);
        $basicBill = null;
        $retrievedBill = null;
        try {
            $basicBill = $this->client->createBill($bill);
            $retrievedBill = $this->client->getBill($basicBill->getId());
        } catch (\Exception $e) {
            $e->getTraceAsString();
            self::fail($e->getMessage());
        }

        $this->assertEquals($basicBill->getId(), $retrievedBill->getId());
        $this->assertEquals($basicBill->getItems(), $retrievedBill->getItems());
    }

    public function testShouldUpdateBill()
    {
        $items = [];

        $item = new BitPaySDK\Model\Bill\Item();
        $item->setPrice(30.0);
        $item->setQuantity(9);
        $item->setDescription("product-a");
        array_push($items, $item);

        $item = new BitPaySDK\Model\Bill\Item();
        $item->setPrice(14.0);
        $item->setQuantity(16);
        $item->setDescription("product-b");
        array_push($items, $item);

        $item = new BitPaySDK\Model\Bill\Item();
        $item->setPrice(3.90);
        $item->setQuantity(42);
        $item->setDescription("product-c");
        array_push($items, $item);

        $item = new BitPaySDK\Model\Bill\Item();
        $item->setPrice(6.99);
        $item->setQuantity(12);
        $item->setDescription("product-d");
        array_push($items, $item);

        $bill = new BitPaySDK\Model\Bill\Bill("1004", Currency::EUR, "", $items);
        $basicBill = null;
        $retrievedBill = null;
        $updatedBill = null;
        try {
            $basicBill = $this->client->createBill($bill);
            $retrievedBill = $this->client->getBill($basicBill->getId());

            $this->assertEquals($basicBill->getId(), $retrievedBill->getId());
            $this->assertEquals($basicBill->getItems(), $retrievedBill->getItems());
            $this->assertEquals(count($retrievedBill->getItems()), 4);

            $items = $retrievedBill->getItems();

            $item = new BitPaySDK\Model\Bill\Item();
            $item->setPrice(60);
            $item->setQuantity(7);
            $item->setDescription("product-added");
            array_push($items, $item);

            $retrievedBill->setItems($items);
            $updatedBill = $this->client->updateBill($retrievedBill, $retrievedBill->getId());
            $items = $updatedBill->getItems();
        } catch (\Exception $e) {
            $e->getTraceAsString();
            self::fail($e->getMessage());
        }

        $this->assertEquals(count($updatedBill->getItems()), 5);
        $this->assertEquals(end($items)->getDescription(), "product-added");
    }

    public function testShouldGetBills()
    {
        $bills = null;
        try {
            $bills = $this->client->getBills();
        } catch (\Exception $e) {
            $e->getTraceAsString();
            self::fail($e->getMessage());
        }

        $this->assertTrue(count($bills) > 0);
    }

    public function testShouldGetBillsByStatus()
    {
        $bills = null;
        try {
            $bills = $this->client->getBills(BillStatus::New);
        } catch (\Exception $e) {
            $e->getTraceAsString();
            self::fail($e->getMessage());
        }

        $this->assertTrue(count($bills) > 0);
    }

    public function testShouldDeliverBill()
    {
        $items = [];

        $item = new BitPaySDK\Model\Bill\Item();
        $item->setPrice(30.0);
        $item->setQuantity(9);
        $item->setDescription("product-a");
        array_push($items, $item);

        $item = new BitPaySDK\Model\Bill\Item();
        $item->setPrice(14.0);
        $item->setQuantity(16);
        $item->setDescription("product-b");
        array_push($items, $item);

        $item = new BitPaySDK\Model\Bill\Item();
        $item->setPrice(3.90);
        $item->setQuantity(42);
        $item->setDescription("product-c");
        array_push($items, $item);

        $item = new BitPaySDK\Model\Bill\Item();
        $item->setPrice(6.99);
        $item->setQuantity(12);
        $item->setDescription("product-d");
        array_push($items, $item);

        $bill = new BitPaySDK\Model\Bill\Bill("1005", Currency::EUR, "", $items);
        $basicBill = null;
        $retrievedBill = null;
        $result = null;
        try {
            $basicBill = $this->client->createBill($bill);
            $result = $this->client->deliverBill($basicBill->getId(), $basicBill->getToken());
            $retrievedBill = $this->client->getBill($basicBill->getId());
        } catch (\Exception $e) {
            $e->getTraceAsString();
            self::fail($e->getMessage());
        }

        $this->assertEquals($basicBill->getId(), $retrievedBill->getId());
        $this->assertEquals($basicBill->getItems(), $retrievedBill->getItems());
        $this->assertEquals("Success", $result);
        $this->assertNotEquals($basicBill->getStatus(), $retrievedBill->getStatus());
        $this->assertEquals($retrievedBill->getStatus(), BillStatus::Sent);
    }

    public function testShouldGetExchangeRates()
    {
        $ratesList = null;
        try {
            $rates = $this->client->getRates();
            $ratesList = $rates->getRates();
        } catch (\Exception $e) {
            $e->getTraceAsString();
            self::fail($e->getMessage());
        }

        $this->assertNotNull($ratesList);
    }

    public function testShouldGetEURExchangeRate()
    {
        $rate = null;
        try {
            $rates = $this->client->getRates();
            $rate = $rates->getRate(Currency::EUR);
        } catch (\Exception $e) {
            $e->getTraceAsString();
            self::fail($e->getMessage());
        }

        $this->assertTrue($rate != 0);
    }

    public function testShouldGetCNYExchangeRate()
    {
        $rate = null;
        try {
            $rates = $this->client->getRates();
            $rate = $rates->getRate(Currency::CNY);
        } catch (\Exception $e) {
            $e->getTraceAsString();
            self::fail($e->getMessage());
        }

        $this->assertTrue($rate != 0);
    }

    public function testShouldUpdateExchangeRates()
    {
        $rates = null;
        $ratesList = null;
        try {
            $rates = $this->client->getRates();
            $rates->update();
            $ratesList = $rates->getRates();
        } catch (\Exception $e) {
            $e->getTraceAsString();
            self::fail($e->getMessage());
        }

        $this->assertNotNull($ratesList);
    }

    public function testShouldGetLedgerBtc()
    {
        $ledge = null;
        try {
            //check within the last few days
            $date = new \DateTime();
            $today = $date->format("Y-m-d");
            $dateBefore = $date->modify('-7 day');
            $sevenDaysAgo = $dateBefore->format("Y-m-d");
            $ledger = $this->client->getLedger(Currency::BTC, $sevenDaysAgo, $today);
        } catch (\Exception $e) {
            $e->getTraceAsString();
            self::fail($e->getMessage());
        }

        $this->assertNotNull($ledger);
        $this->assertTrue(count($ledger->getEntries()) > 0);
    }

    public function testShouldGetLedgerUsd()
    {
        $ledge = null;
        try {
            //check within the last few days
            $date = new \DateTime();
            $today = $date->format("Y-m-d");
            $dateBefore = $date->modify('-30 day');
            $sevenDaysAgo = $dateBefore->format("Y-m-d");
            $ledger = $this->client->getLedger(Currency::USD, $sevenDaysAgo, $today);
        } catch (\Exception $e) {
            $e->getTraceAsString();
            self::fail($e->getMessage());
        }

        $this->assertNotNull($ledger);
        $this->assertTrue(count($ledger->getEntries()) > 0);
    }

    public function testShouldGetLedgers()
    {
        $ledgers = null;
        try {
            $ledgers = $this->client->getLedgers();
        } catch (\Exception $e) {
            $e->getTraceAsString();
            self::fail($e->getMessage());
        }

        $this->assertNotNull($ledgers);
        $this->assertTrue(count($ledgers) > 0);
    }

    public function testShouldSubmitPayoutBatch()
    {
        $date = new \DateTime();
        $threeDaysFromNow = $date->modify('+3 day');

        $effectiveDate = $threeDaysFromNow->format("Y-m-d");
        $currency = Currency::USD;
        $instructions = [
            new BitPaySDK\Model\Payout\PayoutInstruction(100.0, "mtHDtQtkEkRRB5mgeWpLhALsSbga3iZV6u"),
            new BitPaySDK\Model\Payout\PayoutInstruction(200.0, "mvR4Xj7MYT7GJcL93xAQbSZ2p4eHJV5F7A"),
        ];

        $batch = new BitPaySDK\Model\Payout\PayoutBatch($currency, $effectiveDate, $instructions);
        try {
            $batch = $this->client->submitPayoutBatch($batch);
            $this->client->cancelPayoutBatch($batch->getId());
        } catch (\Exception $e) {
            $e->getTraceAsString();
            self::fail($e->getMessage());
        }

        $this->assertNotNull($batch->getId());
        $this->assertTrue(count($batch->getInstructions()) == 2);
    }

    public function testShouldGetPayoutBatches()
    {
        try {
            $batches = $this->client->getPayoutBatches();
        } catch (\Exception $e) {
            $e->getTraceAsString();
            self::fail($e->getMessage());
        }

        $this->assertTrue(count($batches) > 0);
    }

    public function testShouldGetPayoutBatchesByStatus()
    {
        try {
            $batches = $this->client->getPayoutBatches(PayoutStatus::New);
        } catch (\Exception $e) {
            $e->getTraceAsString();
            self::fail($e->getMessage());
        }

        $this->assertTrue(count($batches) > 0);
    }

    public function testShouldSubmitGetAndDeletePayoutBatch()
    {
        $date = new \DateTime();
        $threeDaysFromNow = $date->modify('+3 day');

        $effectiveDate = $threeDaysFromNow->format("Y-m-d");
        $currency = Currency::USD;
        $instructions = [
            new BitPaySDK\Model\Payout\PayoutInstruction(100.0, "mtHDtQtkEkRRB5mgeWpLhALsSbga3iZV6u"),
            new BitPaySDK\Model\Payout\PayoutInstruction(200.0, "mvR4Xj7MYT7GJcL93xAQbSZ2p4eHJV5F7A"),
        ];

        $batch = new BitPaySDK\Model\Payout\PayoutBatch($currency, $effectiveDate, $instructions);
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
